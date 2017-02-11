<?php
/**
 * Single view Job Meta Box
 *
 * Override this template by copying it to yourtheme/simple_job_board/single-jobpost/content-single-job-listing-meta.php
 * 
 * Hooked into single_job_listing_start priority 20
 * 
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/Templates
 * @version     1.1.0
 * @since       2.1.0
 * @since       2.3.0   Added "sjb_job_meta_template" filter.
 */
ob_start();
global $post;

/**
 * Fires on job detail page before comapny meta  
 *                   
 * @since   2.1.0                   
 */
do_action('single_job_listing_meta_before');
?>

<!-- Start Company Meta
================================================== -->
<article class="sjb-row">    
    <header class="sjb-col-md-6">
        <div class="sjb-row">            
            <?php
            /**
             * Template -> Company Logo:
             * 
             * - Display Company Logo.
             */
            get_simple_job_board_template('single-jobpost/job-meta/company-logo.php');
            ?>

            <!-- Job Title & Company Name -->
            <div id="sjb-heading">
                <h4 id="sjb-job-heading">
                    <?php
                    /**
                     * Template -> Job Title:
                     * 
                     * - Display Job Title.
                     */
                    get_simple_job_board_template('single-jobpost/job-meta/job-title.php');

                    /**
                     * Template -> Company Name:
                     * 
                     * - Display Company Name.
                     */
                    get_simple_job_board_template('single-jobpost/job-meta/company-name.php');
                    ?>
                </h4>
            </div>
        </div>        
        <?php
        /**
         * Template -> Company Tagline:
         * 
         * - Display Company Tagline.
         */
        get_simple_job_board_template('single-jobpost/job-meta/company-tagline.php');
        ?>
    </header>
    <?php
    /**
     * Template -> Job Type:
     * 
     * - Display Job Type.
     */
    get_simple_job_board_template('single-jobpost/job-meta/job-type.php');
    
    /**
     * Template -> Job Location:
     * 
     * - Display Job Location.
     */
    get_simple_job_board_template('single-jobpost/job-meta/job-location.php');
    
    /**
     * Template -> Job Posted Date:
     * 
     * - Display Job Posted Date.
     */
    get_simple_job_board_template('single-jobpost/job-meta/job-posted-date.php'); ?>
</article>
<!-- ==================================================
End Company Meta -->

<?php
/**
 * Fires on job detail page after comapny meta  
 *                   
 * @since   2.1.0                   
 */
do_action('single_job_listing_meta_after');

$html_job_meta = ob_get_clean();

/**
 * Modify the Job Meta Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html_job_meta   Job Meta HTML.                   
 */
echo apply_filters( 'sjb_job_meta_template', $html_job_meta );