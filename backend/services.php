<?php
$pageTitle = 'Services';
require_once 'includes/db.php';
include 'includes/header.php';

$success = '';
$error = '';
$csrfError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    $error = 'Invalid session. Please refresh and try again.';
    $csrfError = true;
}

// Handle Add Service
if (isset($_POST['add_service']) && !$csrfError) {
    $parent_id = $_POST['parent_id'] === '' ? NULL : $_POST['parent_id'];
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $service_code = $_POST['service_code'] ?? NULL;
    $icon = $_POST['icon'] ?? NULL;
    $description = $_POST['description'] ?? NULL;
    $emoji = $_POST['emoji'] ?? NULL;
    $subtitle = $_POST['subtitle'] ?? NULL;
    $badge = $_POST['badge'] ?? NULL;
    $badge_class = $_POST['badge_class'] ?? NULL;
    $review_count = $_POST['review_count'] ?? 0;
    $avg_delivery = $_POST['avg_delivery'] ?? '30 min';
    $display_order = $_POST['display_order'] ?? 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $show_on_homepage = isset($_POST['show_on_homepage']) ? 1 : 0;
    $homepage_order = $_POST['homepage_order'] ?? 0;
    $page_title = $_POST['page_title'] ?? NULL;
    $page_subtitle = $_POST['page_subtitle'] ?? NULL;
    $meta_title = $_POST['meta_title'] ?? NULL;
    $meta_description = $_POST['meta_description'] ?? NULL;
    
    // Handle features array
    $features = [];
    if (isset($_POST['features']) && is_array($_POST['features'])) {
        foreach ($_POST['features'] as $feature) {
            if (!empty(trim($feature))) {
                $features[] = trim($feature);
            }
        }
    }
    $features_json = !empty($features) ? json_encode($features) : NULL;
    
    if ($name && $slug) {
        // Enforce unique slug
        $existing = $db->where('slug', $slug)->getOne('services');
        if ($existing) {
            $error = 'Slug already exists. Please use a unique slug.';
        }
    }

    if (!$error && $name && $slug) {
        $data = [
            'parent_id' => $parent_id,
            'name' => $name,
            'slug' => $slug,
            'service_code' => $service_code,
            'icon' => $icon,
            'description' => $description,
            'emoji' => $emoji,
            'subtitle' => $subtitle,
            'badge' => $badge,
            'badge_class' => $badge_class,
            'features' => $features_json,
            'review_count' => $review_count,
            'avg_delivery' => $avg_delivery,
            'show_on_homepage' => $show_on_homepage,
            'homepage_order' => $homepage_order,
            'display_order' => $display_order,
            'is_active' => $is_active,
            'page_title' => $page_title,
            'page_subtitle' => $page_subtitle,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'is_featured' => $is_featured
        ];
        
        if (addService($data)) {
            $success = 'Service/Category added successfully!';
        } else {
            $error = 'Failed to add service/category!';
        }
    } else {
        $error = 'Name and Slug are required!';
    }
}

