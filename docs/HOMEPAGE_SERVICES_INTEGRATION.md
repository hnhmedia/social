# Homepage Services Database Integration - Implementation Guide

## 📋 Overview

This update converts the hardcoded services array in `modules/home.php` to dynamically load from the `si_services` table with real-time order statistics from `si_orders`.

## 🎯 What's Changed

### 1. **Database Schema Updates**
New fields added to `si_services` table:
- `emoji` - Service card emoji (e.g., 👥, ❤️, 🎵)
- `subtitle` - Card subtitle text
- `badge` - Badge text (Most Popular, Best Value, etc.)
- `badge_class` - CSS class for badge styling
- `features` - JSON array of feature bullet points
- `review_count` - Total review count
- `avg_delivery` - Average delivery time display
- `show_on_homepage` - Enable/disable homepage display
- `homepage_order` - Sort order on homepage

### 2. **New PHP Integration File**
Created: `includes/homepage_service_integration.php`

Functions:
- `getHomepageServices()` - Fetches services with live stats
- `getTodayOrderCount($serviceId)` - Counts today's orders per service
- `getTotalOrdersThisWeek()` - Global weekly order count
- `getPackageQuantityRange($serviceId)` - Min/max package quantities

### 3. **Updated Files**
- `modules/home.php` - Replaced hardcoded array with database call
- Dynamic "orders this week" count

## 📦 Installation Steps

### **Step 1: Run SQL Migration**

Execute the SQL file to add new fields to your database:

**Via Command Line:**
```bash
mysql -u root -p social < database/migrations/2026_02_10_add_service_display_fields.sql
```

**Via Adminer/phpMyAdmin:**
1. Open Adminer at your database URL
2. Select the `social` database
3. Go to SQL command
4. Copy and paste the contents of `database/migrations/2026_02_10_add_service_display_fields.sql`
5. Execute

### **Step 2: Verify Files Exist**

Check that these files are in place:
- ✅ `includes/homepage_service_integration.php` (already added)
- ✅ `modules/home.php` (already updated)
- ✅ `database/migrations/2026_02_10_add_service_display_fields.sql`

### **Step 3: Configure Services**

The migration will automatically configure the Instagram Followers service (ID 4). 

For other services, update them manually:

```sql
UPDATE `si_services` 
SET 
  `emoji` = '❤️',
  `subtitle` = 'Make your posts pop',
  `badge` = 'Best Value',
  `badge_class` = '',
  `features` = '["Real people, real likes", "Works on posts, reels, videos", "50 to 100,000+ available", "You pick the delivery speed"]',
  `review_count` = 8700,
  `avg_delivery` = '30 min',
  `show_on_homepage` = 1,
  `homepage_order` = 2
WHERE `slug` = 'buy-instagram-likes';
```

### **Step 4: Test the Homepage**

Visit: `https://betabd.zodiaccdn.com/sgi/`

Expected behavior:
- Services load from database
- "X orders this week" shows real count
- "X today" shows actual daily orders per service
- Features display correctly
- No PHP errors

## 🔧 Configuration Options

### Adding a New Service

1. **Insert into `si_services`:**
```sql
INSERT INTO `si_services` (
  `name`, `slug`, `description`, 
  `emoji`, `subtitle`, `badge`, `badge_class`,
  `features`, `review_count`, `avg_delivery`,
  `show_on_homepage`, `homepage_order`, `is_active`
) VALUES (
  'Buy Instagram Followers',
  'buy-instagram-followers',
  'Real Instagram followers delivered fast',
  '👥',
  'Get real followers fast',
  'Most Popular',
  '',
  '["Real followers (not bots)", "Starts in literally 60 seconds", "Choose from 100 to 100,000+", "We never ask for your password"]',
  10450,
  '30 min',
  1,
  1,
  1
);
```

2. **Add packages to `si_service_packages`** (already done in your case)

### Features JSON Format

The `features` field must be a valid JSON array:

```json
[
  "Real followers (not bots)",
  "Starts in literally 60 seconds", 
  "Choose from 100 to 100,000+",
  "We never ask for your password"
]
```

**Important:** When inserting via SQL, escape the quotes:
```sql
'[\"Feature 1\", \"Feature 2\", \"Feature 3\"]'
```

### Badge Classes

