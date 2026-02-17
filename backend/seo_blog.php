<?php
/**
 * SEO Blog Manager
 * Create and manage blog posts with full SEO controls
 */

$pageTitle = 'Blog Post Manager';
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Check if user has SEO access
if (!hasSEOAccess()) {
    header('Location: dashboard.php');
    exit;
}

include 'includes/header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'save_blog_post') {
        $post_id = (int)$_POST['post_id'];
        $slug = trim($_POST['slug']);
        $title = $_POST['title'];
        $excerpt = $_POST['excerpt'];
        $content = $_POST['content'];
        $featured_image = $_POST['featured_image'];
        $featured_image_alt = $_POST['featured_image_alt'];
        $category = $_POST['category'];
        $tags = $_POST['tags'];
        $meta_title = $_POST['meta_title'];
        $meta_description = $_POST['meta_description'];
        $og_title = $_POST['og_title'];
        $og_description = $_POST['og_description'];
        $og_image = $_POST['og_image'];
        $canonical_url = $_POST['canonical_url'];
        $status = $_POST['status'];
        $published_at = ($status === 'published' && empty($_POST['published_at'])) ? date('Y-m-d H:i:s') : ($_POST['published_at'] ?: NULL);
        
        if ($post_id > 0) {
            // Update
            $stmt = $conn->prepare("UPDATE si_blog_posts SET slug=?, title=?, excerpt=?, content=?, featured_image=?, featured_image_alt=?, category=?, tags=?, meta_title=?, meta_description=?, og_title=?, og_description=?, og_image=?, canonical_url=?, status=?, published_at=? WHERE id=?");
            $stmt->bind_param("ssssssssssssssssi", $slug, $title, $excerpt, $content, $featured_image, $featured_image_alt, $category, $tags, $meta_title, $meta_description, $og_title, $og_description, $og_image, $canonical_url, $status, $published_at, $post_id);
        } else {
            // Insert
            $stmt = $conn->prepare("INSERT INTO si_blog_posts (slug, title, excerpt, content, featured_image, featured_image_alt, category, tags, meta_title, meta_description, og_title, og_description, og_image, canonical_url, status, published_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssssssss", $slug, $title, $excerpt, $content, $featured_image, $featured_image_alt, $category, $tags, $meta_title, $meta_description, $og_title, $og_description, $og_image, $canonical_url, $status, $published_at);
        }
        
        if ($stmt->execute()) {
            $success_message = "✅ Blog post saved successfully!";
            if ($stmt->insert_id) $post_id = $stmt->insert_id;
        } else {
            $error_message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    }
    
    // Delete post
    if ($_POST['action'] === 'delete_post' && isset($_POST['post_id'])) {
        $post_id = (int)$_POST['post_id'];
        $stmt = $conn->prepare("DELETE FROM si_blog_posts WHERE id=?");
        $stmt->bind_param("i", $post_id);
        if ($stmt->execute()) {
            $success_message = "✅ Blog post deleted successfully!";
        }
        $stmt->close();
    }
}

// Get all posts
$posts = [];
$result = $conn->query("SELECT * FROM si_blog_posts ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

// Get unique categories and tags
$categories = [];
$tags_all = [];
foreach ($posts as $post) {
    if ($post['category']) $categories[$post['category']] = true;
    if ($post['tags']) {
        $post_tags = explode(',', $post['tags']);
        foreach ($post_tags as $tag) {
            $tags_all[trim($tag)] = true;
        }
    }
}
$categories = array_keys($categories);
$tags_all = array_keys($tags_all);
?>

<style>
.blog-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--brand-surface);
    border: 1px solid var(--brand-border);
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--brand-muted);
    margin-top: 0.5rem;
}

.blog-filters {
    background: var(--brand-surface);
    border: 1px solid var(--brand-border);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

.blog-filters select, .blog-filters input {
    padding: 0.5rem;
    border: 1px solid var(--brand-border);
    border-radius: 6px;
    font-size: 0.875rem;
}

.blog-filters select {
    min-width: 150px;
}

.blog-grid {
    display: grid;
    gap: 1.5rem;
}

.blog-card {
    background: var(--brand-surface);
    border: 1px solid var(--brand-border);
    border-radius: 12px;
    padding: 1.5rem;
    display: grid;
    grid-template-columns: 120px 1fr auto;
    gap: 1.5rem;
    align-items: start;
    transition: all 0.2s;
}

.blog-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border-color: var(--brand-accent);
}

