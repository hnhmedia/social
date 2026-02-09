# ✅ Installation Checklist

Use this checklist to ensure everything is installed and configured correctly.

---

## Pre-Installation

- [ ] Backup database (IMPORTANT!)
- [ ] Note current site URL: `https://betabd.zodiaccdn.com/sgi/`
- [ ] Have database credentials ready (from `config/database.php`)

---

## Installation Steps

### Step 1: Verify Files

- [ ] `database/migrations/2026_02_10_add_service_display_fields.sql` exists
- [ ] `database/migrations/README.md` exists
- [ ] `includes/homepage_service_integration.php` exists
- [ ] `modules/home.php` has been updated (check for `getHomepageServices()`)
- [ ] `docs/HOMEPAGE_SERVICES_INTEGRATION.md` exists
- [ ] `docs/SUMMARY.md` exists

### Step 2: Run Database Migration

**Option A - Command Line:**
```bash
cd C:\century\socialig\socialig
mysql -u root -p social < database/migrations/2026_02_10_add_service_display_fields.sql
```

**Option B - Adminer:**
1. [ ] Open Adminer in browser
2. [ ] Login to database
3. [ ] Select `social` database
4. [ ] Go to "SQL command"
5. [ ] Paste contents of migration file
6. [ ] Click "Execute"

**Result:**
- [ ] No SQL errors displayed
- [ ] Success message shown

### Step 3: Verify Database Changes

Run these queries to verify:

```sql
-- Check new columns exist
DESCRIBE si_services;
```
Expected output should include:
- [ ] `emoji` column
- [ ] `subtitle` column
- [ ] `badge` column
- [ ] `badge_class` column
- [ ] `features` column
- [ ] `review_count` column
- [ ] `avg_delivery` column
- [ ] `show_on_homepage` column
- [ ] `homepage_order` column

```sql
-- Check index exists
SHOW INDEXES FROM si_services;
```
- [ ] `idx_homepage_display` index exists

```sql
-- Check sample data was inserted
SELECT id, name, emoji, show_on_homepage FROM si_services WHERE show_on_homepage = 1;
```
- [ ] At least 1 service returned
- [ ] Instagram Followers service has emoji '👥'

---

## Testing

### Test 1: Homepage Loads

- [ ] Visit: `https://betabd.zodiaccdn.com/sgi/`
- [ ] Page loads without errors
- [ ] No PHP errors displayed
- [ ] No blank white screen

### Test 2: Services Display

- [ ] Service cards visible on homepage
- [ ] Emojis display correctly (👥, ❤️, 🎵, etc.)
- [ ] Service titles display
- [ ] Subtitles display under titles
- [ ] Badges show (if configured)

### Test 3: Features Display

- [ ] Feature bullet points show under each service
- [ ] At least 4 features per service
- [ ] Features are readable (not JSON code)

### Test 4: Stats Display

- [ ] "X orders this week" shows a number (even if 0)
- [ ] "+X today" shows for each service
- [ ] "Avg. delivery: X min" shows for each service

### Test 5: Links Work

- [ ] Click a service card
- [ ] Redirects to correct service page
- [ ] No 404 errors

---

## Verification Queries

Run these to check everything:

### 1. Count homepage services
```sql
SELECT COUNT(*) as homepage_services 
FROM si_services 
WHERE show_on_homepage = 1 AND is_active = 1;
```
**Expected:** At least 1 service

### 2. Check features format
```sql
SELECT name, features FROM si_services WHERE show_on_homepage = 1 LIMIT 1;
```
**Expected:** Features should be valid JSON array like: `["Feature 1", "Feature 2"]`

### 3. Test order count query
```sql
SELECT COUNT(*) as orders_today FROM si_orders WHERE DATE(created_at) = CURDATE();
```
**Expected:** Number (could be 0)

### 4. Check service data completeness
```sql
SELECT 
  name, 
  emoji, 
  subtitle, 
  badge,
  review_count,
  avg_delivery,
  show_on_homepage
FROM si_services 
WHERE show_on_homepage = 1;
```
**Expected:** All fields filled (except badge can be NULL)

---

## Common Issues

### Issue: No services showing

**Check:**
```sql
SELECT name, show_on_homepage, is_active FROM si_services;
```
- [ ] Set `show_on_homepage = 1` for at least one service
- [ ] Set `is_active = 1` for that service

**Fix:**
```sql
UPDATE si_services SET show_on_homepage = 1, is_active = 1 WHERE id = 4;
```

### Issue: Features not displaying

**Check:**
```sql
SELECT name, features FROM si_services WHERE show_on_homepage = 1;
```
- [ ] Features should be valid JSON
- [ ] Should look like: `["Text 1", "Text 2"]`

**Fix:**
```sql
UPDATE si_services 
SET features = '[\"Feature 1\", \"Feature 2\", \"Feature 3\", \"Feature 4\"]'
WHERE id = 4;
```

### Issue: PHP error "Call to undefined function"

**Check:**
- [ ] `includes/homepage_service_integration.php` exists
- [ ] File uploaded correctly
- [ ] No syntax errors in file

**Test:**
```php
// Add to modules/home.php temporarily
var_dump(file_exists(__DIR__ . '/../includes/homepage_service_integration.php'));
// Should output: bool(true)
```

### Issue: Orders show 0 but there are orders

**Check:**
```sql
-- Check service names match exactly
SELECT DISTINCT service_name FROM si_orders;
SELECT name FROM si_services WHERE show_on_homepage = 1;
```
- [ ] Names must match exactly (case-sensitive)

**Fix:**
```sql
-- Update orders to match service name
UPDATE si_orders 
SET service_name = 'Instagram Followers' 
WHERE service_type = 'instagram' AND service_name LIKE '%follower%';
```

---

## Performance Check

### Page Load Time
- [ ] Homepage loads in < 3 seconds
- [ ] No database timeout errors

### Database Performance
```sql
-- Check query execution time
EXPLAIN SELECT * FROM si_services WHERE show_on_homepage = 1 ORDER BY homepage_order;
```
- [ ] Uses index `idx_homepage_display`
- [ ] No full table scan

---

## Documentation Check

- [ ] Read `docs/HOMEPAGE_SERVICES_INTEGRATION.md`
- [ ] Understand how to add new services
- [ ] Know where to find troubleshooting info
- [ ] Bookmark this checklist for future updates

---

## Final Verification

### All Green?

- [ ] Database migration successful
- [ ] All new columns exist
- [ ] Homepage loads without errors
- [ ] Services display correctly
- [ ] Features show properly
- [ ] Order counts work
- [ ] Links functional
- [ ] No PHP errors in logs

### If All Checked:

🎉 **Installation Complete!** 🎉

Your homepage is now powered by the database with real-time order statistics!

---

## Post-Installation

### Optional: Configure More Services

See `docs/HOMEPAGE_SERVICES_INTEGRATION.md` for:
- Adding new services
- Updating existing services
- Managing display order
- Customizing badges

### Optional: Enable Caching

For high-traffic sites, consider adding APCu caching.
See documentation for implementation.

---

## Support

If issues persist:

1. Review `docs/HOMEPAGE_SERVICES_INTEGRATION.md`
2. Check `database/migrations/README.md`
3. Inspect PHP error logs
4. Verify all files uploaded correctly
5. Test database connection

---

**Checklist Version:** 1.0  
**Last Updated:** February 10, 2026
