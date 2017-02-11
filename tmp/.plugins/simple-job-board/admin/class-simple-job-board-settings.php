<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Simple_Job_Board_Settings class.
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       1.0.0
 *
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/admin
 */

/**
 * This is used to define custom post types.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since       1.0.0
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/admin
 * @author      PressTigers <support@presstigers.com>
 */
class Simple_Job_Board_Settings
{
    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     */
    public function __construct()
    {
        include_once( 'class-simple-job-board-admin-setup.php' );
    }
}
new Simple_Job_Board_Settings();