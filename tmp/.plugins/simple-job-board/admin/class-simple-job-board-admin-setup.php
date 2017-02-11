<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Simple_Job_Board_Setup class.
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
class Simple_Job_Board_Setup {

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     */
    public function __construct() {

        // Hook - Add Settings Menu
        add_action('admin_menu', array($this, 'admin_menu'), 12);

        // Hook - Settings Save Notification
        add_action('admin_notices', array($this, 'settings_notification'));
    }

    /**
     * admin_menu function.
     *
     * @access public
     * @return void
     */
    public function admin_menu() {
        add_submenu_page('edit.php?post_type=jobpost', __('Settings', 'simple-job-board'), __('Settings', 'simple-job-board'), 'manage_options', 'job-board-settings', array($this, 'settings_tab_menu'));
    }

    /**
     * Add Settings Tab Menu.
     * 
     * @Since 1.0.0
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
                 * @param array $args{
                 *     @type array Tab Id => Settings Tab Name
                 * }
                 * 
                 * @return array All Settings Tabs .
                 */
                $settings_tabs = apply_filters('sjb_settings_tab_menus', array(
                    'general'                 => 'General',
                    'appearance'              => 'Appearance',
                    'job_features'            => 'Job Features',
                    'application_form_fields' => 'Application Form Fields',
                    'job_filters'             => 'Filters',
                    'email_notifications'     => 'Email Notifications',
                    'upload_file_ext'         => 'Upload File Extensions',
                ));

                $count = 1;
                foreach ($settings_tabs as $key => $tab_name) {
                    $active_tab = ( 1 === $count ) ? 'nav-tab-active' : '';
                    echo '<a href="#settings-' . sanitize_key($key) . '" class="nav-tab ' . $active_tab . ' ">' . __($tab_name, 'simple-job-board') . '</a>';
                    $count++;
                }
                ?>
            </h2>

            <?php
            /**
             * Action ->Display Settings Section Before First Tab.  
             * 
             * @since 2.2.0 
             */
            do_action('simple_job_board_settings_before');
            ?>

            <!-- General -->
            <div id="settings-general" class="settings_panel" style="display: block;" >

                <?php
                if (isset($_POST['jobpost_slug']) || isset($_POST['job_category_slug']) || isset($_POST['job_type_slug']) || isset($_POST['job_location_slug'])) {
                    if (isset($_POST['jobpost_slug']) && '' != $_POST['jobpost_slug']) {
                        update_option('job_board_jobpost_slug', esc_attr($_POST['jobpost_slug']));
                    }
                    if (isset($_POST['job_category_slug']) && '' != $_POST['job_category_slug']) {
                        update_option('job_board_job_category_slug', esc_attr($_POST['job_category_slug']));
                    }
                    if (isset($_POST['job_type_slug']) && '' != $_POST['job_type_slug']) {
                        update_option('job_board_job_type_slug', esc_attr($_POST['job_type_slug']));
                    }
                    if (isset($_POST['job_location_slug']) && '' != $_POST['job_location_slug']) {
                        update_option('job_board_job_location_slug', esc_attr($_POST['job_location_slug']));
                    }
                }

                if (get_option('job_board_jobpost_slug')) {
                    $jobpost_slug = get_option('job_board_jobpost_slug');
                } else {
                    $jobpost_slug = 'jobs';
                }

                if (get_option('job_board_job_category_slug')) {
                    $category_slug = get_option('job_board_job_category_slug');
                } else {
                    $category_slug = 'job-category';
                }

                if (get_option('job_board_job_type_slug')) {
                    $job_type_slug = get_option('job_board_job_type_slug');
                } else {
                    $job_type_slug = 'job-type';
                }

                if (get_option('job_board_job_location_slug')) {
                    $job_location_slug = get_option('job_board_job_location_slug');
                } else {
                    $job_location_slug = 'job-location';
                }
                ?>
                <form method="post" id="general_options_form">
                    <?php
                    /**
                     * Action -> Add new sub-section before general section content .  
                     * 
                     * @since 2.2.0 
                     */
                    do_action('sjb_general_options_before');
                    ?>
                    <h4>
                        <?php
                        /**
                         * Filter the title of General Options Section
                         * 
                         * @since 2.2.0 
                         */
                        echo apply_filters('sjb_general_option_title', __('General Options', 'simple-job-board'));
                        ?>
                    </h4>
                    <div class="app_form_fields">
                        <table>
                            <?php
                            /**
                             * Action -> Add new fields at start of general section.  
                             * 
                             * @since 2.2.0 
                             */
                            do_action('sjb_general_options_start');
                            ?> 

