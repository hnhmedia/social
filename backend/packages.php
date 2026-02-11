<?php error_reporting(E_ALL); ini_set('display_errors', 1); 
$pageTitle = 'Service Packages';
require_once 'includes/db.php';
include 'includes/header.php';

$success = '';
$error = '';

// Handle Add Package
if (isset($_POST['add_package'])) {
    $package_code = $_POST['package_code'] ?? null;
    $service_id = $_POST['service_id'] ?? 0;
    $tag_id = $_POST['tag_id'] ?? null;
    $quantity = $_POST['quantity'] ?? 0;
    $price = $_POST['price'] ?? 0;
    $original_price = $_POST['original_price'] ?? null;
    $discount_label = $_POST['discount_label'] ?? null;
    $is_popular = isset($_POST['is_popular']) ? 1 : 0;
    $display_order = $_POST['display_order'] ?? 0;
    $is_active = isset($_POST['is_active']) ? 1 : 1;
    
    if ($service_id && $quantity && $price) {
        $data = [
            'package_code' => $package_code,
            'service_id' => $service_id,
            'tag_id' => $tag_id ?: null,
            'quantity' => $quantity,
            'price' => $price,
            'original_price' => $original_price ?: null,
            'discount_label' => $discount_label ?: null,
            'is_popular' => $is_popular,
            'display_order' => $display_order,
            'is_active' => $is_active
        ];
        
        if (addServicePackage($data)) {
            $success = 'Package added successfully!';
        } else {
            $error = 'Failed to add package!';
        }
    } else {
        $error = 'Service, Quantity and Price are required!';
    }
}

// Handle Update Package
if (isset($_POST['update_package'])) {
    $id = $_POST['id'] ?? 0;
    $package_code = $_POST['package_code'] ?? null;
    $service_id = $_POST['service_id'] ?? 0;
    $tag_id = $_POST['tag_id'] ?? null;
    $quantity = $_POST['quantity'] ?? 0;
    $price = $_POST['price'] ?? 0;
    $original_price = $_POST['original_price'] ?? null;
    $discount_label = $_POST['discount_label'] ?? null;
    $is_popular = isset($_POST['is_popular']) ? 1 : 0;
    $display_order = $_POST['display_order'] ?? 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if ($id && $service_id && $quantity && $price) {
        $data = [
            'package_code' => $package_code,
            'service_id' => $service_id,
            'tag_id' => $tag_id ?: null,
            'quantity' => $quantity,
            'price' => $price,
            'original_price' => $original_price ?: null,
            'discount_label' => $discount_label ?: null,
            'is_popular' => $is_popular,
            'display_order' => $display_order,
            'is_active' => $is_active
        ];
        
        if (updateServicePackage($id, $data)) {
            $success = 'Package updated successfully!';
        } else {
            $error = 'Failed to update package!';
        }
    }
}

// Handle Delete Package
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (deleteServicePackage($id)) {
        $success = 'Package deleted successfully!';
    } else {
        $error = 'Failed to delete package!';
    }
}

// Get filter
$filter_service = $_GET['service'] ?? 'all';

// Get all packages
if ($filter_service !== 'all') {
    $packages = getPackagesByService($filter_service);
} else {
    $packages = getAllServicePackages();
}

// Get services for dropdown
$services = getAllServices();
$activeServices = array_filter($services, function($s) { return $s['parent_id'] !== null; });

// Get tags for dropdown
$tags = getAllServiceTags();

