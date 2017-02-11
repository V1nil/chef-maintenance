<?php
/**
 * Template for displays the company logo
 *
 * Override this template by copying it to yourtheme/simple_job_board/single-jobpost/job-meta/company-logo.php
 * 
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/single-jobpost/job-meta
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_job_meta_company_logo_template" filter.
 */
ob_start();
?>

<!-- Start Company Logo 
================================================== -->
<div class="sjb-company-logo">
    <?php
    if ($website = sjb_get_the_company_website()):
        ?>
        <a class="website" href="<?php echo esc_url($website); ?>"  target="_blank" rel="nofollow"><?php sjb_the_company_logo(); ?></a>
        <?php
    else:
        sjb_the_company_logo();
    endif;
    ?>
</div>
<!-- ==================================================
End Company Logo  -->

<?php
$html_logo = ob_get_clean();

/**
 * Modify the Job Meta - Company Logo Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html_logo   Job Meta HTML.                   
 */
echo apply_filters( 'sjb_job_meta_company_logo_template', $html_logo );