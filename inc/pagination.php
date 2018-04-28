<?php

function podium_pagination()
{
    global $wp_query;

    $next_arrow = is_rtl() ? '<i title="Next Posts" class="fas fa-chevron-left"></i>' : '<i title="Next Posts" class="fas fa-chevron-right"></i>';
    $prev_arrow = is_rtl() ? '<i title="Previous Posts" class="fas fa-chevron-right"></i>' : '<i title="Previous Posts"  class="fas fa-chevron-left"></i>';

    $total      = $wp_query->max_num_pages;

    $big = 999999999; // This neeFds to be an unlikely integer

    // For more options and info view the docs for paginate_links()
    // http://codex.wordpress.org/Function_Reference/paginate_links
    $paginate_links = paginate_links([
        'base'        => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'current'     => max(1, get_query_var('paged')),
        'total'       => $total,
        'show_all'    => false,
        'prev_text'   => $prev_arrow,
        'next_text'   => $next_arrow,
        'type' => 'list'
    ]);

    // Display the pagination if more than one page is found
    if ($paginate_links) {
        echo '<div class="pagination">';
        echo $paginate_links;
        echo '</div>';
    }
}