// Get package for editing
$editPackage = null;
if (isset($_GET['edit'])) {
    $editPackage = getServicePackageById($_GET['edit']);
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
        <h2>Manage Service Packages (<?php echo count($packages); ?>)</h2>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <select onchange="window.location.href='?service='+this.value" style="padding: 0.625rem 1rem; border: 2px solid #e2e8f0; border-radius: 10px;">
                <option value="all" <?php echo $filter_service === 'all' ? 'selected' : ''; ?>>All Services</option>
                <?php foreach ($activeServices as $service): ?>
                    <option value="<?php echo $service['id']; ?>" <?php echo $filter_service == $service['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($service['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button class="btn-primary" onclick="showModal('addPackageModal')">+ Add Package</button>
        </div>
    </div>
    
    <?php if (count($packages) > 0): ?>
        <div style="overflow-x: auto;">
            <table class="data-table" style="min-width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="width: 100px;">Code</th>
                        <th style="min-width: 200px;">Service</th>
                        <th style="width: 100px; text-align: right;">Quantity</th>
                        <th style="width: 100px; text-align: right;">Price</th>
                        <th style="width: 120px;">Discount</th>
                        <th style="width: 80px; text-align: center;">Status</th>
                        <th style="width: 180px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $currentService = null;
                    foreach ($packages as $package): 
                        // Get service name
                        $serviceName = 'Unknown';
                        foreach ($services as $s) {
                            if ($s['id'] == $package['service_id']) {
                                $serviceName = $s['name'];
                                break;
                            }
                        }
                        
                        // Show service header if changed
                        if ($currentService !== $package['service_id'] && $filter_service === 'all'):
                            $currentService = $package['service_id'];
                    ?>
                        <tr style="background: #f8fafc;">
                            <td colspan="8" style="font-weight: 600; color: #1e293b; padding: 0.75rem 1rem;">
                                📦 <?php echo htmlspecialchars($serviceName); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                        <tr>
                            <td style="font-weight: 600; color: #64748b;">#<?php echo $package['id']; ?></td>
                            <td>
                                <code style="background: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem;">
                                    <?php echo htmlspecialchars($package['package_code'] ?: '—'); ?>
                                </code>
                            </td>
                            <td>
                                <?php if ($filter_service !== 'all'): ?>
                                    <?php 
                                    // Get tag name
                                    $tagName = '';
                                    if ($package['tag_id']) {
                                        foreach ($tags as $tag) {
                                            if ($tag['id'] == $package['tag_id']) {
                                                $tagName = $tag['name'];
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if ($tagName): ?>
                                        <span class="badge badge-info" style="font-size: 0.75rem;">
                                            <?php echo htmlspecialchars($tagName); ?>
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div style="font-weight: 500; color: #1e293b;">
                                        <?php echo htmlspecialchars($serviceName); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($package['is_popular']): ?>
                                    <span style="color: #f59e0b; font-size: 0.875rem; margin-left: 0.5rem;">⭐ Popular</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <strong style="font-size: 1rem;">
                                    <?php echo number_format($package['quantity']); ?>
                                </strong>
                            </td>
                            <td style="text-align: right;">
                                <div style="font-weight: 600; color: #10b981; font-size: 1.125rem;">
                                    $<?php echo number_format($package['price'], 2); ?>
                                </div>
                                <?php if ($package['original_price']): ?>
                                    <div style="font-size: 0.75rem; color: #94a3b8; text-decoration: line-through;">
                                        $<?php echo number_format($package['original_price'], 2); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($package['discount_label']): ?>
                                    <span class="badge" style="background: #fef3c7; color: #92400e; font-size: 0.75rem; font-weight: 600;">
                                        <?php echo htmlspecialchars($package['discount_label']); ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: #cbd5e1;">—</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($package['is_active']): ?>
                                    <span class="badge badge-success" style="font-size: 0.75rem;">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-warning" style="font-size: 0.75rem;">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="table-actions" style="text-align: right;">
                                <a href="?edit=<?php echo $package['id']; ?><?php echo $filter_service !== 'all' ? '&service='.$filter_service : ''; ?>" 
                                   class="btn-secondary" style="padding: 0.5rem 0.75rem; font-size: 0.875rem;">Edit</a>
                                <a href="?delete=<?php echo $package['id']; ?><?php echo $filter_service !== 'all' ? '&service='.$filter_service : ''; ?>" 
                                   class="btn-danger" 
                                   style="padding: 0.5rem 0.75rem; font-size: 0.875rem;"
                                   onclick="return confirmDelete('Are you sure you want to delete this package?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h3>No Packages Found</h3>
            <p>Start by adding your first service package.</p>
            <button class="btn-primary" onclick="showModal('addPackageModal')">+ Add Package</button>
        </div>
    <?php endif; ?>
</div>

<!-- Add/Edit Package Modal -->
<div id="addPackageModal" class="modal <?php echo $editPackage ? 'active' : ''; ?>">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3><?php echo $editPackage ? 'Edit Package' : 'Add New Package'; ?></h3>
            <button class="modal-close" onclick="hideModal('addPackageModal')">&times;</button>
        </div>
        
        <form method="POST" action="">
            <?php if ($editPackage): ?>
                <input type="hidden" name="id" value="<?php echo $editPackage['id']; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="service_id">Service *</label>
                <select id="service_id" name="service_id" required style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;">
                    <option value="">Select Service</option>
                    <?php foreach ($activeServices as $service): ?>
                        <option value="<?php echo $service['id']; ?>" 
                                <?php echo ($editPackage && $editPackage['service_id'] == $service['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($service['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tag_id">Package Tag (Optional)</label>
                <select id="tag_id" name="tag_id" style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;">
                    <option value="">No Tag</option>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?php echo $tag['id']; ?>" 
                                <?php echo ($editPackage && $editPackage['tag_id'] == $tag['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($tag['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small style="color: #64748b; font-size: 0.875rem;">Tags like "Basic", "Monthly", "Premium"</small>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="package_code">Package Code</label>
                    <input type="text" id="package_code" name="package_code" 
                           value="<?php echo $editPackage ? htmlspecialchars($editPackage['package_code']) : ''; ?>" 
                           maxlength="20"
                           placeholder="e.g., 1IGF">
                    <small style="color: #64748b; font-size: 0.875rem;">Unique identifier</small>
                </div>
                
                <div class="form-group">
                    <label for="quantity">Quantity *</label>
                    <input type="number" id="quantity" name="quantity" 
                           value="<?php echo $editPackage ? $editPackage['quantity'] : ''; ?>" 
                           min="1" required
                           placeholder="e.g., 100">
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="price">Price * ($)</label>
                    <input type="number" id="price" name="price" 
                           value="<?php echo $editPackage ? $editPackage['price'] : ''; ?>" 
                           step="0.01" min="0" required
                           placeholder="9.95">
                </div>
                
                <div class="form-group">
                    <label for="original_price">Original Price ($)</label>
                    <input type="number" id="original_price" name="original_price" 
                           value="<?php echo $editPackage ? $editPackage['original_price'] : ''; ?>" 
                           step="0.01" min="0"
                           placeholder="19.95">
                    <small style="color: #64748b; font-size: 0.875rem;">For showing discounts</small>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="discount_label">Discount Label</label>
                    <input type="text" id="discount_label" name="discount_label" 
                           value="<?php echo $editPackage ? htmlspecialchars($editPackage['discount_label']) : ''; ?>" 
                           maxlength="50"
                           placeholder="40% Off, /month, Premium">
                </div>
                
                <div class="form-group">
                    <label for="display_order">Display Order</label>
                    <input type="number" id="display_order" name="display_order" 
                           value="<?php echo $editPackage ? $editPackage['display_order'] : '0'; ?>" 
                           min="0"
                           placeholder="0">
                </div>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" id="is_popular" name="is_popular" 
                           <?php echo ($editPackage && $editPackage['is_popular']) ? 'checked' : ''; ?>
                           style="width: auto;">
                    <span>⭐ Mark as Popular</span>
                </label>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" id="is_active" name="is_active" 
                           <?php echo (!$editPackage || $editPackage['is_active']) ? 'checked' : ''; ?>
                           style="width: auto;">
                    <span>Active (Available for purchase)</span>
                </label>
            </div>
            
            <button type="submit" name="<?php echo $editPackage ? 'update_package' : 'add_package'; ?>" class="btn">
                <?php echo $editPackage ? 'Update Package' : 'Add Package'; ?>
            </button>
        </form>
    </div>
</div>

<?php if ($editPackage): ?>
<script>
    showModal('addPackageModal');
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
