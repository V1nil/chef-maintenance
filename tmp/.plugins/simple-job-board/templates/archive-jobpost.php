<?php
/**
 * The Template for displaying job archives, including the main jobpost page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/simple_job_board/archive-jobpost.php
 *
 * @author      PressTigers
 * @package     simple-job-board/templates
 * @version     1.0.0
 * @since       2.2.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_header('jobs');
?>

<?php
/**
 * sjb_before_main_content hook
 * 
 * @since 2.2.0
 * 
 * @hooked sjb_job_listing_wrapper_start - 10 (outputs opening divs for the content)
 */
do_action('sjb_before_main_content');
?>

<header  id="sjb_header-detail">
    <h2 id="job-title"><?php echo apply_filters('sjb_jobs_archive_title', __('Job Archives', 'simple-job-board')); ?></h2>
</header>

<?php
if (shortcode_exists('jobpost')) {
    echo do_shortcode('[jobpost]');
} else {
    ?> 
    <?php
    global $wp_query;

    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }

    $args = apply_filters('sjb_output_jobs_args', array(
        'posts_per_page'   => $a['posts'],
        'post_type'        => 'jobpost',
        'jobpost_category' => $a['category'],
        'jobpost_job_type' => $a['type'],
        'jobpost_location' => $a['location'],
        'paged'            => $paged,
    ));

    // Merge $arg array on each $_GET element
    if (isset($_GET['selected_category']) && -1 != $_GET['selected_category'])
        $args['jobpost_category'] = sanitize_text_field($_GET['selected_category']);

    if (isset($_GET['selected_jobtype']) && -1 != $_GET['selected_jobtype'])
        $args['jobpost_job_type'] = sanitize_text_field($_GET['selected_jobtype']);

    if (isset($_GET['selected_location']) && -1 != $_GET['selected_location'])
        $args['jobpost_location'] = sanitize_text_field($_GET['selected_location']);

    if (!empty($_GET['search_keywords'])) {
        $args['s'] = sanitize_text_field($_GET['search_keywords']);
    }

    $wp_query = new WP_Query($args);
    get_simple_job_board_template('job-listings-start.php');
    get_simple_job_board_template('job-filters.php');

    if ($wp_query->have_posts()) :
        do_action('sjb_before_jobpost_loop');

        get_simple_job_board_template('content-job-listing-start.php');

        while ($wp_query->have_posts()) : $wp_query->the_post();
            if ('grid-view' === get_option('job_board_listing_view'))
                get_simple_job_board_template_part('content', 'job-listing-grid-view');
            else
                get_simple_job_board_template_part('content', 'job-listing-list-view');
        endwhile; // end of the loop. 

        get_simple_job_board_template('content-job-listing-end.php');
        get_simple_job_board_template('job-pagination.php');
        do_action('sjb_after_jobpost_loop');
    else:
        get_simple_job_board_template('content-no-jobs-found.php');
    endif;
    get_simple_job_board_template('job-listings-end.php');
    wp_reset_query();
    ?>


    <?php
}
/**
 * sjb_after_main_content hook
 * 
 * @since 2.2.0
 * 
 * @hooked sjb_job_listing_wrapper_end - 10 (outputs opening divs for the content)
 */
do_action('sjb_after_main_content');
?>

<?php get_footer('jobs'); ?>