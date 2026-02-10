<?php get_header(); ?>

<div class="blog-container">
    <!-- Blog Header -->
    <div class="blog-header">
        <h1><?php echo get_theme_mod('blog_header_title', 'Latest Blog Posts'); ?></h1>
        <p><?php echo get_theme_mod('blog_header_description', 'Discover tips, tricks, and insights about social media growth'); ?></p>
    </div>

    <!-- Blog Grid -->
    <?php if (have_posts()) : ?>
        <div class="blog-grid">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('blog-grid', array('class' => 'blog-card-image')); ?>
                        </a>
                    <?php else : ?>
                        <div class="blog-card-image" style="display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                            📝
                        </div>
                    <?php endif; ?>

                    <div class="blog-card-content">
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) :
                        ?>
                            <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="blog-card-category">
                                <?php echo esc_html($categories[0]->name); ?>
                            </a>
                        <?php endif; ?>

                        <h2 class="blog-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <div class="blog-card-excerpt">
                            <?php the_excerpt(); ?>
                        </div>

                        <div class="blog-card-meta">
                            <div class="blog-card-author">
                                <?php echo get_avatar(get_the_author_meta('ID'), 32, '', '', array('class' => 'blog-card-avatar')); ?>
                                <span><?php the_author(); ?></span>
                            </div>
                            <div class="blog-card-date">
                                <span>📅</span>
                                <span><?php echo get_the_date(); ?></span>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <?php socialig_blog_pagination(); ?>

    <?php else : ?>
        <!-- No Posts -->
        <div style="text-align: center; padding: 4rem 2rem;">
            <h2 style="font-size: 2rem; color: #1e293b; margin-bottom: 1rem;">No Posts Found</h2>
            <p style="color: #64748b; font-size: 1.125rem;">We haven't published any posts yet. Check back soon!</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
