<?php
$pageTitle = 'Service Tags';
require_once 'includes/db.php';
include 'includes/header.php';

$success = '';
$error = '';

// Handle Add Service Tag
if (isset($_POST['add_tag'])) {
    $service_id = $_POST['service_id'] ?? 0;
    $tag_name = $_POST['tag_name'] ?? '';
    $tag_slug = $_POST['tag_slug'] ?? '';
    $badge_label = $_POST['badge_label'] ?? NULL;
    $badge_color = $_POST['badge_color'] ?? NULL;
    $icon = $_POST['icon'] ?? NULL;
    $tag_description = $_POST['tag_description'] ?? NULL;
    $display_order = $_POST['display_order'] ?? 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if ($service_id && $tag_name && $tag_slug) {
        $data = [
            'service_id' => $service_id,
            'tag_name' => $tag_name,
            'tag_slug' => $tag_slug,
            'badge_label' => $badge_label,
            'badge_color' => $badge_color,
            'icon' => $icon,
            'tag_description' => $tag_description,
            'display_order' => $display_order,
            'is_active' => $is_active
        ];
        
        if (addServiceTag($data)) {
            $success = 'Service tag added successfully!';
        } else {
            $error = 'Failed to add service tag!';
        }
    } else {
        $error = 'Service, Tag Name, and Slug are required!';
    }
}

// Handle Update Service Tag
if (isset($_POST['update_tag'])) {
    $id = $_POST['id'] ?? 0;
    $service_id = $_POST['service_id'] ?? 0;
    $tag_name = $_POST['tag_name'] ?? '';
    $tag_slug = $_POST['tag_slug'] ?? '';
    $badge_label = $_POST['badge_label'] ?? NULL;
    $badge_color = $_POST['badge_color'] ?? NULL;
    $icon = $_POST['icon'] ?? NULL;
    $tag_description = $_POST['tag_description'] ?? NULL;
    $display_order = $_POST['display_order'] ?? 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if ($id && $service_id && $tag_name && $tag_slug) {
        $data = [
            'service_id' => $service_id,
            'tag_name' => $tag_name,
            'tag_slug' => $tag_slug,
            'badge_label' => $badge_label,
            'badge_color' => $badge_color,
            'icon' => $icon,
            'tag_description' => $tag_description,
            'display_order' => $display_order,
            'is_active' => $is_active
        ];
        
        if (updateServiceTag($id, $data)) {
            $success = 'Service tag updated successfully!';
        } else {
            $error = 'Failed to update service tag!';
        }
    }
}

// Handle Delete Service Tag
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (deleteServiceTag($id)) {
        $success = 'Service tag deleted successfully!';
    } else {
        $error = 'Failed to delete service tag!';
    }
}

// Get all service tags
$tags = getAllServiceTags();

// Get all actual services (not categories) for dropdown
$services = getActualServices();

// Get tag for editing
$editTag = null;
if (isset($_GET['edit'])) {
    $editTag = getServiceTagById($_GET['edit']);
}

// Group tags by service for display
$tagsByService = [];
foreach ($tags as $tag) {
    $tagsByService[$tag['service_id']][] = $tag;
}
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="table-container">
    <div class="table-header">
        <h2>Manage Service Tags (<?php echo count($tags); ?>)</h2>
        <button class="btn-primary" onclick="showModal('addTagModal')">+ Add Service Tag</button>
    </div>
    
    <?php if (count($tags) > 0): ?>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="min-width: 200px;">Service</th>
                        <th style="min-width: 150px;">Tag Name</th>
                        <th style="width: 120px;">Badge</th>
                        <th style="width: 150px;">Description Preview</th>
                        <th style="width: 80px; text-align: center;">Order</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 180px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $currentService = null;
                    foreach ($tags as $tag): 
                        $service = getServiceById($tag['service_id']);
                        $showServiceName = ($currentService !== $tag['service_id']);
                        $currentService = $tag['service_id'];
                    ?>
                        <tr>
                            <td style="font-weight: 600; color: #64748b;">#<?php echo $tag['id']; ?></td>
                            <td>
                                <?php if ($showServiceName && $service): ?>
                                    <div style="font-weight: 600; color: #7c3aed; margin-bottom: 0.25rem;">
                                        <?php echo $service['icon'] ? $service['icon'] . ' ' : ''; ?>
                                        <?php echo htmlspecialchars($service['name']); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <?php if ($tag['icon']): ?>
                                        <span style="font-size: 1.25rem;"><?php echo $tag['icon']; ?></span>
                                    <?php endif; ?>
                                    <strong><?php echo htmlspecialchars($tag['tag_name']); ?></strong>
                                </div>
                                <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.125rem;">
                                    <?php echo htmlspecialchars($tag['tag_slug']); ?>
                                </div>
                            </td>
                            <td>
                                <?php if ($tag['badge_label']): ?>
                                    <span class="badge" style="background: <?php echo htmlspecialchars($tag['badge_color'] ?? '#64748b'); ?>; color: white; font-size: 0.75rem; font-weight: 600;">
                                        <?php echo htmlspecialchars($tag['badge_label']); ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: #cbd5e1;">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($tag['tag_description']): ?>
                                    <div style="font-size: 0.875rem; color: #64748b;">
                                        <?php echo htmlspecialchars(substr($tag['tag_description'], 0, 40)) . '...'; ?>
                                    </div>
                                <?php else: ?>
                                    <span style="color: #cbd5e1;">—</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; font-weight: 600; color: #64748b;">
                                <?php echo $tag['display_order']; ?>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($tag['is_active']): ?>
                                    <span class="badge badge-success" style="font-size: 0.75rem;">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-warning" style="font-size: 0.75rem;">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="table-actions" style="text-align: right;">
                                <a href="?edit=<?php echo $tag['id']; ?>" class="btn-secondary" style="padding: 0.5rem 0.75rem; font-size: 0.875rem;">Edit</a>
                                <a href="?delete=<?php echo $tag['id']; ?>" 
                                   class="btn-danger" 
                                   style="padding: 0.5rem 0.75rem; font-size: 0.875rem;"
                                   onclick="return confirmDelete('Are you sure you want to delete this tag?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h3>No Service Tags Found</h3>
            <p>Start by adding your first service tag.</p>
            <button class="btn-primary" onclick="showModal('addTagModal')">+ Add Service Tag</button>
        </div>
    <?php endif; ?>
