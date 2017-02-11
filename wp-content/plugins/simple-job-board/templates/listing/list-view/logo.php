<?php
/**
 * The template for displaying company logo in list view
 *
 * Override this template by copying it to yourtheme/simple_job_board/listing/list-view/logo.php
 *
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/listing/list-view
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_list_view_company_logo_template" filter.
 */
ob_start();
?>

<!-- Start Company Logo
================================================== -->
<div id="sjb_company-logo-full-view" class="company-logo">
    <a href="<?php the_permalink(); ?>"><?php sjb_the_company_logo(); ?></a>
</div>
<!-- ==================================================
End Company Logo -->

<?php
$html = ob_get_clean();

/**
 * Modify the Job Listing -> Company Logo Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html   Company Logo HTML.                   
 */
echo apply_filters( 'sjb_list_view_company_logo_template', $html );