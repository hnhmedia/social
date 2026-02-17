<?php
/**
 * Technical SEO Tools
 * Manage robots.txt, redirects, sitemap
 */

$pageTitle = 'Technical SEO Tools';
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Check if user has SEO access
if (!hasSEOAccess()) {
    header('Location: dashboard.php');
    exit;
}

include 'includes/header.php';

// Handle robots.txt save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'save_robots') {
        $robots_content = $_POST['robots_txt_content'];
        $stmt = $conn->prepare("UPDATE si_seo_settings SET setting_value=? WHERE setting_key='robots_txt_content'");
        $stmt->bind_param("s", $robots_content);
        if ($stmt->execute()) {
            // Write to actual robots.txt file
            file_put_contents(__DIR__ . '/../robots.txt', $robots_content);
            $success_message = "✅ robots.txt updated successfully!";
        } else {
            $error_message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    }
    
    // Save redirect
    if ($_POST['action'] === 'save_redirect') {
        $redirect_id = (int)$_POST['redirect_id'];
        $old_url = trim($_POST['old_url'], '/');
        $new_url = trim($_POST['new_url'], '/');
        $redirect_type = $_POST['redirect_type'];
        $status = $_POST['status'];
        
        if ($redirect_id > 0) {
            $stmt = $conn->prepare("UPDATE si_redirects SET old_url=?, new_url=?, redirect_type=?, status=? WHERE id=?");
            $stmt->bind_param("ssssi", $old_url, $new_url, $redirect_type, $status, $redirect_id);
        } else {
            $stmt = $conn->prepare("INSERT INTO si_redirects (old_url, new_url, redirect_type, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $old_url, $new_url, $redirect_type, $status);
        }
        
        if ($stmt->execute()) {
            $success_message = "✅ Redirect saved successfully!";
        } else {
            $error_message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    }
    
    // Delete redirect
    if ($_POST['action'] === 'delete_redirect' && isset($_POST['redirect_id'])) {
        $redirect_id = (int)$_POST['redirect_id'];
        $stmt = $conn->prepare("DELETE FROM si_redirects WHERE id=?");
        $stmt->bind_param("i", $redirect_id);
        if ($stmt->execute()) {
            $success_message = "✅ Redirect deleted successfully!";
        }
        $stmt->close();
    }
    
    // Generate sitemap
    if ($_POST['action'] === 'generate_sitemap') {
        include_once __DIR__ . '/../includes/Config.php';
        $baseUrl = rtrim(Config::baseUrl(), '/');
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Add homepage
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$baseUrl}/</loc>\n";
        $xml .= "    <changefreq>daily</changefreq>\n";
        $xml .= "    <priority>1.0</priority>\n";
        $xml .= "  </url>\n";
        
        // Add SEO pages
        $pages = $conn->query("SELECT page_slug, updated_at FROM si_seo_pages WHERE status='active' AND robots NOT LIKE '%noindex%'");
        if ($pages) {
            while ($page = $pages->fetch_assoc()) {
                if ($page['page_slug'] !== 'home') {
                    $xml .= "  <url>\n";
                    $xml .= "    <loc>{$baseUrl}/{$page['page_slug']}</loc>\n";
                    $xml .= "    <lastmod>" . date('Y-m-d', strtotime($page['updated_at'])) . "</lastmod>\n";
                    $xml .= "    <changefreq>weekly</changefreq>\n";
                    $xml .= "    <priority>0.8</priority>\n";
                    $xml .= "  </url>\n";
                }
            }
        }
        
        // Add services
        $services = $conn->query("SELECT slug, updated_at FROM si_services WHERE status='active'");
        if ($services) {
            while ($service = $services->fetch_assoc()) {
                $xml .= "  <url>\n";
                $xml .= "    <loc>{$baseUrl}/services/{$service['slug']}</loc>\n";
                $xml .= "    <lastmod>" . date('Y-m-d', strtotime($service['updated_at'])) . "</lastmod>\n";
                $xml .= "    <changefreq>weekly</changefreq>\n";
                $xml .= "    <priority>0.9</priority>\n";
                $xml .= "  </url>\n";
            }
        }
        
        // Add blog posts
        $posts = $conn->query("SELECT slug, updated_at FROM si_blog_posts WHERE status='published'");
        if ($posts) {
            while ($post = $posts->fetch_assoc()) {
                $xml .= "  <url>\n";
                $xml .= "    <loc>{$baseUrl}/blog/{$post['slug']}</loc>\n";
                $xml .= "    <lastmod>" . date('Y-m-d', strtotime($post['updated_at'])) . "</lastmod>\n";
                $xml .= "    <changefreq>monthly</changefreq>\n";
                $xml .= "    <priority>0.7</priority>\n";
                $xml .= "  </url>\n";
            }
        }
        
        $xml .= '</urlset>';
        
        // Write to file
        file_put_contents(__DIR__ . '/../sitemap.xml', $xml);
        $success_message = "✅ Sitemap generated successfully! <a href='/sitemap.xml' target='_blank'>View Sitemap</a>";
    }
}