</div>

<!-- Add/Edit Service Tag Modal -->
<div id="addTagModal" class="modal <?php echo $editTag ? 'active' : ''; ?>">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3><?php echo $editTag ? 'Edit Service Tag' : 'Add New Service Tag'; ?></h3>
            <button class="modal-close" onclick="hideModal('addTagModal')">&times;</button>
        </div>
        
        <form method="POST" action="">
            <?php if ($editTag): ?>
                <input type="hidden" name="id" value="<?php echo $editTag['id']; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="service_id">Service *</label>
                <select id="service_id" name="service_id" required style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;">
                    <option value="">Select a service...</option>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo $service['id']; ?>" <?php echo ($editTag && $editTag['service_id'] == $service['id']) ? 'selected' : ''; ?>>
                            <?php echo $service['icon'] ? $service['icon'] . ' ' : ''; ?>
                            <?php echo htmlspecialchars($service['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tag_name">Tag Name *</label>
                <input type="text" id="tag_name" name="tag_name" 
                       value="<?php echo $editTag ? htmlspecialchars($editTag['tag_name']) : ''; ?>" 
                       maxlength="100" required placeholder="e.g., Real Followers, Managed Growth">
            </div>
            
            <div class="form-group">
                <label for="tag_slug">Tag Slug *</label>
                <input type="text" id="tag_slug" name="tag_slug" 
                       value="<?php echo $editTag ? htmlspecialchars($editTag['tag_slug']) : ''; ?>" 
                       maxlength="100" required placeholder="e.g., real, managed, prestige">
                <small style="color: #64748b; font-size: 0.875rem;">Auto-generated from tag name (URL-friendly)</small>
            </div>
            
            <div class="form-group">
                <label for="icon">Icon/Emoji</label>
                <input type="text" id="icon" name="icon" 
                       value="<?php echo $editTag ? htmlspecialchars($editTag['icon']) : ''; ?>" 
                       maxlength="50" placeholder="🔥 or 📅 or 👑">
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="badge_label">Badge Label</label>
                    <input type="text" id="badge_label" name="badge_label" 
                           value="<?php echo $editTag ? htmlspecialchars($editTag['badge_label']) : ''; ?>" 
                           maxlength="50" placeholder="STANDARD, POPULAR, EXCLUSIVE">
                </div>
                
                <div class="form-group">
                    <label for="badge_color">Badge Color</label>
                    <input type="text" id="badge_color" name="badge_color" 
                           value="<?php echo $editTag ? htmlspecialchars($editTag['badge_color']) : ''; ?>" 
                           maxlength="50" placeholder="#3b82f6 or gradient">
                    <small style="color: #64748b; font-size: 0.875rem;">CSS color or gradient</small>
                </div>
            </div>
            
            <div class="form-group">
                <label for="tag_description">Description/Features</label>
                <textarea id="tag_description" name="tag_description" rows="3" 
                          style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-family: inherit; resize: vertical;"
                          placeholder="Real Followers, No Password, 24/7 Support, Fast Growth"><?php echo $editTag ? htmlspecialchars($editTag['tag_description']) : ''; ?></textarea>
                <small style="color: #64748b; font-size: 0.875rem;">Comma-separated features list</small>
            </div>
            
            <div class="form-group">
                <label for="display_order">Display Order</label>
                <input type="number" id="display_order" name="display_order" 
                       value="<?php echo $editTag ? $editTag['display_order'] : 0; ?>" 
                       min="0" style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;">
                <small style="color: #64748b; font-size: 0.875rem;">Lower numbers appear first</small>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" 
                           <?php echo (!$editTag || $editTag['is_active']) ? 'checked' : ''; ?>
                           style="width: auto;">
                    <span>Active (Show on website)</span>
                </label>
            </div>
            
            <button type="submit" name="<?php echo $editTag ? 'update_tag' : 'add_tag'; ?>" class="btn">
                <?php echo $editTag ? 'Update Service Tag' : 'Add Service Tag'; ?>
            </button>
        </form>
    </div>
</div>

<script>
// Auto-generate slug from tag name
document.getElementById('tag_name').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('tag_slug').value = slug;
});
</script>

<?php if ($editTag): ?>
<script>
    showModal('addTagModal');
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
