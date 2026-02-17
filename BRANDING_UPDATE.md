# Branding Update Guide

This guide explains how to update your existing database to replace "Famoid" references with "Genuine Socials".

## Quick Update

Run this single command to update all testimonials and FAQs:

### On VPS (Linux):
```bash
cd /var/www/genuinsocial
mysql -u si_user -p si_socialmedia < update_branding.sql
```

### Using Docker:
```bash
cd /var/www/genuinsocial
docker-compose exec db mysql -u si_user -p si_socialmedia < update_branding.sql
```

### On Local Windows (XAMPP):
```powershell
cd d:\genuinsocial
C:\xampp\mysql\bin\mysql.exe -u si_user -p si_socialmedia < update_branding.sql
```

### Using phpMyAdmin:
1. Open phpMyAdmin
2. Select `si_socialmedia` database
3. Click "SQL" tab
4. Open `update_branding.sql` in a text editor
5. Copy the contents
6. Paste into the SQL query box
7. Click "Go"

## What Gets Updated

This script will:
- ✅ Replace "Famoid" → "Genuine Socials" in all testimonial titles
- ✅ Replace "Famoid" → "Genuine Socials" in all testimonial content
- ✅ Replace "Famoid" → "Genuine Socials" in all FAQ questions
- ✅ Replace "Famoid" → "Genuine Socials" in all FAQ answers
- ✅ Update timestamps to reflect the changes
- ✅ Show you a summary of updates
- ✅ Verify no "Famoid" mentions remain

## Case Insensitive

The script handles all variations:
- Famoid
- famoid
- FAMOID

All will be replaced with "Genuine Socials"

## Safe to Run Multiple Times

This script is safe to run multiple times. If there are no more "Famoid" references, it simply won't make any changes.

## Backup First (Recommended)

Before running the update, create a backup:

```bash
# Backup testimonials
mysqldump -u si_user -p si_socialmedia si_testimonials > testimonials_backup.sql

# Backup FAQs
mysqldump -u si_user -p si_socialmedia si_faqs > faqs_backup.sql

# Or backup entire database
mysqldump -u si_user -p si_socialmedia > full_backup_before_update.sql
```

## Verification

After running the script, you'll see output like:

```
+-------------------------+-------+
| status                  | count |
+-------------------------+-------+
| Testimonials Updated    |    15 |
+-------------------------+-------+

+-------------------------+-------+
| status                  | count |
+-------------------------+-------+
| FAQs Updated            |    30 |
+-------------------------+-------+

+----------------------------------------+-------+
| warning                                | count |
+----------------------------------------+-------+
| Remaining Famoid Mentions in Test...   |     0 |
+----------------------------------------+-------+

+----------------------------------------+-------+
| warning                                | count |
+----------------------------------------+-------+
| Remaining Famoid Mentions in FAQs      |     0 |
+----------------------------------------+-------+
```

If "Remaining" counts are 0, you're all set! ✅

## Manual Verification

You can also verify manually in the admin panel:
- Visit: http://yourdomain.com/backend/testimonials.php
- Visit: http://yourdomain.com/backend/faqs.php
- Check that all text now says "Genuine Socials" instead of "Famoid"

## Troubleshooting

### "Access Denied" Error
Make sure your database credentials in `.env` are correct.

### No Changes Made
If the script reports 0 updates, your database already uses "Genuine Socials" or doesn't have "Famoid" references.

### Need to Restore
If something goes wrong:
```bash
mysql -u si_user -p si_socialmedia < testimonials_backup.sql
mysql -u si_user -p si_socialmedia < faqs_backup.sql
```

## After Update

Don't forget to also update:
1. 🔍 Check frontend display to confirm changes
2. 🔄 Clear any caches (browser, server-side)
3. 📱 Test on mobile and desktop
4. ✉️ Update email templates if they mention the old brand
5. 📄 Review Terms of Service and Privacy Policy pages