// Get robots.txt content
$robots_content = '';
$result = $conn->query("SELECT setting_value FROM si_seo_settings WHERE setting_key='robots_txt_content'");
if ($result && $row = $result->fetch_assoc()) {
    $robots_content = $row['setting_value'];
}

// Get all redirects
$redirects = [];
$result = $conn->query("SELECT * FROM si_redirects ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $redirects[] = $row;
    }
}

// Check if sitemap exists
$sitemap_exists = file_exists(__DIR__ . '/../sitemap.xml');
$sitemap_modified = $sitemap_exists ? date('M j, Y g:i A', filemtime(__DIR__ . '/../sitemap.xml')) : 'Never';
?>

<style>
.tool-sections {
    display: grid;
    gap: 2rem;
}

.tool-card {
    background: var(--brand-surface);
    border: 1px solid var(--brand-border);
    border-radius: 12px;
    padding: 2rem;
}

.tool-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.tool-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--brand-heading);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.code-editor {
    background: #1e1e1e;
    border: 1px solid var(--brand-border);
    border-radius: 8px;
    padding: 1rem;
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
    line-height: 1.6;
    color: #d4d4d4;
    min-height: 300px;
    resize: vertical;
}

.redirect-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.redirect-table th,
.redirect-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid var(--brand-border);
}

.redirect-table th {
    background: var(--brand-surface-2);
    font-weight: 600;
    color: var(--brand-heading);
}

.redirect-table td {
    font-size: 0.875rem;
}

.redirect-url {
    font-family: 'Courier New', monospace;
    font-size: 0.8rem;
    color: var(--brand-accent);
}

.sitemap-info {
    background: var(--brand-surface-2);
    border: 1px solid var(--brand-border);
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.sitemap-stat {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--brand-border);
}

.sitemap-stat:last-child {
    border-bottom: none;
}

.sitemap-stat strong {
    color: var(--brand-heading);
}
</style>

<?php if (isset($success_message)): ?>
<div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
<div class="alert alert-error"><?php echo $error_message; ?></div>
<?php endif; ?>

<div class="tool-sections">
    <!-- Robots.txt Editor -->
    <div class="tool-card">
        <div class="tool-header">
            <h2 class="tool-title">🤖 robots.txt Editor</h2>
        </div>
        
        <p style="color: var(--brand-muted); margin-bottom: 1.5rem;">
            The robots.txt file tells search engines which pages they can and cannot crawl. Be careful with your edits!
        </p>
        
        <form method="POST">
            <input type="hidden" name="action" value="save_robots">
            <div class="form-group">
                <label for="robots_txt_content">robots.txt Content</label>
                <textarea name="robots_txt_content" id="robots_txt_content" class="code-editor" required><?php echo htmlspecialchars($robots_content); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">💾 Save robots.txt</button>
            <a href="/robots.txt" target="_blank" class="btn btn-outline">👁️ View Current File</a>
        </form>
        
        <div style="margin-top: 1.5rem; padding: 1rem; background: var(--brand-surface-2); border-radius: 8px;">
            <strong>💡 Common Examples:</strong>
            <pre style="font-size: 0.8rem; color: var(--brand-muted); margin-top: 0.5rem;">
