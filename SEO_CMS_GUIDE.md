# SEO CMS Manager - Setup & User Guide

## 🎉 What's Been Created

A complete SEO Content Management System has been built for your non-technical SEO specialist! Here's what you now have:

### ✅ Backend Features (Admin Panel)
1. **Page SEO Editor** - Manage meta tags, OG tags, and content for all pages
2. **Blog Post Manager** - Full blog CMS with WYSIWYG editor
3. **Technical SEO Tools** - robots.txt editor, sitemap generator, 301 redirects
4. **Global Settings** - Analytics codes, social profiles, site-wide SEO settings

### ✅ Database Tables Created
- `si_seo_pages` - SEO metadata for each page
- `si_page_content` - Editable content blocks (for future use)
- `si_blog_posts` - Complete blog posts with SEO fields
- `si_redirects` - 301/302 redirect management
- `si_seo_settings` - Global SEO settings

### ✅ Frontend Integration
- Automatic meta tags injection
- Open Graph and Twitter Card support
- Structured data (Schema.org JSON-LD)
- Analytics integration (Google Analytics, GTM, Facebook Pixel)
- Automatic redirect handling
- Canonical URLs
- Custom head/footer scripts support

---

## 📥 Installation Steps

### Step 1: Import Database Schema
```bash
# In your MySQL database, run:
mysql -u your_username -p your_database < backend/sql/seo_tables.sql
```

Or import via phpMyAdmin:
1. Go to phpMyAdmin
2. Select your database (`genuinsocial`)
3. Click "Import" tab
4. Choose file: `backend/sql/seo_tables.sql`
5. Click "Go"

### Step 2: Verify File Permissions
Make sure these files are writable by PHP:
```bash
chmod 644 robots.txt
chmod 644 sitemap.xml
```

If they don't exist, they'll be created automatically when you generate them from the backend.

### Step 3: Access the SEO Manager
1. Login to your admin panel: `https://yoursite.com/backend/`
2. Look for the "🔍 SEO MANAGER" section in the left sidebar
3. You'll see 4 new menu items:
   - 📄 Page SEO
   - 📝 Blog Posts
   - ⚙️ Technical SEO
   - 🌐 Global Settings

---

## 🎯 How to Use Each Section

### 1. Page SEO (📄 Page SEO)

**What it does:** Manage SEO metadata for every page on your site.

**How to use:**
1. Click on any page card to edit
2. Fill in these SEO fields:
   - **SEO Title** (50-60 characters optimal)
   - **Meta Description** (120-155 characters optimal)
   - **H1 Heading** - Main page title
   - **Canonical URL** - Preferred URL for this page
   - **Robots** - Control search engine indexing
   - **Open Graph** tags - For Facebook/LinkedIn sharing
   - **Twitter Card** tags - For Twitter/X sharing
   - **Custom Head Code** - Advanced: Add custom HTML for this page

3. **Live Preview** - See how your page will look in Google search and social media
4. Click "Save Changes"

**Adding a new page:**
- Click "➕ Add New Page"
- Enter the page URL slug (e.g., `about`, `contact`, `services/new-service`)
- Fill in all SEO fields
- Save

---

### 2. Blog Post Manager (📝 Blog Posts)

**What it does:** Create and manage blog posts with full SEO controls.

**How to use:**

**Creating a new post:**
1. Click "➕ Create New Blog Post"
2. Fill in:
   - **Title** - Auto-generates URL slug
   - **URL Slug** - Customize if needed
   - **Excerpt** - Short summary (shows in listings)
   - **Content** - Use the WYSIWYG editor to format content
     - Bold, italic, headings
     - Bullet lists, numbered lists
     - Insert links and images
   - **Featured Image** - Add image URL and alt text
   - **Category** - Organize posts
   - **Tags** - Comma-separated (e.g., `instagram, growth, tips`)

3. **SEO Section:**
   - Meta Title & Description
   - Social Share Title & Description
   - Social Share Image
   - Canonical URL

4. **Publishing:**
   - **Draft** - Save for later
   - **Published** - Live immediately
   - **Scheduled** - Set publish date/time

5. Click "💾 Save Post"

**Editing posts:**
- Click "✏️ Edit" on any post card
- Make changes
- Save

**Filtering posts:**
- Use the filters at the top to find posts by status, category, or search term

---

### 3. Technical SEO Tools (⚙️ Technical SEO)

**What it does:** Manage technical SEO elements like robots.txt, sitemap, and redirects.

#### 🤖 robots.txt Editor
- Edit what search engines can and cannot crawl
- Common examples provided
- Click "💾 Save robots.txt" to update

