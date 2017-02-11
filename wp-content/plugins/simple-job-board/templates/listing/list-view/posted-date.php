<?php
/**
 * The template for displaying job posted date in list view
 *
 * Override this template by copying it to yourtheme/simple_job_board/listing/list-view/posted-date.php
 *
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/listing/list-view
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_list_view_posted_date_template" filter.
 */
ob_start();
?>

<!-- Start Job Posted Date
================================================== -->
<div class="sjb-col-md-2">
    <?php if ($job_posting_time = sjb_get_the_job_posting_time()) {
        ?>
        <div id="sjb_job-bolits">
            <i class="fa fa-calendar"></i><?php sjb_the_job_posting_time(); ?>
        </div>
    <?php } ?>
</div>
<!-- ==================================================
End Job Posted Date -->

<?php
$html = ob_get_clean();

/**
 * Modify the Job Listing -> Job Posted Date Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html   Job Posted Date HTML.                   
 */
echo apply_filters( 'sjb_list_view_posted_date_template', $html );