.blog-thumbnail {
    width: 120px;
    height: 80px;
    background: var(--brand-surface-2);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.blog-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.blog-info {
    flex: 1;
}

.blog-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--brand-heading);
    margin-bottom: 0.5rem;
}

.blog-slug {
    font-size: 0.8rem;
    color: var(--brand-muted);
    font-family: 'Courier New', monospace;
    background: var(--brand-surface-2);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    display: inline-block;
    margin-bottom: 0.5rem;
}

.blog-excerpt {
    font-size: 0.875rem;
    color: var(--brand-muted);
    line-height: 1.5;
    margin-bottom: 0.75rem;
}

.blog-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.8rem;
    color: var(--brand-muted);
}

.blog-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    align-items: flex-end;
}

.blog-actions .badge {
    margin-bottom: 0.5rem;
}

/* Editor styles */
.editor-container {
    border: 1px solid var(--brand-border);
    border-radius: 8px;
    min-height: 400px;
    background: white;
    padding: 1rem;
}

.toolbar {
    display: flex;
    gap: 0.25rem;
    padding: 0.5rem;
    border-bottom: 1px solid var(--brand-border);
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.toolbar button {
    padding: 0.5rem 0.75rem;
    border: 1px solid var(--brand-border);
    background: white;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.toolbar button:hover {
    background: var(--brand-surface-2);
}

.toolbar button.active {
    background: var(--brand-accent);
    color: white;
    border-color: var(--brand-accent);
}

#editor-content {
    min-height: 300px;
    padding: 1rem;
    outline: none;
    line-height: 1.8;
}

#editor-content:focus {
    outline: 2px solid var(--brand-accent);
    outline-offset: 2px;
    border-radius: 4px;
}
</style>

<?php if (isset($success_message)): ?>
<div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
<div class="alert alert-error"><?php echo $error_message; ?></div>
<?php endif; ?>

<!-- Stats -->
<div class="blog-stats">
    <div class="stat-card">
        <div class="stat-number"><?php echo count($posts); ?></div>
        <div class="stat-label">Total Posts</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo count(array_filter($posts, fn($p) => $p['status'] === 'published')); ?></div>
        <div class="stat-label">Published</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo count(array_filter($posts, fn($p) => $p['status'] === 'draft')); ?></div>
        <div class="stat-label">Drafts</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?php echo array_sum(array_column($posts, 'views')); ?></div>
        <div class="stat-label">Total Views</div>
    </div>
</div>

<div class="page-actions" style="margin-bottom:1.5rem;">
    <button onclick="openAddModal()" class="btn btn-primary">
        ➕ Create New Blog Post
    </button>
</div>

<!-- Filters -->
<div class="blog-filters">
    <label>
        <strong>Status:</strong>
        <select id="filterStatus" onchange="filterPosts()">
            <option value="">All</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
            <option value="scheduled">Scheduled</option>
        </select>
    </label>
    <label>
        <strong>Category:</strong>
        <select id="filterCategory" onchange="filterPosts()">
            <option value="">All</option>
            <?php foreach ($categories as $cat): ?>
            <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>
        <strong>Search:</strong>
        <input type="text" id="filterSearch" placeholder="Search posts..." oninput="filterPosts()">
    </label>
</div>

<!-- Posts Grid -->
<div class="blog-grid" id="postsGrid">
    <?php foreach ($posts as $post): ?>
    <div class="blog-card" data-status="<?php echo $post['status']; ?>" data-category="<?php echo htmlspecialchars($post['category']); ?>" data-title="<?php echo htmlspecialchars(strtolower($post['title'])); ?>">
        <div class="blog-thumbnail">
            <?php if ($post['featured_image']): ?>
            <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" alt="<?php echo htmlspecialchars($post['featured_image_alt'] ?: $post['title']); ?>">
            <?php else: ?>
            📝
            <?php endif; ?>
        </div>
        
        <div class="blog-info">
            <div class="blog-title"><?php echo htmlspecialchars($post['title']); ?></div>
            <span class="blog-slug">📄 /blog/<?php echo htmlspecialchars($post['slug']); ?></span>
            <div class="blog-excerpt"><?php echo htmlspecialchars(substr($post['excerpt'] ?: strip_tags($post['content']), 0, 150)); ?>...</div>
            <div class="blog-meta">
                <span>📁 <?php echo htmlspecialchars($post['category'] ?: 'Uncategorized'); ?></span>
                <span>👁️ <?php echo number_format($post['views']); ?> views</span>
                <span>📅 <?php echo date('M j, Y', strtotime($post['created_at'])); ?></span>
            </div>
        </div>
        
        <div class="blog-actions">
            <span class="badge <?php echo $post['status'] === 'published' ? 'badge-success' : ($post['status'] === 'draft' ? 'badge-warning' : 'badge-info'); ?>">
                <?php echo ucfirst($post['status']); ?>
            </span>
            <button onclick='editPost(<?php echo json_encode($post, JSON_HEX_TAG | JSON_HEX_APOS); ?>)' class="btn btn-secondary btn-sm">
                ✏️ Edit
            </button>
            <button onclick="window.open('/blog/<?php echo $post['slug']; ?>', '_blank')" class="btn btn-outline btn-sm">
                👁️ View
            </button>
            <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this post?')">
                <input type="hidden" name="action" value="delete_post">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Edit/Add Modal -->
