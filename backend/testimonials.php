<?php
$pageTitle = 'Testimonials';
require_once 'includes/db.php';
include 'includes/header.php';

$success = '';
$error = '';

// Handle Add Testimonial
if (isset($_POST['add_testimonial'])) {
    $name = $_POST['name'] ?? '';
    $content = $_POST['content'] ?? '';
    $rating = $_POST['rating'] ?? 5;
    $email = $_POST['email'] ?? null;
    $service_type = $_POST['service_type'] ?? null;
    $title = $_POST['title'] ?? null;
    $avatar_url = $_POST['avatar_url'] ?? null;
    $active = isset($_POST['active']) ? 1 : 0;
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    if ($name && $content) {
        if (addTestimonial($name, $content, $rating, $email, $service_type, $title, $avatar_url, $active, $featured)) {
            $success = 'Testimonial added successfully!';
        } else {
            $error = 'Failed to add testimonial!';
        }
    } else {
        $error = 'Name and Content are required!';
    }
}

// Handle Update Testimonial
if (isset($_POST['update_testimonial'])) {
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $content = $_POST['content'] ?? '';
    $rating = $_POST['rating'] ?? 5;
    $email = $_POST['email'] ?? null;
    $service_type = $_POST['service_type'] ?? null;
    $title = $_POST['title'] ?? null;
    $avatar_url = $_POST['avatar_url'] ?? null;
    $active = isset($_POST['active']) ? 1 : 0;
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    if ($id && $name && $content) {
        if (updateTestimonial($id, $name, $content, $rating, $email, $service_type, $title, $avatar_url, $active, $featured)) {
            $success = 'Testimonial updated successfully!';
        } else {
            $error = 'Failed to update testimonial!';
        }
    }
}

// Handle Delete Testimonial
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (deleteTestimonial($id)) {
        $success = 'Testimonial deleted successfully!';
    } else {
        $error = 'Failed to delete testimonial!';
    }
}

// Get all testimonials
$testimonials = getAllTestimonials();

