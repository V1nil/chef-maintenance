<?php
/**
 * The template for displaying job title
 *
 * Override this template by copying it to yourtheme/simple_job_board/single-jobpost/job-meta/job-title.php
 * 
 * @author      PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/single-jobpost/job-meta
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_job_meta_job_title_template" filter.
 */
ob_start();

// Job Title
the_title();

$html_title = ob_get_clean();

/**
 * Modify the Job Title Template.
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html_title   Job Title HTML.                   
 */
echo apply_filters( 'sjb_job_meta_job_title_template', $html_title );