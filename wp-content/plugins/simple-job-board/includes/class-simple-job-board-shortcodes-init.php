<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Simple_Job_Board_Shortcodes_Init Class
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       2.2.3
 * 
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 * @author     PressTigers <support@presstigers.com>
 */

class Simple_Job_Board_Shortcodes_Init {

    /**
     * Constructor
     */
    public function __construct() {

        /**
         * The class responsible for job listing shortcode functionality
         * of the plugin.
         */
        require_once plugin_dir_path(__FILE__) . 'shortcodes/class-simple-job-board-shortcode-jobpost.php';

        // Check if Job Listing Shortcode Class Exists
        if (class_exists('Simple_Job_Board_Shortcode_Jobpost')) {
            new Simple_Job_Board_Shortcode_Jobpost();
        }
    }

}

new Simple_Job_Board_Shortcodes_Init();