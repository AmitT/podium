<?php
/**
 *
 * @package podium
 */

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
    <?php
    }
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
    $html = str_replace('?feature=oembed', '?feature=oembed&html5=1&theme=light&color=white&autohide=2&modestbranding=1&showinfo=0&rel=0&iv_load_policy=3&cc_load_policy=1', $html);

// Add wrapper div with Foundation class
    // http://foundation.zurb.com/sites/docs/flex-video.html
    return '<div class="responsive-embed widescreen">' . $html . '</div>';
}

/**
 * @param  $svg_file
 * @return string
 */
function svg_get_contents($svg_file)
{
// Check if file exists
    if ($svg_file) {
        // Set user-agent
        ini_set('user_agent', 'Mozilla/5.0 (X11; OrcamServer; Linux x86_64; rv:50.0) Gecko/20100101 Firefox/50.0');
        // Get SVG contents

        $arrContextOptions = [
            'ssl'  => [
                'verify_peer'      => false,
                'verify_peer_name' => false
            ],
            'http' => [
                'header' => 'Authorization: Basic ' . base64_encode('OrCam:testingWebsite') // Auth for testing website
            ]
        ];

        $svg_file = file_get_contents($svg_file, false, stream_context_create($arrContextOptions));
        // Clean unnecessary meta and info
        $find_string  = '<svg';
        $position     = strpos($svg_file, $find_string);
        $svg_file_new = substr($svg_file, $position);
        // Restore user agent
        ini_restore('user_agent');
        return $svg_file_new;
    }

    return 'The file does not exist';
}
