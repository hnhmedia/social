<?php
/**
 * SEO Global Settings
 * Manage analytics codes, social profiles, default SEO settings
 */

$pageTitle = 'SEO Global Settings';
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
    if ($_POST['action'] === 'save_settings') {
        $saved_count = 0;
        foreach ($_POST as $key => $value) {
            if ($key !== 'action' && strpos($key, 'setting_') === 0) {
                $setting_key = substr($key, 8); // Remove 'setting_' prefix
                $stmt = $conn->prepare("UPDATE si_seo_settings SET setting_value=? WHERE setting_key=?");
                $stmt->bind_param("ss", $value, $setting_key);
                if ($stmt->execute()) {
                    $saved_count++;
                }
                $stmt->close();
            }
        }
        $success_message = "✅ Settings saved successfully! ($saved_count updated)";
    }
}

// Get all settings grouped
$settings = [];
$result = $conn->query("SELECT * FROM si_seo_settings ORDER BY setting_group, setting_key");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $settings[$row['setting_group']][] = $row;
    }
}
?>

<style>
.settings-sections {
    display: grid;
    gap: 2rem;
}

.settings-card {
    background: var(--brand-surface);
    border: 1px solid var(--brand-border);
    border-radius: 12px;
    padding: 2rem;
}

.settings-card-header {
    border-bottom: 2px solid var(--brand-border);
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.settings-card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--brand-heading);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.settings-card-description {
    font-size: 0.9rem;
    color: var(--brand-muted);
    margin-top: 0.5rem;
}

.setting-item {
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--brand-border);
}

.setting-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.setting-label {
    font-weight: 600;
    color: var(--brand-heading);
    margin-bottom: 0.5rem;
    display: block;
}

.setting-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--brand-border);
    border-radius: 6px;
    font-size: 0.9rem;
    font-family: inherit;
}

.setting-textarea {
    min-height: 100px;
    resize: vertical;
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
}

.setting-help {
    font-size: 0.8rem;
    color: var(--brand-muted);
    margin-top: 0.5rem;
    display: flex;
    align-items: start;
    gap: 0.5rem;
}

.setting-help-icon {
    flex-shrink: 0;
    margin-top: 0.1rem;
}

.save-bar {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: var(--brand-surface);
    border: 1px solid var(--brand-border);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    display: none;
    z-index: 1000;
}