                            <tr>
                                <td><?php echo __('Jobpost Custom Post Type Slug:', 'simple-job-board'); ?></td>
                                <td><input type="text" name="jobpost_slug" value="<?php echo $jobpost_slug ?>" size="30" maxlength="25"></td>
                            </tr>
                            <tr>
                                <td><?php echo __('Job Category Taxonomy Slug:', 'simple-job-board'); ?></td>
                                <td><input type="text" name="job_category_slug" value="<?php echo $category_slug ?>" size="30" maxlength="25"/></td>
                            </tr>
                            <tr>
                                <td><?php echo __('Job Type Taxonomy Slug:', 'simple-job-board'); ?></td>
                                <td><input type="text" name="job_type_slug" value="<?php echo $job_type_slug ?>" size="30" maxlength="25"/></td>
                            </tr>
                            <tr>
                                <td><?php echo __('Job Location Taxonomy Slug:', 'simple-job-board'); ?></td>
                                <td><input type="text" name="job_location_slug" value="<?php echo $job_location_slug ?>" size="30" maxlength="25"/></td>
                            </tr>

                            <?php
                            /**
                             * Action -> Add new fields at the end of general section.  
                             * 
                             * @since 2.2.0 
                             */
                            do_action('sjb_general_options_end');
                            ?>
                        </table>                         
                    </div> 
                    <?php
                    /**
                     * Action -> Add new sub-section after general section content .  
                     * 
                     * @since 2.2.0 
                     */
                    do_action('sjb_general_options_after');
                    ?>
                    <input type="hidden" value="1" name="admin_notices" />
                    <input type="submit" name="general_options_submit" id="general-options-form-submit" class="button button-primary" value="<?php echo __('Save Changes', 'simple-job-board'); ?>" />
                </form>
            </div>

            <!-- Appearance -->
            <div id="settings-appearance" class="settings_panel" style="display: none;" >
                <form method="post" id="appearance_options_form">
                    <?php
                    if ((isset($_POST['job_listing_views_settings']) && '' != $_POST['job_listing_views_settings'])) {
                        update_option('job_board_listing_view', $_POST['job_listing_views_settings']);
                    }

                    if ((isset($_POST['job_listing_content_settings']) && '' != $_POST['job_listing_content_settings'])) {
                        update_option('job_board_listing', $_POST['job_listing_content_settings']);
                    }

                    if (isset($_POST['container_class']) || isset($_POST['container_id'])) {
                        if (isset($_POST['container_class']) && '' != $_POST['container_class']) {
                            update_option('job_board_container_class', esc_attr($_POST['container_class']));
                        }
                        if (isset($_POST['container_id']) && '' != $_POST['container_id']) {
                            update_option('job_board_container_id', esc_attr($_POST['container_id']));
                        }
                    }
                    if (get_option('job_board_container_class')) {
                        $container_class = get_option('job_board_container_class');
                    } else {
                        $container_class = 'container sjb-container';
                    }

                    if (get_option('job_board_container_id')) {
                        $container_ids = explode(" ", get_option('job_board_container_id'));
                        $container_id = $container_ids[0];
                    } else {
                        $container_id = 'container';
                    }

                    // Select Job Listing View                    
                    $logo_detail = '';
                    $without_logo_detail = '';
                    $without_logo = '';
                    $list_view = '';
                    $grid_view = '';

                    if ($list_view = get_option('job_board_listing_view')) {
                        if ('list-view' === $list_view)
                            $list_view = 'checked';

                        if ('grid-view' === $list_view)
                            $grid_view = 'checked';
                    }
                    else {
                        $list_view = 'checked';
                    }

                    if ($list_contents = get_option('job_board_listing')) {
                        if ('logo-detail' === $list_contents)
                            $logo_detail = 'checked';

                        if ('without-logo-detail' === $list_contents)
                            $without_logo_detail = 'checked';

                        if ('without-logo' === $list_contents)
                            $without_logo = 'checked';
                    }
                    else {
                        $logo_detail = 'checked';
                    }
                    ?>

                    <?php
                    /**
                     * Action -> Add new section before content wrapper styling.  
                     * 
                     * @since 2.2.2 
                     */
                    do_action('sjb_content_wrapper_styling_before');
                    ?>
                    
                    <h4><?php _e('Content Wrapper Styling', 'simple-job-board'); ?></h4>
                    <div class="app_form_fields">                        
                        <table>
                            <?php
                            /**
                             * Action -> Add new fields at start of of Content Wrapper.  
                             * 
                             * @since 2.2.2 
                             */
                            do_action('sjb_content_wrapper_styling_start');
                            ?> 
                            
