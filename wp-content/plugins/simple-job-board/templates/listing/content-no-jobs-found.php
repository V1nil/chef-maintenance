<?php
/**
 * Displayed when no jobs are found matching the current query
 *
 * Override this template by copying it to yourtheme/simple_job_board/listing/content-no-jobs-found.php
 *
 * @author 	PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/listing
 * @version     1.0.0
 * @since       2.1.0
 */
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

// Get Current Page Slug           
$slugs = sjb_get_slugs();
$page_slug = $slugs[0];
$slug = ( get_option('permalink_structure') ) ? $page_slug : '';

echo '<div class="no-job-listing"><p>' .__( 'No jobs found.', 'simple-job-board' ).'</p><p><a href="' . esc_url(home_url('/')) . $slug . '" class="btn btn-primary"> Back to Jobs Page </a></p></div>';