<?php

// Comment Layout
/**
 * @param $comment
 * @param $args
 * @param $depth
 */
function podium_comments($comment, $args, $depth)
{

    $GLOBALS['comment'] = $comment; ?>
  <li <?php comment_class('panel'); ?>>
    <article id="comment-<?php comment_ID(); ?>" class="clearfix large-12 columns">
      <header class="comment-author">
        <?php

    // create variable
    // $bgauthemail = get_comment_author_email();
    ?>
        <?php printf(__('<cite class="fn">%s</cite>', 'podium'), get_comment_author_link()); ?> on
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>"><?php comment_time(__(' F jS, Y - g:ia', 'podium')); ?> </a></time>
        <?php edit_comment_link(__('(Edit)', 'podium'), '  ', ''); ?>
      </header>
      <?php

    if ('0' == $comment->comment_approved) {?>
        <div class="alert alert-info">
          <p><?php _e('Your comment is awaiting moderation.', 'podium')?></p>
        </div>
        <?php }

    ?>
        <section class="comment_content clearfix">
          <?php comment_text()?>
        </section>
        <?php comment_reply_link(array_merge($args, ['depth' => $depth, 'max_depth' => $args['max_depth']])); ?>
      </article>

      <!-- </li> is added by WordPress automatically -->
      <?php

}