Available badge classes (defined in CSS):
- `` (default purple)
- `trending` (pink/gradient)
- `creator` (orange)
- Custom classes can be added to your CSS

### Hiding/Showing Services

To hide a service from homepage:
```sql
UPDATE si_services SET show_on_homepage = 0 WHERE id = 5;
```

To change display order:
```sql
UPDATE si_services SET homepage_order = 10 WHERE id = 5;
```

## 📊 How Data Flows

```
[si_services table]
     ↓
getHomepageServices()
     ↓
getTodayOrderCount() → [si_orders table] → Count today's orders
     ↓
getPackageQuantityRange() → [si_service_packages table] → Min/Max
     ↓
[modules/home.php renders]
```

## 🎨 Display Features

### Rating
Hardcoded to **5.0 stars** (as requested)

### Review Count
From `si_services.review_count` field
Displayed as: "10,450+"

### Today's Orders
Real-time count from `si_orders` table
- Counted by matching `service_name` field
- Filtered by `DATE(created_at) = TODAY`
- Format: "+847 today"

### Delivery Time
From `si_services.avg_delivery` field
Displayed as: "Avg. delivery: **30 min**"

## 🐛 Troubleshooting

### No Services Showing

**Check:**
1. Is `show_on_homepage = 1` in database?
2. Is `is_active = 1`?
3. Does the service have the required fields filled?
4. Run migration successfully?

**Debug:**
```php
// Add to modules/home.php temporarily (after line 197)
$services = getHomepageServices();
echo '<pre>'; print_r($services); die();
```

### Orders Count Shows 0

**Check:**
1. Does `si_orders.service_name` match `si_services.name` exactly?
   - Case-sensitive match required
   - Example: "Instagram Followers" not "instagram followers"
2. Are there orders with `created_at` = today?

**Debug:**
```php
// Test today's orders
$db = Database::getConnection();
$db->where('DATE(created_at)', date('Y-m-d'));
$count = $db->getValue('si_orders', 'COUNT(*)');
echo "Total orders today: $count";

// Test specific service
$db->where('service_name', 'Instagram Followers');
$db->where('DATE(created_at)', date('Y-m-d'));
$count = $db->getValue('si_orders', 'COUNT(*)');
echo "Instagram Followers orders today: $count";
```

### Features Not Displaying

**Check:**
1. Is the JSON valid? Use https://jsonlint.com/
2. Are quotes properly escaped in the database?
3. Check browser console for JavaScript errors

**Fix:**
```sql
-- View current value
SELECT features FROM si_services WHERE id = 4;

-- Re-insert with proper escaping
UPDATE si_services 
SET features = '[\"Feature 1\", \"Feature 2\", \"Feature 3\"]' 
WHERE id = 4;
```

### PHP Errors

**Common Issues:**

1. **"Call to undefined function getHomepageServices()"**
   - Solution: Check that `includes/homepage_service_integration.php` exists
   - Verify the require_once path is correct

2. **"Table 'social.si_services' doesn't have column 'emoji'"**
   - Solution: Run the migration SQL file

3. **Database connection errors**
   - Check `config/database.php` credentials
   - Verify MySQL server is running

## 📈 Performance Notes

- Database queries are optimized with indexes
- Order counts are calculated on-the-fly
- For high-traffic sites (10k+ daily visitors), consider caching

### Optional: Add Caching

For high-traffic sites, cache the results:

```php
// In includes/homepage_service_integration.php
function getHomepageServices() {
    // Check cache first (requires APCu extension)
    $cacheKey = 'homepage_services_' . date('Y-m-d-H'); // Hourly cache
    if (function_exists('apcu_fetch')) {
        $cached = apcu_fetch($cacheKey);
        if ($cached !== false) {
            return $cached;
        }
    }
    
    // ... existing code ...
    
    // Cache for 1 hour
    if (function_exists('apcu_store')) {
        apcu_store($cacheKey, $result, 3600);
    }
    
    return $result;
}
```

## 🔐 Security Notes

- All output is escaped with `htmlspecialchars()`
- Database queries use parameterized statements via MysqliDb
- JSON decoding includes validation
- No user input directly inserted into queries

## 📝 Maintenance

### Daily Tasks
- Monitor order counts for accuracy
- Check for PHP errors in logs

### Weekly Tasks
- Review services display order
- Update review counts if needed