                            <tr>
                                <td><?php _e('Job Board Container Id:', 'simple-job-board'); ?></td>
                                <td><input type="text" name="container_id" value="<?php echo $container_id; ?>" size="30" /></td>
                            </tr>
                            <tr>
                                <td><?php _e('Job Board Container Class:', 'simple-job-board'); ?></td>
                                <td><input type="text" name="container_class" value="<?php echo $container_class; ?>" size="30" ></td>
                            </tr>
                            <tr>
                                <td colspan="2"><?php _e('Add classes seprated by space or comma e.g. container sjb-container or container,sjb-container', 'simple-job-board'); ?></td>
                            </tr>                                                      

                            <?php
                            /**
                             * Action -> Add new fields at the end of Content Wrapper.  
                             * 
                             * @since 2.2.2 
                             */
                            do_action('sjb_content_wrapper_styling_end');
                            ?>
                        </table>
                    </div>

                    <?php
                    /**
                     * Action -> Add new section after content wrapper styling.  
                     * 
                     * @since 2.2.2 
                     */
                    do_action('sjb_content_wrapper_styling_after');
                    ?>

                    <h4><?php echo apply_filters('sjb_job_listing_views_title', __('Job Listing Views', 'simple-job-board')); ?></h4>
                    <div class="app_form_fields">
                        <?php
                        /**
                         * Action -> Add new fields at start of job listing view.  
                         * 
                         * @since 2.2.0 
                         */
                        do_action('sjb_listing_view_start');
                        ?>

                        <p>
                            <input type="radio" name="job_listing_views_settings" value="list-view" id="list-view" <?php echo $list_view; ?> />
                            <?php _e('Display job listing in list view', 'simple-job-board'); ?>                                               
                        </p>						
                        <p>
                            <input type="radio" name="job_listing_views_settings" value="grid-view" id="grid-view" <?php echo $grid_view; ?> />
                            <?php _e('Display job listing in grid view', 'simple-job-board'); ?>                                               
                        </p>

                        <?php
                        /**
                         * Action -> Add new fields at end of job listing view.  
                         * 
                         * @since 2.2.0 
                         */
                        do_action('sjb_listing_view_end');
                        ?>
                    </div>
                    <?php
                    /**
                     * Action -> Add new sub-section after appearance listing view .  
                     * 
                     * @since 2.2.0 
                     */
                    do_action('sjb_appearance_listing_view_after');
                    ?>

                    <h4><?php echo apply_filters('sjb_job_listing_content_title', __('Job Listing Contents', 'simple-job-board')); ?></h4>
                    <div class="app_form_fields">                        
                        <?php
                        /**
                         * Action -> Add new fields at start of job content.  
                         * 
                         * @since 2.2.0 
                         */
                        do_action('sjb_listing_content_start');
                        ?>   

                        <p>
                            <input type="radio" name="job_listing_content_settings" value="logo-detail" id="logo-detail" <?php echo $logo_detail; ?> />
                            <?php _e('Display job listing with company logo and detail', 'simple-job-board'); ?>                                               
                        </p>
                        <p>
                            <input type="radio" name="job_listing_content_settings" value="without-logo-detail" id="without-logo-detail" <?php echo $without_logo_detail; ?> /> 
                            <?php _e('Display job listing without company logo and detail', 'simple-job-board'); ?>                                                   
                        </p>
                        <p>
                            <input type="radio" name="job_listing_content_settings" value="without-logo" id="without-logo" <?php echo $without_logo; ?> />
                            <?php _e('Display job listing without company logo', 'simple-job-board'); ?>                            
                        </p>                        

                        <?php
                        /**
                         * Action -> Add new fields at the end of job content.  
                         * 
                         * @since 2.2.0 
                         */
                        do_action('sjb_listing_content_end');
                        ?>
                    </div>
                    <?php
                    /**
                     * Action -> Add new sub-section after appearance listing content .  
                     * 
                     * @since 2.2.0 
                     */
                    do_action('sjb_appearance_listing_content_after');
                    ?> 
                    <input type="hidden" value="1" name="admin_notices" />
                    <input type="submit" name="job_general_options" id="job_general_options" class="button button-primary" value="<?php echo __('Save Changes', 'simple-job-board'); ?>" />
                </form>
            </div>