**Example robots.txt:**
```
User-agent: *
Allow: /

Disallow: /admin/
Disallow: /backend/

Sitemap: https://genuinesocials.com/sitemap.xml
```

#### 🗺️ XML Sitemap Generator
- Click "🔄 Generate Sitemap" to create/update your sitemap
- Includes all pages, services, and published blog posts
- Automatically formats for search engines

**After generating:**
1. Submit to [Google Search Console](https://search.google.com/search-console)
2. Submit to [Bing Webmaster Tools](https://www.bing.com/webmasters)
3. Add sitemap URL to robots.txt (done automatically)

#### 🔀 301 Redirects Manager
**What it does:** Redirect old URLs to new ones (preserves SEO value).

**When to use:**
- You've changed a page URL
- You've deleted a page but want to redirect visitors
- You're restructuring your site

**How to add a redirect:**
1. Click "➕ Add Redirect"
2. Enter:
   - **Old URL** - The old page path (without leading slash)
     - Example: `blog/old-post-name`
   - **New URL** - Where to redirect
     - Example: `blog/new-post-name`
   - **Type:**
     - **301 (Permanent)** - Use for permanent moves (recommended for SEO)
     - **302 (Temporary)** - Use for temporary changes
   - **Status:**
     - **Active** - Redirect is live
     - **Inactive** - Disabled

3. Click "💾 Save Redirect"

**Monitoring:**
- "Hits" column shows how many times each redirect has been used

---

### 4. Global Settings (🌐 Global Settings)

**What it does:** Manage site-wide SEO settings, analytics, and tracking codes.

#### 📊 Analytics & Tracking

**Google Analytics:**
- Enter your GA4 ID: `G-XXXXXXXXXX`
- Or Universal Analytics: `UA-XXXXXXXXX-X`
- Find this in Google Analytics → Admin → Property Settings

**Google Tag Manager:**
- Enter your GTM ID: `GTM-XXXXXXX`
- Find this in Google Tag Manager → Container ID

**Facebook Pixel:**
- Enter your Pixel ID: `1234567890123456`
- Find this in Facebook Business Manager → Events Manager

#### 🔗 Social Media Profiles
Add full URLs to your social profiles:
- Facebook Page
- Instagram Profile
- Twitter/X Handle
- LinkedIn Company
- TikTok Profile

**Why?** These are used in structured data and may appear in search results.

#### 🖼️ Default SEO Settings

**Default Social Share Image:**
- Upload an image to your server
- Enter the full URL: `https://genuinesocials.com/images/og-image.jpg`
- **Recommended size:** 1200 x 630 pixels
- This is used when a specific page doesn't have a custom image

#### ⚙️ Technical SEO Settings

**Google Site Verification:**
- Verify your site with Google Search Console
- Enter the verification code (just the code, not the full meta tag)
- Example: `google1234567890abcdef`

**Custom Scripts (Header):**
- Add any tracking codes that need to be in `<head>`
- Examples: Hotjar, Clarity, custom analytics

**Custom Scripts (Footer):**
- Add scripts that should load at the end
- Examples: Chat widgets, additional tracking

**⚠️ Save all settings** when done - click "💾 Save All Settings" at the bottom

---

## 🚀 Quick Start Checklist

### For Your SEO Person:

1. ✅ **Setup Analytics** (Global Settings)
   - Add Google Analytics ID
   - Add Facebook Pixel ID
   - Add social media profiles

2. ✅ **Configure Homepage SEO** (Page SEO)
   - Edit the "home" page
   - Optimize title and description
   - Add Open Graph image
   - Verify H1 heading

3. ✅ **Setup Important Pages** (Page SEO)
   - Contact page
   - About page
   - Privacy Policy
   - Terms of Service

4. ✅ **Generate Sitemap** (Technical SEO)
   - Click "Generate Sitemap"
   - Submit to Google Search Console

5. ✅ **Update robots.txt** (Technical SEO)
   - Add your sitemap URL
   - Block any private folders

6. ✅ **Create First Blog Post** (Blog Posts)
   - Practice with a test post
   - Use the WYSIWYG editor
   - Add SEO metadata
   - Publish when ready

---

## 🎨 SEO Best Practices

### Title Tags
- **Length:** 50-60 characters
- Include primary keyword
- Include brand name at the end
- Make it compelling and clickable

**Good Example:**
```
Buy Real Instagram Followers | Genuine Socials
```

**Bad Example:**
```
Home | Genuine Socials | Instagram | TikTok | Social Media | Marketing | Buy Followers
```

### Meta Descriptions
- **Length:** 120-155 characters
- Include primary keyword naturally
- Write for humans, not search engines
- Include a call-to-action

**Good Example:**
```
Get real Instagram followers through ad-backed delivery. Trusted since 2017. 24/7 support. Try Genuine Socials today!
```

### H1 Headings
- Only ONE H1 per page
- Should be descriptive and include main keyword
- Different from title tag (but related)

### Open Graph Images
- **Size:** 1200 x 630 pixels
- **Format:** JPG or PNG
- Include branding
- Looks good when cropped (mobile vs desktop)

### Blog Post SEO
- Use descriptive URLs (`/blog/how-to-grow-instagram` not `/blog/post-123`)
- Break content into sections with H2/H3 headings
- Add images with alt text
- Internal link to other relevant posts
- Include a clear call-to-action

---

## 🔧 Troubleshooting

### "Meta tags not showing up on frontend"
1. Check that the page slug in SEO Manager matches your actual page URL
2. Clear browser cache (Ctrl+Shift+R)
3. Check page source (Right-click → View Page Source)
4. Look for `<!-- SEO Meta Tags -->` comment

### "Sitemap not generating"
1. Check file permissions: `chmod 644 sitemap.xml`
2. Check if database tables exist
3. Check error logs in your hosting control panel

### "Redirects not working"
1. Make sure redirect handler is included in `index.php`
2. Check .htaccess is enabled
3. Check redirect status is "Active" in admin
4. Clear browser cache

### "Analytics not tracking"
1. Verify IDs are correct (no extra spaces)
2. Check browser console for errors (F12 → Console)
3. Use browser extensions to verify:
   - Google Tag Assistant (for GA)
   - Facebook Pixel Helper (for FB Pixel)

---

## 📞 Support & Questions

### For Your SEO Person:
- All changes are saved in real-time
- No need to wait for "approval" - publish directly
- Use the preview feature before publishing
- Changes take effect immediately on the live site

### Advanced Features (Future):
- **Content Blocks** - Editable page sections (table ready, just needs UI)
- **A/B Testing** - Test different titles/descriptions
- **SEO Audit** - Automatic checks for issues
- **Performance Monitoring** - Track page speed scores

---

## 🎯 What Your SEO Person Can Do Now:

### ✅ Full Control Over:
- All page titles and meta descriptions
- Social media sharing appearance (OG tags)
- Blog content creation and editing
- URL structure and redirects
- Analytics and tracking codes
- robots.txt and sitemap
- Global SEO settings

### ✅ Live Preview:
- See exactly how pages will look in:
  - Google search results
  - Facebook shares
  - Twitter/X cards

### ✅ No Technical Knowledge Needed:
- Simple, visual interface
- Character counters with recommendations
- Helpful tips and examples throughout
- Safe to use - won't break the site

---

## 📊 Recommended Workflow

### Daily:
- Check analytics dashboard
- Monitor blog post performance
- Respond to any tracking issues

### Weekly:
- Create 1-2 new blog posts
- Update underperforming page titles/descriptions
- Check for 404 errors and add redirects

### Monthly:
- Regenerate sitemap
- Review and update meta descriptions
- Check analytics for trending topics
- Update seasonal content

---

## 🎉 You're All Set!

Your SEO specialist now has everything they need to:
- Optimize every page for search engines
- Create engaging blog content
- Manage technical SEO elements
- Track performance with analytics
- Make data-driven improvements

**No coding required!** 🚀

---

## Quick Reference

### Access URLs:
- **SEO Manager:** `https://yoursite.com/backend/seo_pages.php`
- **Blog Manager:** `https://yoursite.com/backend/seo_blog.php`
- **Technical SEO:** `https://yoursite.com/backend/seo_technical.php`
- **Global Settings:** `https://yoursite.com/backend/seo_settings.php`

### Important Files:
- **Database Schema:** `backend/sql/seo_tables.sql`
- **SEO Helper:** `includes/SEOHelper.php`
- **Redirect Handler:** `includes/redirect_handler.php`

### Key Features:
✅ Meta Tags Management
✅ Open Graph & Twitter Cards
✅ Structured Data (Schema.org)
✅ Blog CMS with WYSIWYG Editor
✅ 301 Redirects Manager
✅ Sitemap Generator
✅ robots.txt Editor
✅ Analytics Integration
✅ Live Preview
✅ Mobile Responsive

---

**Questions or need help?** Everything is documented in the interface with helpful tooltips and examples!
