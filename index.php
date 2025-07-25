<?php
require_once 'includes/db-connection.php';

// Fetch featured blog post (most recent published post)
$featured_post = null;
$recent_posts = [];

if (!isset($db_error)) {
    try {
        // Get featured post (most recent with highest views)
        $featured_sql = "SELECT * FROM blog_posts WHERE status = 'published' ORDER BY views DESC, created_at DESC LIMIT 1";
        $featured_stmt = $pdo->prepare($featured_sql);
        $featured_stmt->execute();
        $featured_post = $featured_stmt->fetch(PDO::FETCH_ASSOC);

        // Get recent posts (excluding the featured one)
        $recent_sql = "SELECT * FROM blog_posts WHERE status = 'published'";
        if ($featured_post) {
            $recent_sql .= " AND id != :featured_id";
        }
        $recent_sql .= " ORDER BY created_at DESC LIMIT 3";

        $recent_stmt = $pdo->prepare($recent_sql);
        if ($featured_post) {
            $recent_stmt->bindParam(':featured_id', $featured_post['id']);
        }
        $recent_stmt->execute();
        $recent_posts = $recent_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // If query fails, fall back to static content
        $db_error = true;
    }
}

// Helper function to calculate reading time
function calculateReadingTime($content)
{
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    return max(1, $reading_time); // Minimum 1 minute
}