            <!-- Job Features -->
            <div id="settings-job_features" class="settings_panel" style="display: none;">                
                <h4><?php _e('Default Feature List', 'simple-job-board'); ?></h4>
                <div class="app_form_fields jobpost_fields">
                    <form method="post" action="" id="job_feature_form">
                        <ul id="settings_job_features">
                            <?php
                            /* Save Form Data to Wordpress Option */
                            if (isset($_POST['jobfeature']) && $_POST['jobfeature'] != '' && isset($_POST['jobfeature_value'])) {

                                $option_name = 'jobfeature_settings_options';
                                $option_data = array_combine($_POST['jobfeature'], $_POST['jobfeature_value']);
                                $serialized_option = serialize($option_data);

                                if (FALSE !== get_option('jobfeature_settings_options')) {

                                    //update field option array
                                    update_option($option_name, $serialized_option);
                                } else {

                                    // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
                                    $deprecated = NULL;
                                    $autoload = 'no';
                                    add_option($option_name, $serialized_option, $deprecated, $autoload);
                                }
                            } elseif (isset($_POST['empty_feature']) && 'empty_features' == $_POST['empty_feature']) {
                                update_option('jobfeature_settings_options', '');
                            }

                            // Display Settings Option Feature
                            $options_data = get_option('jobfeature_settings_options');
                            $fields = unserialize($options_data);
                            if (NULL != $fields):
                                foreach ($fields as $field => $val) {
                                    if ('empty' === $val) {
                                        $feature_value = '<input type="text" value=" "  name="jobfeature_value[]" />';
                                    } else {
                                        $feature_value = '<input type="text" value="' . $val . '"  name="jobfeature_value[]" />';
                                    }
                                    echo '<li class="' . $field . '"><label for="' . $field . '"><strong>' . __('Field Name', 'simple-job-board') . ':</strong> ' . ucwords(str_replace('_', ' ', substr($field, 11))) . '</label> <input type="hidden"  name="jobfeature[]" value="' . $field . '"  >' . $feature_value . ' &nbsp; <div class="button removeField" >' . __('Delete', 'simple-job-board') . '</div></li>';
                                }
                            endif;
                            ?>
                        </ul>
                        <input type="hidden" name="empty_feature" value="empty_features" />
                        <input type="hidden" value="1" name="admin_notices" />
                    </form>
                </div> 

                <h4><?php _e('Add New Feature', 'simple-job-board'); ?></h4>
                <div class="app_form_fields">
                    <table id="jobfeatures_form" class="alignleft">
                        <thead>
                            <tr>
                                <th><?php _e('Feature', 'simple-job-board'); ?></th>
                                <th><?php _e('Value', 'simple-job-board'); ?></th>
                            </tr>
                        </thead>
                        <tbody>                        
                            <tr>
                                <td class="left" id="jobFeature"><input type="text" id="settings_jobfeature_name" /></td>
                                <td><input type="text" id="settings_jobfeature_value" /></td>
                                <td><input type="submit" class="button" id="settings_addFeature" value="<?php echo __('Add Field', 'simple-job-board'); ?>" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <input type="submit" name="jobfeature_submit" id="jobfeature_form" class="button button-primary" value="<?php echo __('Save Changes', 'simple-job-board'); ?>" />
            </div>

            <!-- Application Form Fields -->
            <div id="settings-application_form_fields" class="settings_panel" style="display: none;">
                <?php
                global $jobfields;
                $field_types = array(
                    'text' => __('Text Field', 'simple-job-board'),
                    'text_area' => __('Text Area', 'simple-job-board'),
                    'email' => __('Email', 'simple-job-board'),
                    'phone' => __('Phone', 'simple-job-board'),
                    'date' => __('Date', 'simple-job-board'),
                    'checkbox' => __('Check Box', 'simple-job-board'),
                    'dropdown' => __('Drop Down', 'simple-job-board'),
                    'radio' => __('Radio', 'simple-job-board'),
                );
                ?>
                <h4><?php _e('Default Application Form Fields', 'simple-job-board'); ?></h4>
                <div class="app_form_fields jobpost_fields">
                    <form method="post" id="job_app_form">
                        <ul id="settings_app_form_fields">
                            <?php
                            // Save the Form Data
                            if (isset($_POST['field_name']) && isset($_POST['field_type']) && isset($_POST['field_optional'])) {
                                $jopapp_fields = $this->sjb_mergeArrays($_POST['field_name'], $_POST['field_type'], $_POST['field_option'], $_POST['field_optional']);

                                // Creating WP Options For Job Application
                                $jobapp_option_name = 'jobapp_settings_options';
                                $jobapp_option_data = $jopapp_fields;
                                $jobapp_serialized_option = serialize($jobapp_option_data);

                                if (FALSE !== get_option('jobapp_settings_options')) {

                                    // Update Option 
                                    update_option($jobapp_option_name, $jobapp_serialized_option);
                                } else {

                                    // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
                                    $deprecated = NULL;
                                    $autoload = 'no';
                                    add_option($jobapp_option_name, $jobapp_serialized_option, $deprecated, $autoload);
                                }
                            } elseif (isset($_POST['empty_jobapp']) && 'empty_jobapp' == $_POST['empty_jobapp']) {
                                update_option('jobapp_settings_options', '');
                            }

