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

    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <div class="container justify-content-center align-items-center">
            <div class="logo-section mb-4">
                <div>
                    <?php include 'includes/logo.php'; ?>
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
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <!-- video with overlay background -->
                <div class="video-background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden;">
                    <div style="position: absolute; width:100%; height: 100%; background: rgba(0 ,0, 0, 0.7)"></div>
                    <video autoplay muted loop class="w-100 h-100" style="object-fit: cover;">
                        <source src="https://media.istockphoto.com/id/1130999398/video/aerial-view-of-a-yacht-in-the-bay-of-dubai-during-sunset-u-a-e.mp4?s=mp4-640x640-is&k=20&c=0ASA4nKXKmSm3tBBO2n1J2Rf7GerJQJSpHufy2X55fo=" type="video/mp4">
                    </video>
                </div>
                <div class="carousel-text" style="position: relative; z-index: 1; color: white;">
                    <p class="carousel-title">Every investment, backed by research.</p>
                    <p class="carousel-subtitle">From market timing to tax structuring — every move is informed.</p>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <!-- video with overlay background -->
                <div class="video-background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden;">
                    <div style="position: absolute; width:100%; height: 100%; background: rgba(0 ,0, 0, 0.7)"></div>
                    <video autoplay muted loop class="w-100 h-100" style="object-fit: cover;">
                        <source src="https://media.istockphoto.com/id/473356869/video/aerial-view-palm-atlantis-dubai.mp4?s=mp4-640x640-is&k=20&c=q2L92MljZZ9WMCucSBxTDwfZVrfhAhMzQECu_CNAfts=" type="video/mp4">
                    </video>
                </div>
                <div class="carousel-text" style="position: relative; z-index: 1; color: white;">
                    <p class="carousel-title">A portfolio that grows and pays.</p>
                    <p class="carousel-subtitle">Not just capital appreciation — but dependable passive income.</p>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <!-- video with overlay background -->
                <div class="video-background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden;">
                    <div style="position: absolute; width:100%; height: 100%; background: rgba(0 ,0, 0, 0.7)"></div>
                    <video autoplay muted loop class="w-100 h-100" style="object-fit: cover;">
                        <source src="https://media.istockphoto.com/id/1366594945/video/two-young-brothers-jumping-off-the-boat-into-the-sea-at-sunset.mp4?s=mp4-640x640-is&k=20&c=XPYjnU_0KEekni2xK3GSF38pYlBja_vtdVpCeQX-n3k=" type="video/mp4">
                    </video>
                </div>
                <div class="carousel-text" style="position: relative; z-index: 1; color: white;">
                    <p class="carousel-title">A future you can hand down.</p>
                    <p class="carousel-subtitle">We help you build for tomorrow, with confidence today.</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container-fluid bg-dark py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="text-white">Flemington.ae</h2>
                    <p class="text-white mb-0">Navigating Dubai Real Estate Investments with Precision</p>
                    <button class="btn btn-danger mt-3">Know more <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div id="aboutCarousel" class="carousel slide about-carousel" data-bs-ride="carousel" data-bs-interval="5000">

            <!-- Carousel Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#aboutCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#aboutCarousel" data-bs-slide-to="1"></button>
            </div>

            <!-- Carousel Items -->
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="row">
                        <!-- What We Do -->
                        <div class="col-lg-3 col-sm-12">
                            <div>
                                <h3 class="section-title text-danger">WHAT WE DO?</h3>
                                <p class="mb-3"><strong>Investment advisory built for:</strong></p>

                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        • International Investors
                                    </li>
                                    <li class="mb-2">
                                        • Expats moving to UAE
                                    </li>
                                    <li class="mb-2">
                                        • Private Offices & UHNIs
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-5 col-sm-12">
                            <p class="para-text mt-5">
                                Across borders and asset types, we support clients with intelligent deal sourcing, active investment management, and strategic exits. Whether pursuing growth, timing a key purchase, or preserving family capital, our advisory blends insight, structure, and long-term clarity.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-lg-3 col-sm-12">
                            <div>
                                <h4 class="section-title text-danger">OUR APPROACH?</h4>
                                <p class="mb-3"><strong>Analytics First. Emotion Second.</strong></p>
                                <ul class="list-unstyled">
                                    <li class="mb-2">• Unbiased independent advice</li>
                                    <li class="mb-2">• Facts over instinct, logic over noise</li>
                                    <li class="mb-2">• Risk identified and managed</li>
                                    <li class="mb-2">• Growth zone and products identification </li>
                                    <li class="mb-2">• Market moves planned with precision</li>
                                    <li class="mb-2">• Comprehensive post-purchase support</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-5 col-sm-12">
                            <p class="para-text mt-5">At Flemington, we act with the discipline of a traditional investment house—measured, rational, and enduring. Our advice is unbiased and independent, guided by data, structure, and a clear view of risk. We plan with precision, support beyond the purchase, and focus not just on returns, but on building long-term value that lasts generations. Our vision is for the decades, not quarters!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="bg-primary why-flemington text-white">
        <div class="container">
            <div class="row py-5 px-5">
                <div class="col-lg-6 col-sm-12">
                    <h3 class="section-title  text-white mt-5">WHY FLEMINGTON PROPERTIES?</h3>

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
                </div>

                <div class="col-lg-6 col-sm-12">
                    <h3 class="section-title  text-white mt-5">LET'S TALK STRATEGY</h3>
                    <p class="mb-4">Whether you're buying your first asset or restructuring a portfolio — start with intelligence, not instinct.</p>
                    <button type="button" class="btn btn-danger me-3 border-0" data-bs-toggle="modal" data-bs-target="#consultationModal">BOOK A FREE CONSULTATION</button>
                    <p class="mt-3 mb-0">
                        You can also reach us directly at <a href="mailto:ub@flemington.ae" class="text-danger text-decoration-none">ub@flemington.ae</a>
                    </p>
                </div>
            </div>
        </div>

    </section>
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