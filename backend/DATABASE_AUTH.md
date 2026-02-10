# 🔐 Database-Driven Authentication Setup

## ✅ Updated! Admin Authentication Now Uses Database

Your admin panel has been upgraded to use **database-driven authentication** with **proper password encryption**!

---

## 🎯 **What Changed?**

### **Before:**
- ❌ Hardcoded credentials in `auth.php`
- ❌ Plain text password comparison
- ❌ No way to add multiple admins

### **After:**
- ✅ Credentials stored in database (`si_admin_users` table)
- ✅ Bcrypt password encryption (cost: 12)
- ✅ Support for multiple admin users
- ✅ User roles (admin, super_admin)
- ✅ Active/Inactive status
- ✅ Last login tracking

---

## 🚀 **Quick Setup (2 Methods)**

### **Method 1: Web-Based Setup (Recommended)**

1. **Open setup page:**
   ```
   http://localhost/sgi/backend/setup.php
   ```

2. **Click "Run Setup"**
   - Creates `si_admin_users` table
   - Creates default admin user
   - Shows success message

3. **Login with default credentials:**
   - Username: `admin`
   - Password: `admin@123`

4. **Done!** ✅

---

### **Method 2: Manual SQL Import**

1. **Import SQL file:**
   ```sql
   -- In phpMyAdmin or MySQL command line
   -- Navigate to your database
   -- Import: backend/si_admin_users.sql
   ```

2. **The SQL file creates:**
   - `si_admin_users` table
   - Default admin user (admin/admin@123)

3. **Login:**
   - Go to: `http://localhost/sgi/backend/`
   - Username: `admin`
   - Password: `admin@123`

---

## 📊 **Database Table Structure**

### **Table: `si_admin_users`**

```sql
CREATE TABLE `si_admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,        -- Bcrypt encrypted
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','super_admin'),      -- User role
  `status` enum('active','inactive'),      -- Active/Inactive
  `last_login` datetime DEFAULT NULL,      -- Last login time
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
);
```

---

## 🔐 **Default Admin Credentials**

```
Username: admin
Password: admin@123
Name: Administrator
Email: admin@socialig.com
Role: super_admin
Status: active
```

**⚠️ IMPORTANT: Change the password after first login!**

---

## 🔒 **Password Security**

### **Encryption Details:**
- Algorithm: **Bcrypt**
- Cost Factor: **12** (high security)
- Auto-salting: **Yes**
- Rainbow table resistant: **Yes**

### **Password Hash Example:**
```
Plain Password: admin@123
Encrypted Hash: $2y$12$LQv3c1yycY2bvrXf4h4Qz.8WXKe7D9xwZJE4rKPqADvHlF8FGnXGq
```

---

## 👥 **How to Add More Admin Users**

### **Method 1: Using PHP Script**

Create a file `add_admin.php` in `/backend/`:

```php
<?php
require_once 'includes/db.php';

// Add new admin user
$username = 'john';
$password = 'SecurePass123!';
$name = 'John Doe';
$email = 'john@socialig.com';
$role = 'admin'; // or 'super_admin'

$adminId = createAdminUser($username, $password, $name, $email, $role);

if ($adminId) {
    echo "Admin user created! ID: " . $adminId;
} else {
    echo "Failed to create admin user!";
}
```

### **Method 2: Direct SQL Insert**

```sql
INSERT INTO `si_admin_users` 
(`username`, `password`, `name`, `email`, `role`, `status`, `created_at`) 
VALUES (
  'newadmin',
  -- Generate hash using PHP: password_hash('your_password', PASSWORD_BCRYPT, ['cost' => 12])
  '$2y$12$YOUR_GENERATED_HASH_HERE',
  'New Admin Name',
  'newadmin@socialig.com',
  'admin',
  'active',
  NOW()
);
```

---

## 🔑 **How to Generate Password Hashes**

### **Using PHP:**

```php
<?php
$password = 'YourSecurePassword123!';
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
echo $hash;
```

### **Using Online Tool:**
⚠️ Not recommended for production passwords
- Use only for testing/development
- Always generate hashes server-side for real passwords

---

## 🛡️ **Security Features**

### **Authentication System:**
- ✅ Session-based login
- ✅ Password verification using `password_verify()`
- ✅ Protected against SQL injection (MysqliDb)
- ✅ Protected against timing attacks (bcrypt)
- ✅ Protected against rainbow tables (auto-salting)

### **Additional Protection:**
- ✅ Username uniqueness enforced
- ✅ Email uniqueness enforced
- ✅ Active/Inactive status control
- ✅ Last login tracking
- ✅ Role-based access (future enhancement)

---

## 🔄 **How to Change Admin Password**

### **Method 1: Database Helper Function**

```php
<?php
require_once 'includes/db.php';

