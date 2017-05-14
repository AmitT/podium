<?php
/**
 *
 * @package podium
 */

// Custom filter function to modify default gallery shortcode output
function podium_post_gallery($output, $attr)
{

    // Initialize
    global $post, $wp_locale;

    // Gallery instance counter
    /**
     * @var int
     */
    static $instance = 0;
    $instance++;

    // Validate the author's orderby attribute
    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby']) {
            unset($attr['orderby']);
        }

    }

    // Get attributes from shortcode
    extract(shortcode_atts([
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        // 'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ], $attr));

    $size = 'thumbnail';

    // Initialize
    $id          = intval($id);
    $attachments = [];

    if ('RAND' == $order) {
        $orderby = 'none';
    }

    if (!empty($include)) {

        // Include attribute is present
        $include      = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(['include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby]);

        // Setup attachments array
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }

    } elseif (!empty($exclude)) {

        // Exclude attribute is present
        $exclude = preg_replace('/[^0-9,]+/', '', $exclude);

        // Setup attachments array
        $attachments = get_children(['post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby]);
    } else {
        // Setup attachments array
        $attachments = get_children(['post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby]);
    }

    if (empty($attachments)) {
        return '';
    }

    // Filter gallery differently for feeds
    if (is_feed()) {
        $output = "\n";
        foreach ($attachments as $att_id => $attachment) {
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        }

        return $output;
    }

    // Filter tags and attributes
    $itemtag    = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns    = intval($columns);
    $itemwidth  = $columns > 0 ? floor(100 / $columns) : 100;
    $float      = is_rtl() ? 'right' : 'left';
    $selector   = "gallery-{$instance}";

    // Filter gallery CSS
    $output = apply_filters('gallery_style', "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }
            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;
            }
            #{$selector} img {
                border: 2px solid #cfcfcf;
            }
            #{$selector} .gallery-caption {
                margin-left: 0;
            }
        </style>
        <!-- see gallery_shortcode() in wp-includes/media.php -->
        <div id='$selector' class='row small-up-1 medium-up-{$columns} gallery galleryid-{$id}'>"
    );

    // Iterate through the attachments in this gallery instance
    $i = 0;

    foreach ($attachments as $id => $attachment) {

        // Attachment link
        $img = wp_prepare_attachment_for_js($id);
        $url = $img['sizes']['full']['url'];
        $alt = $img['alt'];

        if (isset($img['sizes'][$size]['url'])) {
            $thumb_url = $img['sizes'][$size]['url'];
        } else {
            $thumb_url = $img['url'];
        }

        // Start itemtag
        $output .= "<{$itemtag} class='column column-block gallery-item'>";

        // icontag
        $output .= "<{$icontag} class='gallery-icon'>";

        if ('none' != $attr['link']) {
            $output .= '<a data-open="Modal' . $post->ID . $id . '" class="thumbnail-wrap">';
        }

        $output .= wp_get_attachment_image($id, $size);


        if ('none' != $attr['link']) {
            $output .= '</a>';
        }

        $output .= "</{$icontag}>";

        if ($captiontag && trim($attachment->post_excerpt)) {

            // captiontag
            $output .= "
            <{$captiontag} class='gallery-caption'>
                " . wptexturize($attachment->post_excerpt) . "
            </{$captiontag}>";

        }

        // End itemtag
        $output .= "</{$itemtag}>";

        $output .= "<div class=\"reveal large\" id=\"Modal{$post->ID}{$id}\" aria-labelledby=\"ModalHeader\" data-reveal>
                      <img src=\"{$url}\" alt=\"{$alt}\" />
                      <button class=\"close-button\" data-close aria-label=\"Close Modal\" type=\"button\">
                        <span aria-hidden=\"true\">&times;</span>
                      </button>
                </div>";

        // Line breaks by columns set
        if ($columns > 0 && ++$i % $columns == 0) {
            $output .= '<br style="clear: both">';
        }

    }

    // End gallery output
    $output .= "
        <br style='clear: both;'>
    </div>\n";

    return $output;

}

// Apply filter to default gallery shortcode
add_filter('post_gallery', 'podium_post_gallery', 10, 2);


// Get featured image or placeholder
/**
 * @param $size
 */
function get_podium_featured_image($size)
{

    if (has_post_thumbnail()) {

        the_post_thumbnail($size);

    } else {

        ?>
  <img src="<?php echo get_template_directory_uri(); ?>/dist/images/placeholder.jpg" alt="placeholder image" />
  <?php }

}

// Make embeds responsive
// Modest youtube player
add_filter('embed_oembed_html', 'podium_oembed_html', 99, 4);
/**
 * @param $html
 * @param $url
 * @param $attr
 * @param $post_id
 */
function podium_oembed_html($html, $url, $attr, $post_id)
{

    // Parameters for Modest youtube player:
    $html = str_replace('?feature=oembed', '?feature=oembed&theme=light&color=white&autohide=2&modestbranding=1&showinfo=0&rel=0&iv_load_policy=3', $html);

// Add wrapper div with Foundation class
    // http://foundation.zurb.com/sites/docs/flex-video.html
    return '<div class="responsive-embed widescreen">' . $html . '</div>';
}

/**
 * @param  $svg_file
 * @return mixed
 */
function svg_get_contents($svg_file)
{

// Check if file exists
    if ($svg_file) {

        // Set user-agent
        ini_set('user_agent', 'Mozilla/5.0 (X11; WinsiteServer; Linux x86_64; rv:50.0) Gecko/20100101 Firefox/50.0');

        // Get SVG contents
        $svg_file = file_get_contents($svg_file);

        // Clean unnecessary meta and info
        $find_string = '<svg';
        $position    = strpos($svg_file, $find_string);

        $svg_file_new = substr($svg_file, $position);

        // Restore user agent
        ini_restore('user_agent');

        return $svg_file_new;

    }

    return 'The file does not exist';

}
