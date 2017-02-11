<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Simple_Job_Board_Settings_Upload_File_Extensions Class
 * 
 * This file used to define the settings for the resume extensions. Allowable
 * extensions for resume are doc, docx, rtf, txt, odt.
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since      2.2.3
 *
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/admin/settings
 * @author     PressTigers <support@presstigers.com>
 */

class Simple_Job_Board_Settings_Upload_File_Extensions {

    /**
     * Initialize the class and set its properties.
     *
     * @since   2.2.3
     */
    public function __construct() {

        // Filter -> Add Settings Uploaded File Extensions Tab
        add_filter('sjb_settings_tab_menus', array($this, 'add_settings_tab'), 80);

        // Action -> Add Settings Uploaded File Extensions Section 
        add_action('sjb_settings_tab_section', array($this, 'add_settings_section'), 80);

        // Action -> Save Settings Uploaded File Extensions Section 
        add_action('sjb_save_setting_sections', array($this, 'save_settings_section'));
    }

    /**
     * Add Settings Uploaded File Extensions Tab.
     *
     * @since    2.2.3
     * 
     * @param    array  $tabs  Settings Tab
     * @return   array  $tabs  Merge array of Settings Tab with "Upload File Extensions" Tab.
     */
    public function add_settings_tab($tabs) {
        
        $tabs['upload_file_ext'] = __( 'Upload File Extensions', 'simple-job-board' );
        return $tabs;
    }

    /**
     * Add Settings Uploaded File Extensions Section.
     *
     * @since    2.2.3
     */
    public function add_settings_section() {
        
        ?>
        <!-- Upload File Extensions -->
        <div id="settings-upload_file_ext" class="sjb-admin-settings" style="display: none;">
            
            <?php
            /**
             * Action -> Add new section before file upload settings .  
             * 
             * @since 2.2.0 
             */
            do_action('sjb_file_upload_settings_before');
            ?>

            <form method="post" id="upload-file-form">
                <h4 class="first"><?php echo __('Upload File Extensions', 'simple-job-board'); ?></h4>
                <div class="sjb-section">
                    <div class="sjb-content">
                        
                        <?php
                        /**
                         * Action -> Add new fields at start of upload section first field.  
                         * 
                         * @since 2.2.0 
                         */
                        do_action('sjb_file_upload_settings_start');
                        ?>
                        
                        <select multiple="multiple" name="file_extensions[]" id="upload-file-select" size="6">
                            
                            <?php
                            /**
                             * Action -> Add new extension at the start of list.  
                             * 
                             * @since 2.2.0 
                             */
                            do_action('sjb_file_extension_options_start');
                            ?>
                            
                            <option <?php
                            $selected = ( 'no' === get_option('job_board_all_extensions_check') ) ? ( FALSE !== get_option('job_board_upload_file_ext') ) ? (in_array('pdf', get_option('job_board_upload_file_ext')) ? 'selected' : '' ) : '' : 'selected';
                            echo $selected
                            ?> value="pdf"><?php echo __('pdf', 'simple-job-board'); ?></option>
                            <option <?php
                            $selected = ( 'no' === get_option('job_board_all_extensions_check') ) ? ( FALSE !== get_option('job_board_upload_file_ext') ) ? (in_array('doc', get_option('job_board_upload_file_ext')) ? 'selected' : '' ) : '' : 'selected';
                            echo $selected
                            ?> value="doc"><?php echo __('doc', 'simple-job-board'); ?></option>
                            <option <?php
                            $selected = ( 'no' === get_option('job_board_all_extensions_check') ) ? ( FALSE !== get_option('job_board_upload_file_ext') ) ? (in_array('docx', get_option('job_board_upload_file_ext')) ? 'selected' : '' ) : '' : 'selected';
                            echo $selected
                            ?> value="docx"><?php echo __('docx', 'simple-job-board'); ?></option>
                            <option <?php
                            $selected = ( 'no' === get_option('job_board_all_extensions_check') ) ? ( FALSE !== get_option('job_board_upload_file_ext') ) ? (in_array('odt', get_option('job_board_upload_file_ext')) ? 'selected' : '' ) : '' : 'selected';
                            echo $selected
                            ?> value="odt"><?php echo __('odt', 'simple-job-board'); ?></option>
                            <option <?php
                            $selected = ( 'no' === get_option('job_board_all_extensions_check') ) ? ( FALSE !== get_option('job_board_upload_file_ext') ) ? (in_array('rtf', get_option('job_board_upload_file_ext')) ? 'selected' : '' ) : '' : 'selected';
                            echo $selected
                            ?> value="rtf"><?php echo __('rtf', 'simple-job-board'); ?></option>
                            <option <?php
                            $selected = ( 'no' === get_option('job_board_all_extensions_check') ) ? ( FALSE !== get_option('job_board_upload_file_ext') ) ? (in_array('txt', get_option('job_board_upload_file_ext')) ? 'selected' : '' ) : '' : 'selected';
                            echo $selected
                            ?> value="txt"><?php echo __('txt', 'simple-job-board'); ?></option>
                                
                                <?php
                                /**
                                 * Action -> Add new extension at the end of list.  
                                 * 
                                 * @since 2.2.0 
                                 */
                                do_action('sjb_file_extension_options_end');
                                ?>
                            
                        </select>
                        <div class="sjb-form-group"><?php echo __('Press and hold down the Ctrl key to select multiple extensions.', 'simple-job-board'); ?></div>
                        <div class="sjb-form-group">
                            <input type="checkbox" name="all_file_extensions" id="all-file-ext" value="all extension"  <?php if ('yes' === get_option('job_board_all_extensions_check')) echo 'checked="checked"'; ?> />
                            <label><?php echo __('Enable all extensions', 'simple-job-board'); ?></label>
                            <input type='hidden' name="empty_file_extensions" value="empty_file_extensions" >
                        </div>

                        <div class="sjb-form-group">
                            <input type="checkbox" name="files_hotlinking" id="files-hotlinking" value="files hotlinking"  <?php if ('yes' === get_option('job_board_anti_hotlinking')) echo 'checked="checked"'; ?> />
                            <label><?php echo __('Enable Uploaded Files Anti-Hotlinking', 'simple-job-board'); ?></label>
                        </div>
                        
                        <?php
                        /**
                         * Action -> Add new fields at the end of upload section.  
                         * 
                         * @since 2.2.0 
                         */
                        do_action('sjb_file_upload_settings_end');
                        ?>
                        
                    </div>
                </div>
                <input type="hidden" value="1" name="admin_notices" />
                <input type="submit" name="upload_file_form_submit" id="upload-file-form-submit" class="button button-primary" value="<?php echo __('Save Changes', 'simple-job-board'); ?>" />
            </form>
        </div>
        
        <?php
    }

