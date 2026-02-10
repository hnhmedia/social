<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <div class="single-post-container">
        <!-- Post Header -->
        <header class="single-post-header">
            <?php
            $categories = get_the_category();
            if (!empty($categories)) :
            ?>
                <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="single-post-category">
                    <?php echo esc_html($categories[0]->name); ?>
                </a>
            <?php endif; ?>

            <h1 class="single-post-title"><?php the_title(); ?></h1>

            <div class="single-post-meta">
                <div class="single-post-author">
                    <?php echo get_avatar(get_the_author_meta('ID'), 48, '', '', array('class' => 'single-post-avatar')); ?>
                    <div class="single-post-author-info">
                        <h4><?php the_author(); ?></h4>
                        <p><?php echo get_the_date(); ?> • <?php echo socialig_reading_time(); ?></p>
                    </div>
                </div>
                <div style="display: flex; gap: 1rem; color: #94a3b8; font-size: 0.9rem;">
                    <span>👁️ <?php echo socialig_get_post_views(get_the_ID()); ?> views</span>
                    <span>💬 <?php comments_number('0 comments', '1 comment', '% comments'); ?></span>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('blog-featured', array('class' => 'single-post-featured-image')); ?>
        <?php endif; ?>

        <!-- Post Content -->
        <div class="single-post-content">
            <?php the_content(); ?>
        </div>

        <!-- Tags -->
        <?php if (has_tag()) : ?>
            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e2e8f0;">
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                    <?php
                    $tags = get_the_tags();
                    foreach ($tags as $tag) {
                        echo '<a href="' . get_tag_link($tag->term_id) . '" style="padding: 0.5rem 1rem; background: #f1f5f9; color: #64748b; border-radius: 20px; text-decoration: none; font-size: 0.875rem; transition: all 0.2s;" onmouseover="this.style.background=\'#7c3aed\'; this.style.color=\'white\';" onmouseout="this.style.background=\'#f1f5f9\'; this.style.color=\'#64748b\';">#' . $tag->name . '</a>';
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Post Navigation -->
        <div style="display: flex; justify-content: space-between; margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #e2e8f0; gap: 2rem;">
            <div style="flex: 1;">
                <?php
                $prev_post = get_previous_post();
                if (!empty($prev_post)) :
                ?>
                    <a href="<?php echo get_permalink($prev_post->ID); ?>" style="display: block; padding: 1.5rem; background: #f8fafc; border-radius: 12px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#faf5ff';" onmouseout="this.style.background='#f8fafc';">
                        <span style="font-size: 0.875rem; color: #94a3b8; display: block; margin-bottom: 0.5rem;">← Previous Post</span>
                        <span style="font-weight: 600; color: #1e293b;"><?php echo get_the_title($prev_post->ID); ?></span>
                    </a>
                <?php endif; ?>
            </div>
            <div style="flex: 1; text-align: right;">
                <?php
                $next_post = get_next_post();
                if (!empty($next_post)) :
                ?>
                    <a href="<?php echo get_permalink($next_post->ID); ?>" style="display: block; padding: 1.5rem; background: #f8fafc; border-radius: 12px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#faf5ff';" onmouseout="this.style.background='#f8fafc';">
                        <span style="font-size: 0.875rem; color: #94a3b8; display: block; margin-bottom: 0.5rem;">Next Post →</span>
                        <span style="font-weight: 600; color: #1e293b;"><?php echo get_the_title($next_post->ID); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Related Posts -->
        <?php
        $related_posts = socialig_related_posts(get_the_ID(), 3);
        if ($related_posts->have_posts()) :
        ?>
            <div class="related-posts">
                <h3>Related Posts</h3>
                <div class="related-posts-grid">
                    <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                        <article class="blog-card" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('blog-grid', array('class' => 'blog-card-image')); ?>
                                </a>
                            <?php endif; ?>
                            <div class="blog-card-content">
                                <h4 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">
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

        <!-- Comments -->
        <?php
        if (comments_open() || get_comments_number()) {
            comments_template();
        }
        ?>
    </div>
<?php endwhile; ?>

<?php get_footer(); ?>