// Handle Update Service
if (isset($_POST['update_service']) && !$csrfError) {
    $id = $_POST['id'] ?? 0;
    $parent_id = $_POST['parent_id'] === '' ? NULL : $_POST['parent_id'];
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $service_code = $_POST['service_code'] ?? NULL;
    $icon = $_POST['icon'] ?? NULL;
    $description = $_POST['description'] ?? NULL;
    $emoji = $_POST['emoji'] ?? NULL;
    $subtitle = $_POST['subtitle'] ?? NULL;
    $badge = $_POST['badge'] ?? NULL;
    $badge_class = $_POST['badge_class'] ?? NULL;
    $review_count = $_POST['review_count'] ?? 0;
    $avg_delivery = $_POST['avg_delivery'] ?? '30 min';
    $display_order = $_POST['display_order'] ?? 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $show_on_homepage = isset($_POST['show_on_homepage']) ? 1 : 0;
    $homepage_order = $_POST['homepage_order'] ?? 0;
    $page_title = $_POST['page_title'] ?? NULL;
    $page_subtitle = $_POST['page_subtitle'] ?? NULL;
    $meta_title = $_POST['meta_title'] ?? NULL;
    $meta_description = $_POST['meta_description'] ?? NULL;
    
    // Handle features array
    $features = [];
    if (isset($_POST['features']) && is_array($_POST['features'])) {
        foreach ($_POST['features'] as $feature) {
            if (!empty(trim($feature))) {
                $features[] = trim($feature);
            }
        }
    }
    $features_json = !empty($features) ? json_encode($features) : NULL;
    
    if ($id && $name && $slug) {
        // Enforce unique slug except self
        $existing = $db->where('slug', $slug)->where('id', $id, '!=')->getOne('services');
        if ($existing) {
            $error = 'Slug already exists. Please use a unique slug.';
        }
    }

    if (!$error && $id && $name && $slug) {
        $data = [
            'parent_id' => $parent_id,
            'name' => $name,
            'slug' => $slug,
            'service_code' => $service_code,
            'icon' => $icon,
            'description' => $description,
            'emoji' => $emoji,
            'subtitle' => $subtitle,
            'badge' => $badge,
            'badge_class' => $badge_class,
            'features' => $features_json,
            'review_count' => $review_count,
            'avg_delivery' => $avg_delivery,
            'show_on_homepage' => $show_on_homepage,
            'homepage_order' => $homepage_order,
            'display_order' => $display_order,
            'is_active' => $is_active,
            'page_title' => $page_title,
            'page_subtitle' => $page_subtitle,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'is_featured' => $is_featured
        ];
        
        if (updateService($id, $data)) {
            $success = 'Service/Category updated successfully!';
        } else {
            $error = 'Failed to update service/category!';
        }
    }
}

// Handle inline quick update (order/status/featured)
if (isset($_POST['update_service_inline']) && !$csrfError) {
    $id = (int)($_POST['id'] ?? 0);
    $display_order = isset($_POST['display_order']) ? (int)$_POST['display_order'] : 0;
    $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    if ($id) {
        if (updateServiceInline($id, [
            'display_order' => $display_order,
            'is_active' => $is_active,
            'is_featured' => $is_featured
        ])) {
            $success = 'Service updated.';
        } else {
            $error = 'Failed to update service.';
        }
    }
}

// Handle Delete Service
if (isset($_POST['delete']) && !$csrfError) {
    $id = $_POST['delete'];
    $service = getServiceById($id);
    
    // Check if it's a category with children
    if ($service && $service['parent_id'] === NULL && serviceHasChildren($id)) {
        $error = 'Cannot delete category with services! Delete services first.';
    } else {
        if (deleteService($id)) {
            $success = 'Service/Category deleted successfully!';
        } else {
            $error = 'Failed to delete service/category!';
        }
    }
}

// Filters
$filters = [
    'q' => $_GET['q'] ?? '',
    'is_active' => $_GET['is_active'] ?? '',
    'type' => $_GET['type'] ?? ''
];

// Get services with filters
$services = getServicesFiltered($filters);
$categories = getServiceCategories();