<div id="blogModal" class="modal">
    <div class="modal-content" style="max-width: 1200px;">
        <div class="modal-header">
            <h2 id="modalTitle">Create New Blog Post</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <form method="POST" id="blogForm">
            <div class="modal-body">
                <input type="hidden" name="action" value="save_blog_post">
                <input type="hidden" name="post_id" id="post_id" value="0">
                <input type="hidden" name="content" id="content_hidden">
                
                <div class="form-section">
                    <div class="form-section-title">📝 Content</div>
                    
                    <div class="form-group">
                        <label for="title">Post Title *</label>
                        <input type="text" name="title" id="title" required placeholder="Enter your blog post title">
                    </div>
                    
                    <div class="form-group">
                        <label for="slug">URL Slug *</label>
                        <input type="text" name="slug" id="slug" required placeholder="post-url-slug">
                        <small>Auto-generated from title, or customize it</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="excerpt">Excerpt / Summary</label>
                        <textarea name="excerpt" id="excerpt" rows="3" placeholder="Short summary of the post (shown in listings)"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Post Content *</label>
                        <div class="editor-container">
                            <div class="toolbar">
                                <button type="button" onclick="formatDoc('bold')"><strong>B</strong></button>
                                <button type="button" onclick="formatDoc('italic')"><em>I</em></button>
                                <button type="button" onclick="formatDoc('underline')"><u>U</u></button>
                                <button type="button" onclick="formatDoc('formatBlock', 'h2')">H2</button>
                                <button type="button" onclick="formatDoc('formatBlock', 'h3')">H3</button>
                                <button type="button" onclick="formatDoc('formatBlock', 'p')">P</button>
                                <button type="button" onclick="formatDoc('insertUnorderedList')">• List</button>
                                <button type="button" onclick="formatDoc('insertOrderedList')">1. List</button>
                                <button type="button" onclick="insertLink()">🔗 Link</button>
                                <button type="button" onclick="insertImage()">🖼️ Image</button>
                                <button type="button" onclick="formatDoc('removeFormat')">Clear Format</button>
                            </div>
                            <div id="editor-content" contenteditable="true"></div>
                        </div>
                        <small>Use the toolbar to format your content</small>
                    </div>
                </div>
                
                <div class="form-section">
                    <div class="form-section-title">🖼️ Featured Image</div>
                    
                    <div class="form-group">
                        <label for="featured_image">Featured Image URL</label>
                        <input type="url" name="featured_image" id="featured_image" placeholder="https://example.com/image.jpg">
                    </div>
                    
                    <div class="form-group">
                        <label for="featured_image_alt">Image Alt Text</label>
                        <input type="text" name="featured_image_alt" id="featured_image_alt" placeholder="Describe the image for SEO">
                    </div>
                </div>
                
                <div class="form-section">
                    <div class="form-section-title">📁 Organization</div>
                    
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" name="category" id="category" list="categories-list" placeholder="e.g., Instagram Tips">
                        <datalist id="categories-list">
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    
                    <div class="form-group">
                        <label for="tags">Tags (comma-separated)</label>
                        <input type="text" name="tags" id="tags" placeholder="instagram, growth, tips">
                        <small>Common tags: <?php echo implode(', ', array_slice($tags_all, 0, 5)); ?></small>
                    </div>
                </div>
                
                <div class="form-section">
                    <div class="form-section-title">🔍 SEO Settings</div>
                    
                    <div class="form-group">
                        <label for="meta_title">SEO Title</label>
                        <input type="text" name="meta_title" id="meta_title" maxlength="70">
                        <small>Leave empty to use post title</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="2" maxlength="160"></textarea>
                        <small>Leave empty to use excerpt</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="og_title">Social Share Title</label>
                        <input type="text" name="og_title" id="og_title">
                    </div>
                    
                    <div class="form-group">
                        <label for="og_description">Social Share Description</label>
                        <textarea name="og_description" id="og_description" rows="2"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="og_image">Social Share Image</label>
                        <input type="url" name="og_image" id="og_image">
                        <small>Leave empty to use featured image</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="canonical_url">Canonical URL (optional)</label>
                        <input type="url" name="canonical_url" id="canonical_url">
                    </div>
                </div>
                
                <div class="form-section">
                    <div class="form-section-title">📅 Publishing</div>
                    
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="draft">Draft (Save for later)</option>
                            <option value="published">Published (Live now)</option>
                            <option value="scheduled">Scheduled (Set date below)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="published_at">Publish Date/Time (optional)</label>
                        <input type="datetime-local" name="published_at" id="published_at">
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">💾 Save Post</button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    if (document.getElementById('post_id').value === '0') {
        const slug = this.value.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        document.getElementById('slug').value = slug;
    }
});

