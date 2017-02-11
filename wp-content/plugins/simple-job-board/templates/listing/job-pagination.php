<?php
/**
 * Pagination - Show numbered pagination for jobs
 *
 * @author 	PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/listing
 * @version     1.0.0
 * @since       2.2.0
 */
if (!defined('ABSPATH')) { exit; }  // Exit if accessed directly

global $job_query, $wp_rewrite;

/**
 * Job listing pagination
 * 
 * Show pagiantion after displaying
 */
$job_query->query_vars['paged'] > 1 ? $current = $job_query->query_vars['paged'] : $current = 1;

// Pagination Arguments
$pagination_args = array(
    'base'      => @add_query_arg('page', '%#%'),
    'format'    => '?paged=%#%',
    'total'     => $job_query->max_num_pages,
    'current'   => $current,
    'show_all'  => TRUE,
    'next_text' => 'Next',
    'prev_text' => 'Previous',
    'type'      => 'list',
);

// Paginaton Base for Different Types of Pages
if (is_front_page() && ( isset($_GET['selected_category']) || isset($_GET['selected_jobtype']) || isset($_GET['selected_location']) || isset($_GET['search_keywords']) )) {

    // Paginaton Base for Home Page & Static Front Page
    $big = 999999999; // Need an unlikely integer
    if ( $wp_rewrite->using_permalinks() ) {
        $url = explode('?', get_pagenum_link($big)); // Get URL without Query String
        $pagination_args['base'] = str_replace($big, '%#%', esc_url($url[0]));
    }
} else {

    //Paginaton Base for WP Post/Page
    $pagination_args['base'] = @add_query_arg('page', '%#%');
}

/**
 * Modify query string.
 *  
 * Remove query "page" argument from permalink
 */
if (!( isset($_GET['selected_category']) || isset($_GET['selected_jobtype']) || isset($_GET['selected_location']) || isset($_GET['search_keywords']) )) {

    if ($wp_rewrite->using_permalinks())
        $pagination_args['base'] = user_trailingslashit(trailingslashit(remove_query_arg('page', get_pagenum_link(1))) . '?page=%#%/', 'paged');

    if (!empty($job_query->query_vars['s']))
        $pagination_args['add_args'] = array('s' => get_query_var('s'));
}

$pagination = apply_filters('sjb_pagination_links_default_args', $pagination_args);

// Retrieve paginated link for job posts
echo paginate_links($pagination);