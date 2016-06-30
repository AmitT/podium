<?php
/**
*
* @package podium
*/

/**************************************************************/
/**************** New wordpress gallery Output ***************************/
/**************************************************************/

add_filter('post_gallery', 'my_post_gallery', 10, 2);
function my_post_gallery($output, $attr) {
  global $post;

  if (isset($attr['orderby'])) {
    $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
    if (!$attr['orderby'])
    unset($attr['orderby']);
  }

  extract(shortcode_atts(array(
    'order' => 'ASC',
    'orderby' => 'menu_order ID',
    'id' => $post->ID,
    'itemtag' => 'dl',
    'icontag' => 'dt',
    'captiontag' => 'dd',
    'columns' => 3,
    'size' => 'thumbnail',
    'include' => '',
    'exclude' => ''
  ), $attr));

  $id = intval($id);
  if ('RAND' == $order) $orderby = 'none';

  if (!empty($include)) {
    $include = preg_replace('/[^0-9,]+/', '', $include);
    $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

    $attachments = array();
    foreach ($_attachments as $key => $val) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  }

  if (empty($attachments)) return '';

  // Here's your actual output, you may customize it to your need
  $output = '<div class="row small-up-1 medium-up-2 large-up-3 wp-gallery m-40 mb-40">';
  $i =0;

  // Now you loop through each attachment
  foreach ($attachments as $id => $attachment) {
    $img = wp_prepare_attachment_for_js($id);

    $thumb_url = $img['sizes']['thumbnail']['url'];
    $url = $img['sizes']['full']['url'];
    $alt = $img['alt'];

    $i++;

    $output .= "<div class=\"column end\">\n";
    // $output .= "<img src=\"{$img[0]}\" width=\"{$img[1]}\" height=\"{$img[2]}\" alt=\"\" />\n";
    $output .= '<a data-open="Modal'.$post->ID. $i.'" class="thumbnail-wrap">';
      $output .= '<noscript><img class="thumbnail" src="'. $thumb_url .'"  alt="'. $alt.'" title="'. $alt.'" /></noscript>';
    $output .= '</a>';
    $output .= "</div>\n";
    ?>

    <div class="reveal" id="Modal<?php echo $post->ID. $i; ?>" aria-labelledby="ModalHeader" data-reveal>
      <noscript><img src="<?php echo $url; ?>" alt="<?php echo $alt; ?>" /></noscript>
      <button class="close-button" data-close aria-label="Close Modal" type="button">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php
  }

  $output .= "</div>\n";


  return $output;
}