.save-bar.show {
    display: block;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.verification-code {
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
    background: #fef3c7;
    border: 1px solid #fbbf24;
    padding: 0.75rem;
    border-radius: 6px;
    margin-top: 0.5rem;
    word-break: break-all;
}
</style>

<?php if (isset($success_message)): ?>
<div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
<div class="alert alert-error"><?php echo $error_message; ?></div>
<?php endif; ?>

<form method="POST" id="settingsForm">
    <input type="hidden" name="action" value="save_settings">
    
    <div class="settings-sections">
        <!-- Analytics Settings -->
        <div class="settings-card">
            <div class="settings-card-header">
                <h2 class="settings-card-title">📊 Analytics & Tracking</h2>
                <p class="settings-card-description">
                    Connect your analytics and tracking tools to monitor website performance.
                </p>
            </div>
            
            <?php if (isset($settings['analytics'])): ?>
                <?php foreach ($settings['analytics'] as $setting): ?>
                <div class="setting-item">
                    <label class="setting-label" for="<?php echo $setting['setting_key']; ?>">
                        <?php echo $setting['setting_label']; ?>
                    </label>
                    <input 
                        type="text" 
                        class="setting-input" 
                        name="setting_<?php echo $setting['setting_key']; ?>" 
                        id="<?php echo $setting['setting_key']; ?>" 
                        value="<?php echo htmlspecialchars($setting['setting_value'] ?? ''); ?>"
                        placeholder="<?php 
                            if ($setting['setting_key'] === 'google_analytics_id') echo 'G-XXXXXXXXXX or UA-XXXXXXXXX-X';
                            elseif ($setting['setting_key'] === 'google_tag_manager_id') echo 'GTM-XXXXXXX';
                            elseif ($setting['setting_key'] === 'facebook_pixel_id') echo '1234567890123456';
                        ?>"
                    >
                    <div class="setting-help">
                        <span class="setting-help-icon">💡</span>
                        <span>
                            <?php 
                            if ($setting['setting_key'] === 'google_analytics_id') {
                                echo 'Find this in your Google Analytics account → Admin → Property Settings';
                            } elseif ($setting['setting_key'] === 'google_tag_manager_id') {
                                echo 'Find this in Google Tag Manager → Container ID (starts with GTM-)';
                            } elseif ($setting['setting_key'] === 'facebook_pixel_id') {
                                echo 'Find this in Facebook Business Manager → Events Manager → Pixel ID';
                            }
                            ?>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Social Media Profiles -->
        <div class="settings-card">
            <div class="settings-card-header">
                <h2 class="settings-card-title">🔗 Social Media Profiles</h2>
                <p class="settings-card-description">
                    Add your social media profile URLs for structured data and footer links.
                </p>
            </div>
            
            <?php if (isset($settings['social'])): ?>
                <?php foreach ($settings['social'] as $setting): ?>
                    <?php if (strpos($setting['setting_key'], '_url') !== false): ?>
                    <div class="setting-item">
                        <label class="setting-label" for="<?php echo $setting['setting_key']; ?>">
                            <?php echo $setting['setting_label']; ?>
                        </label>
                        <input 
                            type="url" 
                            class="setting-input" 
                            name="setting_<?php echo $setting['setting_key']; ?>" 
                            id="<?php echo $setting['setting_key']; ?>" 
                            value="<?php echo htmlspecialchars($setting['setting_value'] ?? ''); ?>"
                            placeholder="https://<?php 
                                if (strpos($setting['setting_key'], 'facebook') !== false) echo 'facebook.com/yourpage';
                                elseif (strpos($setting['setting_key'], 'instagram') !== false) echo 'instagram.com/yourprofile';
                                elseif (strpos($setting['setting_key'], 'twitter') !== false) echo 'twitter.com/yourhandle';
                                elseif (strpos($setting['setting_key'], 'linkedin') !== false) echo 'linkedin.com/company/yourcompany';
                                elseif (strpos($setting['setting_key'], 'tiktok') !== false) echo 'tiktok.com/@yourprofile';
                            ?>"
                        >
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Default SEO Settings -->
        <div class="settings-card">
            <div class="settings-card-header">
                <h2 class="settings-card-title">🖼️ Default SEO Settings</h2>
                <p class="settings-card-description">
                    Set default values used across your site when specific pages don't have custom settings.
                </p>
            </div>
            
            <?php if (isset($settings['social'])): ?>
                <?php foreach ($settings['social'] as $setting): ?>
                    <?php if (strpos($setting['setting_key'], 'default_') !== false): ?>
                    <div class="setting-item">
                        <label class="setting-label" for="<?php echo $setting['setting_key']; ?>">
                            <?php echo $setting['setting_label']; ?>
                        </label>
                        <input 
                            type="url" 
                            class="setting-input" 
                            name="setting_<?php echo $setting['setting_key']; ?>" 
                            id="<?php echo $setting['setting_key']; ?>" 
                            value="<?php echo htmlspecialchars($setting['setting_value'] ?? ''); ?>"
                            placeholder="https://genuinesocials.com/images/default-og-image.jpg"
                        >
                        <div class="setting-help">
                            <span class="setting-help-icon">💡</span>
                            <span>Recommended size: 1200 x 630 pixels. Used for social media sharing when no custom image is set.</span>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Technical Settings -->
        <div class="settings-card">
            <div class="settings-card-header">
                <h2 class="settings-card-title">⚙️ Technical SEO Settings</h2>
                <p class="settings-card-description">
                    Advanced settings for search engine verification and custom code injection.
                </p>
            </div>
            
            <?php if (isset($settings['technical'])): ?>
                <?php foreach ($settings['technical'] as $setting): ?>
                    <?php if (!in_array($setting['setting_key'], ['robots_txt_content'])): ?>
                    <div class="setting-item">
                        <label class="setting-label" for="<?php echo $setting['setting_key']; ?>">
                            <?php echo $setting['setting_label']; ?>
                        </label>
                        
                        <?php if (strpos($setting['setting_key'], 'scripts') !== false): ?>
                        <textarea 
                            class="setting-input setting-textarea" 
                            name="setting_<?php echo $setting['setting_key']; ?>" 
                            id="<?php echo $setting['setting_key']; ?>"
                            placeholder="<!-- Your custom JavaScript or tracking codes here -->"
                        ><?php echo htmlspecialchars($setting['setting_value'] ?? ''); ?></textarea>
                        <?php else: ?>
                        <input 
                            type="text" 
                            class="setting-input" 
                            name="setting_<?php echo $setting['setting_key']; ?>" 
                            id="<?php echo $setting['setting_key']; ?>" 
                            value="<?php echo htmlspecialchars($setting['setting_value'] ?? ''); ?>"
                            placeholder="<?php 
                                if ($setting['setting_key'] === 'google_site_verification') echo 'google1234567890abcdef.html or meta tag content';
                            ?>"
                        >
                        <?php endif; ?>
                        
                        <div class="setting-help">
                            <span class="setting-help-icon">💡</span>
                            <span>
                                <?php 
                                if ($setting['setting_key'] === 'google_site_verification') {
                                    echo 'Google Search Console → Add Property → HTML file or Meta tag verification code';
                                } elseif ($setting['setting_key'] === 'custom_head_scripts') {
                                    echo 'JavaScript or tracking codes to be added in the &lt;head&gt; section of every page (e.g., Hotjar, Clarity)';
                                } elseif ($setting['setting_key'] === 'custom_footer_scripts') {
                                    echo 'JavaScript codes to be added before closing &lt;/body&gt; tag (e.g., chat widgets, analytics)';
                                }
                                ?>
                            </span>
                        </div>
                        
                        <?php if ($setting['setting_key'] === 'google_site_verification' && !empty($setting['setting_value'])): ?>
                        <div class="verification-code">
                            <strong>Your verification meta tag:</strong><br>
                            &lt;meta name="google-site-verification" content="<?php echo htmlspecialchars($setting['setting_value']); ?>" /&gt;
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <div style="margin-top: 2rem; text-align: center;">
        <button type="submit" class="btn btn-primary btn-lg">
            💾 Save All Settings
        </button>
    </div>
</form>

<!-- Floating Save Bar (appears when form is dirty) -->
<div class="save-bar" id="saveBar">
    <p style="margin-bottom: 1rem; color: var(--brand-muted); font-size: 0.9rem;">
        <strong>⚠️ You have unsaved changes</strong>
    </p>
    <button type="submit" form="settingsForm" class="btn btn-primary">
        💾 Save Changes
    </button>
</div>

<script>
// Show floating save bar when form is modified
let formDirty = false;
const form = document.getElementById('settingsForm');
const saveBar = document.getElementById('saveBar');

form.addEventListener('input', function() {
    if (!formDirty) {
        formDirty = true;
        saveBar.classList.add('show');
    }
});

form.addEventListener('submit', function() {
    formDirty = false;
    saveBar.classList.remove('show');
});

// Warn before leaving with unsaved changes
window.addEventListener('beforeunload', function(e) {
    if (formDirty) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        return e.returnValue;
    }
});
</script>

<?php include 'includes/footer.php'; ?>
