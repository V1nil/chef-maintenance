<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Simple_Job_Board_Meta_Box_Job_Application Class
 * 
 * This meta box is designed to create user defined application form that is 
 * for indvidual job post.
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       2.2.3
 * @since       2.3.2   Added Application Form Labels' Editing Feature.
 * 
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/admin/partials/meta-boxes
 * @author      PressTigers <support@presstigers.com>
 */

class Simple_Job_Board_Meta_Box_Job_Application {

    /**
     * Meta box for Job Application Form.
     * 
     * @since   2.2.3
     */
    public static function sjb_meta_box_output($post) {
        
        global $jobfields;

        // Add a nonce field so we can check for it later.
        wp_nonce_field('sjb_jobpost_meta_box', 'jobpost_meta_box_nonce');
         
        /**
         * Use get_post_meta() to retrieve an existing value
         */
        ?>

        <div class="meta_option_panel jobpost_fields">
            <ul id="app_form_fields">
                <?php
                
                // Form Field Types
                $field_types = array(
                    'text'      => __('Text Field', 'simple-job-board'),
                    'text_area' => __('Text Area', 'simple-job-board'),
                    'email'     => __('Email', 'simple-job-board'),
                    'phone'     => __('Phone', 'simple-job-board'),
                    'date'      => __('Date', 'simple-job-board'),
                    'checkbox'  => __('Check Box', 'simple-job-board'),
                    'dropdown'  => __('Drop Down', 'simple-job-board'),
                    'radio'     => __('Radio', 'simple-job-board'),
                );
               
                /**
                 * Filter -> Modify Form Field Types
                 * 
                 * @since   2.3.0
                 */
                $field_types = apply_filters( 'sjb_form_field_types', $field_types );

                $keys = get_post_custom_keys($post->ID);

                // Getting setting page saved options
                $jobapp_settings_options = unserialize(get_option('jobapp_settings_options'));

                //check Array differnce when $keys is not NULL
                if (NULL == $keys) {

                    // "Add New" job Check
                    $jobapp_removed_options = $jobapp_settings_options;
                } elseif (NULL == $jobapp_settings_options) {
                    $jobapp_removed_options = '';
                } else {
                    // Remove the same option from post meta and options
                    $jobapp_removed_options = array_diff_key($jobapp_settings_options, get_post_meta($post->ID));
                }
                
                // Display Job Application Meta
                if (NULL != $keys):
                    foreach ($keys as $key):
                        if ( substr($key, 0, 7 ) == 'jobapp_' ):
                            $val = get_post_meta($post->ID, $key, TRUE);
                            $val = unserialize($val);
                            $fields = NULL;
                            
                            foreach ( $field_types as $field_key => $field_val ) {
                                if ($val['type'] == $field_key)
                                    $fields .= '<option value="' . $field_key . '" selected>' . $field_val . '</option>';
                                else
                                    $fields .= '<option value="' . $field_key . '" >' . $field_val . '</option>';
                            }
                            
                            /**
                             * New Label Index Insertion:
                             * 
                             * - Addition of new index "label"
                             * - Data Legacy Checking  
                             */
                            $label = isset( $val['label'] ) ? $val['label'] : __( ucwords(str_replace('_', ' ', substr($key, 7))), 'simple-job-board' );                            
                            
                            echo '<li class="' . $key . '">'
                            . '<label class="sjb-editable-label" for="">' . $label . '</label>'
                            . '<input type="hidden" name="' . $key . '[label]" value="' . $label . '"/>'
                            . '<select class="jobapp_field_type" name="' . $key . '[type]">'
                            . $fields
                            . '</select>';
                            
                            // Show Options for Dropdown, Checkbox & Radio Buttons
                            if ( 'checkbox' === $val['type'] || 'dropdown' === $val['type'] || 'radio' === $val['type'] ):
                                echo '<input type="text" name="' . $key . '[options]" class="jobapp-field-options" value="' . $val['options'] . '" placeholder="Option1, option2, option3" />';
                            else:
                                echo '<input type="text" name="' . $key . '[options]" class="jobapp-field-options" placeholder="Option1, option2, option3" style="display:none;"  />&nbsp;';
                            endif;

                            // Set Fields as Optional or Required
                            $is_required =  isset( $val['optional'] ) ? $val['optional'] : 'checked'; 
                            echo '<input type="checkbox" class="jobapp-required-field" ' . $is_required . ' />' . __('Required', 'simple-job-board') . ' &nbsp; ';
                            echo '<input type="hidden"   class="jobapp-optional-field" name="' . $key . '[optional]" value="' . $is_required . '"/>';
                            
                            // Delete Button
                            $button = '<div class="button removeField">' . __('Delete', 'simple-job-board') . '</div>';
                            echo ' &nbsp; ' . $button . '</li>';
                        endif;
                    endforeach;
                endif;

                /**
                 * Settings Job Application Form        
                 */
                if ( NULL != $jobapp_removed_options ):
                    if ( !isset( $_GET['action'] ) ):
                        foreach ($jobapp_removed_options as $jobapp_field_name => $val):
                            if (isset($val['type']) && isset($val['option'])):
                                if (substr($jobapp_field_name, 0, 7) == 'jobapp_'):
                                    $fields = NULL;
                                    foreach ($field_types as $field_key => $field_val) {
                                        if ($val['type'] == $field_key)
                                            $fields .= '<option value="' . $field_key . '" selected>' . $field_val . '</option>';
                                        else
                                            $fields .= '<option value="' . $field_key . '" >' . $field_val . '</option>';
                                    }
                                    
                                    /**
                                     * Label Insertion:
                                     * 
                                     * - Addition of new Field Labels
                                     * - Data Legacy Checking  
                                     */
                                    $label = isset( $val['label'] ) ? $val['label'] : ucwords(str_replace('_', ' ', substr($key, 7)));
                                    
                                    echo '<li class="' . $jobapp_field_name . '"><label class="sjb-editable-label" for="">' . $label . '</label><select class="jobapp_field_type" name="' . $jobapp_field_name . '[type]">' . $fields . '</select>';
                                    
                                    // Show Options for Dropdown, Checkbox & Radio Buttons
                                    if ( 'checkbox' === $val['type'] || 'dropdown' === $val['type'] || 'radio' === $val['type'] ):
                                        echo '<input type="text" name="' . $jobapp_field_name . '[options]" class="jobapp-field-options" value="' . $val['option'] . '"  placeholder="Option1, option2, option3" />';
                                    else:
                                        echo '<input type="text" name="' . $jobapp_field_name . '[options]" class="jobapp-field-options" placeholder="Option1, option2, option3" style="display:none;"  />';

                                    endif;
                                    
                                    // Set Fields as Optional or Required
                                    $is_required =  isset( $val['optional'] ) ? $val['optional'] : 'checked'; 
                                    echo '<input type="checkbox" class="jobapp-required-field" ' . $is_required . ' />' . __('Required', 'simple-job-board') . '&nbsp; ';
                                    echo '<input type="hidden"   class="jobapp-optional-field" name="' . $jobapp_field_name . '[optional]" value="' . $is_required . '"/>';
                                    
                                    echo ' &nbsp;<div class="button removeField">' . __('Delete', 'simple-job-board') . '</div></li>';
                                endif;
                            endif;
                        endforeach;
                    endif;
                endif;
                ?>
            </ul>
        </div>
        <div class="clearfix clear"></div>
        
        <!-- Add Job Application Form -->
        <table id="jobapp_form_fields" class="alignleft">
            <thead>
                <tr>
                    <th><label for="metakeyselect"><?php _e('Field', 'simple-job-board'); ?></label></th>
                    <th><label for="metavalue"><?php _e('Type', 'simple-job-board'); ?></label></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="left" id="newmetaleft"><input type="text" id="jobapp_name" /></td>
                    <td>
                        <select id="jobapp_field_type">
                            <?php
                            foreach ($field_types as $key => $val):
                                echo '<option value="' . $key . '" class="' . $key . '">' . $val . '</option>';
                            endforeach;
                            ?>
                        </select>
                        <input id="jobapp_field_options" class="jobapp_field_type" type="text" style="display: none;" placeholder="Option1, Option2, Option3" >
                    </td>
                    <td><input type="checkbox" id="jobapp_required_field" checked="checked"/><?php _e('Required', 'simple-job-board'); ?></td>
                    <td><div class="button" id="addField"><?php _e('Add Field', 'simple-job-board'); ?></div></td>
                </tr>
            </tbody>
        </table>
        <div class="clearfix clear"></div> 
        
        <?php
    }

    /**
     * Save job application meta box.
     * 
     * @since   2.2.3
     * 
     * @param   int     $post_id    Post id
     * @return  void
     */
    public static function sjb_save_jobpost_meta( $post_id ) {
        
        // Delete previous stored fields
        $old_keys = get_post_custom_keys($post_id);
        foreach ($old_keys as $key => $val):
            if (substr($val, 0, 7) == 'jobapp_') {
                delete_post_meta($post_id, $val); //Remove meta from the db.
            }
        endforeach;
        
        // Add new value
        foreach ($_POST as $key => $val):
            if (substr($key, 0, 7) == 'jobapp_') {
                $my_data = serialize($_POST[$key]);
                update_post_meta( $post_id, $key, $my_data ); // Add new value.
            }
        endforeach;
    }

}