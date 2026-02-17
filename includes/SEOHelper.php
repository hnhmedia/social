<?php
/**
 * SEO Helper Functions
 * Provides SEO metadata for frontend pages
 */

class SEOHelper {
    private static $db = null;
    private static $settings_cache = [];
    private static $page_seo_cache = [];
    
    /**
     * Initialize database connection
     */
    private static function initDB() {
        if (self::$db === null) {
            require_once __DIR__ . '/Database.php';
            self::$db = Database::getConnection();
        }
        return self::$db;
    }
    
    /**
     * Get SEO settings
     */
    private static function getSettings() {
        if (empty(self::$settings_cache)) {
            $db = self::initDB();
            $result = $db->query("SELECT setting_key, setting_value FROM si_seo_settings");
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    self::$settings_cache[$row['setting_key']] = $row['setting_value'];
                }
            }
        }
        return self::$settings_cache;
    }
    
    /**
     * Get page SEO data by slug
     */
    public static function getPageSEO($slug) {
        if (!isset(self::$page_seo_cache[$slug])) {
            $db = self::initDB();
            $stmt = $db->prepare("SELECT * FROM si_seo_pages WHERE page_slug=? AND status='active' LIMIT 1");
            $stmt->bind_param("s", $slug);
            $stmt->execute();
            $result = $stmt->get_result();
            self::$page_seo_cache[$slug] = $result->fetch_assoc() ?: null;
            $stmt->close();
        }
        return self::$page_seo_cache[$slug];
    }
    
    /**
     * Get meta title for current page
     */
    public static function getMetaTitle($page_slug, $default = '') {
        $seo = self::getPageSEO($page_slug);
        return $seo['page_title'] ?? $default;
    }
    
    /**
     * Get meta description for current page
     */
    public static function getMetaDescription($page_slug, $default = '') {
        $seo = self::getPageSEO($page_slug);
        return $seo['meta_description'] ?? $default;
    }
    
    /**
     * Get H1 heading for current page
     */
    public static function getH1($page_slug, $default = '') {
        $seo = self::getPageSEO($page_slug);
        return $seo['h1_heading'] ?? $default;
    }
    
    /**
     * Get canonical URL
     */
    public static function getCanonicalURL($page_slug, $current_url) {
        $seo = self::getPageSEO($page_slug);
        return $seo['canonical_url'] ?? $current_url;
    }
    
    /**
     * Get robots directive
     */
    public static function getRobots($page_slug, $default = 'index, follow') {
        $seo = self::getPageSEO($page_slug);
        return $seo['robots'] ?? $default;
    }
    
    /**
     * Render all meta tags for a page
     */
    public static function renderMetaTags($page_slug, $defaults = []) {
        $seo = self::getPageSEO($page_slug);
        $settings = self::getSettings();
        $baseUrl = rtrim(Config::baseUrl(), '/');
        $currentURL = $baseUrl . '/' . ltrim($page_slug === 'home' ? '' : $page_slug, '/');
        
        // Meta title
        $meta_title = $seo['page_title'] ?? ($defaults['title'] ?? Config::siteName());
        
        // Meta description
        $meta_description = $seo['meta_description'] ?? ($defaults['description'] ?? '');
        
        // Canonical URL
        $canonical = $seo['canonical_url'] ?? $currentURL;
        
        // Robots
        $robots = $seo['robots'] ?? 'index, follow';
        
        // Open Graph
        $og_title = $seo['og_title'] ?? $meta_title;
        $og_description = $seo['og_description'] ?? $meta_description;
        $og_image = $seo['og_image'] ?? ($settings['default_og_image'] ?? '');
        $og_type = $seo['og_type'] ?? 'website';
        
        // Twitter Card
        $twitter_card = $seo['twitter_card'] ?? 'summary_large_image';
        $twitter_title = $seo['twitter_title'] ?? $og_title;
        $twitter_description = $seo['twitter_description'] ?? $og_description;
        $twitter_image = $seo['twitter_image'] ?? $og_image;
        
        // Output meta tags
        $output = '';
        
        // Basic SEO
        $output .= '    <meta name="description" content="' . htmlspecialchars($meta_description) . '">' . "\n";
        $output .= '    <meta name="robots" content="' . htmlspecialchars($robots) . '">' . "\n";
        $output .= '    <link rel="canonical" href="' . htmlspecialchars($canonical) . '">' . "\n";
        
        // Open Graph
        $output .= '    <meta property="og:title" content="' . htmlspecialchars($og_title) . '">' . "\n";
        $output .= '    <meta property="og:description" content="' . htmlspecialchars($og_description) . '">' . "\n";
        $output .= '    <meta property="og:url" content="' . htmlspecialchars($currentURL) . '">' . "\n";
        $output .= '    <meta property="og:type" content="' . htmlspecialchars($og_type) . '">' . "\n";
        if ($og_image) {
            $output .= '    <meta property="og:image" content="' . htmlspecialchars($og_image) . '">' . "\n";
        }
        $output .= '    <meta property="og:site_name" content="' . htmlspecialchars(Config::siteName()) . '">' . "\n";
        
        // Twitter Card
        $output .= '    <meta name="twitter:card" content="' . htmlspecialchars($twitter_card) . '">' . "\n";
        $output .= '    <meta name="twitter:title" content="' . htmlspecialchars($twitter_title) . '">' . "\n";
        $output .= '    <meta name="twitter:description" content="' . htmlspecialchars($twitter_description) . '">' . "\n";
        if ($twitter_image) {
            $output .= '    <meta name="twitter:image" content="' . htmlspecialchars($twitter_image) . '">' . "\n";
        }
        
        // Google Site Verification
        if (!empty($settings['google_site_verification'])) {
            $output .= '    <meta name="google-site-verification" content="' . htmlspecialchars($settings['google_site_verification']) . '">' . "\n";
        }
        
        // Custom head code
        if (!empty($seo['custom_head'])) {
            $output .= '    ' . $seo['custom_head'] . "\n";
        }
        
        return $output;
    }
    
    /**
     * Render analytics scripts
     */
    public static function renderAnalytics() {
        $settings = self::getSettings();
        $output = '';
        
        // Google Analytics
        if (!empty($settings['google_analytics_id'])) {
            $ga_id = $settings['google_analytics_id'];
            $output .= "\n    <!-- Google Analytics -->\n";
            $output .= "    <script async src=\"https://www.googletagmanager.com/gtag/js?id={$ga_id}\"></script>\n";
            $output .= "    <script>\n";
            $output .= "      window.dataLayer = window.dataLayer || [];\n";
            $output .= "      function gtag(){dataLayer.push(arguments);}\n";
            $output .= "      gtag('js', new Date());\n";
            $output .= "      gtag('config', '{$ga_id}');\n";
            $output .= "    </script>\n";
        }
        
        // Google Tag Manager
        if (!empty($settings['google_tag_manager_id'])) {
            $gtm_id = $settings['google_tag_manager_id'];
            $output .= "\n    <!-- Google Tag Manager -->\n";
            $output .= "    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':\n";
            $output .= "    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],\n";
            $output .= "    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=\n";
            $output .= "    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);\n";
            $output .= "    })(window,document,'script','dataLayer','{$gtm_id}');</script>\n";
        }
        
        // Facebook Pixel
        if (!empty($settings['facebook_pixel_id'])) {
            $pixel_id = $settings['facebook_pixel_id'];
            $output .= "\n    <!-- Facebook Pixel -->\n";
            $output .= "    <script>\n";
            $output .= "      !function(f,b,e,v,n,t,s)\n";
            $output .= "      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?\n";
            $output .= "      n.callMethod.apply(n,arguments):n.queue.push(arguments)};\n";
            $output .= "      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';\n";
            $output .= "      n.queue=[];t=b.createElement(e);t.async=!0;\n";
            $output .= "      t.src=v;s=b.getElementsByTagName(e)[0];\n";
            $output .= "      s.parentNode.insertBefore(t,s)}(window, document,'script',\n";
            $output .= "      'https://connect.facebook.net/en_US/fbevents.js');\n";
            $output .= "      fbq('init', '{$pixel_id}');\n";
            $output .= "      fbq('track', 'PageView');\n";
            $output .= "    </script>\n";
            $output .= "    <noscript><img height=\"1\" width=\"1\" style=\"display:none\"\n";
            $output .= "    src=\"https://www.facebook.com/tr?id={$pixel_id}&ev=PageView&noscript=1\"\n";
            $output .= "    /></noscript>\n";
        }
        
        // Custom head scripts
        if (!empty($settings['custom_head_scripts'])) {
            $output .= "\n    <!-- Custom Scripts -->\n";
            $output .= "    " . $settings['custom_head_scripts'] . "\n";
        }
        
        return $output;
    }
    
    /**
     * Render footer scripts
     */
    public static function renderFooterScripts() {
        $settings = self::getSettings();
        $output = '';
        
        // Custom footer scripts
        if (!empty($settings['custom_footer_scripts'])) {
            $output .= "\n    <!-- Custom Footer Scripts -->\n";
            $output .= "    " . $settings['custom_footer_scripts'] . "\n";
        }
        
        return $output;
    }
    
    /**
     * Render structured data (Schema.org JSON-LD)
     */
    public static function renderStructuredData($page_slug, $type = 'WebPage') {
        $settings = self::getSettings();
        $seo = self::getPageSEO($page_slug);
        $baseUrl = rtrim(Config::baseUrl(), '/');
        
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $type,
            'name' => $seo['page_title'] ?? Config::siteName(),
            'url' => $baseUrl . '/' . ($page_slug === 'home' ? '' : $page_slug),
        ];
        
        if (!empty($seo['meta_description'])) {
            $schema['description'] = $seo['meta_description'];
        }
        
        // Add Organization data for homepage
        if ($page_slug === 'home') {
            $org = [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => Config::siteName(),
                'url' => $baseUrl,
                'logo' => $baseUrl . '/images/logo.png',
                'sameAs' => array_filter([
                    $settings['facebook_url'] ?? null,
                    $settings['instagram_url'] ?? null,
                    $settings['twitter_url'] ?? null,
                    $settings['linkedin_url'] ?? null,
                    $settings['tiktok_url'] ?? null,
                ])
            ];
            
            $output = '<script type="application/ld+json">' . "\n";
            $output .= json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
            $output .= '</script>' . "\n";
            $output .= '<script type="application/ld+json">' . "\n";
            $output .= json_encode($org, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
            $output .= '</script>' . "\n";
            
            return $output;
        }
        
        $output = '<script type="application/ld+json">' . "\n";
        $output .= json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
        $output .= '</script>' . "\n";
        
        return $output;
    }
}
