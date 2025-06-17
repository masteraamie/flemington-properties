<?php

require_once('includes/db-connection.php');

// Get post slug from URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (empty($slug)) {
    header('Location: blog');
    exit;
}

// Get post details
$sql = "SELECT * FROM blog_posts WHERE slug = :slug AND status = 'published'";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':slug', $slug);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header('HTTP/1.0 404 Not Found');
    include '404.php';
    exit;
}

// Update view count
$update_sql = "UPDATE blog_posts SET views = views + 1 WHERE id = :id";
$update_stmt = $pdo->prepare($update_sql);
$update_stmt->bindParam(':id', $post['id']);
$update_stmt->execute();

// Get related posts
$related_sql = "SELECT * FROM blog_posts WHERE category = :category AND id != :id AND status = 'published' ORDER BY created_at DESC LIMIT 3";
$related_stmt = $pdo->prepare($related_sql);
$related_stmt->bindParam(':category', $post['category']);
$related_stmt->bindParam(':id', $post['id']);
$related_stmt->execute();
$related_posts = $related_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - Flemington Properties</title>
    <meta name="description" content="<?php echo htmlspecialchars(substr(strip_tags($post['content']), 0, 160)); ?>">
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
        
        .content-section {
            background: #f8f9fa;
            padding: 80px 0;
        }
        
        .article-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .article-header {
            padding: 40px;
            border-bottom: 1px solid #eee;
        }
        
        .article-category {
            background: #2c3e50;
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .article-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            line-height: 1.3;
        }
        
        .article-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            color: #666;
            font-size: 14px;
        }
        
        .article-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .featured-image {
            width: 100%;
            height: 400px;
            background-size: cover;
            background-position: center;
        }
        
        .article-content {
            padding: 40px;
        }
        
        .article-content h2 {
            color: #2c3e50;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        
        .article-content h3 {
            color: #34495e;
            font-weight: 600;
            margin-top: 25px;
            margin-bottom: 12px;
        }
        
        .article-content p {
            line-height: 1.8;
            margin-bottom: 20px;
            color: #555;
        }
        
        .article-content ul,
        .article-content ol {
            margin-bottom: 20px;
            padding-left: 30px;
        }
        
        .article-content li {
            margin-bottom: 8px;
            line-height: 1.6;
            color: #555;
        }
        
        .article-content blockquote {
            border-left: 4px solid #2c3e50;
            padding-left: 20px;
            margin: 30px 0;
            font-style: italic;
            color: #666;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 0 5px 5px 0;
        }
        
        .share-section {
            background: #f8f9fa;
            padding: 20px 40px;
            border-top: 1px solid #eee;
        }
        
        .share-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .share-facebook {
            background: #1877f2;
            color: white;
        }
        
        .share-twitter {
            background: #1da1f2;
            color: white;
        }
        
        .share-linkedin {
            background: #0077b5;
            color: white;
        }
        
        .share-btn:hover {
            transform: translateY(-2px);
            color: white;
        }
        
        .related-posts {
            margin-top: 60px;
        }
        
        .related-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .related-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .related-image {
            height: 150px;
            background-size: cover;
            background-position: center;
        }
        
        .related-content {
            padding: 20px;
        }
        
        .related-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        
        .related-title a {
            color: inherit;
            text-decoration: none;
        }
        
        .related-title a:hover {
            color: #34495e;
        }
        
        .related-date {
            font-size: 12px;
            color: #888;
        }
        
        .back-to-blog {
            background: #2c3e50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }
        
        .back-to-blog:hover {
            background: #34495e;
            color: white;
            transform: translateX(-3px);
        }
        
        .footer-section {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
        }
        
        @media (max-width: 768px) {
            .article-title {
                font-size: 2rem;
            }
            
            .article-header,
            .article-content {
                padding: 25px;
            }
            
            .share-section {
                padding: 20px 25px;
            }
            
            .featured-image {
                height: 250px;
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
                        <div class="logo-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div>
                            <h1 class="brand-text">Flemington Properties</h1>
                            <p class="brand-subtitle">REAL ESTATE ADVISORY</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <a href="blog" class="back-to-blog">
                        <i class="fas fa-arrow-left"></i>
                        Back to Blog
                    </a>
                    
                    <article class="article-container">
                        <!-- Article Header -->
                        <div class="article-header">
                            <span class="article-category"><?php echo htmlspecialchars($post['category']); ?></span>
                            <h1 class="article-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                            <div class="article-meta">
                                <span>
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                                </span>
                                <span>
                                    <i class="fas fa-eye"></i>
                                    <?php echo number_format($post['views']); ?> views
                                </span>
                                <span>
                                    <i class="fas fa-clock"></i>
                                    <?php echo ceil(str_word_count(strip_tags($post['content'])) / 200); ?> min read
                                </span>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <?php if ($post['featured_image']): ?>
                            <div class="featured-image" style="background-image: url('<?php echo htmlspecialchars($post['featured_image']); ?>');"></div>
                        <?php endif; ?>

                        <!-- Article Content -->
                        <div class="article-content">
                            <?php echo $post['content']; ?>
                        </div>

                        <!-- Share Section -->
                        <div class="share-section">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h6 class="mb-3 mb-md-0">Share this article:</h6>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                                       target="_blank" class="share-btn share-facebook">
                                        <i class="fab fa-facebook-f"></i>
                                        Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($post['title']); ?>" 
                                       target="_blank" class="share-btn share-twitter">
                                        <i class="fab fa-twitter"></i>
                                        Twitter
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                                       target="_blank" class="share-btn share-linkedin">
                                        <i class="fab fa-linkedin-in"></i>
                                        LinkedIn
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Related Posts -->
                    <?php if (!empty($related_posts)): ?>
                        <div class="related-posts">
                            <h3 class="section-title mb-4">Related Articles</h3>
                            <div class="row">
                                <?php foreach ($related_posts as $related): ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="related-card">
                                            <div class="related-image" style="background-image: url('<?php echo htmlspecialchars($related['featured_image'] ?: '/placeholder.svg?height=150&width=300'); ?>');"></div>
                                            <div class="related-content">
                                                <h4 class="related-title">
                                                    <a href="blog-detail?slug=<?php echo urlencode($related['slug']); ?>">
                                                        <?php echo htmlspecialchars($related['title']); ?>
                                                    </a>
                                                </h4>
                                                <p class="related-date">
                                                    <?php echo date('M j, Y', strtotime($related['created_at'])); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
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