// Helper function to create excerpt
function createExcerpt($content, $length = 150)
{
    $text = strip_tags($content);
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

// Helper function to format date
function formatDate($date)
{
    return date('M j, Y', strtotime($date));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flemington Properties - Real Estate Advisory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Font Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }


        .bg-primary, .bg-dark {
            background-color: #2c3e50 !important;
        }

        /* Carousel Styling */
        .hero-carousel {
            height: 65vh;
            overflow: hidden;
            position: relative;
            /* Space for search box */
        }

        .carousel-indicators [data-bs-target] {
            background-color: #2c3e50;
        }

        .hero-carousel .carousel-item {
            height: 65vh;
            position: relative;
            background: #ffffff;
        }

        .hero-carousel .carousel-item .carousel-text {
            position: absolute;
            top: 45%;
            width: 100%;
            text-align: center;            
            color: #2c3e50;
        }

        .hero-carousel .carousel-item .carousel-title {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .hero-carousel .carousel-item .carousel-subtitle {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }


        .hero-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            min-height: 60vh;
            display: flex;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c3e50;
            font-size: 24px;
        }

        .brand-text {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0;
        }

        .brand-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            letter-spacing: 2px;
            margin: 0;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: bold;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            opacity: 0.95;
        }

        .hero-description {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
        }

        .content-section {
            background: #f8f9fa;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .check-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
        }

        .check-icon {
            color: #27ae60;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .cta-button {
            background: #2c3e50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            background: #34495e;
            color: white;
            transform: translateY(-2px);
        }

        .insight-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .footer-section {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .brand-text {
                font-size: 1.4rem;
            }

            .hero-section {
                padding: 3rem 1rem 3rem 1rem;
            }
        }

        .chart-container {
            position: relative;
            width: 100%;
            margin-top: 20px;
            background: linear-gradient(135deg, rgba(20, 30, 48, 0.9) 0%, rgba(30, 40, 60, 0.8) 100%);
            border-radius: 10px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .chart-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #FFFFFF;
            text-align: left;
        }

        .chart-source {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
            position: absolute;
            bottom: 8px;
            left: 20px;
        }

        .dubai-areas-section {
            background: white;
            padding: 80px 0;
        }

        .areas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-auto-rows: 200px;
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .area-card {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .area-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .large-card {
            grid-row: span 2;
            grid-column: span 2;
        }

        .medium-card {
            grid-row: span 2;
        }

        .small-card {
            grid-row: span 1;
        }

        .area-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* background: linear-gradient(135deg, rgba(44, 62, 80, 0.7) 0%, rgba(52, 73, 94, 0.5) 100%); */
            background: linear-gradient(135deg, rgb(0 0 0 / 70%) 0%, rgba(52, 73, 94, 0.5) 100%);
            display: flex;
            align-items: flex-end;
            padding: 25px;
            transition: all 0.3s ease;
        }

        .area-card:hover .area-overlay {
            background: linear-gradient(135deg, rgb(0 0 0 / 80%) 0%, rgba(52, 73, 94, 0.6) 100%);
        }

        .area-content {
            color: white;
            width: 100%;
        }

        .property-count {
            font-size: 14px;
            opacity: 0.9;
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .area-name {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: white;
        }

        .more-details-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .more-details-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateX(5px);
        }

        .more-details-btn i {
            font-size: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .areas-grid {
                grid-template-columns: 1fr;
                grid-auto-rows: 250px;
            }

            .large-card,
            .medium-card,
            .small-card {
                grid-row: span 1;
                grid-column: span 1;
            }

            .area-name {
                font-size: 1.5rem;
            }

            .dubai-areas-section {
                padding: 60px 0;
            }
        }

        @media (max-width: 992px) {
            .large-card {
                grid-column: span 1;
            }
        }

        .blog-section {
            background: white;
            padding: 80px 0;
        }

        .featured-blog-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .featured-blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .featured-blog-card .blog-image {
            height: 250px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .featured-blog-card .blog-content {
            padding: 30px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .featured-blog-card .blog-category {
            background: #2c3e50;
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
        }

        .featured-blog-card .blog-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .featured-blog-card .blog-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .featured-blog-card .blog-title a:hover {
            color: #34495e;
        }

        .featured-blog-card .blog-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .featured-blog-card .blog-meta {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .blog-card-small {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 120px;
        }

        .blog-card-small:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
        }

        .blog-image-small {
            height: 120px;
            background-size: cover;
            background-position: center;
        }

        .blog-content-small {
            padding: 15px;
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .blog-category-small {
            background: #f8f9fa;
            color: #2c3e50;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 8px;
        }

        .blog-title-small {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .blog-title-small a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .blog-title-small a:hover {
            color: #34495e;
        }

        .blog-meta-small {
            display: flex;
            gap: 10px;
            font-size: 11px;
            color: #999;
        }

        @media (max-width: 768px) {
            .blog-section {
                padding: 60px 0;
            }

            .featured-blog-card .blog-image {
                height: 200px;
            }

            .featured-blog-card .blog-content {
                padding: 20px;
            }

            .featured-blog-card .blog-title {
                font-size: 1.3rem;
            }

            .blog-card-small {
                margin-bottom: 15px;
            }

            .blog-meta {
                flex-wrap: wrap;
                gap: 10px !important;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <div class="container justify-content-center align-items-center">
            <div class="logo-section mb-4">
                <div>
                    <h1 class="brand-text text-center">Flemington</h1>
                    <p class="brand-subtitle">INVESTMENT ADVISORY</p>
                </div>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>


    <!-- Hero Carousel Slider -->
    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">

        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="4"></button>
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="carousel-text">
                    <p class="carousel-title">Every investment, backed by research.</p>
                    <p class="carousel-subtitle">From market timing to tax structuring — every move is informed.</p>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="carousel-text">
                    <p class="carousel-title">A portfolio that grows and pays.</p>
                    <p class="carousel-subtitle">Not just capital appreciation — but dependable passive income.</p>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <div class="carousel-text">
                    <p class="carousel-title">A future you can hand down.</p>
                    <p class="carousel-subtitle">We help you build for tomorrow, with confidence today.</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container-fluid bg-dark mb-5 py-4">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="text-white">Flemington.ae</h2>
                    <p class="text-white mb-0">Navigating Dubai Real Estate Investments with Precision</p>
                </div>
            </div>
        </div>
        <div class="container py-5">
            <div class="row">
                <!-- What We Do -->
                <div class="col-lg-6 mb-5">
                    <h3 class="section-title">WHAT WE DO</h3>
                    <p class="mb-4"><strong>Insightful Real Estate Advisory built for:</strong></p>

                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <strong>• Investors</strong><br>
                            <span class="text-muted">looking to maximize ROI</span>
                        </li>
                        <li class="mb-3">
                            <strong>• Homebuyers</strong><br>
                            <span class="text-muted">seeking value and timing</span>
                        </li>
                        <li class="mb-3">
                            <strong>• Developers</strong><br>
                            <span class="text-muted">evaluating land, location, and viability</span>
                        </li>
                        <li class="mb-4">
                            <strong>• Institutions</strong><br>
                            <span class="text-muted">needing due diligence & forecasting</span>
                        </li>
                    </ul>

                    <h4 class="section-title mt-5">OUR APPROACH</h4>
                    <p class="mb-3"><strong>Analytics First. Emotion Second.</strong></p>
                    <ul class="list-unstyled">
                        <li class="mb-2">• Market Entry Timing</li>
                        <li class="mb-2">• Growth Zone Identification</li>
                        <li class="mb-2">• Risk-Adjusted Return Projections</li>
                        <li class="mb-2">• Portfolio Performance Audits</li>
                    </ul>
                </div>

                <!-- Why Flemington Properties -->
                <div class="col-lg-6 mb-5">
                    <h3 class="section-title">WHY FLEMINGTON PROPERTIES?</h3>

                    <div class="check-item">
                        <i class="fas fa-check check-icon"></i>
                        <span>100% Independent Advice</span>
                    </div>
                    <div class="check-item">
                        <i class="fas fa-check check-icon"></i>
                        <span>Custom Investment Dashboards</span>
                    </div>
                    <div class="check-item">
                        <i class="fas fa-check check-icon"></i>
                        <span>Quarterly Trend Reports</span>
                    </div>
                    <div class="check-item mb-4">
                        <i class="fas fa-check check-icon"></i>
                        <span>Expert Team with Finance & Real Estate Credentials</span>
                    </div>

                    <h4 class="section-title mt-5">SAMPLE INSIGHTS</h4>
                    <div class="insight-box">
                        <p class="mb-3">Properties within 5km of new metro projects have seen a 24% CAGR over 3 years — but only in low-supply corridors.</p>
                        <p class="mb-0">In 2024, rental yields in Tier-2 cities outperformed Tier-1 by 1.3% on average — driven by hybrid worktrends.</p>
                    </div>

                    <a href="#" class="cta-button mb-4">
                        Download Full 2025 Market Outlook <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <!-- Call to Action Section -->
            <div class="row mt-5">
                <div class="col-lg-8">
                    <h3 class="section-title">LET'S TALK STRATEGY</h3>
                    <p class="mb-4">Whether you're buying your first asset or restructuring a portfolio — start with intelligence, not instinct.</p>
                    <button type="button" class="cta-button me-3 border-0" data-bs-toggle="modal" data-bs-target="#consultationModal">BOOK A FREE CONSULTATION</button>
                    <p class="mt-3 mb-0">
                        You can also reach us directly at <a href="mailto:ub@flemington.ae" class="text-decoration-none">ub@flemington.ae</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Dubai Areas Section -->
    <section class="dubai-areas-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">Explore Dubai's Prime Locations</h2>
                    <p class="lead">Discover investment opportunities across Dubai's most sought-after neighborhoods. From luxury waterfront properties to bustling business districts, find the perfect location for your next investment.</p>
                </div>
            </div>

            <div class="areas-grid">
                <!-- Business Bay -->
                <div class="area-card large-card" style="background-image: url('/assets/images/dubai-neighborhood-business-bay.webp');">
                    <div class="area-overlay">
                        <div class="area-content">
                            <span class="property-count">12 Properties</span>
                            <h3 class="area-name">Business Bay</h3>
                            <button class="more-details-btn  d-none">
                                <span>MORE DETAILS</span>
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dubai Marina -->
                <div class="area-card medium-card" style="background-image: url('/assets/images/DSubai-marina-2-780x780.webp');">
                    <div class="area-overlay">
                        <div class="area-content">
                            <span class="property-count">8 Properties</span>
                            <h3 class="area-name">Dubai Marina</h3>
                            <button class="more-details-btn  d-none">
                                <span>MORE DETAILS</span>
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Downtown Dubai -->
                <div class="area-card medium-card" style="background-image: url('/assets/images/Downtown-dubai-2-780x780.jpg');">
                    <div class="area-overlay">
                        <div class="area-content">
                            <span class="property-count">15 Properties</span>
                            <h3 class="area-name">Downtown Dubai</h3>
                            <button class="more-details-btn  d-none">
                                <span>MORE DETAILS</span>
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Palm Jumeirah -->
                <div class="area-card large-card" style="background-image: url('/assets/images/palm-jumeirah-dubai-990x600.webp');">
                    <div class="area-overlay">
                        <div class="area-content">
                            <span class="property-count">6 Properties</span>
                            <h3 class="area-name">Palm Jumeirah</h3>
                            <button class="more-details-btn d-none">
                                <span>MORE DETAILS</span>
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="blog-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">Latest Market Insights</h2>
                    <p class="lead">Stay ahead with our expert analysis, market trends, and investment insights. Get the knowledge you need to make informed real estate decisions.</p>
                </div>
            </div>

            <?php if (isset($db_error) || (!$featured_post && empty($recent_posts))): ?>
                <!-- Fallback content when database is unavailable -->
                <div class="no-posts-message">
                    <i class="fas fa-newspaper"></i>
                    <h4>Blog Content Coming Soon</h4>
                    <p>We're preparing valuable market insights and analysis for you. Check back soon for the latest real estate trends and investment guidance.</p>
                    <a href="blog.php" class="cta-button">
                        Visit Our Blog <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            <?php else: ?>
                <div class="row">
                    <!-- Featured Blog Post -->
                    <?php if ($featured_post): ?>
                        <div class="col-lg-6 mb-4">
                            <article class="featured-blog-card">
                                <div class="blog-image" style="background-image: url('<?php echo htmlspecialchars($featured_post['featured_image'] ?: '/placeholder.svg?height=300&width=600'); ?>');"></div>
                                <div class="blog-content">
                                    <span class="blog-category"><?php echo htmlspecialchars($featured_post['category']); ?></span>
                                    <h3 class="blog-title">
                                        <a href="blog-detail.php?slug=<?php echo urlencode($featured_post['slug']); ?>">
                                            <?php echo htmlspecialchars($featured_post['title']); ?>
                                        </a>
                                    </h3>
                                    <p class="blog-excerpt">
                                        <?php echo createExcerpt($featured_post['content'], 150); ?>
                                    </p>
                                    <div class="blog-meta">
                                        <span><i class="fas fa-calendar-alt me-1"></i><?php echo formatDate($featured_post['created_at']); ?></span>
                                        <span><i class="fas fa-eye me-1"></i><?php echo number_format($featured_post['views']); ?> views</span>
                                        <span><i class="fas fa-clock me-1"></i><?php echo calculateReadingTime($featured_post['content']); ?> min read</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endif; ?>

                    <!-- Recent Blog Posts -->
                    <div class="col-lg-6">
                        <div class="row">
                            <?php if (!empty($recent_posts)): ?>
                                <?php foreach ($recent_posts as $post): ?>
                                    <div class="col-md-12 mb-4">
                                        <article class="blog-card-small">
                                            <div class="row g-0">
                                                <div class="col-4">
                                                    <div class="blog-image-small" style="background-image: url('<?php echo htmlspecialchars($post['featured_image'] ?: '/placeholder.svg?height=120&width=160'); ?>');"></div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="blog-content-small">
                                                        <span class="blog-category-small"><?php echo htmlspecialchars($post['category']); ?></span>
                                                        <h4 class="blog-title-small">
                                                            <a href="blog-detail.php?slug=<?php echo urlencode($post['slug']); ?>">
                                                                <?php echo htmlspecialchars($post['title']); ?>
                                                            </a>
                                                        </h4>
                                                        <div class="blog-meta-small">
                                                            <span><i class="fas fa-calendar-alt me-1"></i><?php echo formatDate($post['created_at']); ?></span>
                                                            <span><i class="fas fa-eye me-1"></i><?php echo number_format($post['views']); ?> views</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Show placeholder if no recent posts -->
                                <div class="col-12">
                                    <div class="text-center py-4">
                                        <p class="text-muted">More articles coming soon...</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="blog" class="cta-button">
                        View All Articles <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>



    <?php require_once('includes/footer.php'); ?>

    <!-- Consultation Modal -->
    <div class="modal fade" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2c3e50; color: white;">
                    <h5 class="modal-title" id="consultationModalLabel">Book Your Free Consultation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-4">Please fill out the form below and our real estate advisory team will contact you within 24 hours to schedule your consultation.</p>

                    <form id="consultationForm" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name*</label>
                                <input type="text" class="form-control" id="firstName" required>
                                <div class="invalid-feedback">
                                    Please provide your first name.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name*</label>
                                <input type="text" class="form-control" id="lastName" required>
                                <div class="invalid-feedback">
                                    Please provide your last name.
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address*</label>
                                <input type="email" class="form-control" id="email" required>
                                <div class="invalid-feedback">
                                    Please provide a valid email address.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number*</label>
                                <input type="tel" class="form-control" id="phone" required>
                                <div class="invalid-feedback">
                                    Please provide your phone number.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="investmentType" class="form-label">Investment Type</label>
                            <select class="form-select" id="investmentType">
                                <option selected disabled value="">Choose...</option>
                                <option>Residential Property</option>
                                <option>Commercial Property</option>
                                <option>Land Development</option>
                                <option>Portfolio Management</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="budget" class="form-label">Investment Budget Range</label>
                            <select class="form-select" id="budget">
                                <option selected disabled value="">Choose...</option>
                                <option>Under $250,000</option>
                                <option>$250,000 - $500,000</option>
                                <option>$500,000 - $1,000,000</option>
                                <option>$1,000,000 - $5,000,000</option>
                                <option>Over $5,000,000</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Additional Information</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Tell us about your investment goals or any specific questions you have..."></textarea>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="privacyPolicy" required>
                            <label class="form-check-label" for="privacyPolicy">I agree to the privacy policy and terms of service*</label>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" style="background-color: #2c3e50; border: none;" onclick="submitForm()">Submit Request</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #27ae60; color: white;">
                    <h5 class="modal-title">Request Submitted!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-check-circle" style="font-size: 3rem; color: #27ae60;"></i>
                    </div>
                    <h4 class="text-center">Thank You!</h4>
                    <p class="text-center">Your consultation request has been successfully submitted. A member of our team will contact you within 24 hours to schedule your free consultation.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form validation
        (function() {
            'use strict'

            // Fetch all forms to which we want to apply validation
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        // Form submission handler
        function submitForm() {
            const form = document.getElementById('consultationForm');

            if (form.checkValidity()) {
                // Hide consultation modal
                const consultationModal = bootstrap.Modal.getInstance(document.getElementById('consultationModal'));
                consultationModal.hide();

                // Show success modal
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                // Reset form
                form.reset();
                form.classList.remove('was-validated');

                // In a real application, you would send the form data to your server here
                // For example:
                // const formData = new FormData(form);
                // fetch('/submit-consultation', {
                //     method: 'POST',
                //     body: formData
                // });
            } else {
                form.classList.add('was-validated');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Chart initialization with enhanced Chart.js implementation
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('aroiChart').getContext('2d');
            const aroiChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Tier-1', 'Tier-2', 'Tier-3'],
                    datasets: [{
                        label: '10-Year AROI',
                        data: [5.6, 7.2, 9.2],
                        fill: false,
                        tension: 0.4,
                        borderColor: '#7fa6bd',
                        backgroundColor: '#7fa6bd',
                        pointRadius: 5,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 1.5,
                            max: 9.5,
                            ticks: {
                                callback: function(value) {
                                    return value + ' %';
                                },
                                color: 'white'
                            },
                            grid: {
                                color: '#444'
                            }
                        },
                        x: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.raw + ' %';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>