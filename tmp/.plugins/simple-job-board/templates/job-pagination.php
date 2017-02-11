<?php
/**
 * Pagination - Show numbered pagination for jobs.
 *
 * @author 	PressTigers
 * @package 	simple-job-board/templates
 * @version     1.0.0
 * @since       2.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $wp_query, $wp_rewrite;
$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

$pagination = apply_filters(
    'sjb_pagination_links_default_args',
    array(
        'base'      => @add_query_arg('page', '%#%'),
        'format'    => '',
        'total'     => $wp_query->max_num_pages,
        'current'   => $current,
        'show_all'  => TRUE,
        'type'      => 'list',
        'next_text' => 'Next',
        'prev_text' => 'Previous'
    )
);

if (!(isset($_GET['selected_category']) || isset($_GET['selected_jobtype']) || isset($_GET['selected_location']) || isset($_GET['search_keywords']))) {
    if ($wp_rewrite->using_permalinks())
        $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('page', get_pagenum_link(1))) . '?page=%#%/', 'paged');

    if (!empty($wp_query->query_vars['s']))
        $pagination['add_args'] = array('s' => get_query_var('s'));
}
echo paginate_links($pagination);