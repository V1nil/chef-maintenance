<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Simple_Job_Board_Settings_Appearance Class
 * 
 * This is used to define job board appearance settings.
 *
 * This file contains the frontend appearance settings for job listing content, 
 * listing view, job listing and job detail page typography. User can change the
 * job listing layout and content.
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       2.2.3
 * 
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/admin/settings
 * @author      PressTigers <support@presstigers.com>
 */

class Simple_Job_Board_Settings_Appearance {

    /**
     * Initialize the class and set its properties.
     *
     * @since   2.2.3
     */
    public function __construct() {

        // Filter -> Add Settings Appearance Tab
        add_filter('sjb_settings_tab_menus', array($this, 'add_settings_tab'), 30);

        // Action -> Add Settings Appearance Section 
        add_action('sjb_settings_tab_section', array($this, 'add_settings_section'), 30);

        // Action -> Save Settings Appearance Section 
        add_action('sjb_save_setting_sections', array($this, 'save_settings_section'));
    }

    /**
     * Add Settings Appearance Tab.
     *
     * @since    2.2.3
     * 
     * @param    array  $tabs  Settings Tab
     * @return   array  $tabs  Merge array of Settings Tab with Appearance Tab.
     */
    public function add_settings_tab($tabs) {
        
        $tabs['appearance'] = __( 'Appearance', 'simple-job-board' );
        return $tabs;
    }

