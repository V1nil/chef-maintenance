<?php
/**
 * The template for displaying job content in list view within loops.
 *
 * Override this template by copying it to yourtheme/simple_job_board/content-job-listing-list-view.php
 *
 * @author      PressTigers
 * @package     simple-job-board/Templates
 * @version     1.0.0
 * @since       2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $post;
do_action('sjb_job_listing_list_view_before');
?>
<article id="sjb_job-visiable">
    <div class="sjb-row">
        <header class="sjb-col-md-6">
            <div class="sjb-row">
                <div id="sjb_company-logo-full-view" class="company-logo">
                    <a href="<?php the_permalink(); ?>"><?php sjb_the_company_logo(); ?></a>
                </div>
                <div id="sjb-heading">
                    <h4 id="sjb_job-heading" class="company-name">
                        <a href="<?php the_permalink(); ?>"><?php
                            the_title();

                            if (sjb_get_the_company_name()) {
                                ?>
                                | <?php
                                sjb_the_company_name();
                            }
                            ?> 
                        </a>
                    </h4>
                </div>     
            </div>
        </header>
        <div class="sjb-col-md-2">
            <?php if ( $job_type = sjb_get_the_job_type()) {
                ?>
                <div id="sjb_job-bolits">
                    <i class="fa fa-clock-o"></i><?php sjb_the_job_type(); ?>
                </div>
            <?php } ?> 
        </div>
        <div class="sjb-col-md-2">
            <?php if ( $job_location = sjb_get_the_job_location()) {
                ?>
                <div id="sjb_job-bolits">
                    <i class="fa fa-location-arrow"></i><?php sjb_the_job_location(); ?>
                </div>
            <?php } ?>
        </div>
        <div class="sjb-col-md-2">
            <?php if ( $job_posting_time = sjb_get_the_job_posting_time()) {
                ?>
                <div id="sjb_job-bolits">
                    <i class="fa fa-calendar"></i><?php sjb_the_job_posting_time(); ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="sjb-row">
        <p class="sjb-lead job-description">
            <?php echo sjb_get_the_excerpt('255', '', ''); ?>
        </p>
    </div>
</article>
<?php do_action('sjb_job_listing_list_view_after'); ?>