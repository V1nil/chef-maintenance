<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Simple_Job_Board_Settings_Init Class
 * 
 * This is used to define job settings. This file contains following settings
 * 
 * - General,
 * - Appearance,
 * - Job Features,
 * - Application Form Fields,
 * - Filters
 * - Email Notifications
 * - Upload File Extensions
 * 
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       2.2.3
 * 
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/admin
 * @author      PressTigers <support@presstigers.com> 
 */

class Simple_Job_Board_Settings_Init {

    /**
     * Initialize the class and set its properties.
     *
     * @since   2.2.3
     */
    public function __construct() {
        
        /**
         * The class responsible for defining all the plugin general settings that occur in the frontend area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/settings/class-simple-job-board-settings-general.php';
        
        // Check if General Settings Class Exists
        if ( class_exists ( 'Simple_Job_Board_Settings_General' ) ) {
            
            // Initialize General Settings Object           
            new Simple_Job_Board_Settings_General();
        }
        
        /**
         * The class responsible for defining all the plugin appearance settings that occur in the frontend area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/settings/class-simple-job-board-settings-appearance.php';
        
        // Check if  Appearance Settings Class Exists
        if ( class_exists ( 'Simple_Job_Board_Settings_Appearance' ) ) {
            
            // Initialize Appearance Settings Object           
            new Simple_Job_Board_Settings_Appearance();
        }
        
        /**
         * The class responsible for defining all the plugin job features settings that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/settings/class-simple-job-board-settings-job-features.php';
        
        // Check if  Job Features Settings Class Exists
        if ( class_exists ( 'Simple_Job_Board_Settings_Job_Features' ) ) {
            
            // Initialize Job Features Object           
            new Simple_Job_Board_Settings_Job_Features();
        }
        
        /**
         * The class responsible for defining all the plugin job application form settings that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/settings/class-simple-job-board-settings-application-form-fields.php';
        
        // Check if Job Application Form Settings Class Exists
        if ( class_exists ( 'Simple_Job_Board_Settings_Application_Form_Fields' ) ) {
            
            // Initialize Job Application Form Settings Object           
            new Simple_Job_Board_Settings_Application_Form_Fields();
        }
        
        /**
         * The class responsible for defining all the plugin job filters settings that occur in the frontend area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/settings/class-simple-job-board-settings-filters.php';
        
        // Check if Job Filters Settings Class Exists
        if ( class_exists ( 'Simple_Job_Board_Settings_Filters' ) ) {
            
            // Initialize Job Filters Settings Object           
            new Simple_Job_Board_Settings_Filters();
        }
        
        /**
         * The class responsible for defining all the plugin email notifications settings that occur in the frontend area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/settings/class-simple-job-board-settings-email-notifications.php';
        
        // Check if Email Notifications Settings Class Exists
        if ( class_exists ( 'Simple_Job_Board_Settings_Email_Notifications' ) ) {
            
            // Initialize Email Notifications Settings Object           
            new Simple_Job_Board_Settings_Email_Notifications();
        }        
        
        /**
         * The class responsible for defining all the plugin uplaod file extensions settings that occur in the frontend area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/settings/class-simple-job-board-settings-upload-file-extensions.php';
        
        // Check if Upload File Extension Settings Class Exists
        if (class_exists ( 'Simple_Job_Board_Settings_Upload_File_Extensions' )) {
            
            // Initialize Upload File Extension Settings Object           
            new Simple_Job_Board_Settings_Upload_File_Extensions();
        }  
        
        // Action - Add Settings Menu
        add_action( 'admin_menu', array($this, 'admin_menu'), 12 );

        // Action - Save Settings
        add_action( 'admin_notices', array($this, 'sjb_save_settings' ) );
    }

    /**
     * Add Settings Page Under Job Board Menu.
     * 
     * @since   2.0.0
     */
    public function admin_menu() {
        
        add_submenu_page('edit.php?post_type=jobpost', __('Settings', 'simple-job-board'), __('Settings', 'simple-job-board'), 'manage_options', 'job-board-settings', array($this, 'settings_tab_menu'));
    }

    /**
     * Add Settings Tab Menu.
     * 
     * @Since   2.0.0
     */
    public function settings_tab_menu() {
        
        ?>
        <div class="wrap">
            <h1><?php _e('Settings', 'simple-job-board'); ?></h1>        
            <h2 class="nav-tab-wrapper">
                
                <?php
                /**
                 * Filter the Settings Tab Menus. 
                 * 
                 * @since 2.2.0 
                 * 
                 * @param array (){
                 *     @type array Tab Id => Settings Tab Name
                 * }
                 */
                $settings_tabs = apply_filters('sjb_settings_tab_menus', array());

                $count = 1;
                foreach ( $settings_tabs as $key => $tab_name ) {
                    $active_tab = ( 1 === $count ) ? 'nav-tab-active' : '';
                    echo '<a href="#settings-' . sanitize_key($key) . '" class="nav-tab ' . $active_tab . ' ">' .$tab_name . '</a>';
                    $count++;
                }
                ?>
                
            </h2>
            
            <?php
            /**
             * Action -> Display Settings Sections.  
             * 
             * @since 2.2.3 
             */
            do_action('sjb_settings_tab_section');
            ?>
            
        </div>

        <?php
    }

    /**
     * Merge Arrays
     * 
     * @since    1.0.0
     * 
     * @param    array    $jobapp_field_name        Applicantion Form Field Name
     * @param    array    $jobapp_field_type        Applicantion Form Field Type
     * @param    array    $jobapp_field_option      Applicantion Form Field Options
     * @param    array    $jobapp_field_optional    Applicantion Form Field Optional
     * @return   array    $result                   Associative array with Field Name,Type,Option & Required parameters.
     */
    public static function sjb_mergeArrays($jobapp_field_name, $jobapp_field_type, $jobapp_field_option, $jobapp_field_optional) {
        
        $result = array();

        foreach ($jobapp_field_name as $key => $name) {
            $result = array_merge($result, array(
                $name => array(
                    'type'     => $jobapp_field_type[$key],
                    'option'   => $jobapp_field_option[$key],
                    'optional' => $jobapp_field_optional[$key],
                )
            ));
        }

        return $result;
    }

    /**
     * Save Settings.
     * 
     * @since   2.2.3
     */
    public function sjb_save_settings() {
        
        /**
         * Action -> Save Setting Sections.  
         * 
         * @since   2.2.3 
         */
        do_action('sjb_save_setting_sections');

        // Admin Notices
        if (isset($_POST['admin_notices'])) {
?>
        <div class="updated">
            <p><?php echo apply_filters('sjb_saved_settings_notification', __('Settings have been saved.', 'simple-job-board')); ?></p>
        </div>

<?php
        }
    }

}

new Simple_Job_Board_Settings_Init();