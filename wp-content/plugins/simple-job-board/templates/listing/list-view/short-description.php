<?php
/**
 * The template for displaying job short description in list view
 *
 * Override this template by copying it to yourtheme/simple_job_board/listing/list-view/short-description.php
 *
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/listing/list-view
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_list_view_short_description_template" filter.
 */
ob_start();
?>

<!-- Start Job Short Description 
================================================== -->
<div class="sjb-row">
    <div class="sjb-lead job-description">
        <?php the_excerpt(); ?>
    </div>
</div>
<!-- ==================================================
End Job Short Description  -->

<?php
$html = ob_get_clean();

/**
 * Modify the Job Listing -> Short Description Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html   Short Description HTML.                   
 */
echo apply_filters( 'sjb_list_view_short_description_template', $html );