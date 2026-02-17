<?php
/**
 * SEO Pages Manager
 * Edit meta tags, OG tags, and content for all pages
 */

$pageTitle = 'Page SEO Manager';
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
    if ($_POST['action'] === 'save_page_seo') {
        $page_id = (int)$_POST['page_id'];
        $page_slug = $_POST['page_slug'];
        $page_title = $_POST['page_title'];
        $meta_description = $_POST['meta_description'];
        $h1_heading = $_POST['h1_heading'];
        $canonical_url = $_POST['canonical_url'];
        $robots = $_POST['robots'];
        
        // Open Graph
        $og_title = $_POST['og_title'];
        $og_description = $_POST['og_description'];
        $og_image = $_POST['og_image'];
        
        // Twitter
        $twitter_title = $_POST['twitter_title'];
        $twitter_description = $_POST['twitter_description'];
        $twitter_image = $_POST['twitter_image'];
        
        // Custom head
        $custom_head = $_POST['custom_head'] ?? '';
        
        if ($page_id > 0) {
            // Update existing
            $stmt = $conn->prepare("UPDATE si_seo_pages SET page_title=?, meta_description=?, h1_heading=?, canonical_url=?, robots=?, og_title=?, og_description=?, og_image=?, twitter_title=?, twitter_description=?, twitter_image=?, custom_head=? WHERE id=?");
            $stmt->bind_param("ssssssssssssi", $page_title, $meta_description, $h1_heading, $canonical_url, $robots, $og_title, $og_description, $og_image, $twitter_title, $twitter_description, $twitter_image, $custom_head, $page_id);
        } else {
            // Insert new
            $stmt = $conn->prepare("INSERT INTO si_seo_pages (page_slug, page_title, meta_description, h1_heading, canonical_url, robots, og_title, og_description, og_image, twitter_title, twitter_description, twitter_image, custom_head) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssss", $page_slug, $page_title, $meta_description, $h1_heading, $canonical_url, $robots, $og_title, $og_description, $og_image, $twitter_title, $twitter_description, $twitter_image, $custom_head);
        }
        
        if ($stmt->execute()) {
            $success_message = "✅ Page SEO updated successfully!";
        } else {
            $error_message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    }
    
    // Delete page
    if ($_POST['action'] === 'delete_page' && isset($_POST['page_id'])) {
        $page_id = (int)$_POST['page_id'];
        $stmt = $conn->prepare("DELETE FROM si_seo_pages WHERE id=?");
        $stmt->bind_param("i", $page_id);
        if ($stmt->execute()) {
            $success_message = "✅ Page deleted successfully!";
        }
        $stmt->close();
    }
}

// Get all pages
$pages = [];
$result = $conn->query("SELECT * FROM si_seo_pages ORDER BY page_slug ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $pages[] = $row;
    }
}
?>

<style>
.seo-grid {
    display: grid;
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.seo-card {
    background: var(--brand-surface);
    border: 1px solid var(--brand-border);
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.2s;
}

.seo-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border-color: var(--brand-accent);
}

.seo-card-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 1rem;
}

.seo-card-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--brand-heading);
    margin-bottom: 0.25rem;
}

.seo-card-slug {
    font-size: 0.85rem;
    color: var(--brand-muted);
    font-family: 'Courier New', monospace;
    background: var(--brand-surface-2);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    display: inline-block;
}

.seo-card-meta {
    font-size: 0.85rem;
    color: var(--brand-muted);
    line-height: 1.5;
    margin-top: 0.5rem;
}

.seo-card-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.modal {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.6);
}

.modal-content {
    background-color: var(--brand-surface);
    margin: 2% auto;
    padding: 0;
    border: none;
    width: 90%;
    max-width: 900px;
    border-radius: 16px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--brand-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    background: var(--brand-surface);
    z-index: 10;
}

.modal-header h2 {
    font-size: 1.5rem;
    color: var(--brand-heading);
}

.modal-body {
    padding: 2rem;
}

.modal-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--brand-border);
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    position: sticky;
    bottom: 0;
    background: var(--brand-surface);
}

.close {
    color: var(--brand-muted);
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.2s;
}

.close:hover {
    color: var(--brand-heading);
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--brand-border);
}

