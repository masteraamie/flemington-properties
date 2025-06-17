<?php

require_once('includes/db-connection.php');

// Pagination settings
$posts_per_page = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

// Get category filter
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Build query
$where_clause = "WHERE status = 'published'";
$params = [];

if ($category_filter) {
    $where_clause .= " AND category = :category";
    $params[':category'] = $category_filter;
}

// Get total posts count
$count_sql = "SELECT COUNT(*) FROM blog_posts $where_clause";
$count_stmt = $pdo->prepare($count_sql);
$count_stmt->execute($params);
$total_posts = $count_stmt->fetchColumn();
$total_pages = ceil($total_posts / $posts_per_page);

// Get posts
$sql = "SELECT * FROM blog_posts $where_clause ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $posts_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get categories for filter
$cat_sql = "SELECT DISTINCT category FROM blog_posts WHERE status = 'published' ORDER BY category";
$cat_stmt = $pdo->prepare($cat_sql);
$cat_stmt->execute();
$categories = $cat_stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Flemington Properties</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 60px 0;
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

        .page-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-top: 30px;
        }

        .content-section {
            background: #f8f9fa;
            padding: 80px 0;
        }

        .blog-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .blog-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .blog-category {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #2c3e50;
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }

        .blog-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .blog-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .blog-title a {
            color: inherit;
            text-decoration: none;
        }

        .blog-title a:hover {
            color: #34495e;
        }

        .blog-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .blog-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .read-more {
            color: #2c3e50;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .read-more:hover {
            color: #34495e;
        }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
        }

        .filter-btn {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #495057;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            margin: 5px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #2c3e50;
            color: white;
            border-color: #2c3e50;
        }

        .pagination {
            justify-content: center;
            margin-top: 50px;
        }

        .page-link {
            color: #2c3e50;
            border-color: #dee2e6;
        }

        .page-link:hover {
            color: #34495e;
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .page-item.active .page-link {
            background-color: #2c3e50;
            border-color: #2c3e50;
        }

        .footer-section {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .content-section {
                padding: 60px 0;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo-section mb-4">
                        <?php include('includes/logo.php')  ?>
                        <div>
                            <h1 class="brand-text">Flemington Properties</h1>
                            <p class="brand-subtitle">REAL ESTATE ADVISORY</p>
                        </div>
                    </div>

                    <h1 class="page-title">Market Insights & Analysis</h1>
                    <p class="mb-0">Stay informed with the latest real estate trends, market analysis, and investment insights</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-3 mb-md-0">Filter by Category:</h5>
                        <a href="blog" class="filter-btn <?php echo empty($category_filter) ? 'active' : ''; ?>">All Posts</a>
                        <?php foreach ($categories as $category): ?>
                            <a href="blog?category=<?php echo urlencode($category); ?>"
                                class="filter-btn <?php echo $category_filter === $category ? 'active' : ''; ?>">
                                <?php echo htmlspecialchars($category); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="text-muted"><?php echo $total_posts; ?> articles found</span>
                    </div>
                </div>
            </div>

            <!-- Blog Posts Grid -->
            <div class="row">
                <?php if (empty($posts)): ?>
                    <div class="col-12 text-center">
                        <div class="py-5">
                            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                            <h4>No articles found</h4>
                            <p class="text-muted">Try adjusting your filter or check back later for new content.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <article class="blog-card">
                                <div class="blog-image" style="background-image: url('<?php echo htmlspecialchars($post['featured_image'] ?: '/placeholder.svg?height=200&width=400'); ?>');">
                                    <span class="blog-category"><?php echo htmlspecialchars($post['category']); ?></span>
                                </div>
                                <div class="blog-content">
                                    <h2 class="blog-title">
                                        <a href="blog-detail?slug=<?php echo urlencode($post['slug']); ?>">
                                            <?php echo htmlspecialchars($post['title']); ?>
                                        </a>
                                    </h2>
                                    <p class="blog-excerpt">
                                        <?php echo htmlspecialchars(substr(strip_tags($post['content']), 0, 150)) . '...'; ?>
                                    </p>
                                    <div class="blog-meta">
                                        <span>
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            <?php echo date('M j, Y', strtotime($post['created_at'])); ?>
                                        </span>
                                        <a href="blog-detail?slug=<?php echo urlencode($post['slug']); ?>" class="read-more">
                                            Read More <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Blog pagination">
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="blog?page=<?php echo $page - 1; ?><?php echo $category_filter ? '&category=' . urlencode($category_filter) : ''; ?>">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                <a class="page-link" href="blog?page=<?php echo $i; ?><?php echo $category_filter ? '&category=' . urlencode($category_filter) : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="blog?page=<?php echo $page + 1; ?><?php echo $category_filter ? '&category=' . urlencode($category_filter) : ''; ?>">
                                    Next <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p class="mb-2">Flemington Properties Advisory | Registered RERA Partner | © 2025</p>
                    <p class="mb-0">
                        <a href="index" class="text-white text-decoration-none me-3">Home</a>
                        <a href="blog" class="text-white text-decoration-none me-3">Blog</a>
                        <a href="privacy-policy" class="text-white text-decoration-none me-3">Privacy Policy</a>
                        <a href="#" class="text-white text-decoration-none">Contact</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>