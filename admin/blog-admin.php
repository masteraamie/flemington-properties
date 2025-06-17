<?php
session_start();

// Simple authentication (in production, use proper authentication)
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login');
    exit;
}

require_once('../includes/db-connection.php');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $title = $_POST['title'];
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
                $content = $_POST['content'];
                $excerpt = $_POST['excerpt'];
                $category = $_POST['category'];
                $featured_image = $_POST['featured_image'];
                $status = $_POST['status'];

                $sql = "INSERT INTO blog_posts (title, slug, content, excerpt, category, featured_image, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$title, $slug, $content, $excerpt, $category, $featured_image, $status]);

                $success = "Post created successfully!";
                break;

            case 'update':
                $id = $_POST['id'];
                $title = $_POST['title'];
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
                $content = $_POST['content'];
                $excerpt = $_POST['excerpt'];
                $category = $_POST['category'];
                $featured_image = $_POST['featured_image'];
                $status = $_POST['status'];

                $sql = "UPDATE blog_posts SET title=?, slug=?, content=?, excerpt=?, category=?, featured_image=?, status=?, updated_at=NOW() WHERE id=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$title, $slug, $content, $excerpt, $category, $featured_image, $status, $id]);

                $success = "Post updated successfully!";
                break;

            case 'delete':
                $id = $_POST['id'];
                $sql = "DELETE FROM blog_posts WHERE id=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);

                $success = "Post deleted successfully!";
                break;
        }
    }
}

