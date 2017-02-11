<?php
/**
 * Displayed when no jobs are found matching the current query.
 *
 * Override this template by copying it to yourtheme/simple_job_board/content-no-jobs-found.php
 *
 * @author 	PressTigers
 * @package 	simple-job-board/templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
echo '<div class="no-job-listing">' .__( 'No jobs found.' , 'simple-job-board' ).'</div>';