# Allow all bots
User-agent: *
Allow: /

# Block specific folder
User-agent: *
Disallow: /admin/

# Sitemap location
Sitemap: https://genuinesocials.com/sitemap.xml
            </pre>
        </div>
    </div>
    
    <!-- Sitemap Generator -->
    <div class="tool-card">
        <div class="tool-header">
            <h2 class="tool-title">🗺️ XML Sitemap Generator</h2>
        </div>
        
        <div class="sitemap-info">
            <div class="sitemap-stat">
                <strong>Status:</strong>
                <span><?php echo $sitemap_exists ? '<span style="color: #10b981;">✅ Generated</span>' : '<span style="color: #ef4444;">❌ Not Generated</span>'; ?></span>
            </div>
            <div class="sitemap-stat">
                <strong>Last Generated:</strong>
                <span><?php echo $sitemap_modified; ?></span>
            </div>
            <?php if ($sitemap_exists): ?>
            <div class="sitemap-stat">
                <strong>File Size:</strong>
                <span><?php echo number_format(filesize(__DIR__ . '/../sitemap.xml') / 1024, 2); ?> KB</span>
            </div>
            <?php endif; ?>
        </div>
        
        <p style="color: var(--brand-muted); margin-bottom: 1.5rem;">
            Generate an XML sitemap of all your pages, services, and blog posts for search engines.
        </p>
        
        <form method="POST">
            <input type="hidden" name="action" value="generate_sitemap">
            <button type="submit" class="btn btn-primary">🔄 Generate Sitemap</button>
            <?php if ($sitemap_exists): ?>
            <a href="/sitemap.xml" target="_blank" class="btn btn-outline">👁️ View Sitemap</a>
            <?php endif; ?>
        </form>
        
        <div style="margin-top: 1.5rem; padding: 1rem; background: #fef3c7; border: 1px solid #fbbf24; border-radius: 8px;">
            <strong>📌 After Generating:</strong>
            <ol style="margin-top: 0.5rem; padding-left: 1.5rem; color: #92400e;">
                <li>Submit to <a href="https://search.google.com/search-console" target="_blank">Google Search Console</a></li>
                <li>Submit to <a href="https://www.bing.com/webmasters" target="_blank">Bing Webmaster Tools</a></li>
                <li>Add sitemap URL to robots.txt</li>
                <li>Regenerate monthly or after major content changes</li>
            </ol>
        </div>
    </div>
    
    <!-- 301 Redirects Manager -->
    <div class="tool-card">
        <div class="tool-header">
            <h2 class="tool-title">🔀 301 Redirects Manager</h2>
            <button onclick="openRedirectModal()" class="btn btn-primary btn-sm">
                ➕ Add Redirect
            </button>
        </div>
        
        <p style="color: var(--brand-muted); margin-bottom: 1.5rem;">
            Redirect old URLs to new ones to preserve SEO value and avoid 404 errors.
        </p>
        
        <?php if (count($redirects) > 0): ?>
        <table class="redirect-table">
            <thead>
                <tr>
                    <th>Old URL</th>
                    <th>→</th>
                    <th>New URL</th>
                    <th>Type</th>
                    <th>Hits</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($redirects as $redirect): ?>
                <tr>
                    <td><span class="redirect-url">/<?php echo htmlspecialchars($redirect['old_url']); ?></span></td>
                    <td style="text-align: center;">→</td>
                    <td><span class="redirect-url">/<?php echo htmlspecialchars($redirect['new_url']); ?></span></td>
                    <td>
                        <span class="badge <?php echo $redirect['redirect_type'] === '301' ? 'badge-success' : 'badge-info'; ?>">
                            <?php echo $redirect['redirect_type']; ?>
                        </span>
                    </td>
                    <td><?php echo number_format($redirect['hit_count']); ?></td>
                    <td>
                        <span class="badge <?php echo $redirect['status'] === 'active' ? 'badge-success' : 'badge-warning'; ?>">
                            <?php echo ucfirst($redirect['status']); ?>
                        </span>
                    </td>
                    <td>
                        <button onclick='editRedirect(<?php echo json_encode($redirect, JSON_HEX_TAG | JSON_HEX_APOS); ?>)' class="btn btn-secondary btn-sm">✏️</button>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this redirect?')">
                            <input type="hidden" name="action" value="delete_redirect">
                            <input type="hidden" name="redirect_id" value="<?php echo $redirect['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div style="text-align: center; padding: 3rem; color: var(--brand-muted);">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🔀</div>
            <p>No redirects configured yet.</p>
        </div>
        <?php endif; ?>
        
        <div style="margin-top: 1.5rem; padding: 1rem; background: var(--brand-surface-2); border-radius: 8px;">
            <strong>💡 Redirect Types:</strong>
            <ul style="margin-top: 0.5rem; color: var(--brand-muted); font-size: 0.875rem;">
                <li><strong>301 (Permanent):</strong> Use when a page is moved forever. Passes SEO value.</li>
                <li><strong>302 (Temporary):</strong> Use for temporary changes. Does not pass full SEO value.</li>
            </ul>
        </div>
    </div>
