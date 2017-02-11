<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Simple_Job_Board_Post_Types class
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       1.0.0
 *
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 */

/**
 * This is used to define custom post types.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since       1.0.0
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 * @author      PressTigers <support@presstigers.com>
 */
class Simple_Job_Board_Post_Types
{
    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     */
    public function __construct()
    {
        /* Jobpost Custom Post Type */
        require_once plugin_dir_path ( __FILE__ ) . '/class-simple-job-board-post-types-jobpost.php';
        
        if (class_exists ( 'Simple_Job_Board_Post_Types_Jobpost' )) {				
            new Simple_Job_Board_Post_Types_Jobpost ();
        }
        
        /* Applicants Custom Post Type */
        require_once plugin_dir_path ( __FILE__ ) . '/class-simple-job-board-post-types-applicants.php';
        
        if (class_exists ( 'Simple_Job_Board_Post_Types_Applicants' )) {				
            new Simple_Job_Board_Post_Types_Applicants ();
        }
    }
       
}
new Simple_Job_Board_Post_Types();