// WYSIWYG functions
function formatDoc(cmd, value=null) {
    document.execCommand(cmd, false, value);
    document.getElementById('editor-content').focus();
}

function insertLink() {
    const url = prompt('Enter URL:');
    if (url) {
        formatDoc('createLink', url);
    }
}

function insertImage() {
    const url = prompt('Enter image URL:');
    if (url) {
        formatDoc('insertImage', url);
    }
}

// Form submission
document.getElementById('blogForm').addEventListener('submit', function(e) {
    // Copy editor content to hidden field
    document.getElementById('content_hidden').value = document.getElementById('editor-content').innerHTML;
});

function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Create New Blog Post';
    document.getElementById('blogForm').reset();
    document.getElementById('post_id').value = '0';
    document.getElementById('editor-content').innerHTML = '';
    document.getElementById('blogModal').style.display = 'block';
}

function editPost(post) {
    document.getElementById('modalTitle').textContent = 'Edit Blog Post';
    document.getElementById('post_id').value = post.id;
    document.getElementById('slug').value = post.slug;
    document.getElementById('title').value = post.title;
    document.getElementById('excerpt').value = post.excerpt || '';
    document.getElementById('editor-content').innerHTML = post.content;
    document.getElementById('featured_image').value = post.featured_image || '';
    document.getElementById('featured_image_alt').value = post.featured_image_alt || '';
    document.getElementById('category').value = post.category || '';
    document.getElementById('tags').value = post.tags || '';
    document.getElementById('meta_title').value = post.meta_title || '';
    document.getElementById('meta_description').value = post.meta_description || '';
    document.getElementById('og_title').value = post.og_title || '';
    document.getElementById('og_description').value = post.og_description || '';
    document.getElementById('og_image').value = post.og_image || '';
    document.getElementById('canonical_url').value = post.canonical_url || '';
    document.getElementById('status').value = post.status;
    
    if (post.published_at) {
        const date = new Date(post.published_at);
        const localDateTime = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
        document.getElementById('published_at').value = localDateTime;
    }
    
    document.getElementById('blogModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('blogModal').style.display = 'none';
}

function filterPosts() {
    const status = document.getElementById('filterStatus').value.toLowerCase();
    const category = document.getElementById('filterCategory').value.toLowerCase();
    const search = document.getElementById('filterSearch').value.toLowerCase();
    
    const cards = document.querySelectorAll('.blog-card');
    cards.forEach(card => {
        const cardStatus = card.dataset.status;
        const cardCategory = card.dataset.category.toLowerCase();
        const cardTitle = card.dataset.title;
        
        const matchStatus = !status || cardStatus === status;
        const matchCategory = !category || cardCategory === category;
        const matchSearch = !search || cardTitle.includes(search);
        
        card.style.display = (matchStatus && matchCategory && matchSearch) ? 'grid' : 'none';
    });
}

window.onclick = function(event) {
    const modal = document.getElementById('blogModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>

<?php include 'includes/footer.php'; ?>
