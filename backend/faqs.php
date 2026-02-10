<?php 
$pageTitle = 'FAQs';
require_once 'includes/db.php';
include 'includes/header.php';

$success = '';
$error = '';

// Handle Add FAQ
if (isset($_POST['add_faq'])) {
    $question = $_POST['question'] ?? '';
    $answer = $_POST['answer'] ?? '';
    $category = $_POST['category'] ?? 'general';
    $sort_order = $_POST['sort_order'] ?? 0;
    $active = isset($_POST['active']) ? 1 : 0;
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    if ($question && $answer) {
        if (addFaq($question, $answer, $category, $sort_order, $active, $featured)) {
            $success = 'FAQ added successfully!';
        } else {
            $error = 'Failed to add FAQ!';
        }
    } else {
        $error = 'Question and Answer are required!';
    }
}

// Handle Update FAQ
if (isset($_POST['update_faq'])) {
    $id = $_POST['id'] ?? 0;
    $question = $_POST['question'] ?? '';
    $answer = $_POST['answer'] ?? '';
    $category = $_POST['category'] ?? 'general';
    $sort_order = $_POST['sort_order'] ?? 0;
    $active = isset($_POST['active']) ? 1 : 0;
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    if ($id && $question && $answer) {
        if (updateFaq($id, $question, $answer, $category, $sort_order, $active, $featured)) {
            $success = 'FAQ updated successfully!';
        } else {
            $error = 'Failed to update FAQ!';
        }
    }
}

// Handle Delete FAQ
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (deleteFaq($id)) {
        $success = 'FAQ deleted successfully!';
    } else {
        $error = 'Failed to delete FAQ!';
    }
}

// Get all FAQs
$faqs = getAllFaqs();

// Get FAQ for editing
$editFaq = null;
if (isset($_GET['edit'])) {
    $editFaq = getFaqById($_GET['edit']);
}

// Get existing categories
$existingCategories = getFaqCategories();
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="table-container">
    <div class="table-header">
        <h2>Manage FAQs (<?php echo count($faqs); ?>)</h2>
        <button class="btn-primary" onclick="showModal('addFaqModal')">+ Add FAQ</button>
    </div>
    
    <?php if (count($faqs) > 0): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Sort</th>
                    <th>Category</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($faqs as $faq): ?>
                    <tr>
                        <td><?php echo $faq['sort_order']; ?></td>
                        <td>
                            <span class="badge badge-info">
                                <?php echo htmlspecialchars($faq['category'] ?? 'general'); ?>
                            </span>
                        </td>
                        <td><strong><?php echo htmlspecialchars($faq['question']); ?></strong></td>
                        <td><?php echo htmlspecialchars(substr($faq['answer'], 0, 100)) . '...'; ?></td>
                        <td>
                            <?php if ($faq['active']): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($faq['featured']): ?>
                                <span style="font-size: 1.2rem;">⭐</span>
                            <?php else: ?>
                                <span style="color: #cbd5e1;">☆</span>
                            <?php endif; ?>
                        </td>
                        <td class="table-actions">
                            <a href="?edit=<?php echo $faq['id']; ?>" class="btn-secondary">Edit</a>
                            <a href="?delete=<?php echo $faq['id']; ?>" 
                               class="btn-danger" 
                               onclick="return confirmDelete('Are you sure you want to delete this FAQ?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <h3>No FAQs Found</h3>
            <p>Start by adding your first FAQ.</p>
            <button class="btn-primary" onclick="showModal('addFaqModal')">+ Add FAQ</button>
        </div>
    <?php endif; ?>
</div>

<!-- Add/Edit FAQ Modal -->
<div id="addFaqModal" class="modal <?php echo $editFaq ? 'active' : ''; ?>">
    <div class="modal-content">
        <div class="modal-header">
            <h3><?php echo $editFaq ? 'Edit FAQ' : 'Add New FAQ'; ?></h3>
            <button class="modal-close" onclick="hideModal('addFaqModal')">&times;</button>
        </div>
        
        <form method="POST" action="">
            <?php if ($editFaq): ?>
                <input type="hidden" name="id" value="<?php echo $editFaq['id']; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="question">Question *</label>
                <input type="text" id="question" name="question" 
                       value="<?php echo $editFaq ? htmlspecialchars($editFaq['question']) : ''; ?>" 
                       maxlength="500" required>
            </div>
            
            <div class="form-group">
                <label for="answer">Answer *</label>
                <textarea id="answer" name="answer" rows="6" required style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-family: inherit; resize: vertical;"><?php echo $editFaq ? htmlspecialchars($editFaq['answer']) : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" 
                       value="<?php echo $editFaq ? htmlspecialchars($editFaq['category']) : 'general'; ?>" 
                       list="categoryList"
                       placeholder="e.g., general, billing, technical">
                <datalist id="categoryList">
                    <?php foreach ($existingCategories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat); ?>">
                    <?php endforeach; ?>
                    <option value="general">
                    <option value="billing">
                    <option value="technical">
                    <option value="account">
                    <option value="services">
                </datalist>
                <small style="color: #64748b; font-size: 0.875rem;">Type a new category or select from existing ones</small>
            </div>
            
            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" 
                       value="<?php echo $editFaq ? $editFaq['sort_order'] : 0; ?>" min="0">
                <small style="color: #64748b; font-size: 0.875rem;">Lower numbers appear first</small>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" id="active" name="active" 
                           <?php echo (!$editFaq || $editFaq['active']) ? 'checked' : ''; ?>
                           style="width: auto;">
                    <span>Active (Show on website)</span>
                </label>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" id="featured" name="featured" 
                           <?php echo ($editFaq && $editFaq['featured']) ? 'checked' : ''; ?>
                           style="width: auto;">
                    <span>Featured (⭐ Show in featured section)</span>
                </label>
            </div>
            
            <button type="submit" name="<?php echo $editFaq ? 'update_faq' : 'add_faq'; ?>" class="btn">
                <?php echo $editFaq ? 'Update FAQ' : 'Add FAQ'; ?>
            </button>
        </form>
    </div>
</div>

<?php if ($editFaq): ?>
<script>
    showModal('addFaqModal');
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
