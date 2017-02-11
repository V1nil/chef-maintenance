<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Simple_Job_Board_Shortcodes class.
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       1.0.0
 *
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 */

/**
 * This is used to define custom post types.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since       1.0.0
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 * @author      PressTigers <support@presstigers.com>
 */
class Simple_Job_Board_Shortcodes {

    /**
     * Constructor
     */
    public function __construct() {
        add_shortcode('jobpost', array($this, 'jobs_listing'));
        add_shortcode('job', array($this, 'output_job'));
    }

    /**
     * jobs_listing function.
     *
     * @access public
     * @param mixed $args
     * @return void
     */
    public function jobs_listing($atts) {
        ob_start();
        global $wp_query;

        // Shortcode Default Array
        $a = shortcode_atts(apply_filters('sjb_output_jobs_defaults', array(
            'posts' => '15',
            'excerpt' => 'yes',
            'category' => '',
            'type' => '',
            'location' => '',
            'keywords' => '',
            'order' => 'DESC',
            'search' => 'true',
                        ), $atts), $atts);

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        $args = apply_filters('sjb_output_jobs_args', array(
            'posts_per_page' => $a['posts'],
            'post_type' => 'jobpost',
            'jobpost_category' => $a['category'],
            'jobpost_job_type' => $a['type'],
            'jobpost_location' => $a['location'],
            'paged' => $paged,
                ), $atts);

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

        if ('false' <> $a['search'] && '' <> $a['search']):
            get_simple_job_board_template('job-filters.php', array('per_page' => $a['posts'], 'order' => $a['order'], 'categories' => $a['category'], 'job_types' => $a['type'], 'atts' => $atts, 'location' => $a['location'], 'keywords' => $a['keywords']));
        endif;

        if ($wp_query->have_posts()):
            /**
             * Add new section before job listing
             * 
             * @since 2.2.0
             */
            do_action('sjb_job_listing_before');
        
            global $counter;
            $counter = 1;
            
            while ($wp_query->have_posts()): $wp_query->the_post();
                if ('grid-view' === get_option('job_board_listing_view'))
                    get_simple_job_board_template_part('content', 'job-listing-grid-view');
                else
                    get_simple_job_board_template_part('content', 'job-listing-list-view');
            endwhile;

            /**
             * Action-> Add new section after job listing
             * 
             * @since 2.2.0
             */
            do_action('sjb_job_listing_after');

            get_simple_job_board_template('job-pagination.php');
        else:
            get_simple_job_board_template('content-no-jobs-found.php');
        endif;

        get_simple_job_board_template('job-listings-end.php');
        $html = ob_get_clean();
        wp_reset_query();
        return apply_filters('sjb_job_listing_shortcode', $html);
    }

    /**
     * output_job function.
     *
     * @access public
     * @param  array $args
     * @return string
     */
    public function output_job($atts) {
        extract(shortcode_atts(apply_filters('sjb_single_job_default_args', array(
            'id' => '',
                                ), $atts)));

        if (!$id)
            return;

        ob_start();
        $args = array(
            'post_type' => 'jobpost',
            'post_status' => 'publish',
            'p' => $id
        );
        $jobs = new WP_Query($args);

        if ($jobs->have_posts()) :
            ?>
            <?php while ($jobs->have_posts()) : $jobs->the_post(); ?>
                <h1><?php the_title(); ?></h1>
                <?php get_simple_job_board_template_part('content-single', 'job-listing'); ?>
            <?php endwhile; ?>
            <?php
        endif;

        wp_reset_postdata();
        return '<div class="job-shortcode single-job-listing">' . ob_get_clean() . '</div>';
    }

}

new Simple_Job_Board_Shortcodes();