.form-section:last-child {
    border-bottom: none;
}

.form-section-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--brand-heading);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.char-count {
    font-size: 0.75rem;
    color: var(--brand-muted);
    margin-top: 0.25rem;
}

.char-count.warning {
    color: #f59e0b;
}

.char-count.error {
    color: #ef4444;
}

.preview-box {
    background: var(--brand-surface-2);
    border: 1px solid var(--brand-border);
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.preview-title {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--brand-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.75rem;
}

.google-preview {
    font-family: Arial, sans-serif;
}

.google-preview-title {
    color: #1a0dab;
    font-size: 20px;
    font-weight: 400;
    line-height: 1.3;
    margin-bottom: 4px;
    cursor: pointer;
}

.google-preview-url {
    color: #006621;
    font-size: 14px;
    margin-bottom: 4px;
}

.google-preview-description {
    color: #545454;
    font-size: 13px;
    line-height: 1.4;
}

.social-preview {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background: white;
}

.social-preview-image {
    width: 100%;
    height: 200px;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
}

.social-preview-content {
    padding: 12px;
}

.social-preview-title {
    font-weight: 600;
    font-size: 14px;
    color: #000;
    margin-bottom: 4px;
}

.social-preview-description {
    font-size: 12px;
    color: #666;
    line-height: 1.4;
}

.social-preview-url {
    font-size: 11px;
    color: #999;
    margin-top: 4px;
    text-transform: uppercase;
}
</style>

<?php if (isset($success_message)): ?>
<div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
<div class="alert alert-error"><?php echo $error_message; ?></div>
<?php endif; ?>

<div class="page-actions">
    <button onclick="openAddModal()" class="btn btn-primary">
        ➕ Add New Page
    </button>
</div>

<div class="seo-grid">
    <?php foreach ($pages as $page): ?>
    <div class="seo-card">
        <div class="seo-card-header">
            <div>
                <div class="seo-card-title"><?php echo htmlspecialchars($page['page_title'] ?: 'Untitled Page'); ?></div>
                <span class="seo-card-slug">📄 /<?php echo htmlspecialchars($page['page_slug']); ?></span>
            </div>
            <span class="badge badge-success"><?php echo ucfirst($page['status']); ?></span>
        </div>
        
        <div class="seo-card-meta">
            <strong>Meta Description:</strong> <?php echo htmlspecialchars(substr($page['meta_description'] ?? 'Not set', 0, 100)); ?><?php echo strlen($page['meta_description'] ?? '') > 100 ? '...' : ''; ?><br>
            <strong>H1:</strong> <?php echo htmlspecialchars($page['h1_heading'] ?: 'Not set'); ?><br>
            <strong>Robots:</strong> <?php echo htmlspecialchars($page['robots']); ?>
        </div>
        
        <div class="seo-card-actions">
            <button onclick='editPage(<?php echo json_encode($page, JSON_HEX_TAG | JSON_HEX_APOS); ?>)' class="btn btn-secondary btn-sm">
                ✏️ Edit SEO
            </button>
            <button onclick="previewPage(<?php echo $page['id']; ?>)" class="btn btn-outline btn-sm">
                👁️ Preview
            </button>
            <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this page SEO data?')">
                <input type="hidden" name="action" value="delete_page">
                <input type="hidden" name="page_id" value="<?php echo $page['id']; ?>">
                <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Edit/Add Modal -->
<div id="seoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Edit Page SEO</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <form method="POST" id="seoForm">
            <div class="modal-body">
                <input type="hidden" name="action" value="save_page_seo">
                <input type="hidden" name="page_id" id="page_id" value="0">
                
                <!-- Basic Info -->
                <div class="form-section">
                    <div class="form-section-title">📄 Basic Information</div>
                    
                    <div class="form-group">
                        <label for="page_slug">Page Slug (URL) *</label>
                        <input type="text" name="page_slug" id="page_slug" required placeholder="e.g., home, contact, services/buy-instagram-followers">
                        <small>The URL path for this page (without domain)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="page_title">SEO Title (Browser Title) *</label>
                        <input type="text" name="page_title" id="page_title" required maxlength="70" oninput="updateCharCount('page_title', 70)">
                        <div class="char-count" id="page_title_count">0 / 70 characters (optimal: 50-60)</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="meta_description">Meta Description *</label>
                        <textarea name="meta_description" id="meta_description" rows="3" required maxlength="160" oninput="updateCharCount('meta_description', 160)"></textarea>
                        <div class="char-count" id="meta_description_count">0 / 160 characters (optimal: 120-155)</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="h1_heading">H1 Heading (Main Page Title)</label>
                        <input type="text" name="h1_heading" id="h1_heading">
                    </div>
                </div>
                
                <!-- Technical SEO -->
                <div class="form-section">
                    <div class="form-section-title">⚙️ Technical SEO</div>
                    
                    <div class="form-group">
                        <label for="canonical_url">Canonical URL</label>
                        <input type="url" name="canonical_url" id="canonical_url" placeholder="https://genuinesocials.com/page-url">
                        <small>Preferred URL for this page (leave empty to auto-generate)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="robots">Robots Directive</label>
                        <select name="robots" id="robots">
                            <option value="index, follow">index, follow (Default - Allow in search)</option>
                            <option value="noindex, follow">noindex, follow (Hide from search)</option>
                            <option value="index, nofollow">index, nofollow (Show but don't follow links)</option>
                            <option value="noindex, nofollow">noindex, nofollow (Hide completely)</option>
                        </select>
                    </div>
                </div>
                
                <!-- Open Graph (Facebook/LinkedIn) -->
                <div class="form-section">
                    <div class="form-section-title">📘 Facebook / LinkedIn (Open Graph)</div>
                    
                    <div class="form-group">
                        <label for="og_title">OG Title</label>
                        <input type="text" name="og_title" id="og_title" maxlength="95">
                        <small>Leave empty to use SEO title</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="og_description">OG Description</label>
                        <textarea name="og_description" id="og_description" rows="3" maxlength="200"></textarea>
                        <small>Leave empty to use meta description</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="og_image">OG Image URL</label>
                        <input type="url" name="og_image" id="og_image" placeholder="https://example.com/image.jpg">
                        <small>Recommended: 1200x630px</small>
                    </div>
                </div>
                
                <!-- Twitter Card -->
                <div class="form-section">
                    <div class="form-section-title">🐦 Twitter / X Card</div>
                    
                    <div class="form-group">
                        <label for="twitter_title">Twitter Title</label>
                        <input type="text" name="twitter_title" id="twitter_title" maxlength="70">
                        <small>Leave empty to use OG title</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="twitter_description">Twitter Description</label>
                        <textarea name="twitter_description" id="twitter_description" rows="3" maxlength="200"></textarea>
                        <small>Leave empty to use OG description</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="twitter_image">Twitter Image URL</label>
                        <input type="url" name="twitter_image" id="twitter_image" placeholder="https://example.com/image.jpg">
                        <small>Leave empty to use OG image</small>
                    </div>
                </div>
                
                <!-- Custom Head Code -->
                <div class="form-section">
                    <div class="form-section-title">💻 Custom Head Code (Advanced)</div>
                    
                    <div class="form-group">
                        <label for="custom_head">Custom HTML for &lt;head&gt;</label>
                        <textarea name="custom_head" id="custom_head" rows="4" placeholder="<!-- Custom meta tags, scripts, etc. -->" style="font-family: monospace; font-size: 0.85rem;"></textarea>
                        <small>⚠️ Advanced: Add custom meta tags or scripts for this page only</small>
                    </div>
                </div>
                
                <!-- Preview Section -->
                <div class="form-section">
                    <div class="form-section-title">👁️ Preview</div>
                    
                    <div class="preview-box">
                        <div class="preview-title">Google Search Preview</div>
                        <div class="google-preview">
                            <div class="google-preview-title" id="preview_google_title">Your Page Title Will Appear Here</div>
                            <div class="google-preview-url" id="preview_google_url">https://genuinesocials.com/page-url</div>
                            <div class="google-preview-description" id="preview_google_description">Your meta description will appear here in search results...</div>
                        </div>
                    </div>
                    
                    <div class="preview-box">
                        <div class="preview-title">Facebook / LinkedIn Preview</div>
                        <div class="social-preview">
                            <div class="social-preview-image" id="preview_og_image">📸 1200 x 630</div>
                            <div class="social-preview-content">
                                <div class="social-preview-title" id="preview_og_title">Your Page Title</div>
                                <div class="social-preview-description" id="preview_og_description">Your description will appear here when shared on social media...</div>
                                <div class="social-preview-url">GENUINESOCIALS.COM</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">💾 Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function updateCharCount(fieldId, maxLength) {
    const field = document.getElementById(fieldId);
    const counter = document.getElementById(fieldId + '_count');
    const length = field.value.length;
    
    counter.textContent = length + ' / ' + maxLength + ' characters';
    
    if (fieldId === 'page_title') {
        counter.textContent += ' (optimal: 50-60)';
        if (length < 50 || length > 60) counter.classList.add('warning');
        else counter.classList.remove('warning');
    }
    
    if (fieldId === 'meta_description') {
        counter.textContent += ' (optimal: 120-155)';
        if (length < 120 || length > 155) counter.classList.add('warning');
        else counter.classList.remove('warning');
    }
    
    // Update preview
    updatePreview();
}

function updatePreview() {
    // Google Preview
    const title = document.getElementById('page_title').value || 'Your Page Title Will Appear Here';
    const description = document.getElementById('meta_description').value || 'Your meta description will appear here in search results...';
    const slug = document.getElementById('page_slug').value || 'page-url';
    
    document.getElementById('preview_google_title').textContent = title;
    document.getElementById('preview_google_url').textContent = 'https://genuinesocials.com/' + slug;
    document.getElementById('preview_google_description').textContent = description;
    
    // Social Preview
    const ogTitle = document.getElementById('og_title').value || title;
    const ogDescription = document.getElementById('og_description').value || description;
    const ogImage = document.getElementById('og_image').value;
    
    document.getElementById('preview_og_title').textContent = ogTitle;
    document.getElementById('preview_og_description').textContent = ogDescription;
    
    if (ogImage) {
        document.getElementById('preview_og_image').innerHTML = '<img src="' + ogImage + '" style="width:100%;height:100%;object-fit:cover;" onerror="this.parentElement.innerHTML=\'📸 Image Not Found\'">';
    } else {
        document.getElementById('preview_og_image').innerHTML = '📸 1200 x 630';
    }
}

// Add event listeners for real-time preview
document.addEventListener('DOMContentLoaded', function() {
    const previewFields = ['page_title', 'meta_description', 'page_slug', 'og_title', 'og_description', 'og_image'];
    previewFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', updatePreview);
        }
    });
});