</div>

<!-- Redirect Modal -->
<div id="redirectModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h2 id="redirectModalTitle">Add New Redirect</h2>
            <span class="close" onclick="closeRedirectModal()">&times;</span>
        </div>
        <form method="POST" id="redirectForm">
            <div class="modal-body">
                <input type="hidden" name="action" value="save_redirect">
                <input type="hidden" name="redirect_id" id="redirect_id" value="0">
                
                <div class="form-group">
                    <label for="old_url">Old URL Path *</label>
                    <input type="text" name="old_url" id="old_url" required placeholder="old-page-url">
                    <small>Without leading slash. Example: blog/old-post</small>
                </div>
                
                <div class="form-group">
                    <label for="new_url">New URL Path *</label>
                    <input type="text" name="new_url" id="new_url" required placeholder="new-page-url">
                    <small>Without leading slash. Example: blog/new-post</small>
                </div>
                
                <div class="form-group">
                    <label for="redirect_type">Redirect Type</label>
                    <select name="redirect_type" id="redirect_type">
                        <option value="301">301 - Permanent (Recommended for SEO)</option>
                        <option value="302">302 - Temporary</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="redirect_status">Status</label>
                    <select name="status" id="redirect_status">
                        <option value="active">Active (Redirect NOW)</option>
                        <option value="inactive">Inactive (Disabled)</option>
                    </select>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeRedirectModal()" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">💾 Save Redirect</button>
            </div>
        </form>
    </div>
</div>

<script>
function openRedirectModal() {
    document.getElementById('redirectModalTitle').textContent = 'Add New Redirect';
    document.getElementById('redirectForm').reset();
    document.getElementById('redirect_id').value = '0';
    document.getElementById('redirectModal').style.display = 'block';
}

function editRedirect(redirect) {
    document.getElementById('redirectModalTitle').textContent = 'Edit Redirect';
    document.getElementById('redirect_id').value = redirect.id;
    document.getElementById('old_url').value = redirect.old_url;
    document.getElementById('new_url').value = redirect.new_url;
    document.getElementById('redirect_type').value = redirect.redirect_type;
    document.getElementById('redirect_status').value = redirect.status;
    document.getElementById('redirectModal').style.display = 'block';
}

function closeRedirectModal() {
    document.getElementById('redirectModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('redirectModal');
    if (event.target == modal) {
        closeRedirectModal();
    }
}
</script>

<?php include 'includes/footer.php'; ?>