    /**
     * Save Settings Upload File Extension Section.
     * 
     * This function is used to save the uploaded file extensions settings. User
     * can set the security of uploaded file by enabling/disabling it's 
     * extension & anti-hotlinking rules.
     *
     * @since    2.2.3
     */
    public function save_settings_section() {

        // Save File Extension on Form Submission
        if ( !empty( $_POST['file_extensions'] )  || !empty( $_POST['empty_file_extensions'] ) ) {

            // Empty Checkboxes Status
            $file_extension = $anti_hotlinking = 'no';

            // Save Extentions Settigns
            if ( !empty( $_POST['file_extensions'] ) ) {

                // Save Extentions in WP Options || Add Options if not Exist
                ( FALSE !== get_option('job_board_upload_file_ext') ) ? 
                    update_option('job_board_upload_file_ext', $_POST['file_extensions']) :
                    add_option('job_board_upload_file_ext', $_POST['file_extensions'], '', 'no');
            }

            // Enable All File Extensions
            if ( isset( $_POST['all_file_extensions'] ) ) {
                update_option('job_board_all_extensions_check', 'yes');
                $file_extension = 'yes';
            }

            // Enable File Anti-hotlinking Rules
            if ( isset($_POST['files_hotlinking'] ) ) {
                update_option('job_board_anti_hotlinking', 'yes');
                $anti_hotlinking = 'yes';
                $sjbrObj = new Simple_Job_Board_Rewrite();
                $sjbrObj->job_board_rewrite();
            }

            // Disable File Extensions
            if ( 'no' === $file_extension ) {
                update_option('job_board_all_extensions_check', 'no');
            }

            // Disable Anti-Hotlinking Rules
            if ( 'no' === $anti_hotlinking ) {
                update_option('job_board_anti_hotlinking', 'no');
                $sjbrObj = new Simple_Job_Board_Rewrite();
                $sjbrObj->job_board_rewrite();
            }
        }
    }

}