$admin_id = 1; // The admin's ID
$new_password = 'NewSecurePassword123!';

if (updateAdminPassword($admin_id, $new_password)) {
    echo "Password updated successfully!";
} else {
    echo "Failed to update password!";
}
```

### **Method 2: Direct SQL Update**

```sql
UPDATE `si_admin_users` 
SET `password` = '$2y$12$YOUR_NEW_HASH_HERE',
    `updated_at` = NOW()
WHERE `id` = 1;
```

---

## 📋 **Admin User Roles**

### **super_admin:**
- Full system access
- Can manage other admins (future feature)
- Cannot be deleted or deactivated easily

### **admin:**
- Standard admin access
- Can manage content (FAQs, testimonials)
- Can view users and orders

---

## 🔍 **Troubleshooting**

### **Problem: "Invalid username or password"**

**Solutions:**
1. Check username is correct (case-sensitive)
2. Verify password is exactly `admin@123`
3. Check user status is 'active'
4. Run setup.php again if needed

### **Problem: "Table si_admin_users doesn't exist"**

**Solutions:**
1. Run `setup.php` via browser
2. Import `si_admin_users.sql` via phpMyAdmin
3. Check database connection in `config/database.php`

### **Problem: Login works but shows "Admin" instead of name**

**Solutions:**
1. Check `name` field is populated in database
2. Clear browser cache and cookies
3. Logout and login again

---

## 📝 **Files Modified**

### **Updated Files:**
```
✅ backend/includes/auth.php       - Database authentication
✅ backend/includes/db.php         - Admin user functions
✅ backend/includes/header.php     - Show admin name
✅ backend/login.php               - Database login
```

### **New Files:**
```
✅ backend/setup.php               - Web-based setup wizard
✅ backend/si_admin_users.sql      - SQL table structure
✅ backend/DATABASE_AUTH.md        - This documentation
```

---

## ✅ **Verification Checklist**

After setup, verify:

```
□ Can access http://localhost/sgi/backend/
□ Login page loads correctly
□ Can login with admin/admin@123
□ Dashboard shows "Welcome, Administrator"
□ Sidebar shows @admin username
□ Last login is tracked in database
□ Logout works correctly
□ Cannot access pages when logged out
```

---

## 🔐 **Production Recommendations**

Before going live:

1. **Change default password:**
   ```
   From: admin@123
   To: Strong unique password (min 16 chars)
   ```

2. **Update admin email:**
   ```
   From: admin@socialig.com
   To: Your real admin email
   ```

3. **Enable HTTPS:**
   - Use SSL certificate
   - Force HTTPS redirects

4. **Add IP restrictions:**
   ```apache
   # .htaccess
   Order Deny,Allow
   Deny from all
   Allow from YOUR.IP.ADDRESS
   ```

5. **Enable rate limiting:**
   - Limit login attempts
   - Add CAPTCHA on login

6. **Regular backups:**
   - Backup si_admin_users table
   - Store password hashes securely

---

## 🎯 **Summary**

**What You Have Now:**
- ✅ Database-driven authentication
- ✅ Bcrypt encrypted passwords
- ✅ Support for multiple admins
- ✅ User roles and status
- ✅ Last login tracking
- ✅ Secure session management
- ✅ Easy setup via web interface

**Next Steps:**
1. Run `setup.php` or import `si_admin_users.sql`
2. Login with admin/admin@123
3. Change the default password
4. Start using the admin panel!

---

**Your admin panel is now secure with database authentication!** 🔐🚀
