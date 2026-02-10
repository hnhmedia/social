<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <div class="single-post-container">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="single-post-header">
                <h1 class="single-post-title"><?php the_title(); ?></h1>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('blog-featured', array('class' => 'single-post-featured-image')); ?>
            <?php endif; ?>

            <div class="single-post-content">
                <?php the_content(); ?>
            </div>
        </article>

        <?php
        if (comments_open() || get_comments_number()) {
            comments_template();
        }
        ?>
    </div>
<?php endwhile(); ?>

<?php get_footer(); ?>