// Get all posts
$sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get post for editing
$edit_post = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $sql = "SELECT * FROM blog_posts WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$edit_id]);
    $edit_post = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Admin - Flemington Properties</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <style>
        /* CKEditor 5 custom styling */
        .ck-editor__editable {
            min-height: 400px;
        }

        .ck-editor__editable_inline {
            border: 2px solid #e9ecef;
            border-radius: 0 0 8px 8px;
        }

        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border-color: #e9ecef;
        }

        .ck.ck-editor__main>.ck-editor__editable.ck-focused {
            border-color: #2c3e50;
            box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
        }

        .ck.ck-toolbar {
            border: 2px solid #e9ecef;
            border-bottom: none;
            border-radius: 8px 8px 0 0;
            background: #f8f9fa;
        }

        .ck.ck-toolbar .ck-toolbar__separator {
            background: #dee2e6;
        }

        .ck.ck-button:not(.ck-disabled):hover {
            background-color: #2c3e50;
            color: white;
        }

        .ck.ck-button.ck-on {
            background-color: #2c3e50;
            color: white;
        }

        .ck.ck-dropdown__button:hover {
            background-color: #2c3e50;
            color: white;
        }

        /* Responsive toolbar */
        @media (max-width: 768px) {
            .ck.ck-toolbar {
                flex-wrap: wrap;
            }

            .ck.ck-toolbar .ck-toolbar__separator {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 bg-dark text-white p-3">
                <div class="d-flex align-items-center mb-4">
                    <div class="logo-icon me-2" style="width: 30px; height: 30px; background: white; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: #2c3e50; font-size: 16px;">
                        <i class="fas fa-home"></i>
                    </div>
                    <div>
                        <h6 class="mb-0" style="font-size: 14px;">Flemington Properties</h6>
                        <small style="font-size: 10px; opacity: 0.8;">BLOG ADMIN</small>
                    </div>
                </div>

                <div class="mb-3 pb-3 border-bottom border-secondary">
                    <small class="text-muted">Welcome back,</small>
                    <div class="fw-bold"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></div>
                    <small class="text-muted">Last login: <?php echo date('M j, g:i A', $_SESSION['login_time'] ?? time()); ?></small>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="#posts">
                            <i class="fas fa-list me-2"></i>
                            All Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="#new-post">
                            <i class="fas fa-plus me-2"></i>
                            New Post
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="../blog" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>
                            View Blog
                        </a>
                    </li>
                    <li class="nav-item mt-3 pt-3 border-top border-secondary">
                        <a class="nav-link text-white d-flex align-items-center" href="../index.html" target="_blank">
                            <i class="fas fa-globe me-2"></i>
                            View Website
                        </a>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-white d-flex align-items-center border-0 bg-transparent w-100 text-start"
                            onclick="confirmLogout()"
                            style="cursor: pointer;">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout
                        </button>
                    </li>
                </ul>

                <div class="mt-auto pt-4">
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Secure Session
                        </small>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <!-- New/Edit Post Form -->
                <div class="card mb-4" id="new-post">
                    <div class="card-header">
                        <h5><?php echo $edit_post ? 'Edit Post' : 'Create New Post'; ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="<?php echo $edit_post ? 'update' : 'create'; ?>">
                            <?php if ($edit_post): ?>
                                <input type="hidden" name="id" value="<?php echo $edit_post['id']; ?>">
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" value="<?php echo $edit_post ? htmlspecialchars($edit_post['title']) : ''; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Content</label>
                                        <textarea class="form-control" name="content" id="content-editor" rows="15"><?php echo $edit_post ? $edit_post['content'] : ''; ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Excerpt</label>
                                        <textarea class="form-control" name="excerpt" rows="3"><?php echo $edit_post ? htmlspecialchars($edit_post['excerpt']) : ''; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="form-select" name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="Market Analysis" <?php echo ($edit_post && $edit_post['category'] === 'Market Analysis') ? 'selected' : ''; ?>>Market Analysis</option>
                                            <option value="Investment Guide" <?php echo ($edit_post && $edit_post['category'] === 'Investment Guide') ? 'selected' : ''; ?>>Investment Guide</option>
                                            <option value="Legal Guide" <?php echo ($edit_post && $edit_post['category'] === 'Legal Guide') ? 'selected' : ''; ?>>Legal Guide</option>
                                            <option value="Property News" <?php echo ($edit_post && $edit_post['category'] === 'Property News') ? 'selected' : ''; ?>>Property News</option>
                                            <option value="Dubai Insights" <?php echo ($edit_post && $edit_post['category'] === 'Dubai Insights') ? 'selected' : ''; ?>>Dubai Insights</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Featured Image URL</label>
                                        <input type="url" class="form-control" name="featured_image" value="<?php echo $edit_post ? htmlspecialchars($edit_post['featured_image']) : ''; ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status">
                                            <option value="draft" <?php echo ($edit_post && $edit_post['status'] === 'draft') ? 'selected' : ''; ?>>Draft</option>
                                            <option value="published" <?php echo ($edit_post && $edit_post['status'] === 'published') ? 'selected' : ''; ?>>Published</option>
                                            <option value="archived" <?php echo ($edit_post && $edit_post['status'] === 'archived') ? 'selected' : ''; ?>>Archived</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        <?php echo $edit_post ? 'Update Post' : 'Create Post'; ?>
                                    </button>

                                    <?php if ($edit_post): ?>
                                        <a href="blog-admin" class="btn btn-secondary w-100 mt-2">Cancel Edit</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Posts List -->
                <div class="card" id="posts">
                    <div class="card-header">
                        <h5>All Posts</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Views</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($posts as $post): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($post['category']); ?></span></td>
                                            <td>
                                                <span class="badge bg-<?php echo $post['status'] === 'published' ? 'success' : ($post['status'] === 'draft' ? 'warning' : 'secondary'); ?>">
                                                    <?php echo ucfirst($post['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo number_format($post['views']); ?></td>
                                            <td><?php echo date('M j, Y', strtotime($post['created_at'])); ?></td>
                                            <td>
                                                <a href="?edit=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                                <a href="../blog-detail?slug=<?php echo urlencode($post['slug']); ?>" target="_blank" class="btn btn-sm btn-outline-info">View</a>
                                                <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize CKEditor 5
        let editorInstance;

        ClassicEditor
            .create(document.querySelector('#content-editor'), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                        'alignment', '|',
                        'numberedList', 'bulletedList', '|',
                        'outdent', 'indent', '|',
                        'link', 'insertImage', 'insertTable', 'mediaEmbed', '|',
                        'blockQuote', 'codeBlock', '|',
                        'horizontalLine', '|',
                        'undo', 'redo', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        }
                    ]
                },
                fontSize: {
                    options: [
                        9, 11, 13, 'default', 17, 19, 21, 27, 35
                    ],
                    supportAllValues: true
                },
                fontColor: {
                    colors: [{
                            color: 'hsl(0, 0%, 0%)',
                            label: 'Black'
                        },
                        {
                            color: 'hsl(0, 0%, 30%)',
                            label: 'Dim grey'
                        },
                        {
                            color: 'hsl(0, 0%, 60%)',
                            label: 'Grey'
                        },
                        {
                            color: 'hsl(0, 0%, 90%)',
                            label: 'Light grey'
                        },
                        {
                            color: 'hsl(0, 0%, 100%)',
                            label: 'White',
                            hasBorder: true
                        },
                        {
                            color: 'hsl(0, 75%, 60%)',
                            label: 'Red'
                        },
                        {
                            color: 'hsl(30, 75%, 60%)',
                            label: 'Orange'
                        },
                        {
                            color: 'hsl(60, 75%, 60%)',
                            label: 'Yellow'
                        },
                        {
                            color: 'hsl(90, 75%, 60%)',
                            label: 'Light green'
                        },
                        {
                            color: 'hsl(120, 75%, 60%)',
                            label: 'Green'
                        },
                        {
                            color: 'hsl(150, 75%, 60%)',
                            label: 'Aquamarine'
                        },
                        {
                            color: 'hsl(180, 75%, 60%)',
                            label: 'Turquoise'
                        },
                        {
                            color: 'hsl(210, 75%, 60%)',
                            label: 'Light blue'
                        },
                        {
                            color: 'hsl(240, 75%, 60%)',
                            label: 'Blue'
                        },
                        {
                            color: 'hsl(270, 75%, 60%)',
                            label: 'Purple'
                        },
                        // Flemington Properties brand colors
                        {
                            color: '#2c3e50',
                            label: 'Flemington Dark Blue'
                        },
                        {
                            color: '#34495e',
                            label: 'Flemington Blue'
                        }
                    ]
                },
                fontBackgroundColor: {
                    colors: [{
                            color: 'hsl(0, 75%, 60%)',
                            label: 'Red'
                        },
                        {
                            color: 'hsl(30, 75%, 60%)',
                            label: 'Orange'
                        },
                        {
                            color: 'hsl(60, 75%, 60%)',
                            label: 'Yellow'
                        },
                        {
                            color: 'hsl(90, 75%, 60%)',
                            label: 'Light green'
                        },
                        {
                            color: 'hsl(120, 75%, 60%)',
                            label: 'Green'
                        },
                        {
                            color: 'hsl(150, 75%, 60%)',
                            label: 'Aquamarine'
                        },
                        {
                            color: 'hsl(180, 75%, 60%)',
                            label: 'Turquoise'
                        },
                        {
                            color: 'hsl(210, 75%, 60%)',
                            label: 'Light blue'
                        },
                        {
                            color: 'hsl(240, 75%, 60%)',
                            label: 'Blue'
                        },
                        {
                            color: 'hsl(270, 75%, 60%)',
                            label: 'Purple'
                        }
                    ]
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                image: {
                    styles: [
                        'alignCenter',
                        'alignLeft',
                        'alignRight'
                    ],
                    resizeOptions: [{
                            name: 'resizeImage:original',
                            label: 'Original',
                            value: null
                        },
                        {
                            name: 'resizeImage:50',
                            label: '50%',
                            value: '50'
                        },
                        {
                            name: 'resizeImage:75',
                            label: '75%',
                            value: '75'
                        }
                    ],
                    toolbar: [
                        'imageTextAlternative', 'toggleImageCaption', '|',
                        'imageStyle:inline', 'imageStyle:wrapText', 'imageStyle:breakText', 'imageStyle:side', '|',
                        'resizeImage'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn', 'tableRow', 'mergeTableCells',
                        'tableProperties', 'tableCellProperties'
                    ],
                    tableProperties: {
                        borderColors: [{
                                color: 'hsl(0, 0%, 90%)',
                                label: 'Light grey'
                            },
                            {
                                color: 'hsl(0, 0%, 60%)',
                                label: 'Grey'
                            },
                            {
                                color: 'hsl(0, 0%, 30%)',
                                label: 'Dark grey'
                            },
                            {
                                color: 'hsl(0, 0%, 0%)',
                                label: 'Black'
                            },
                            {
                                color: '#2c3e50',
                                label: 'Flemington Blue'
                            }
                        ],
                        backgroundColors: [{
                                color: 'hsl(0, 0%, 100%)',
                                label: 'White'
                            },
                            {
                                color: 'hsl(0, 0%, 90%)',
                                label: 'Light grey'
                            },
                            {
                                color: 'hsl(0, 75%, 60%)',
                                label: 'Red'
                            },
                            {
                                color: 'hsl(30, 75%, 60%)',
                                label: 'Orange'
                            },
                            {
                                color: 'hsl(60, 75%, 60%)',
                                label: 'Yellow'
                            },
                            {
                                color: 'hsl(90, 75%, 60%)',
                                label: 'Light green'
                            },
                            {
                                color: 'hsl(120, 75%, 60%)',
                                label: 'Green'
                            },
                            {
                                color: 'hsl(150, 75%, 60%)',
                                label: 'Aquamarine'
                            },
                            {
                                color: 'hsl(180, 75%, 60%)',
                                label: 'Turquoise'
                            },
                            {
                                color: 'hsl(210, 75%, 60%)',
                                label: 'Light blue'
                            },
                            {
                                color: 'hsl(240, 75%, 60%)',
                                label: 'Blue'
                            },
                            {
                                color: 'hsl(270, 75%, 60%)',
                                label: 'Purple'
                            }
                        ]
                    },
                    tableCellProperties: {
                        borderColors: [{
                                color: 'hsl(0, 0%, 90%)',
                                label: 'Light grey'
                            },
                            {
                                color: 'hsl(0, 0%, 60%)',
                                label: 'Grey'
                            },
                            {
                                color: 'hsl(0, 0%, 30%)',
                                label: 'Dark grey'
                            },
                            {
                                color: 'hsl(0, 0%, 0%)',
                                label: 'Black'
                            }
                        ],
                        backgroundColors: [{
                                color: 'hsl(0, 0%, 100%)',
                                label: 'White'
                            },
                            {
                                color: 'hsl(0, 0%, 90%)',
                                label: 'Light grey'
                            },
                            {
                                color: 'hsl(0, 75%, 60%)',
                                label: 'Red'
                            },
                            {
                                color: 'hsl(30, 75%, 60%)',
                                label: 'Orange'
                            },
                            {
                                color: 'hsl(60, 75%, 60%)',
                                label: 'Yellow'
                            },
                            {
                                color: 'hsl(90, 75%, 60%)',
                                label: 'Light green'
                            },
                            {
                                color: 'hsl(120, 75%, 60%)',
                                label: 'Green'
                            },
                            {
                                color: 'hsl(150, 75%, 60%)',
                                label: 'Aquamarine'
                            },
                            {
                                color: 'hsl(180, 75%, 60%)',
                                label: 'Turquoise'
                            },
                            {
                                color: 'hsl(210, 75%, 60%)',
                                label: 'Light blue'
                            },
                            {
                                color: 'hsl(240, 75%, 60%)',
                                label: 'Blue'
                            },
                            {
                                color: 'hsl(270, 75%, 60%)',
                                label: 'Purple'
                            }
                        ]
                    }
                },
                codeBlock: {
                    languages: [{
                            language: 'plaintext',
                            label: 'Plain text'
                        },
                        {
                            language: 'c',
                            label: 'C'
                        },
                        {
                            language: 'cs',
                            label: 'C#'
                        },
                        {
                            language: 'cpp',
                            label: 'C++'
                        },
                        {
                            language: 'css',
                            label: 'CSS'
                        },
                        {
                            language: 'diff',
                            label: 'Diff'
                        },
                        {
                            language: 'html',
                            label: 'HTML'
                        },
                        {
                            language: 'java',
                            label: 'Java'
                        },
                        {
                            language: 'javascript',
                            label: 'JavaScript'
                        },
                        {
                            language: 'php',
                            label: 'PHP'
                        },
                        {
                            language: 'python',
                            label: 'Python'
                        },
                        {
                            language: 'ruby',
                            label: 'Ruby'
                        },
                        {
                            language: 'typescript',
                            label: 'TypeScript'
                        },
                        {
                            language: 'xml',
                            label: 'XML'
                        }
                    ]
                },
                mediaEmbed: {
                    previewsInData: true
                },
                removePlugins: [
                    'CKBoxImageEdit',
                    'CKFinder',
                    'EasyImage',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    'MathType'
                ]
            })
            .then(editor => {
                editorInstance = editor;

                // Set minimum height
                editor.editing.view.change(writer => {
                    writer.setStyle('min-height', '400px', editor.editing.view.document.getRoot());
                });

                // Custom styling for the editor
                editor.editing.view.change(writer => {
                    writer.setStyle('font-family', 'Arial, sans-serif', editor.editing.view.document.getRoot());
                    writer.setStyle('font-size', '14px', editor.editing.view.document.getRoot());
                    writer.setStyle('line-height', '1.6', editor.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });

        // Handle form submission to get editor data
        document.querySelector('form').addEventListener('submit', function(e) {
            if (editorInstance) {
                // Update the textarea with editor content
                document.querySelector('#content-editor').value = editorInstance.getData();
            }
        });

        // Logout confirmation function
        function confirmLogout() {
            // Check if there are unsaved changes
            let hasUnsavedChanges = false;

            if (editorInstance) {
                const currentContent = editorInstance.getData();
                const originalContent = document.querySelector('#content-editor').defaultValue || '';
                hasUnsavedChanges = currentContent !== originalContent;
            }

            // Check form fields for changes
            const form = document.querySelector('form');
            if (form) {
                const formData = new FormData(form);
                const titleField = form.querySelector('input[name="title"]');
                const excerptField = form.querySelector('textarea[name="excerpt"]');

                if (titleField && titleField.value.trim() !== (titleField.defaultValue || '')) {
                    hasUnsavedChanges = true;
                }
                if (excerptField && excerptField.value.trim() !== (excerptField.defaultValue || '')) {
                    hasUnsavedChanges = true;
                }
            }

            if (hasUnsavedChanges) {
                // Show modal with warning about unsaved changes
                const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
                modal.show();
            } else {
                // Direct logout if no unsaved changes
                window.location.href = 'logout';
            }
        }

        // Auto-save functionality (optional)
        let autoSaveTimer;

        function autoSave() {
            if (editorInstance) {
                const content = editorInstance.getData();
                const title = document.querySelector('input[name="title"]').value;

                if (title.trim() && content.trim()) {
                    // Store in localStorage as backup
                    localStorage.setItem('blog_draft_title', title);
                    localStorage.setItem('blog_draft_content', content);
                    localStorage.setItem('blog_draft_timestamp', Date.now());

                    // Show auto-save indicator
                    showAutoSaveIndicator();
                }
            }
        }

        function showAutoSaveIndicator() {
            // Create or update auto-save indicator
            let indicator = document.getElementById('autosave-indicator');
            if (!indicator) {
                indicator = document.createElement('div');
                indicator.id = 'autosave-indicator';
                indicator.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: #28a745;
                    color: white;
                    padding: 8px 12px;
                    border-radius: 4px;
                    font-size: 12px;
                    z-index: 1050;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                `;
                document.body.appendChild(indicator);
            }

            indicator.innerHTML = '<i class="fas fa-check me-1"></i>Draft saved';
            indicator.style.opacity = '1';

            setTimeout(() => {
                indicator.style.opacity = '0';
            }, 2000);
        }

        // Set up auto-save timer
        function setupAutoSave() {
            if (autoSaveTimer) {
                clearInterval(autoSaveTimer);
            }

            autoSaveTimer = setInterval(autoSave, 30000); // Auto-save every 30 seconds
        }

        // Load draft from localStorage if available
        function loadDraft() {
            const draftTitle = localStorage.getItem('blog_draft_title');
            const draftContent = localStorage.getItem('blog_draft_content');
            const draftTimestamp = localStorage.getItem('blog_draft_timestamp');

            if (draftTitle && draftContent && draftTimestamp) {
                const timeDiff = Date.now() - parseInt(draftTimestamp);
                const hoursDiff = timeDiff / (1000 * 60 * 60);

                // Only load draft if it's less than 24 hours old
                if (hoursDiff < 24) {
                    const titleField = document.querySelector('input[name="title"]');
                    if (titleField && !titleField.value.trim()) {
                        if (confirm('A draft was found. Would you like to restore it?')) {
                            titleField.value = draftTitle;
                            if (editorInstance) {
                                editorInstance.setData(draftContent);
                            }
                        }
                    }
                }
            }
        }

        // Clear draft from localStorage
        function clearDraft() {
            localStorage.removeItem('blog_draft_title');
            localStorage.removeItem('blog_draft_content');
            localStorage.removeItem('blog_draft_timestamp');
        }

        // Initialize auto-save and draft loading
        document.addEventListener('DOMContentLoaded', function() {
            setupAutoSave();

            // Load draft after a short delay to ensure editor is ready
            setTimeout(loadDraft, 1000);

            // Clear draft when form is successfully submitted
            document.querySelector('form').addEventListener('submit', function() {
                clearDraft();
            });
        });
    </script>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Confirm Logout
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-question-circle fa-3x text-warning mb-3"></i>
                    <p class="mb-3">Are you sure you want to logout?</p>
                    <p class="small text-muted">Any unsaved changes will be lost.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="logout" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt me-1"></i>
                        Yes, Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>