                            $jobapp_setting_fields = unserialize(get_option('jobapp_settings_options'));

                            if (NULL != $jobapp_setting_fields):
                                foreach ($jobapp_setting_fields as $key => $val):
                                    if (isset($val['type']) && isset($val['option'])):
                                        if (substr($key, 0, 7) == 'jobapp_'):
                                            $select_option = NULL;

                                            // Job Application Form Selected Field
                                            foreach ($field_types as $field_key => $field_val) {
                                                if ($val['type'] == $field_key)
                                                    $select_option .= '<option value="' . $field_key . '" selected>' . $field_val . '</option>';
                                            }

                                            // Options for [Checkbox],[Radio],[Drop Down] Fields
                                            if (!( 'text' === $val['type'] or 'date' === $val['type'] or 'text_area' === $val['type'] or 'email' === $val['type'] or 'phone' === $val['type'] )):
                                                $field_options = '<input type="text" name="field_option[]" value="' . $val['option'] . '"  placeholder="Option1, option2, option3" />';
                                            else:
                                                $field_options = '<input type="hidden" name="field_option[]" value="' . $val['option'] . '" placeholder="Option1, option2, option3"  />';

                                            endif;

                                            echo '<li class="' . $key . '">'
                                            . '<label for="">' . ucwords(str_replace('_', ' ', substr($key, 7))) . '</label>'
                                            . '<input type="hidden" name="field_name[]" value="' . $key . '" >'
                                            . '<input type="hidden" name="field_type[]" value="' . $val['type'] . '" >'
                                            . '' . $field_options . ''
                                            . '<select class="jobapp_field_type" name="' . $key . '[type]">' . $select_option . '</select>&nbsp;';

                                            // Set Fields as Optional or Required
                                            if (isset($val['optional'])) {
                                                echo '<input type="checkbox" name="field_required[]" value="' . $val['optional'] . '" class="settings-jobapp-required-field"  ' . $val['optional'] . ' />' . __('Required', 'simple-job-board') . ' &nbsp; ';
                                                echo '<input type="hidden"   name="field_optional[]" value="' . $val['optional'] . '" class="settings-jobapp-optional-field"  />';
                                            } else {
                                                echo '<input type="checkbox" name="field_required[]" value="checked" class="settings-jobapp-required-field" checked />' . __('Required', 'simple-job-board') . '&nbsp; ';
                                                echo '<input type="hidden"   name="field_optional[]" value="checked" class="settings-jobapp-optional-field" />';
                                            }

                                            echo ' &nbsp; <div class="button removeField">' . __('Delete', 'simple-job-board') . '</div></li>';
                                        endif;
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </ul>
                        <input type="hidden" name="empty_jobapp" value="empty_jobapp" />
                        <input type="hidden" value="1" name="admin_notices" />
                    </form>
                </div>
                <div class="clearfix clear"></div>

