<?php
if (post_password_required()) {
    return;
}
?>

<div class="comments-area" id="comments">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf('1 Comment');
            } else {
                printf('%1$s Comments', number_format_i18n($comment_count));
            }
            ?>
        </h3>

        <ul class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ul',
                'short_ping' => true,
                'avatar_size' => 48,
            ));
            ?>
        </ul>

        <?php
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        ?>
            <nav class="comment-navigation">
                <div class="nav-previous"><?php previous_comments_link('← Older Comments'); ?></div>
                <div class="nav-next"><?php next_comments_link('Newer Comments →'); ?></div>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p style="color: #94a3b8; text-align: center; padding: 2rem;">Comments are closed.</p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply' => 'Leave a Comment',
        'comment_field' => '<p class="comment-form-comment"><label for="comment">Comment</label><textarea id="comment" name="comment" cols="45" rows="8" required style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 10px; font-family: inherit; font-size: 1rem; resize: vertical;"></textarea></p>',
        'fields' => array(
            'author' => '<p class="comment-form-author"><label for="author">Name *</label><input id="author" name="author" type="text" required style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;"></p>',
            'email' => '<p class="comment-form-email"><label for="email">Email *</label><input id="email" name="email" type="email" required style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;"></p>',
            'url' => '<p class="comment-form-url"><label for="url">Website</label><input id="url" name="url" type="url" style="width: 100%; padding: 1rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;"></p>',
        ),
        'submit_button' => '<button type="submit" class="submit" style="padding: 1rem 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 1rem;">Post Comment</button>',
        'class_submit' => 'btn btn-primary',
    ));
    ?>
</div>
