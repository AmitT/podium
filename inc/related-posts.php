<?php

// Related Posts Function, matches posts by tags - call using podium_related_posts(); )
function podium_related_posts()
{
    global $post;
    $tags = wp_get_post_tags($post->ID);

    if ($tags) {

        foreach ($tags as $tag) {
            $tag_arr .= $tag->slug . ',';
        }

        $args = [
            'tag'         => $tag_arr,
            'numberposts' => 3, /* you can change this to show more */
            'post__not_in' => [$post->ID]
        ];
        $related_posts = get_posts($args);

        if ($related_posts) {

            echo '<h4>Related Posts</h4>';
            echo '<ul id="podium-related-posts">';

            foreach ($related_posts as $post) {
                setup_postdata($post);
                ?>
                <li class="related_post">
                    <a href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    <?php get_template_part('parts/content', 'byline'); ?>
                </li>
                <?php

            }

        }

    }

    wp_reset_postdata();
    echo '</ul>';
}

/* end podium related posts function */
?>