                <div class="app_form_fields">
                    <table id="jobapp_form_fields" class="alignleft">
                        <thead>
                            <tr>
                                <th class="left"><?php _e('Field', 'simple-job-board'); ?></th>
                                <th><?php _e('Type', 'simple-job-board'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="left" id="newmetaleft"><input type="text" id="setting_jobapp_name" /></td>
                                <td>
                                    <select id="setting_jobapp_field_type">
                                        <?php
                                        foreach ($field_types as $key => $val):
                                            echo '<option value="' . $key . '" class="' . $key . '">' . $val . '</option>';
                                        endforeach;
                                        ?>
                                    </select>
                                    <input id="settings_jobapp_field_options" class="jobapp_field_type" type="text" style="display: none;" placeholder="Option1, Option2, Option3" >
                                </td>
                                <td><input type="checkbox" id="settings_jobapp_required_field" checked="checked"/> <?php _e('Required', 'simple-job-board'); ?></td>
                                <td><input type="submit" class="button" id="app_add_field" value="<?php _e('Add Field', 'simple-job-board'); ?>" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <input type="submit" name="jobapp_submit" id="jobapp_btn" class="button button-primary" value="<?php echo __('Save Changes', 'simple-job-board'); ?>" />
            </div>

            <!-- Filters Setting -->
            <div id="settings-job_filters" class="settings_panel" style="display: none;">
                <?php
                /**
                 * Action -> Add new sub-section before job filters settings .  
                 * 
                 * @since 2.2.0 
                 */
                do_action('sjb_job_filters_settings_before');

                if (( isset($_POST['job_filters']) && '' !== $_POST['job_filters'] ) || isset($_POST['empty_filter'])) {

                    // Empty  checkboxes status
                    $category_status = 0;
                    $jobtype_status = 0;
                    $location_status = 0;
                    $search_bar_status = 0;

                    // Update checkbox status 
                    if (isset($_POST['job_filters']) && '' != $_POST['job_filters']) {
                        foreach ($_POST['job_filters'] as $filter) {
                            if ('category' === $filter) {
                                update_option('job_board_category_filter', 'yes');
                                $category_status = 1;
                            } elseif ('jobtype' === $filter) {
                                update_option('job_board_jobtype_filter', 'yes');
                                $jobtype_status = 1;
                            } elseif ('location' === $filter) {
                                update_option('job_board_location_filter', 'yes');
                                $location_status = 1;
                            } elseif ('search_bar' === $filter) {
                                update_option('job_board_search_bar', 'yes');
                                $search_bar_status = 1;
                            }
                        }
                    }

                    // Setting filter's value to 'no' that are not set
                    if (0 === $category_status)
                        update_option('job_board_category_filter', 'no');
                    if (0 === $jobtype_status)
                        update_option('job_board_jobtype_filter', 'no');
                    if (0 === $location_status)
                        update_option('job_board_location_filter', 'no');
                    if (0 === $search_bar_status)
                        update_option('job_board_search_bar', 'no');
                }
                ?>
                <h4><?php _e('Select filters that display on front-end', 'simple-job-board'); ?></h4>
                <form method="post" id="job_filters_form">
                    <div class="app_form_fields">

                        <?php
                        /**
                         * Action -> Add new fields at the start of job filters section.  
                         * 
                         * @since 2.2.0 
                         */
                        do_action('sjb_job_filters_settings_start');
                        ?> 

                        <p>
                            <input type="checkbox" name="job_filters[]" value="category"  <?php if ('yes' === get_option('job_board_category_filter')) echo 'checked="checked"'; ?> />
                            <label><?php echo __('Enable the Job Category Filter', 'simple-job-board'); ?></label>
                            <input type='hidden' name="empty_filter[]" value="empty_category" >
                        </p>
                        <p>
                            <input type="checkbox" name="job_filters[]" value="jobtype" <?php if ('yes' === get_option('job_board_jobtype_filter')) echo 'checked="checked"'; ?>/>
                            <label><?php echo __('Enable the Job Type Filter', 'simple-job-board'); ?></label>
                            <input type='hidden' name="empty_filter[]" value="empty_jobtype" >
                        </p>
                        <p>
                            <input type="checkbox" name="job_filters[]" value="location" <?php if ('yes' === get_option('job_board_location_filter')) echo 'checked="checked"'; ?>/>
                            <label><?php echo __('Enable the Job Location Filter', 'simple-job-board'); ?></label>
                            <input type='hidden' name="empty_filter[]" value="empty_location" >
                        </p>                       
                        <p>
                            <input type="checkbox" name="job_filters[]" value="search_bar" <?php if ('yes' === get_option('job_board_search_bar')) echo 'checked="checked"'; ?>/>
                            <label><?php echo __('Enable the Search Bar', 'simple-job-board'); ?></label>
                            <input type='hidden' name="empty_filter[]" value="empty_search_bar" >
                        </p>

                        <?php
                        /**
                         * Action -> Add new fields at the end of job filters section.  
                         * 
                         * @since 2.2.0 
                         */
                        do_action('sjb_job_filters_settings_end');
                        ?>

                    </div>
                    <input type="hidden" value="1" name="admin_notices" />
                    <input type="submit" name="jobfilter_submit" id="job_filters" class="button button-primary" value="<?php echo __('Save Changes', 'simple-job-board'); ?>" />
                </form>
                <?php
                /**
                 * Action -> Add new sub-section after job filters settings .  
                 * 
                 * @since 2.2.0 
                 */
                do_action('sjb_job_filters_settings_after');
                ?>
            </div>

            <!-- Notification -->
            <div id="settings-email_notifications" class="settings_panel" style="display: none;">
                <?php
                /**
                 * Action -> Add new sub-section before notifications settings .  
                 * 
                 * @since 2.2.0 
                 */
                do_action('sjb_notifications_settings_before');

                $hr_email = ( false !== get_option('settings_hr_email') ) ? get_option('settings_hr_email') : '';
                if ((isset($_POST['email_notification']) && '' != $_POST['email_notification']) || isset($_POST['empty_form_check'])) {

                    // Empty  checkboxes status
                    $hr_email_status = 'no';
                    $admin_email_status = 'no';
                    $applicant_email_status = 'no';
                    if (isset($_POST['email_notification'])) {
                        foreach ($_POST['email_notification'] as $value) {
                            if ('hr_email' === $value) {
                                update_option('job_board_hr_notification', 'yes');
                                $hr_email_status = 'yes';
                            } elseif ('admin_email' === $value) {
                                update_option('job_board_admin_notification', 'yes');
                                $admin_email_status = 'yes';
                            } elseif ('applicant_email' === $value) {
                                update_option('job_board_applicant_notification', 'yes');
                                $applicant_email_status = 'yes';
                            }
                        }
                    }

                    if (isset($_POST['hr_email'])) {
                        ( false !== get_option('settings_hr_email') ) ? update_option('settings_hr_email', $_POST['hr_email']) : add_option('settings_hr_email', $_POST['hr_email'], '');
                        $hr_email = get_option('settings_hr_email');
                    }

                    // Setting filter's value to 'no' that are not set
                    if ('no' === $hr_email_status)
                        update_option('job_board_hr_notification', 'no');
                    if ('no' === $admin_email_status)
                        update_option('job_board_admin_notification', 'no');
                    if ('no' === $applicant_email_status)
                        update_option('job_board_applicant_notification', 'no');
                }
                ?>
                <h4><?php _e('Enable Email Notification', 'simple-job-board'); ?></h4>
                <form method="post" id="email_notification_form">
                    <div class="app_form_fields">
                        <table>

                            <?php
                            /**
                             * Action -> Add new fields at the start of notification section.  
                             * 
                             * @since 2.2.0 
                             */
                            do_action('sjb_email_notifications_settings_start');
                            ?> 

                            <tr>
                                <th><?php echo __('HR Email:', 'simple-job-board'); ?><input type="hidden" name="empty_form_check" value="empty_form_submitted"></th>
                                <td><input type="email" name="hr_email" value="<?php echo $hr_email ?>" size="30"></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td><input type="checkbox" name="email_notification[]" value="hr_email" <?php if ('yes' === get_option('job_board_hr_notification')) echo 'checked="checked"'; ?>/><?php echo __('Enable the HR email notification', 'simple-job-board'); ?><br /><br /></td>
                            </tr>
                            <tr>
                                <th><?php echo __('Admin Email:', 'simple-job-board'); ?></th>
                                <td><input type="text" value="<?php echo get_option('admin_email'); ?>" size="30" readonly></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td><input type="checkbox" name="email_notification[]" value="admin_email" <?php if ('yes' === get_option('job_board_admin_notification')) echo 'checked="checked"'; ?> /><?php echo __('Enable the Admin email notification', 'simple-job-board'); ?></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td><input type="checkbox" name="email_notification[]" value="applicant_email" <?php if ('yes' === get_option('job_board_applicant_notification')) echo 'checked="checked"'; ?>/><?php echo __('Enable the Applicant email notification', 'simple-job-board'); ?></td>
                            </tr>

                            <?php
                            /**
                             * Action -> Add new fields at the end of notification section.  
                             * 
                             * @since 2.2.0 
                             */
                            do_action('sjb_notifications_settings_end');
                            ?> 

                        </table>
                    </div>
                    <?php
                    /**
                     * Action -> Add new sub-section after notifications settings .  
                     * 
                     * @since 2.2.0 
                     */
                    do_action('sjb_notifications_settings_after');
                    ?>
                    <input type="hidden" value="1" name="admin_notices" />
                    <input type="submit" name="job_email_notification" id="job_email_notification" class="button button-primary" value="<?php echo __('Save Changes', 'simple-job-board'); ?>" />
                </form>
            </div>

            <!-- Upload File Extensions -->
            <div id="settings-upload_file_ext" class="settings_panel" style="display: none;">
                <?php
                /**
                 * Action -> Add new sub-section before file upload settings .  
                 * 
                 * @since 2.2.0 
                 */
                do_action('sjb_file_upload_settings_before');

                // Save File Extension on Form Submission
                if ((isset($_POST['file_extensions']) && '' != $_POST['file_extensions']) || isset($_POST['empty_file_extensions'])) {

                    // Empty Checkboxes Status
                    $file_extension = 'no';
                    $files_anti_hotlinking = 'no';
                    if (isset($_POST['file_extensions'])) {
                        $file_extensions = $_POST['file_extensions'];

                        // Save Setting Extentions to WordPress Options 
                        if (FALSE !== get_option('job_board_upload_file_ext')) {
                            update_option('job_board_upload_file_ext', $file_extensions);
                        } else {

                            // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
                            $deprecated = NULL;
                            $autoload = 'no';
                            add_option('job_board_upload_file_ext', $file_extensions, $deprecated, $autoload);
                        }
                    }

                    if (isset($_POST['all_file_extensions'])) {
                        update_option('job_board_all_extensions_check', 'yes');
                        $file_extension = 'yes';
                    }

                    if (isset($_POST['files_hotlinking'])) {
                        update_option('job_board_anti_hotlinking', 'yes');
                        $files_anti_hotlinking = 'yes';
                        $sjbrObj = new Simple_Job_Board_Rewrite();
                        $sjbrObj->job_board_rewrite();
                    }

                    if ('no' === $file_extension)
                        update_option('job_board_all_extensions_check', 'no');

                    if ('no' === $files_anti_hotlinking) {
                        update_option('job_board_anti_hotlinking', 'no');
                        $sjbrObj = new Simple_Job_Board_Rewrite();
                        $sjbrObj->job_board_rewrite();
                    }
                }
                ?>

                <form method="post" id="upload-file-form">
                    <h4><?php echo __('Upload File Extensions', 'simple-job-board'); ?></h4>
                    <div class="app_form_fields">

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
                        <p><?php echo __('Press and hold down the Ctrl key to select multiple extensions.', 'simple-job-board'); ?></p>
                        <p>
                            <input type="checkbox" name="all_file_extensions" id="all-file-ext" value="all extension"  <?php if ('yes' === get_option('job_board_all_extensions_check')) echo 'checked="checked"'; ?> />
                            <label><?php echo __('Enable all extensions', 'simple-job-board'); ?></label>
                            <input type='hidden' name="empty_file_extensions" value="empty_file_extensions" >
                        </p>

                        <p>
                            <input type="checkbox" name="files_hotlinking" id="files-hotlinking" value="files hotlinking"  <?php if ('yes' === get_option('job_board_anti_hotlinking')) echo 'checked="checked"'; ?> />
                            <label><?php echo __('Enable Uploaded Files Anti-Hotlinking', 'simple-job-board'); ?></label>
                        </p>

                        <?php
                        /**
                         * Action -> Add new fields at the end of upload section.  
                         * 
                         * @since 2.2.0 
                         */
                        do_action('sjb_file_upload_settings_end');
                        ?>

                    </div>
                    <input type="hidden" value="1" name="admin_notices" />
                    <input type="submit" name="upload_file_form_submit" id="upload-file-form-submit" class="button button-primary" value="<?php echo __('Save Changes', 'simple-job-board'); ?>" />
                </form>
            </div>

            <?php
            /**
             * Action -> Display Settings Section After Last Tab.  
             * 
             * @since 2.2.0 
             */
            do_action('simple_job_board_settings_after');
            ?>
            <div id="sjb-presstigers-logo"><a href="http://www.presstigers.com/" target="_blank"><img src="<?php echo SIMPLE_JOB_BOARD_PLUGIN_URL .'/admin/images/powerByIcon.png' ?>" alt="Powered by PressTigers"/></a></div>
        </div>
        
        <?php
    }

    /**
     * Merge Arrays
     * @since    1.0.0
     * 
     * @param    string    $job_application_field_name    Applicantion Form Field Name 
     * @param    string    $job_application_field_type    Applicantion Form Field Type 
     * @param    string    $job_application_field_option  Applicantion Form Field Options     * 
     */
    public function sjb_mergeArrays($job_application_field_name, $job_application_field_type, $job_application_field_option, $job_application_field_optional) {
        $result = array();

        foreach ($job_application_field_name as $key => $name) {
            $result = array_merge($result, array(
                $name => array(
                    'type' => $job_application_field_type[$key],
                    'option' => $job_application_field_option[$key],
                    'optional' => $job_application_field_optional[$key],
                )
            ));
        }

        return $result;
    }

    /**
     * Settings Save Notification
     * @since    1.0.0
     *    
     * @return void
     */
    public function settings_notification() {
        if (isset($_POST['admin_notices'])) {
            ?>
            <div class="updated">
                <p><?php echo apply_filters('sjb_saved_settings_notification', __('Settings saved.', 'simple-job-board')); ?></p>
            </div>
            <?php
        }
    }

}

new Simple_Job_Board_Setup();