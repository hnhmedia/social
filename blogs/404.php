<?php get_header(); ?>

<div class="blog-container">
    <div class="error-404">
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        <p>The page you're looking for doesn't exist or has been moved.</p>
        <a href="<?php echo home_url(); ?>" style="display: inline-block; padding: 1rem 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 10px; font-weight: 600; margin-top: 1rem;">Back to Blog Home</a>
        
        <!-- Search Form -->
        <div style="max-width: 500px; margin: 3rem auto 0;">
            <h3 style="color: #1e293b; margin-bottom: 1rem;">Try searching:</h3>
            <form role="search" method="get" class="blog-search-form" action="<?php echo home_url('/'); ?>">
                <input type="search" name="s" placeholder="Search for posts..." required>
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Recent Posts -->
        <?php
        $recent_posts = new WP_Query(array(
            'posts_per_page' => 3,
            'ignore_sticky_posts' => 1,
        ));
        
        if ($recent_posts->have_posts()) :
        ?>
            <div style="margin-top: 4rem;">
                <h3 style="color: #1e293b; margin-bottom: 2rem;">Or check out our recent posts:</h3>
                <div class="blog-grid" style="max-width: 900px; margin: 0 auto;">
                    <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <article class="blog-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('blog-grid', array('class' => 'blog-card-image')); ?>
                                </a>
                            <?php endif; ?>
                            <div class="blog-card-content">
                                <h4 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">
                                    <a href="<?php the_permalink(); ?>" style="color: #1e293b; text-decoration: none;">
                                        <?php the_title(); ?>
                                    </a>
                                </h4>
                                <p style="color: #64748b; font-size: 0.875rem;"><?php echo get_the_date(); ?></p>
                            </div>
                        </article>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
