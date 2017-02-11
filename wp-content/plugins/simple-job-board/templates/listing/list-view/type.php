<?php
/**
 * The template for displaying job type in list view
 *
 * Override this template by copying it to yourtheme/simple_job_board/listing/list-view/type.php
 *
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/listing/list-view
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_list_view_job_type_template" filter.
 */
ob_start();
?>

<!-- Start Job Type
================================================== -->
<div class="sjb-col-md-2">
    <?php if ($job_type = sjb_get_the_job_type()) {
        ?>
        <div id="sjb_job-bolits">
            <i class="fa fa-clock-o"></i><?php sjb_the_job_type(); ?>
        </div>
    <?php } ?> 
</div>
<!-- ==================================================
End Job Type -->

<?php
$html = ob_get_clean();

/**
 * Modify the Job Listing -> Job Title Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html   Job Title HTML.                   
 */
echo apply_filters( 'sjb_list_view_job_type_template', $html );