// Get testimonial for editing
$editTestimonial = null;
if (isset($_GET['edit'])) {
    $editTestimonial = getTestimonialById($_GET['edit']);
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
        <h2>Manage Testimonials (<?php echo count($testimonials); ?>)</h2>
        <button class="btn-primary" onclick="showModal('addTestimonialModal')">+ Add Testimonial</button>
    </div>
    
    <?php if (count($testimonials) > 0): ?>
        <div style="overflow-x: auto;">
            <table class="data-table" style="min-width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="min-width: 150px;">Customer</th>
                        <th style="width: 200px;">Testimonial</th>
                        <th style="width: 80px; text-align: center;">Rating</th>
                        <th style="width: 80px; text-align: center;">Status</th>
                        <th style="width: 180px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testimonials as $testimonial): ?>
                        <tr>
                            <td style="font-weight: 600; color: #64748b;">#<?php echo $testimonial['id']; ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <?php if ($testimonial['avatar_url']): ?>
                                        <img src="<?php echo htmlspecialchars($testimonial['avatar_url']); ?>" 
                                             alt="Avatar" 
                                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0;">
                                    <?php else: ?>
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.125rem;">
                                            <?php echo strtoupper(substr($testimonial['name'], 0, 1)); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <?php echo htmlspecialchars($testimonial['name']); ?>
                                            <?php if ($testimonial['featured']): ?>
                                                <span style="font-size: 0.875rem; margin-left: 0.25rem;">⭐</span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($testimonial['service_type']): ?>
                                            <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.125rem;">
                                                <?php echo htmlspecialchars($testimonial['service_type']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if ($testimonial['title']): ?>
                                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 0.25rem; font-size: 0.875rem;">
                                        <?php echo htmlspecialchars(substr($testimonial['title'], 0, 40)) . (strlen($testimonial['title']) > 40 ? '...' : ''); ?>
                                    </div>
                                <?php endif; ?>
                                <div style="font-size: 0.875rem; color: #64748b; line-height: 1.4;">
                                    <?php echo htmlspecialchars(substr($testimonial['content'], 0, 80)) . '...'; ?>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div style="font-size: 1rem; line-height: 1;">
                                    <?php 
                                    $rating = $testimonial['rating'] ?? 5;
                                    echo str_repeat('⭐', $rating);
                                    ?>
                                </div>
                                <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">
                                    <?php echo $rating; ?>/5
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($testimonial['active']): ?>
                                    <span class="badge badge-success" style="font-size: 0.75rem;">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-warning" style="font-size: 0.75rem;">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="table-actions" style="text-align: right;">
                                <a href="?edit=<?php echo $testimonial['id']; ?>" class="btn-secondary" style="padding: 0.5rem 0.75rem; font-size: 0.875rem;">Edit</a>
                                <a href="?delete=<?php echo $testimonial['id']; ?>" 
                                   class="btn-danger" 
                                   style="padding: 0.5rem 0.75rem; font-size: 0.875rem;"
                                   onclick="return confirmDelete('Are you sure you want to delete this testimonial?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h3>No Testimonials Found</h3>
            <p>Start by adding your first testimonial.</p>
            <button class="btn-primary" onclick="showModal('addTestimonialModal')">+ Add Testimonial</button>
        </div>
    <?php endif; ?>
</div>

<!-- Add/Edit Testimonial Modal -->
<div id="addTestimonialModal" class="modal <?php echo $editTestimonial ? 'active' : ''; ?>">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3><?php echo $editTestimonial ? 'Edit Testimonial' : 'Add New Testimonial'; ?></h3>
            <button class="modal-close" onclick="hideModal('addTestimonialModal')">&times;</button>
        </div>
        
        <form method="POST" action="">
            <?php if ($editTestimonial): ?>
                <input type="hidden" name="id" value="<?php echo $editTestimonial['id']; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" id="name" name="name" 
                       value="<?php echo $editTestimonial ? htmlspecialchars($editTestimonial['name']) : ''; ?>" 
                       maxlength="100" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo $editTestimonial ? htmlspecialchars($editTestimonial['email']) : ''; ?>" 
                       maxlength="100">
                <small style="color: #64748b; font-size: 0.875rem;">Optional - for internal reference</small>
            </div>
            
            <div class="form-group">
                <label for="title">Title/Headline</label>
                <input type="text" id="title" name="title" 
                       value="<?php echo $editTestimonial ? htmlspecialchars($editTestimonial['title']) : ''; ?>" 
                       maxlength="200"
                       placeholder="e.g., Great Service! or Best Investment Ever">
                <small style="color: #64748b; font-size: 0.875rem;">Optional - catchy headline for the testimonial</small>
            </div>
            
            <div class="form-group">
                <label for="content">Testimonial Content *</label>
                <textarea id="content" name="content" rows="5" required style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-family: inherit; resize: vertical;"><?php echo $editTestimonial ? htmlspecialchars($editTestimonial['content']) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="service_type">Service Type</label>
                <input type="text" id="service_type" name="service_type" 
                       value="<?php echo $editTestimonial ? htmlspecialchars($editTestimonial['service_type']) : ''; ?>" 
                       maxlength="50"
                       placeholder="e.g., Instagram Followers, TikTok Likes">
                <small style="color: #64748b; font-size: 0.875rem;">Optional - which service this testimonial is for</small>
            </div>
            
            <div class="form-group">
                <label for="avatar_url">Avatar URL</label>
                <input type="url" id="avatar_url" name="avatar_url" 
                       value="<?php echo $editTestimonial ? htmlspecialchars($editTestimonial['avatar_url']) : ''; ?>" 
                       maxlength="255"
                       placeholder="https://example.com/avatar.jpg">
                <small style="color: #64748b; font-size: 0.875rem;">Optional - URL to user's avatar image</small>
            </div>
            
            <div class="form-group">
                <label for="rating">Rating *</label>
                <select id="rating" name="rating" style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo ($editTestimonial && $editTestimonial['rating'] == $i) ? 'selected' : ($i == 5 && !$editTestimonial ? 'selected' : ''); ?>>
                            <?php echo str_repeat('⭐', $i) . " ($i stars)"; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" id="active" name="active" 
                           <?php echo ($editTestimonial && $editTestimonial['active']) ? 'checked' : ''; ?>
                           style="width: auto;">
                    <span>Active (Show on website)</span>
                </label>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" id="featured" name="featured" 
                           <?php echo ($editTestimonial && $editTestimonial['featured']) ? 'checked' : ''; ?>
                           style="width: auto;">
                    <span>Featured (⭐ Highlight on homepage)</span>
                </label>
            </div>
            
            <button type="submit" name="<?php echo $editTestimonial ? 'update_testimonial' : 'add_testimonial'; ?>" class="btn">
                <?php echo $editTestimonial ? 'Update Testimonial' : 'Add Testimonial'; ?>
            </button>
        </form>
    </div>
</div>

<?php if ($editTestimonial): ?>
<script>
    showModal('addTestimonialModal');
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
