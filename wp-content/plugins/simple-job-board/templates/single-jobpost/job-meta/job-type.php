<?php
/**
 * The template for displaying job type
 *
 * Override this template by copying it to yourtheme/simple_job_board/single-jobpost/job-meta/job-type.php
 * 
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/single-jobpost/job-meta
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_job_meta_job_type_template" filter.
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
End Job Type  -->

<?php
$html_job_type = ob_get_clean();

/**
 * Modify the Job Meta - Job Type Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html_job_type   Job Type HTML.                   
 */
echo apply_filters( 'sjb_job_meta_job_type_template', $html_job_type );