# Database Sample Data Import Guide

This document explains how to import the sample testimonials and FAQs into your database.

## What's Included

### Testimonials (25 entries)
- Mix of Instagram, TikTok, and YouTube services
- Various customer profiles (businesses, influencers, content creators)
- All with 4-5 star ratings
- Real-looking names and email addresses
- Diverse use cases and success stories
- Featured and active flags for display control

### FAQs (30 entries)
- Comprehensive questions covering:
  - General information about the service
  - Safety and security concerns
  - Delivery and timing questions
  - Payment and guarantees
  - Service quality and features
  - Customer support
  - Order management
- Organized by categories (general, safety, delivery, guarantee, payment, quality, support, orders, services)
- Featured flags for highlighting important FAQs

## How to Import

### Method 1: Using Command Line (Recommended)

**On VPS (Linux/Ubuntu):**
```bash
# Navigate to project directory
cd /var/www/genuinsocial

# Import the sample data
mysql -u si_user -p si_socialmedia < sample_data.sql
```

**On Local Windows (PowerShell):**
```powershell
# Navigate to project directory
cd d:\genuinsocial

# If using XAMPP
C:\xampp\mysql\bin\mysql.exe -u si_user -p si_socialmedia < sample_data.sql

# If using Docker
docker-compose exec db mysql -u si_user -p si_socialmedia < sample_data.sql
```

### Method 2: Using phpMyAdmin

1. Open phpMyAdmin in your browser
2. Select the `si_socialmedia` database
3. Click on the "SQL" tab
4. Click "Choose File" or drag and drop `sample_data.sql`
5. Click "Go" to execute the import

### Method 3: Using MySQL Workbench

1. Open MySQL Workbench
2. Connect to your database server
3. Go to Server → Data Import
4. Select "Import from Self-Contained File"
5. Browse and select `sample_data.sql`
6. Select `si_socialmedia` as the target schema
7. Click "Start Import"

## Verification

After importing, verify the data was added successfully:

```sql
-- Check testimonials count
SELECT COUNT(*) FROM si_testimonials;
-- Should return 25

-- Check FAQs count
SELECT COUNT(*) FROM si_faqs;
-- Should return 30

-- View active and featured testimonials
SELECT id, name, title, rating, active, featured 
FROM si_testimonials 
WHERE active = 1 
ORDER BY featured DESC, created_at DESC;

-- View featured FAQs
SELECT id, question, category, featured 
FROM si_faqs 
WHERE active = 1 AND featured = 1 
ORDER BY sort_order;
```

## Customization

### To Add More Data
Simply edit `sample_data.sql` and add more INSERT statements following the same format.

### To Clear Existing Data First
Uncomment these lines at the top of `sample_data.sql`:
```sql
TRUNCATE TABLE `si_testimonials`;
TRUNCATE TABLE `si_faqs`;
```

**Warning:** This will delete all existing testimonials and FAQs!

### To Update Existing Data
If you want to keep your existing data and just add the new sample data, the file is already configured to use INSERT statements that will append to your existing records.

## Managing Data via Admin Panel

After importing, you can manage all testimonials and FAQs through the admin panel:

- **Testimonials:** http://yourdomain.com/backend/testimonials.php
- **FAQs:** http://yourdomain.com/backend/faqs.php

Features available in admin panel:
- ✅ Activate/deactivate items
- ⭐ Mark items as featured
- ✏️ Edit content
- 🗑️ Delete items
- 📊 Sort and organize
- 🔍 Search and filter

## Data Schema Reference

### Testimonials Table Structure
- `id` - Unique identifier
- `user_id` - Link to registered user (NULL for manual entries)
- `name` - Customer name
- `email` - Customer email
- `service_type` - Service purchased (instagram_followers, tiktok_likes, etc.)
- `rating` - Star rating (1-5)
- `title` - Testimonial headline
- `content` - Full testimonial text
- `avatar_url` - Profile picture URL
- `active` - Display status (0=hidden, 1=visible)
- `featured` - Featured status (0=normal, 1=featured)
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### FAQs Table Structure
- `id` - Unique identifier
- `question` - FAQ question
- `answer` - Detailed answer
- `category` - Category (general, safety, delivery, etc.)
- `sort_order` - Display order
- `active` - Display status (0=hidden, 1=visible)
- `featured` - Featured status (0=normal, 1=featured)
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

## Tips

1. **Start with Featured Items:** The sample data includes several items marked as `featured = 1`. These are designed to be your best testimonials and most important FAQs.

2. **Update Avatar URLs:** The sample uses placeholder avatar service (pravatar.cc). Consider replacing these with actual customer photos or using a service like:
   - https://ui-avatars.com/api/?name=John+Doe
   - https://robohash.org/
   - Or upload real customer photos

3. **Customize Content:** Feel free to edit the testimonials and FAQs to better match your brand voice and actual customer experiences.

4. **Regular Updates:** Keep your testimonials and FAQs updated based on real customer feedback and common questions you receive.

5. **A/B Testing:** Use the featured flag to test which testimonials or FAQs perform best on your homepage.

## Troubleshooting

### Error: "Duplicate entry for key 'PRIMARY'"
Solution: The IDs might conflict with existing data. Edit `sample_data.sql` and remove the `id` field from INSERT statements, or change the ID numbers to start after your current highest ID.

### Error: "Access denied"
Solution: Verify your database credentials in `.env` file match what you're using in the import command.

### Error: "Table doesn't exist"
Solution: Make sure you've imported `admin_sgmlocal.sql` first to create the table structure.

### Data not showing on frontend
Solution: 
1. Check that `active = 1` in database
2. Verify frontend integration files are in place
3. Clear any caches
4. Check for PHP errors in logs

## Next Steps

After importing:
1. ✅ Review the testimonials in admin panel
2. ✅ Activate the ones you want to display
3. ✅ Mark your best testimonials as featured
4. ✅ Review FAQs and customize answers
5. ✅ Test the frontend display
6. ✅ Add more custom testimonials over time

## Support

If you encounter any issues importing this data, check:
- Database connection in `.env` file
- MySQL/MariaDB service is running
- Database user has INSERT permissions
- File paths are correct
