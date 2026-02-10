</div>
<!-- WordPress Content Ends Here -->

<?php
// Try to include main site footer
$main_footer = dirname(dirname(__DIR__)) . '/footer.php';

if (file_exists($main_footer)) {
    // Include main site footer
    include $main_footer;
} else {
    // Fallback: Simple blog footer
    ?>
    <!-- Blog Fallback Footer -->
    <footer class="footer" style="background: #1e293b; color: white; padding: 3rem 0; margin-top: 4rem;">
        <div class="footer-inner" style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div>
                    <h3 style="margin-bottom: 1rem; color: white;"><?php echo socialig_site_name(); ?></h3>
                    <p style="color: #94a3b8; line-height: 1.6;">Your trusted social media growth partner since 2017.</p>
                </div>
                <div>
                    <h4 style="margin-bottom: 1rem; color: white;">Quick Links</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 0.5rem;"><a href="<?php echo socialig_base_url(); ?>" style="color: #94a3b8; text-decoration: none;">Home</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="<?php echo home_url(); ?>" style="color: #94a3b8; text-decoration: none;">Blog</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="<?php echo socialig_base_url('about'); ?>" style="color: #94a3b8; text-decoration: none;">About</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="<?php echo socialig_base_url('contact'); ?>" style="color: #94a3b8; text-decoration: none;">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="margin-bottom: 1rem; color: white;">Categories</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <?php
                        $categories = get_categories(array('number' => 5));
                        foreach ($categories as $category) {
                            echo '<li style="margin-bottom: 0.5rem;"><a href="' . get_category_link($category->term_id) . '" style="color: #94a3b8; text-decoration: none;">' . $category->name . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #334155; color: #94a3b8;">
                <p>&copy; <?php echo date('Y'); ?> <?php echo socialig_site_name(); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <?php
}
?>

<?php wp_footer(); ?>
</body>
</html>
