<?php
/**
 * The Template for displaying job details.
 *
 * Override this template by copying it to yourtheme/simple_job_board/single-jobpost.php
 *
 * @author      PressTigers
 * @package     simple-job-board/templates
 * @version     1.0.0
 * @since       2.2.0
 */
get_header('jobs');

/**
 * sjb_before_main_content hook
 *
 * @hooked sjb_job_listing_wrapper_start - 10 (outputs opening divs for the content)
 */
do_action('sjb_before_main_content');
?>

<section id="sjb-page-detail">
    <div class="container">
        <div class="sjb-row">
            <h2 id="job-title"><?php echo apply_filters('sjb_single_job_detail_page_title', get_the_title()); ?></h2>
        </div>
    </div>
</section> 

<?php
while (have_posts()) : the_post();
    get_simple_job_board_template_part('content-single', 'job-listing');
endwhile; // end of the loop. 

/**
 * sjb_after_main_content hook
 *
 * @hooked sjb_job_listing_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('sjb_after_main_content');

get_footer('jobs');
