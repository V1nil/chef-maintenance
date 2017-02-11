<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wordpress.org/plugins/simple-job-board
 * @since      1.0.0
 *
 * @package    Simple_Job_Board
 * @subpackage Simple_Job_Board/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Job_Board
 * @subpackage Simple_Job_Board/admin
 * @author     PressTigers <support@presstigers.com>
 */
class Simple_Job_Board_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $simple_job_board    The ID of this plugin.
     */
    private $simple_job_board;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $simple_job_board       The name of this plugin.
     * @param    string    $version    The version of this plugin.
     */
    public function __construct($simple_job_board, $version) {
        $this->simple_job_board = $simple_job_board;
        $this->version = $version;

        /**
         * The class responsible for defining basic meta options under custom post type in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-simple-job-board-metaboxes.php';

        /**
         * The class responsible for defining all the meta options under custom post type in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-simple-job-board-writepanels.php';

        /**
         * The class responsible for writing rules in htaccess file and to protect the file from direct link.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-simple-job-board-rewrite.php';

        /**
         * The class responsible for defining all the plugin settings that occur in the front end area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-simple-job-board-settings.php';

        /**
         * The class responsible for Applicant's detail in the back end area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-simple-job-board-applicants.php';
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Simple_Job_Board_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Simple_Job_Board_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->simple_job_board . '-jqueryui',     'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css', array(), $this->version, 'all');
        wp_enqueue_style($this->simple_job_board . '-google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans', array(), $this->version, 'all');
        wp_enqueue_style($this->simple_job_board . '-fontawesome',  'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->simple_job_board, plugin_dir_url(__FILE__) . 'css/simple-job-board-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Simple_Job_Board_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Simple_Job_Board_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->simple_job_board . '-admin', plugin_dir_url(__FILE__) . 'js/simple-job-board-admin.js', array('jquery', 'jquery-ui-sortable'), $this->version, FALSE);

        /* Localize Script for Making jQuery Stings Translation Ready */
        wp_localize_script($this->simple_job_board . '-admin', 'settings_application_form', array(
            
            'admin_jquery_alerts' => array(
                'empty_feature_name' => __('Please fill out feature name.', 'simple-job-board'),
                'empty_field_name'   => __('Please fill out application form field name.', 'simple-job-board'),
            ),
            
                )
        );
    }

}