    /**
     * Add Settings Appearance Section.
     *
     * @since    2.2.3
     */
    public function add_settings_section() {
        
        ?>
        <!-- Appearance -->
        <div id="settings-appearance" class="sjb-admin-settings" style="display: none;" >
            <form method="post" id="appearance_options_form">
                <?php
                // Get Appearance Options
                $container_class = get_option('job_board_container_class') ? get_option('job_board_container_class') : 'container sjb-container';

                // Get Container Id
                if (get_option('job_board_container_id')) {
                    $container_ids = explode(" ", get_option('job_board_container_id'));
                    $container_id = $container_ids[0];
                } else {
                    $container_id = 'container';
                }

                // Select Job Listing View                   
                $logo_detail = $without_logo_detail = $without_logo = $without_detail = $list_view = $grid_view = $jobpost_logo = $jobpost_without_logo = '';
                
                if ($list_view = get_option('job_board_listing_view')) {
                    if ('list-view' === $list_view)
                        $list_view = 'checked';

                    if ('grid-view' === $list_view)
                        $grid_view = 'checked';
                } else {
                    // Default List View
                    $list_view = 'checked';
                }
                
                // Select job post content with or without company logo & job detail
                if ( $jobpost_content = get_option('job_board_jobpost_content')) {
                    if ('with-logo' === $jobpost_content)
                        $jobpost_logo = 'checked';

                    if ('without-logo' === $jobpost_content)
                        $jobpost_without_logo = 'checked';
                }  else {
                    $jobpost_logo = 'checked';
                }              

                // Select job listing with or without company logo & job detail
                if ($list_contents = get_option('job_board_listing')) {
                    if ('logo-detail' === $list_contents)
                        $logo_detail = 'checked';

                    if ('without-logo-detail' === $list_contents)
                        $without_logo_detail = 'checked';

                    if ('without-logo' === $list_contents)
                        $without_logo = 'checked';

                    if ('without-detail' === $list_contents)
                        $without_detail = 'checked';
                } else {
                    $logo_detail = 'checked';
                }

                // Get Settings Job Board Typography
                if (get_option('job_board_typography')) {
                    $job_board_typography = get_option('job_board_typography');
                }
                
                /**
                 * Action -> Add new section before content wrapper styling.  
                 * 
                 * @since 2.2.2 
                 */
                do_action('sjb_content_wrapper_styling_before');
                ?>
                
                <h4 class="first"><?php _e('Content Wrapper Styling', 'simple-job-board'); ?></h4>
                <div class="sjb-section">
                    <div class="sjb-content">
                        
                        <?php
                        /**
                         * Action -> Add new fields at start of of Content Wrapper.  
                         * 
                         * @since 2.2.2 
                         */
                        do_action('sjb_content_wrapper_styling_start');
                        ?> 
                        <div class="sjb-form-group">
                            <label><?php _e('Job Board Container Id:', 'simple-job-board'); ?></label>
                            <input type="text" name="container_id" value="<?php echo $container_id; ?>" size="30" />
                        </div>
                        <div class="sjb-form-group">
                            <label><?php _e('Job Board Container Class:', 'simple-job-board'); ?></label>
                            <input type="text" name="container_class" value="<?php echo $container_class; ?>" size="30" >
                        </div>
                        <p><?php _e('Add classes seprated by space or comma e.g. container sjb-container or container,sjb-container', 'simple-job-board'); ?></p>
                        
                        <?php
                        /**
                         * Action -> Add new fields at the end of Content Wrapper.  
                         * 
                         * @since 2.2.2 
                         */
                        do_action('sjb_content_wrapper_styling_end');
                        ?>
                    </div>
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
                <div class="sjb-section">
                    <div class="sjb-content">
                        
                        <?php
                        /**
                         * Action -> Add new fields at start of job listing view.  
                         * 
                         * @since   2.2.0
                         */
                        do_action('sjb_listing_view_start');
                        ?>
                        <div class="sjb-form-group">
                            <input type="radio" name="job_listing_views_settings" value="list-view" id="list-view" <?php echo $list_view; ?> />
                            <label><?php _e('Display job listing in list view', 'simple-job-board'); ?></label>
                        </div>						
                        <div class="sjb-form-group">
                            <input type="radio" name="job_listing_views_settings" value="grid-view" id="grid-view" <?php echo $grid_view; ?> />
                            <label><?php _e('Display job listing in grid view', 'simple-job-board'); ?></label>
                        </div>
                        
                        <?php
                        /**
                         * Action -> Add new fields at end of job listing view.  
                         * 
                         * @since   2.2.0
                         */
                        do_action('sjb_listing_view_end');
                        ?>
                    </div>
                </div>
                
                <?php
                /**
                 * Action -> Add new section after appearance listing view .  
                 * 
                 * @since   2.2.0 
                 */
                do_action('sjb_appearance_listing_view_after');
                ?>
                
                <h4><?php echo apply_filters('sjb_job_listing_content_title', __('Job Listing Contents', 'simple-job-board')); ?></h4>
                <div class="sjb-section">
                    <div class="sjb-content">
                        
                        <?php
                        /**
                         * Action -> Add new fields at start of job content.  
                         * 
                         * @since   2.2.0 
                         */
                        do_action('sjb_listing_content_start');
                        ?>   
                        <div class="sjb-form-group">
                            <input type="radio" name="job_listing_content_settings" value="logo-detail" id="logo-detail" <?php echo $logo_detail; ?> />
                            <label><?php _e('Display job listing with company logo and detail', 'simple-job-board'); ?></label>
                        </div>
                        <div class="sjb-form-group">
                            <input type="radio" name="job_listing_content_settings" value="without-logo-detail" id="without-logo-detail" <?php echo $without_logo_detail; ?> /> 
                            <label><?php _e('Display job listing without company logo and detail', 'simple-job-board'); ?></label>
                        </div>
                        <div class="sjb-form-group">
                            <input type="radio" name="job_listing_content_settings" value="without-logo" id="without-logo" <?php echo $without_logo; ?> />
                            <label><?php _e('Display job listing without company logo', 'simple-job-board'); ?></label>
                        </div>
                        <div class="sjb-form-group">
                            <input type="radio" name="job_listing_content_settings" value="without-detail" id="without-detail" <?php echo $without_detail; ?> />
                            <label><?php _e('Display job listing without company detail', 'simple-job-board'); ?></label>
                        </div>
                        
                        <?php
                        /**
                         * Action -> Add new fields at the end of job content.  
                         * 
                         * @since   2.2.0 
                         */
                        do_action('sjb_listing_content_end');
                        ?>
                    </div>
                </div>
                
                <?php
                /**
                 * Action -> Add new section after appearance listing content.  
                 * 
                 * @since   2.2.0 
                 */
                do_action('sjb_appearance_listing_content_after');
                ?>
                
                <h4><?php echo apply_filters('sjb_job_post_content_title', __('Job Post Content', 'simple-job-board')); ?></h4>
                <div class="sjb-section">
                    <div class="sjb-content">
                        
                        <?php
                        /**
                         * Action -> Add new fields at start of job content.  
                         * 
                         * @since   2.3.2 
                         */
                        do_action('sjb_job_post_content_start');
                        ?>   
                        <div class="sjb-form-group">
                            <input type="radio" name="job_post_content_settings" value="with-logo" id="logo-detail" <?php echo $jobpost_logo; ?> />
                            <label><?php _e('Display job post with company logo', 'simple-job-board'); ?></label>
                        </div>
                        <div class="sjb-form-group">
                            <input type="radio" name="job_post_content_settings" value="without-logo" id="without-logo-detail" <?php echo $jobpost_without_logo; ?> /> 
                            <label><?php _e('Display job post without company logo', 'simple-job-board'); ?></label>
                        </div>
                        
                        <?php
                        /**
                         * Action -> Add new fields at the end of job content.  
                         * 
                         * @since   2.3.2
                         */
                        do_action('sjb_job_post_content_end');
                        ?>
                    </div>
                </div>
                
                <?php
                /**
                 * Action -> Add new section after appearance listing content.  
                 * 
                 * @since   2.3.2 
                 */
                do_action('sjb_appearance_listing_content_after');
                ?>
                
                <h4><?php echo apply_filters( 'sjb_job_listing_typography_title', __( 'Job Listing Page Typography', 'simple-job-board' ) ); ?></h4>
                <div class="sjb-section">
                    <?php
                    /**
                     * Action -> Add new fields at start of job listing typography section.  
                     * 
                     * @since   2.2.0 
                     */
                    do_action('sjb_job_listing_page_typography_start');
                    ?>
                    <ul class="sjb-typography">
                        <li class="sjb-typography-label">
                            <label><?php _e('Job filters background color', 'simple-job-board'); ?></label>
                        </li>
                        <li class="sjb-typography-input">
                            <input type="text" value="<?php echo isset($job_board_typography['filters_background_color']) ? $job_board_typography['filters_background_color'] : '#f2f2f2'; ?>" name="job_board_typography[filters_background_color]" class="sjb-color-picker" data-default-color="#f2f2f2" />
                        </li>
                    </ul>
                    <ul class="sjb-typography">
                        <li class="sjb-typography-label">
                            <label><?php _e('Job filters button background color', 'simple-job-board'); ?></label>
                        </li>
                        <li class="sjb-typography-input">
                            <input type="text" value="<?php echo isset($job_board_typography['filters_button_background_color']) ? $job_board_typography['filters_button_background_color'] : '#164e91'; ?>" name="job_board_typography[filters_button_background_color]" class="sjb-color-picker" data-default-color="#164e91" />
                        </li>
                    </ul>
                    <ul class="sjb-typography">
                        <li class="sjb-typography-label">
                            <label><?php _e('Job listing title color', 'simple-job-board'); ?></label>
                        </li>
                        <li class="sjb-typography-input">
                            <input type="text" value="<?php echo isset($job_board_typography['job_listing_title_color']) ? $job_board_typography['job_listing_title_color'] : '#3b3a3c'; ?>" name="job_board_typography[job_listing_title_color]" class="sjb-color-picker" data-default-color="#3b3a3c" />
                        </li>
                    </ul>
                    <ul class="sjb-typography">
                        <li class="sjb-typography-label">
                            <label><?php _e('Font Awesome icon color', 'simple-job-board'); ?></label>
                        </li>
                        <li class="sjb-typography-input">
                            <input type="text" value="<?php echo isset($job_board_typography['fontawesome_icon_color']) ? $job_board_typography['fontawesome_icon_color'] : '#3b3a3c'; ?>" name="job_board_typography[fontawesome_icon_color]" class="sjb-color-picker" data-default-color="#3b3a3c" />
                        </li>
                    </ul>
                    <ul class="sjb-typography">
                        <li class="sjb-typography-label">
                            <label><?php _e('Font Awesome text color', 'simple-job-board'); ?></label>
                        </li>
                        <li class="sjb-typography-input">
                            <input type="text" value="<?php echo isset($job_board_typography['fontawesome_text_color']) ? $job_board_typography['fontawesome_text_color'] : '#164e91'; ?>" name="job_board_typography[fontawesome_text_color]" class="sjb-color-picker" data-default-color="#164e91" />
                        </li>
                    </ul>                        
                    <ul class="sjb-typography">
                        <li class="sjb-typography-label">
                            <label><?php _e('Pagination text color', 'simple-job-board'); ?></label>
                        </li>
                        <li class="sjb-typography-input">
                            <input type="text" value="<?php echo isset($job_board_typography['pagination_text_color']) ? $job_board_typography['pagination_text_color'] : '#fff'; ?>" name="job_board_typography[pagination_text_color]" class="sjb-color-picker" data-default-color="#fff" />
                        </li>
                    </ul>
                    <ul class="sjb-typography">
                        <li class="sjb-typography-label">
                            <label><?php _e('Pagination background color', 'simple-job-board'); ?></label>
                        </li>
                        <li class="sjb-typography-input">
                            <input type="text" value="<?php echo isset($job_board_typography['pagination_background_color']) ? $job_board_typography['pagination_background_color'] : '#164e91'; ?>" name="job_board_typography[pagination_background_color]" class="sjb-color-picker" data-default-color="#164e91" />
                        </li>
                    </ul>
                    
                    <?php
                    /**
                     * Action -> Add new fields at the end of job listing page typography section.  
                     * 
                     * @since   2.2.0 
                     */
                    do_action('sjb_job_listing_page_typography_end');
                    ?> 
                </div>
                
                <?php
                /**
                 * Action -> Add new section after appearance listing typography content.  
                 * 
                 * @since   2.3.2 
                 */
                do_action('sjb_appearance_listing_typography_after');
                ?>
                
                <h4><?php echo apply_filters('sjb_job_detail_page_typography_title', __('Job Detail Page Typography', 'simple-job-board')); ?></h4>
                <div class="sjb-section">
                    
                    <?php
                    /**
                     * Action -> Add new fields at start of job detail page typography section.  
                     * 
                     * @since   2.2.0 
                     */
                    do_action('sjb_job_detail_page_typography_start');
                    ?>
                    <ul class="sjb-typography">
                        <li class="sjb-typography-label">
                            <label><?php _e('Job title color', 'simple-job-board'); ?></label>
                        </li>
                        <li class="sjb-typography-input">
                            <input type="text" value="<?php echo isset($job_board_typography['job_title_color']) ? $job_board_typography['job_title_color'] : '#164e91'; ?>" name="job_board_typography[job_title_color]" class="sjb-color-picker" data-default-color="#164e91" />
                        </li>
                    </ul>
                    <ul class="sjb-typography">
                        <li class="sjb-typography-label">
                            <label><?php _e('Headings color', 'simple-job-board'); ?></label>
                        </li>
                        <li class="sjb-typography-input">
                            <input type="text" value="<?php echo isset($job_board_typography['headings_color']) ? $job_board_typography['headings_color'] : '#164e91'; ?>" name="job_board_typography[headings_color]" class="sjb-color-picker" data-default-color="#164e91" />
                        </li>
                    </ul>
                    <ul class="sjb-typography">
                        <li class="sjb-typography-label">
                            <label><?php _e('Job submit button text color', 'simple-job-board'); ?></label>
                        </li>
                        <li class="sjb-typography-input">
                            <input type="text" value="<?php echo isset($job_board_typography['job_submit_button_text_color']) ? $job_board_typography['job_submit_button_text_color'] : '#fff'; ?>" name="job_board_typography[job_submit_button_text_color]" class="sjb-color-picker" data-default-color="#fff" />
                        </li>
                    </ul>
                    <ul class="sjb-typography">
                        <li class="sjb-typography-label">
                            <label><?php _e('Job submit button background color', 'simple-job-board'); ?></label>
                        </li>
                        <li class="sjb-typography-input">
                            <input type="text" value="<?php echo isset($job_board_typography['job_submit_button_background_color']) ? $job_board_typography['job_submit_button_background_color'] : '#164e91'; ?>" name="job_board_typography[job_submit_button_background_color]" class="sjb-color-picker" data-default-color="#164e91" />
                        </li>
                    </ul>
                    
                    <?php
                    /**
                     * Action -> Add new fields at the end of job detail page typography section.  
                     * 
                     * @since   2.2.0 
                     */
                    do_action('sjb_job_detail_page_typography_end');
                    ?> 
                </div>
                
                <?php
                /**
                 * Action -> Add new section after detail page typography.  
                 * 
                 * @since   2.2.0 
                 */
                do_action('sjb_appearance_detail_page_typography_after');
                ?> 
                
                <input type="hidden" value="1" name="admin_notices" />
                <input type="submit" name="job_general_options" id="job_general_options" class="button button-primary" value="<?php echo __('Save Changes', 'simple-job-board'); ?>" />
            </form>
        </div>
        <?php
    }

