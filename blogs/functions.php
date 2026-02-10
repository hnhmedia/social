<?php
/**
 * SocialIG Blog Theme Functions
 * Integrates WordPress blog with main SocialIG site
 */

// ============================================
// THEME SETUP
// ============================================

function socialig_blog_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    
    // Set thumbnail sizes
    set_post_thumbnail_size(800, 450, true);
    add_image_size('blog-grid', 400, 240, true);
    add_image_size('blog-featured', 1200, 600, true);
    
    // Register navigation menus
    register_nav_menus(array(
        'blog-menu' => __('Blog Menu', 'socialig-blog'),
        'footer-menu' => __('Footer Menu', 'socialig-blog'),
    ));
}
add_action('after_setup_theme', 'socialig_blog_setup');

// ============================================
// ENQUEUE STYLES & SCRIPTS
// ============================================

function socialig_blog_scripts() {
    // Main theme stylesheet
    wp_enqueue_style('socialig-blog-style', get_stylesheet_uri(), array(), '1.0');
    
    // Parent site styles (from main SocialIG site)
    // Uncomment these if you want to use parent site styles
    // wp_enqueue_style('parent-style', '../css/style.css');
    // wp_enqueue_style('parent-service-style', '../css/service-pages.css');
    
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', array(), null);
    
    // Comments script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'socialig_blog_scripts');

// ============================================
// SIDEBAR & WIDGETS
// ============================================

function socialig_blog_widgets_init() {
    register_sidebar(array(
        'name' => __('Blog Sidebar', 'socialig-blog'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'socialig-blog'),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="sidebar-widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'socialig_blog_widgets_init');

// ============================================
// EXCERPT LENGTH
// ============================================

function socialig_blog_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'socialig_blog_excerpt_length');

function socialig_blog_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'socialig_blog_excerpt_more');

// ============================================
// PAGINATION
// ============================================

function socialig_blog_pagination() {
    global $wp_query;
    
    if ($wp_query->max_num_pages <= 1) {
        return;
    }
    
    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);
    
    if ($paged >= 1) {
        $links[] = $paged;
    }
    
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
    
    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
    
    echo '<div class="blog-pagination">';
    
    if (get_previous_posts_link()) {
        printf('<a href="%s">← Previous</a>', get_previous_posts_page_link());
    }
    
    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' current' : '';
        printf('<a href="%s" class="%s">%s</a>', esc_url(get_pagenum_link(1)), $class, '1');
        
        if (!in_array(2, $links)) {
            echo '<span>...</span>';
        }
    }
    
    sort($links);
    foreach ((array) $links as $link) {
        $class = $paged == $link ? ' current' : '';
        printf('<a href="%s" class="%s">%s</a>', esc_url(get_pagenum_link($link)), $class, $link);
    }
    
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links)) {
            echo '<span>...</span>';
        }
        
        $class = $paged == $max ? ' current' : '';
        printf('<a href="%s" class="%s">%s</a>', esc_url(get_pagenum_link($max)), $class, $max);
    }
    
    if (get_next_posts_link()) {
        printf('<a href="%s">Next →</a>', get_next_posts_page_link());
    }
    
    echo '</div>';
}

// ============================================
// GET MAIN SITE CONFIG
// ============================================

function socialig_get_config() {
    // Path to main site config
    $config_path = dirname(dirname(__DIR__)) . '/config/database.php';
    
    if (file_exists($config_path)) {
        $config = include($config_path);
        return $config;
    }
    
    // Default fallback config
    return array(
        'site' => array(
            'base_url' => '/sgi',
            'site_name' => 'SocialIG',
            'support_email' => 'support@socialig.com',
        )
    );
}

// ============================================
// HELPER FUNCTIONS
// ============================================

// Get site name from main site config
function socialig_site_name() {
    $config = socialig_get_config();
    return $config['site']['site_name'] ?? 'SocialIG';
}

// Get base URL from main site config
function socialig_base_url($path = '') {
    $config = socialig_get_config();
    $base_url = $config['site']['base_url'] ?? '/sgi';
    
    if ($path) {
        return $base_url . '/' . ltrim($path, '/');
    }
    
    return $base_url;
}

