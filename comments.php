<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package podium
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if (post_password_required()) {
    return;
}

?>

<div id="comments" class="comments-area">

    <?php // You can start editing here -- including this comment! ?>

    <?php

    if (have_comments() && (comments_open() || get_comments_number())) {
        ?>
        <h2 class="comments-title">
            <?php
// WPCS: XSS OK.
            printf(
                esc_html(
                    _nx(
                        'One thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        get_comments_number(),
                        'comments title',
                        'podium'
                    )
                ),
                number_format_i18n(get_comments_number()),
                '<span>' . get_the_title() .
                '</span>'
            );
            ?>
        </h2>

        <?php

        if (get_comment_pages_count() > 1
            && get_option('page_comments')) { // Are there comments to navigate through? ?>
                <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                    <h2 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'podium'); ?></h2>
                    <div class="nav-links">
                        <div class="nav-previous"><?php previous_comments_link(
                            esc_html__('Older Comments', 'podium')
                        ); ?></div>
                            <div
                            class="nav-next"><?php next_comments_link(esc_html__('Newer Comments', 'podium')); ?></div>

                        </div><!-- .nav-links -->
                    </nav><!-- #comment-nav-above -->
                <?php }

    // Check for comment navigation. ?>

    <ol class="comment-list">
        <?php
        wp_list_comments([
            'style'      => 'ol',
            'short_ping' => true
        ]);
        ?>
    </ol><!-- .comment-list -->

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { ?>
        <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
            <h2 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'podium'); ?></h2>
            <div class="nav-links">
                <div class="nav-previous"><?php previous_comments_link(esc_html__('Older Comments', 'podium')); ?></div>
                <div class="nav-next"><?php next_comments_link(esc_html__('Newer Comments', 'podium')); ?></div>
            </div><!-- .nav-links -->
        </nav><!-- #comment-nav-below -->
    <?php } ?>
<?php } ?>

<?php if (!comments_open()
          && '0' != get_comments_number()
          && post_type_supports(get_post_type(), 'comments')) {
    ?>
    <p class="no-comments"><?php esc_html_e('Comments are closed.', 'podium'); ?></p>
<?php } ?>
<?php comment_form(); ?>

</div><!-- #comments -->