// Get service for editing
$editService = null;
if (isset($_GET['edit'])) {
    $editService = getServiceById($_GET['edit']);
    // Parse features JSON
    if ($editService && $editService['features']) {
        $editService['features_array'] = json_decode($editService['features'], true);
    }
}
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="table-container">
    <div class="table-header" style="gap: 1rem; flex-wrap: wrap;">
        <h2>Manage Services & Categories (<?php echo count($services); ?>)</h2>
        <form method="GET" action="" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center;">
            <input type="text" name="q" value="<?php echo htmlspecialchars($filters['q']); ?>" placeholder="Search name, slug, code" style="padding: 0.6rem 0.8rem; border: 2px solid #e2e8f0; border-radius: 10px; min-width: 220px;">
            <select name="type" style="padding: 0.6rem 0.8rem; border: 2px solid #e2e8f0; border-radius: 10px; min-width: 140px;">
                <option value="">All Types</option>
                <option value="category" <?php echo $filters['type'] === 'category' ? 'selected' : ''; ?>>Categories</option>
                <option value="service" <?php echo $filters['type'] === 'service' ? 'selected' : ''; ?>>Services</option>
            </select>
            <select name="is_active" style="padding: 0.6rem 0.8rem; border: 2px solid #e2e8f0; border-radius: 10px; min-width: 140px;">
                <option value="">All Status</option>
                <option value="1" <?php echo $filters['is_active'] === '1' ? 'selected' : ''; ?>>Active</option>
                <option value="0" <?php echo $filters['is_active'] === '0' ? 'selected' : ''; ?>>Inactive</option>
            </select>
            <button class="btn-secondary" type="submit">Filter</button>
        </form>
        <button class="btn-primary" onclick="showModal('addServiceModal')">+ Add Service/Category</button>
    </div>
    
    <?php if (count($services) > 0): ?>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="min-width: 250px;">Name</th>
                        <th style="width: 120px; text-align: center;">Code</th>
                        <th style="width: 100px; text-align: center;">Type</th>
                        <th style="width: 100px; text-align: center;">Order</th>
                        <th style="width: 100px; text-align: center;">Status</th>
                        <th style="width: 100px; text-align: center;">Homepage</th>
                        <th style="width: 240px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td style="font-weight: 600; color: #64748b;">#<?php echo $service['id']; ?></td>
                            <td>
                                <?php if ($service['parent_id'] === NULL): ?>
                                    <strong style="color: #7c3aed;">
                                        <?php echo $service['icon'] ? $service['icon'] . ' ' : ''; ?>
                                        <?php echo htmlspecialchars($service['name']); ?>
                                    </strong>
                                <?php else: ?>
                                    <span style="margin-left: 2rem; color: #64748b;">
                                        └─ <?php echo $service['icon'] ? $service['icon'] . ' ' : ''; ?>
                                        <?php echo htmlspecialchars($service['name']); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if ($service['badge']): ?>
                                    <span class="badge" style="background: #fbbf24; color: #78350f; margin-left: 0.5rem; font-size: 0.75rem;">
                                        <?php echo htmlspecialchars($service['badge']); ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; color: #475569; font-weight: 600;">
                                <?php echo htmlspecialchars($service['service_code'] ?? '—'); ?>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($service['parent_id'] === NULL): ?>
                                    <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 0.75rem;">Category</span>
                                <?php else: ?>
                                    <span class="badge badge-info" style="font-size: 0.75rem;">Service</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; font-weight: 600; color: #64748b;">
                                <?php echo $service['display_order']; ?>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($service['is_active']): ?>
                                    <span class="badge badge-success" style="font-size: 0.75rem;">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-warning" style="font-size: 0.75rem;">Inactive</span>
                                <?php endif; ?>
                                <?php if ($service['is_featured']): ?>
                                    <span style="font-size: 0.875rem; margin-left: 0.25rem;">⭐</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($service['show_on_homepage']): ?>
                                    <span style="color: #10b981; font-weight: 600;">✓</span>
                                    <span style="font-size: 0.75rem; color: #64748b;">(<?php echo $service['homepage_order']; ?>)</span>
                                <?php else: ?>
                                    <span style="color: #cbd5e1;">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="table-actions" style="text-align: right; gap: 0.35rem;">
                                <form method="POST" action="" style="display: inline-flex; gap: 0.35rem; align-items: center;">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken()); ?>">
                                    <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                                    <input type="number" name="display_order" value="<?php echo $service['display_order']; ?>" min="0" style="width: 80px; padding: 0.4rem 0.5rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem;">
                                    <select name="is_active" style="padding: 0.35rem 0.5rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem;">
                                        <option value="1" <?php echo $service['is_active'] ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?php echo !$service['is_active'] ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                    <label style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.85rem; color: #475569;">
                                        <input type="checkbox" name="is_featured" <?php echo $service['is_featured'] ? 'checked' : ''; ?> style="width: auto;">
                                        <span>Featured</span>
                                    </label>
                                    <button type="submit" name="update_service_inline" class="btn-secondary" style="padding: 0.4rem 0.8rem;">Save</button>
                                </form>
                                <a href="?edit=<?php echo $service['id']; ?>" class="btn-secondary" style="padding: 0.5rem 0.75rem; font-size: 0.875rem;">Edit</a>
                                <form method="POST" action="" style="display: inline;">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken()); ?>">
                                    <input type="hidden" name="delete" value="<?php echo $service['id']; ?>">
                                    <button type="submit" class="btn-danger" style="padding: 0.5rem 0.75rem; font-size: 0.875rem;" onclick="return confirmDelete('Are you sure you want to delete this <?php echo $service['parent_id'] === NULL ? 'category' : 'service'; ?>?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h3>No Services Found</h3>
            <p>Start by adding your first service or category.</p>
            <button class="btn-primary" onclick="showModal('addServiceModal')">+ Add Service/Category</button>
        </div>
    <?php endif; ?>
