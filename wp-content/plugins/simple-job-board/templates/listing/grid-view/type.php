<?php
/**
 * The template for displaying job type in grid view.
 *
 * Override this template by copying it to yourtheme/simple_job_board/listing/grid-view/type.php
 *
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/listing/grid-view/
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_grid_view_job_type_template" filter.
 */
ob_start();
?>

<!-- Start Job's type
================================================== -->
<div class="sjb-col-md-12">
    <?php if ($job_type = sjb_get_the_job_type()) {
        ?>
        <div id="sjb_job-bolits">
            <i class="fa fa-clock-o"></i><?php sjb_the_job_type(); ?>
        </div>
    <?php } ?>
</div>
<!-- ==================================================
End Job's type -->

<?php
$html = ob_get_clean();

/**
 * Modify the Job Listing -> Job Title Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html   Job Title HTML.                   
 */
echo apply_filters( 'sjb_grid_view_job_type_template', $html );