    /**
     * Save Settings Appearance Section.
     * 
     * This function save the settings for job listing views, content and typography.
     *
     * @since   2.2.3
     */
    public function save_settings_section() {
        
        // Save Job Listing View
        if ( !empty( $_POST['job_listing_views_settings'] ) ) {
            update_option('job_board_listing_view', esc_attr($_POST['job_listing_views_settings']));
        }

        // Save Job Listing Content
        if ( !empty($_POST['job_listing_content_settings'] ) ) {
            update_option('job_board_listing', esc_attr($_POST['job_listing_content_settings']));
        }
        
        // Save Job Post Content
        if ( !empty($_POST['job_post_content_settings'] ) ) {
            update_option('job_board_jobpost_content', esc_attr($_POST['job_post_content_settings']));
        }

        // Save Content Wrapper Styling
        if ( !empty( $_POST['container_class'] ) || !empty( $_POST['container_id'] ) ) {

            // Save Container Class
            if ( !empty( $_POST['container_class'] ) ) {
                update_option('job_board_container_class', esc_attr($_POST['container_class']));
            }

            // Save Container Id
            if ( !empty( $_POST['container_id'] ) ) {
                update_option('job_board_container_id', esc_attr($_POST['container_id']));
            }
        }

        // Save Job Baord Typography
        if ( !empty( $_POST['job_board_typography'] ) ) {
            update_option('job_board_typography', $_POST['job_board_typography']);
        }
    }
}