</div>

<!-- Add/Edit Service Modal -->
<div id="addServiceModal" class="modal <?php echo $editService ? 'active' : ''; ?>">
    <div class="modal-content" style="max-width: 800px; max-height: 90vh; overflow-y: auto;">
        <div class="modal-header">
            <h3><?php echo $editService ? 'Edit Service/Category' : 'Add New Service/Category'; ?></h3>
            <button class="modal-close" onclick="hideModal('addServiceModal')">&times;</button>
        </div>
        
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken()); ?>">
            <?php if ($editService): ?>
                <input type="hidden" name="id" value="<?php echo $editService['id']; ?>">
            <?php endif; ?>
            
            <!-- Basic Info Section -->
            <div style="background: #f8fafc; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                <h4 style="margin: 0 0 1rem 0; color: #1e293b;">📝 Basic Information</h4>
                
                <div class="form-group">
                    <label for="parent_id">Type</label>
                    <select id="parent_id" name="parent_id" style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;">
                        <option value="">Category (Top Level)</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo ($editService && $editService['parent_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                Service under <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" id="name" name="name" 
                           value="<?php echo $editService ? htmlspecialchars($editService['name']) : ''; ?>" 
                           maxlength="200" required oninput="syncSlugFromName()">
                </div>
                
                <div class="form-group">
                    <label for="slug">URL Slug *</label>
                    <input type="text" id="slug" name="slug" 
                           value="<?php echo $editService ? htmlspecialchars($editService['slug']) : ''; ?>" 
                           maxlength="200" required>
                    <small style="color: #64748b; font-size: 0.875rem;">Auto-generated from name (URL-friendly). You can override.</small>
                </div>
                
                <div class="form-group">
                    <label for="service_code">Service Code</label>
                    <input type="text" id="service_code" name="service_code" 
                           value="<?php echo $editService ? htmlspecialchars($editService['service_code']) : ''; ?>" 
                           maxlength="10" placeholder="e.g., IGF, IGL">
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3" style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-family: inherit; resize: vertical;"><?php echo $editService ? htmlspecialchars($editService['description']) : ''; ?></textarea>
                </div>
            </div>
            
            <!-- Display Settings Section -->
            <div style="background: #f8fafc; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                <h4 style="margin: 0 0 1rem 0; color: #1e293b;">🎨 Display Settings</h4>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <input type="text" id="icon" name="icon" 
                               value="<?php echo $editService ? htmlspecialchars($editService['icon']) : ''; ?>" 
                               maxlength="50" placeholder="📸 or 👥">
                    </div>
                    
                    <div class="form-group">
                        <label for="emoji">Emoji</label>
                        <input type="text" id="emoji" name="emoji" 
                               value="<?php echo $editService ? htmlspecialchars($editService['emoji']) : ''; ?>" 
                               maxlength="10" placeholder="🎵">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" id="subtitle" name="subtitle" 
                           value="<?php echo $editService ? htmlspecialchars($editService['subtitle']) : ''; ?>" 
                           maxlength="200" placeholder="Short description">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="badge">Badge Text</label>
                        <input type="text" id="badge" name="badge" 
                               value="<?php echo $editService ? htmlspecialchars($editService['badge']) : ''; ?>" 
                               maxlength="50" placeholder="Most Popular">
                    </div>
                    
                    <div class="form-group">
                        <label for="badge_class">Badge CSS Class</label>
                        <input type="text" id="badge_class" name="badge_class" 
                               value="<?php echo $editService ? htmlspecialchars($editService['badge_class']) : ''; ?>" 
                               maxlength="50">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Features (Bullet Points)</label>
                    <div id="features-container">
                        <?php 
                        if ($editService && isset($editService['features_array']) && is_array($editService['features_array'])) {
                            foreach ($editService['features_array'] as $feature) {
                                echo '<div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">';
                                echo '<input type="text" name="features[]" value="' . htmlspecialchars($feature) . '" style="flex: 1; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px;">';
                                echo '<button type="button" onclick="this.parentElement.remove()" class="btn-danger" style="padding: 0.875rem 1.25rem;">Remove</button>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <button type="button" onclick="addFeature()" class="btn-secondary" style="margin-top: 0.5rem;">+ Add Feature</button>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="review_count">Review Count</label>
                        <input type="number" id="review_count" name="review_count" 
                               value="<?php echo $editService ? $editService['review_count'] : 0; ?>" 
                               min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="avg_delivery">Avg Delivery Time</label>
                        <input type="text" id="avg_delivery" name="avg_delivery" 
                               value="<?php echo $editService ? htmlspecialchars($editService['avg_delivery']) : '30 min'; ?>" 
                               maxlength="50">
                    </div>
                </div>
            </div>
            
            <!-- Settings Section -->
            <div style="background: #f8fafc; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                <h4 style="margin: 0 0 1rem 0; color: #1e293b;">⚙️ Settings</h4>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="display_order">Display Order</label>
                        <input type="number" id="display_order" name="display_order" 
                               value="<?php echo $editService ? $editService['display_order'] : 0; ?>" 
                               min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="homepage_order">Homepage Order</label>
                        <input type="number" id="homepage_order" name="homepage_order" 
                               value="<?php echo $editService ? $editService['homepage_order'] : 0; ?>" 
                               min="0">
                    </div>
                </div>
                
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_active" 
                               <?php echo (!$editService || $editService['is_active']) ? 'checked' : ''; ?>
                               style="width: auto;">
                        <span>Active (Show on website)</span>
                    </label>
                </div>
                
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_featured" 
                               <?php echo ($editService && $editService['is_featured']) ? 'checked' : ''; ?>
                               style="width: auto;">
                        <span>Featured (⭐ Highlight)</span>
                    </label>
                </div>
                
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="show_on_homepage" 
                               <?php echo ($editService && $editService['show_on_homepage']) ? 'checked' : ''; ?>
                               style="width: auto;">
                        <span>Show on Homepage</span>
                    </label>
                </div>
            </div>
            
            <!-- SEO Section -->
            <div style="background: #f8fafc; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                <h4 style="margin: 0 0 1rem 0; color: #1e293b;">🔍 SEO Settings</h4>
                
                <div class="form-group">
                    <label for="page_title">Page Title</label>
                    <input type="text" id="page_title" name="page_title" 
                           value="<?php echo $editService ? htmlspecialchars($editService['page_title']) : ''; ?>" 
                           maxlength="255">
                </div>
                
                <div class="form-group">
                    <label for="page_subtitle">Page Subtitle</label>
                    <textarea id="page_subtitle" name="page_subtitle" rows="2" style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-family: inherit; resize: vertical;"><?php echo $editService ? htmlspecialchars($editService['page_subtitle']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" 
                           value="<?php echo $editService ? htmlspecialchars($editService['meta_title']) : ''; ?>" 
                           maxlength="255">
                </div>
                
                <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-family: inherit; resize: vertical;"><?php echo $editService ? htmlspecialchars($editService['meta_description']) : ''; ?></textarea>
                </div>
            </div>
            
            <button type="submit" name="<?php echo $editService ? 'update_service' : 'add_service'; ?>" class="btn">
                <?php echo $editService ? 'Update Service/Category' : 'Add Service/Category'; ?>
            </button>
        </form>
    </div>
</div>

<script>
function syncSlugFromName() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    if (!nameInput || !slugInput) return;
    // Only auto-fill if slug was not manually edited after modal open
    const slugDirty = slugInput.dataset.dirty === '1';
    if (slugDirty) return;
    const slug = nameInput.value
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    slugInput.value = slug;
}

// Track manual edits on slug
document.getElementById('slug')?.addEventListener('input', function() {
    this.dataset.dirty = '1';
});

// Feature adder already present; keep existing behavior
</script>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});

// Add feature function
function addFeature() {
    const container = document.getElementById('features-container');
    const div = document.createElement('div');
    div.style.display = 'flex';
    div.style.gap = '0.5rem';
    div.style.marginBottom = '0.5rem';
    div.innerHTML = `
        <input type="text" name="features[]" placeholder="Enter feature text" style="flex: 1; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px;">
        <button type="button" onclick="this.parentElement.remove()" class="btn-danger" style="padding: 0.875rem 1.25rem;">Remove</button>
    `;
    container.appendChild(div);
}
</script>

<?php if ($editService): ?>
<script>
    showModal('addServiceModal');
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
