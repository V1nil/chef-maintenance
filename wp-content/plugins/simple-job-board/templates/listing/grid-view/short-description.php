<?php
/**
 * The template for displaying job short description in gird view.
 *
 * Override this template by copying it to yourtheme/simple_job_board/listing/grid-view/short-description.php
 *
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/listing/grid-view/
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_grid_view_short_description_template" filter.
 */
ob_start();
?>

<!-- Start Job's Short Description 
================================================== -->
<div class="sjb-col-md-12">
    <div class="sjb-row">
        <div class="sjb-lead job-description">
            <?php the_excerpt(); ?>
        </div>
    </div>
</div>
<!-- ==================================================
End Job's Short Description  -->

<?php
$html = ob_get_clean();

/**
 * Modify the Job Listing -> Short Description Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html   Short Description HTML.                   
 */
echo apply_filters( 'sjb_grid_view_short_description_template', $html );