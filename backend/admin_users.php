<?php
$pageTitle = 'Admin Users';
require_once 'includes/db.php';
include 'includes/header.php';

$success = '';
$error = '';

// Handle Add Admin User
if (isset($_POST['add_admin'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? 'admin';
    
    if ($username && $password && $name && $email) {
        // Check if username already exists
        $existingUser = $db->where('username', $username)->getOne('admin_users');
        if ($existingUser) {
            $error = 'Username already exists!';
        } else {
            if (createAdminUser($username, $password, $name, $email, $role)) {
                $success = 'Admin user created successfully!';
            } else {
                $error = 'Failed to create admin user!';
            }
        }
    } else {
        $error = 'All fields are required!';
    }
}

// Handle Update Admin User
if (isset($_POST['update_admin'])) {
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? 'admin';
    $status = $_POST['status'] ?? 'active';
    
    if ($id && $name && $email) {
        // Don't allow deactivating yourself
        if ($id == getAdminId() && $status == 'inactive') {
            $error = 'You cannot deactivate your own account!';
        } else {
            if (updateAdminUser($id, $name, $email, $role, $status)) {
                $success = 'Admin user updated successfully!';
            } else {
                $error = 'Failed to update admin user!';
            }
        }
    }
}

// Handle Change Password
if (isset($_POST['change_password'])) {
    $id = $_POST['id'] ?? 0;
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if ($id && $new_password) {
        if ($new_password !== $confirm_password) {
            $error = 'Passwords do not match!';
        } elseif (strlen($new_password) < 6) {
            $error = 'Password must be at least 6 characters!';
        } else {
            if (updateAdminPassword($id, $new_password)) {
                $success = 'Password changed successfully!';
            } else {
                $error = 'Failed to change password!';
            }
        }
    }
}

// Handle Delete Admin User
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Don't allow deleting yourself
    if ($id == getAdminId()) {
        $error = 'You cannot delete your own account!';
    } else {
        if (deleteAdminUser($id)) {
            $success = 'Admin user deleted successfully!';
        } else {
            $error = 'Failed to delete admin user!';
        }
    }
}

// Get all admin users
$adminUsers = getAllAdminUsers();

// Get admin for editing
$editAdmin = null;
if (isset($_GET['edit'])) {
    $editAdmin = getAdminUserById($_GET['edit']);
}

// Get admin for password change
$changePasswordAdmin = null;
if (isset($_GET['change_password'])) {
    $changePasswordAdmin = getAdminUserById($_GET['change_password']);
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
        <h2>Manage Admin Users (<?php echo count($adminUsers); ?>)</h2>
        <button class="btn-primary" onclick="showModal('addAdminModal')">+ Add Admin User</button>
    </div>
    
    <?php if (count($adminUsers) > 0): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($adminUsers as $admin): ?>
                    <tr>
                        <td>#<?php echo $admin['id']; ?></td>
                        <td>
                            <strong>@<?php echo htmlspecialchars($admin['username']); ?></strong>
                            <?php if ($admin['id'] == getAdminId()): ?>
                                <span class="badge" style="background: #7c3aed; color: white; margin-left: 0.5rem;">You</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($admin['name']); ?></td>
                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                        <td>
                            <?php if ($admin['role'] == 'super_admin'): ?>
                                <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">Super Admin</span>
                            <?php else: ?>
                                <span class="badge badge-info">Admin</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($admin['status'] == 'active'): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($admin['last_login']): ?>
                                <?php echo date('M d, Y H:i', strtotime($admin['last_login'])); ?>
                            <?php else: ?>
                                <span style="color: #cbd5e1;">Never</span>
                            <?php endif; ?>
                        </td>
                        <td class="table-actions">
                            <a href="?edit=<?php echo $admin['id']; ?>" class="btn-secondary">Edit</a>
                            <a href="?change_password=<?php echo $admin['id']; ?>" class="btn-secondary">Password</a>
                            <?php if ($admin['id'] != getAdminId()): ?>
                                <a href="?delete=<?php echo $admin['id']; ?>" 
                                   class="btn-danger" 
                                   onclick="return confirmDelete('Are you sure you want to delete this admin user?')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <h3>No Admin Users Found</h3>
            <p>Start by adding your first admin user.</p>
            <button class="btn-primary" onclick="showModal('addAdminModal')">+ Add Admin User</button>
        </div>
    <?php endif; ?>
</div>

<!-- Add Admin Modal -->
<div id="addAdminModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Admin User</h3>
            <button class="modal-close" onclick="hideModal('addAdminModal')">&times;</button>
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username *</label>
                <input type="text" id="username" name="username" required maxlength="50" placeholder="admin123">
                <small style="color: #64748b; font-size: 0.875rem;">Unique username for login</small>
            </div>
            
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required minlength="6" placeholder="Min 6 characters">
                <small style="color: #64748b; font-size: 0.875rem;">Minimum 6 characters</small>
            </div>
            
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" required maxlength="100" placeholder="John Doe">
            </div>
            
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required maxlength="100" placeholder="admin@example.com">
            </div>
            
            <div class="form-group">
                <label for="role">Role *</label>
                <select id="role" name="role" required style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;">
                    <option value="admin">Admin</option>
                    <option value="super_admin">Super Admin</option>
                </select>
                <small style="color: #64748b; font-size: 0.875rem;">Super Admin has full access</small>
            </div>
            
            <button type="submit" name="add_admin" class="btn">Create Admin User</button>
        </form>
    </div>
</div>

<!-- Edit Admin Modal -->
<div id="editAdminModal" class="modal <?php echo $editAdmin ? 'active' : ''; ?>">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Admin User</h3>
            <button class="modal-close" onclick="hideModal('editAdminModal')">&times;</button>
        </div>
        
        <?php if ($editAdmin): ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $editAdmin['id']; ?>">
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" value="<?php echo htmlspecialchars($editAdmin['username']); ?>" disabled style="background: #f8fafc; cursor: not-allowed;">
                <small style="color: #64748b; font-size: 0.875rem;">Username cannot be changed</small>
            </div>
            
            <div class="form-group">
                <label for="edit_name">Full Name *</label>
                <input type="text" id="edit_name" name="name" value="<?php echo htmlspecialchars($editAdmin['name']); ?>" required maxlength="100">
            </div>
            
            <div class="form-group">
                <label for="edit_email">Email *</label>
                <input type="email" id="edit_email" name="email" value="<?php echo htmlspecialchars($editAdmin['email']); ?>" required maxlength="100">
            </div>
            
            <div class="form-group">
                <label for="edit_role">Role *</label>
                <select id="edit_role" name="role" required style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;">
                    <option value="admin" <?php echo $editAdmin['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="super_admin" <?php echo $editAdmin['role'] == 'super_admin' ? 'selected' : ''; ?>>Super Admin</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="edit_status">Status *</label>
                <select id="edit_status" name="status" required style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;">
                    <option value="active" <?php echo $editAdmin['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo $editAdmin['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                </select>
                <?php if ($editAdmin['id'] == getAdminId()): ?>
                    <small style="color: #dc2626; font-size: 0.875rem;">⚠️ You cannot deactivate your own account</small>
                <?php endif; ?>
            </div>
            
            <button type="submit" name="update_admin" class="btn">Update Admin User</button>
        </form>
        <?php endif; ?>
    </div>
</div>

<!-- Change Password Modal -->
<div id="changePasswordModal" class="modal <?php echo $changePasswordAdmin ? 'active' : ''; ?>">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Change Password</h3>
            <button class="modal-close" onclick="hideModal('changePasswordModal')">&times;</button>
        </div>
        
        <?php if ($changePasswordAdmin): ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $changePasswordAdmin['id']; ?>">
            
            <div style="background: #f8fafc; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                <p style="margin: 0; color: #1e293b;">
                    <strong>User:</strong> <?php echo htmlspecialchars($changePasswordAdmin['name']); ?> 
                    (@<?php echo htmlspecialchars($changePasswordAdmin['username']); ?>)
                </p>
            </div>
            
            <div class="form-group">
                <label for="new_password">New Password *</label>
                <input type="password" id="new_password" name="new_password" required minlength="6" placeholder="Minimum 6 characters">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password *</label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="6" placeholder="Re-enter password">
            </div>
            
            <button type="submit" name="change_password" class="btn">Change Password</button>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php if ($editAdmin): ?>
<script>
    showModal('editAdminModal');
</script>
<?php endif; ?>

<?php if ($changePasswordAdmin): ?>
<script>
    showModal('changePasswordModal');
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
