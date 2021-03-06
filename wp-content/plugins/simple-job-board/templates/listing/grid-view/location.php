<?php
/**
 * The template for displaying job loactaion in grid view
 *
 * Override this template by copying it to yourtheme/simple_job_board/listing/grid-view/location.php
 *
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/listing/grid-view/
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_grid_view_job_location_template" filter.
 */
ob_start();
?>

<!-- Start Job's Location
================================================== -->
<div class="sjb-col-md-12">
    <?php if ($job_location = sjb_get_the_job_location()) {
        ?>
        <div id="sjb_job-bolits">
            <i class="fa fa-location-arrow"></i><?php sjb_the_job_location(); ?>
        </div>
    <?php } ?>
</div>
<!-- ==================================================
End Job's Location -->

<?php
$html = ob_get_clean();

/**
 * Modify the Job Listing -> Job Location Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html   Job Location HTML.                   
 */
echo apply_filters( 'sjb_grid_view_job_location_template', $html );