// Get reading time for post
function socialig_reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    
    return $reading_time . ' min read';
}

// Get post views (requires post meta)
function socialig_get_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return 0;
    }
    
    return $count;
}

// Set post views
function socialig_set_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

// Track post views on single post pages
function socialig_track_post_views($post_id) {
    if (!is_single()) {
        return;
    }
    
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    
    socialig_set_post_views($post_id);
}
add_action('wp_head', 'socialig_track_post_views');

// ============================================
// RELATED POSTS
// ============================================

function socialig_related_posts($post_id, $limit = 3) {
    $categories = wp_get_post_categories($post_id);
    
    if (empty($categories)) {
        return array();
    }
    
    $args = array(
        'category__in' => $categories,
        'post__not_in' => array($post_id),
        'posts_per_page' => $limit,
        'ignore_sticky_posts' => 1,
    );
    
    return new WP_Query($args);
}

// ============================================
// BREADCRUMBS
// ============================================

function socialig_breadcrumbs() {
    if (is_home() || is_front_page()) {
        return;
    }
    
    echo '<div class="breadcrumbs">';
    echo '<a href="' . home_url() . '">Home</a> <span>/</span> ';
    
    if (is_category() || is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            echo '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a> <span>/</span> ';
        }
    }
    
    if (is_single()) {
        the_title();
    } elseif (is_category()) {
        single_cat_title();
    } elseif (is_tag()) {
        single_tag_title();
    } elseif (is_author()) {
        echo 'Author: ' . get_the_author();
    } elseif (is_search()) {
        echo 'Search Results for: ' . get_search_query();
    } elseif (is_404()) {
        echo 'Page Not Found';
    }
    
    echo '</div>';
}

// ============================================
// CUSTOMIZER
// ============================================

function socialig_blog_customize_register($wp_customize) {
    // Blog Header Section
    $wp_customize->add_section('blog_header_section', array(
        'title' => __('Blog Header', 'socialig-blog'),
        'priority' => 30,
    ));
    
    // Blog Title
    $wp_customize->add_setting('blog_header_title', array(
        'default' => 'Latest Blog Posts',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('blog_header_title', array(
        'label' => __('Blog Header Title', 'socialig-blog'),
        'section' => 'blog_header_section',
        'type' => 'text',
    ));
    
    // Blog Description
    $wp_customize->add_setting('blog_header_description', array(
        'default' => 'Discover tips, tricks, and insights about social media growth',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('blog_header_description', array(
        'label' => __('Blog Header Description', 'socialig-blog'),
        'section' => 'blog_header_section',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'socialig_blog_customize_register');

// ============================================
// CUSTOM POST META
// ============================================

// Add custom meta boxes
function socialig_add_custom_meta_boxes() {
    add_meta_box(
        'socialig_post_options',
        'Post Options',
        'socialig_post_options_callback',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'socialig_add_custom_meta_boxes');

function socialig_post_options_callback($post) {
    wp_nonce_field('socialig_save_post_options', 'socialig_post_options_nonce');
    
    $featured = get_post_meta($post->ID, '_socialig_featured', true);
    $reading_time = get_post_meta($post->ID, '_socialig_reading_time', true);
    
    ?>
    <p>
        <label>
            <input type="checkbox" name="socialig_featured" value="1" <?php checked($featured, '1'); ?>>
            Featured Post
        </label>
    </p>
    <p>
        <label>Reading Time (optional):</label>
        <input type="text" name="socialig_reading_time" value="<?php echo esc_attr($reading_time); ?>" placeholder="5 min read" style="width: 100%;">
    </p>
    <?php
}

function socialig_save_post_options($post_id) {
    if (!isset($_POST['socialig_post_options_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['socialig_post_options_nonce'], 'socialig_save_post_options')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save featured status
    $featured = isset($_POST['socialig_featured']) ? '1' : '0';
    update_post_meta($post_id, '_socialig_featured', $featured);
    
    // Save reading time
    if (isset($_POST['socialig_reading_time'])) {
        update_post_meta($post_id, '_socialig_reading_time', sanitize_text_field($_POST['socialig_reading_time']));
    }
}
add_action('save_post', 'socialig_save_post_options');