function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add New Page';
    document.getElementById('seoForm').reset();
    document.getElementById('page_id').value = '0';
    document.getElementById('page_slug').removeAttribute('readonly');
    updateCharCount('page_title', 70);
    updateCharCount('meta_description', 160);
    updatePreview();
    document.getElementById('seoModal').style.display = 'block';
}

function editPage(page) {
    document.getElementById('modalTitle').textContent = 'Edit Page SEO: ' + page.page_slug;
    document.getElementById('page_id').value = page.id;
    document.getElementById('page_slug').value = page.page_slug;
    document.getElementById('page_slug').setAttribute('readonly', 'readonly');
    document.getElementById('page_title').value = page.page_title || '';
    document.getElementById('meta_description').value = page.meta_description || '';
    document.getElementById('h1_heading').value = page.h1_heading || '';
    document.getElementById('canonical_url').value = page.canonical_url || '';
    document.getElementById('robots').value = page.robots || 'index, follow';
    document.getElementById('og_title').value = page.og_title || '';
    document.getElementById('og_description').value = page.og_description || '';
    document.getElementById('og_image').value = page.og_image || '';
    document.getElementById('twitter_title').value = page.twitter_title || '';
    document.getElementById('twitter_description').value = page.twitter_description || '';
    document.getElementById('twitter_image').value = page.twitter_image || '';
    document.getElementById('custom_head').value = page.custom_head || '';
    
    updateCharCount('page_title', 70);
    updateCharCount('meta_description', 160);
    updatePreview();
    document.getElementById('seoModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('seoModal').style.display = 'none';
}

function previewPage(pageId) {
    alert('Preview functionality coming soon! Page ID: ' + pageId);
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('seoModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>

<?php include 'includes/footer.php'; ?>