### Monthly Tasks
1. Review and update review counts
2. Verify order statistics are accurate
3. Update badge text/classes as needed
4. Add/remove services from homepage

### Adding New Features to Existing Services
1. Update features JSON in database
2. No code changes needed!

```sql
UPDATE si_services 
SET features = '["New feature 1", "New feature 2", "New feature 3", "New feature 4"]'
WHERE id = 4;
```

## 🎓 Example: Complete Service Setup

```sql
-- 1. Create the service
INSERT INTO `si_services` (
  `name`, `slug`, `description`,
  `emoji`, `subtitle`, `badge`, `badge_class`, `features`,
  `review_count`, `avg_delivery`,
  `show_on_homepage`, `homepage_order`, `is_active`
) VALUES (
  'TikTok Followers',
  'buy-tiktok-followers',
  'Buy real TikTok followers',
  '🎵',
  'Go viral on TikTok',
  'Creator Pick',
  'creator',
  '[\"Quality TikTok followers\", \"Helps you hit the For You page\", \"100 to 50,000+ followers\", \"Natural-looking growth\"]',
  6200,
  '30 min',
  1,
  5,
  1
);

-- 2. Get the service ID
SELECT id FROM si_services WHERE slug = 'buy-tiktok-followers';
-- Let's say it returns ID = 10

-- 3. Add packages to si_service_packages
INSERT INTO si_service_packages (
  package_code, service_id, tag_id, quantity, price, 
  original_price, discount_label, is_popular, display_order, is_active
) VALUES
('1TTF', 10, 1, 100, 4.95, NULL, '', 0, 1, 1),
('2TTF', 10, 1, 250, 8.95, 14.90, '40% Off', 0, 2, 1),
('3TTF', 10, 1, 500, 14.95, 29.90, '50% Off', 1, 3, 1);

-- 4. Test by creating a sample order
INSERT INTO `si_orders` (
  `user_id`, `order_number`, `service_type`, `service_name`,
  `quantity`, `price`, `target_url`, `status`, `created_at`
) VALUES (
  1, 'TEST-TT-001', 'tiktok', 'TikTok Followers',
  1000, 29.95, '@testuser', 'completed', NOW()
);

-- 5. Verify it appears on homepage
-- Visit: https://betabd.zodiaccdn.com/sgi/
```

## ✅ Verification Checklist

After installation, verify:

- [ ] SQL migration executed successfully (no errors)
- [ ] New columns exist in `si_services` table
- [ ] `homepage_service_integration.php` file exists in `includes/` folder
- [ ] `modules/home.php` updated (hardcoded array removed)
- [ ] Services configured in database with all required fields
- [ ] Features JSON is valid for each service
- [ ] Homepage loads without PHP errors
- [ ] Services display correctly on homepage
- [ ] Order counts display (even if 0)
- [ ] "Orders this week" shows real data
- [ ] All service links work correctly
- [ ] Badges display correctly with proper styling
- [ ] Delivery time shows per service
- [ ] Features list displays under each service

## 📂 File Structure

After implementation, your structure should be:

```
C:\century\socialig\socialig\
├── config/
│   └── database.php
├── database/
│   └── migrations/
│       └── 2026_02_10_add_service_display_fields.sql
├── docs/
│   └── HOMEPAGE_SERVICES_INTEGRATION.md (this file)
├── includes/
│   ├── Config.php
│   ├── Database.php
│   ├── homepage_service_integration.php ✨ NEW
│   └── ...
├── modules/
│   ├── home.php ✨ UPDATED
│   └── ...
└── ...
```

## 🚀 Quick Start Commands

```bash
# 1. Navigate to project
cd C:\century\socialig\socialig

# 2. Run migration
mysql -u root -p social < database/migrations/2026_02_10_add_service_display_fields.sql

# 3. Verify files
dir includes\homepage_service_integration.php
dir database\migrations\2026_02_10_add_service_display_fields.sql

# 4. Test homepage
# Open browser: https://betabd.zodiaccdn.com/sgi/
```

## 📞 Support

If you encounter issues:

1. Check the Troubleshooting section above
2. Review PHP error logs
3. Verify database connection
4. Check that all files are uploaded correctly

## 🎉 Done!

Your homepage now dynamically loads services from the database with real-time order statistics!

---

**Last Updated:** February 10, 2026  
**Version:** 1.0
