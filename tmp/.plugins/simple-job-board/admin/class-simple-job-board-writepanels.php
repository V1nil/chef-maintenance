<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Simple_Job_Board_Writepanels class
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
class Simple_Job_Board_Writepanels {

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     */
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_jobpost', array($this, 'job_board_save_meta_boxes'), 20, 2);
    }

    /**
     * add_meta_boxes function.
     *
     * @access public
     * @return void
     */
    public function add_meta_boxes() {
        global $wp_post_types;
        add_meta_box(
                'jobpost_metas', sprintf(__('%s Features', 'simple-job-board'), $wp_post_types['jobpost']->labels->singular_name), array($this, 'job_board_meta_job_features'), 'jobpost', 'normal', 'high'
        );

        add_meta_box(
                'jobpost_application_fields', __('Application Form Fields', 'simple-job-board'), array($this, 'job_board_meta_application_form'), 'jobpost', 'normal', 'high'
        );
    }

    /**
     * job_board_meta_job_features function.
     *
     * @access public
     * @param mixed $post
     * @return void
     */
    public function job_board_meta_job_features($post) {
        global $jobfields;

        // Add a nonce field so we can check for it later.
        wp_nonce_field('sjb_jobpost_meta_awesome_box', 'jobpost_meta_box_nonce');

        /*
         * Use get_post_meta() to retrieve an existing value
         * from the database and use the value for the form.
         */
        ?>
        <div class="job_features meta_option_panel jobpost_fields">
            <ul id="job_features">
        <?php
        $keys = get_post_custom_keys($post->ID);

        //getting setting page saved options
        $settings_options = unserialize(get_option('jobfeature_settings_options'));

        //check Array differnce when $keys is not NULL
        if (NULL == $keys) {

            //"Add New" job check
            $removed_options = $settings_options;
        } elseif (NULL == $settings_options) {
            $removed_options = '';
        } else {

            //Remove the same option from post meta and options
            $removed_options = array_diff_key($settings_options, get_post_meta($post->ID));
        }

        if (NULL != $keys):
            foreach ($keys as $key):
                if (substr($key, 0, 11) == 'jobfeature_') {
                    $val = get_post_meta($post->ID, $key, TRUE);
                    echo '<li><label for="' . $key . '">';
                    _e(ucwords(str_replace('_', ' ', substr($key, 11))), 'simple-job-board');
                    echo '</label> ';

                    // Setting options meta Fileds button to Empty
                    $button = '<div class="button removeField">' . __('Delete', 'simple-job-board') . '</div>';
                    echo '<input type="text" id="' . $key . '" name="' . $key . '" value="' . esc_attr($val) . '" /> &nbsp; ' . $button . '</li>';
                }
            endforeach;
        endif;

        // Adding setting page features to jobpost
        if (NULL != $removed_options):
            if (!isset($_GET['action'])):

                foreach ($removed_options as $key => $val):
                    if ('empty' === $val) {
                        $val = ''; // Conver Empty Value Parameter to NULL 
                    }

                    if (substr($key, 0, 11) == 'jobfeature_') {
                        echo '<li><label for="' . $key . '">';
                        _e(ucwords(str_replace('_', ' ', substr($key, 11))), 'simple-job-board');
                        echo '</label> ';
                        echo '<input type="text" id="' . $key . '" name="' . $key . '" value="' . esc_attr($val) . '" /> &nbsp; <div class="button removeField">' . __('Delete', 'simple-job-board') . '</div></li>';
                    }
                endforeach;
            endif;
        endif;
        ?>
            </ul>
        </div>
        <div class="clearfix clear"></div>
        <table id="jobfeatures_form" class="alignleft">
            <thead>
                <tr>
                    <th><label for="jobFeature"><?php _e('Feature', 'simple-job-board'); ?></label></th>
                    <th><label for="jobFeatureVal"><?php _e('Value', 'simple-job-board'); ?></label></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="jobFeature"><input type="text" id="jobfeature_name" /></td>
                    <td><input type="text" id="jobfeature_value" /></td>
                    <td><div class="button" id="addFeature"><?php _e('Add Field', 'simple-job-board'); ?></div></td>
                </tr>
            </tbody>
        </table>
        <div class="clearfix clear"></div>
        <?php
    }

    /**
     * job_board_meta_application_form function.
     *
     * @access public
     * @param mixed $post
     * @return void
     */
    public function job_board_meta_application_form( $post ) {
        global $jobfields;

        // Add a nonce field so we can check for it later.
        wp_nonce_field('sjb_jobpost_meta_awesome_box', 'jobpost_meta_box_nonce');

        /**
         * Use get_post_meta() to retrieve an existing value
         */
        ?>
        <div class="meta_option_panel jobpost_fields">
            <ul id="app_form_fields">
        <?php
        $field_types = array(
            'text'      => __( 'Text Field', 'simple-job-board' ),
            'text_area' => __( 'Text Area', 'simple-job-board' ),
            'email'     => __( 'Email', 'simple-job-board' ),
            'phone'     => __( 'Phone', 'simple-job-board' ),
            'date'      => __( 'Date', 'simple-job-board' ),
            'checkbox'  => __( 'Check Box', 'simple-job-board' ),
            'dropdown'  => __( 'Drop Down', 'simple-job-board' ),
            'radio'     => __( 'Radio', 'simple-job-board' ),            
        );
        
        $keys = get_post_custom_keys($post->ID);

        // Getting setting page saved options
        $jobapp_settings_options = unserialize(get_option('jobapp_settings_options'));

        //check Array differnce when $keys is not NULL
        if (NULL == $keys) {

            //"Add New" job Check
            $jobapp_removed_options = $jobapp_settings_options;
        } elseif (NULL == $jobapp_settings_options) {
            $jobapp_removed_options = '';
        } else {
            //Remove the same option from post meta and options
            $jobapp_removed_options = array_diff_key($jobapp_settings_options, get_post_meta($post->ID));
        }

        if (NULL != $keys):
            foreach ($keys as $key):
                if (substr($key, 0, 7) == 'jobapp_'):                    
                    $val = get_post_meta($post->ID, $key, TRUE);
                    $val = unserialize($val);
                    
                    $fields = NULL;
                    foreach ($field_types as $field_key => $field_val) {
                        if ($val['type'] == $field_key)
                            $fields .= '<option value="' . $field_key . '" selected>' . $field_val . '</option>';
                        else
                            $fields .= '<option value="' . $field_key . '" >' . $field_val . '</option>';
                    }
                    echo '<li class="' . $key . '">'
                            . '<label for="">' . ucwords(str_replace('_', ' ', substr($key, 7))) . '</label>'
                            . '<select class="jobapp_field_type" name="' . $key . '[type]">'
                            . $fields 
                            . '</select>';
                            if (!($val['type'] == 'text' or $val['type'] == 'date' or $val['type'] == 'text_area' or $val['type'] == 'email' or $val['type'] == 'phone' )):
                                echo '<input type="text" name="' . $key . '[options]" value="' . $val['options'] . '" placeholder="Option1, option2, option3" />';
                            else:
                                echo '<input type="text" name="' . $key . '[options]" placeholder="Option1, option2, option3" style="display:none;"  />&nbsp;';
                            endif;
                            
                            // Set Fields as Optional or Required
                            if( isset($val['optional']) ){                                
                                echo '<input type="checkbox" class="jobapp-required-field" '.$val['optional'].' />' . __('Required', 'simple-job-board') . ' &nbsp; '; 
                                echo '<input type="hidden"   class="jobapp-optional-field" name="' . $key.'[optional]" value="'.$val['optional'].'"/>';
                            }
                            else{
                                echo '<input type="checkbox" class="jobapp-required-field" checked />' . __('Required', 'simple-job-board') . ' &nbsp; '; 
                                echo '<input type="hidden"   class="jobapp-optional-field" name="' . $key.'[optional]" value="checked"/>'; 
                            }
                        
                    $button = '<div class="button removeField">' . __('Delete', 'simple-job-board') . '</div>';

                    echo ' &nbsp; ' . $button . '</li>';
                endif;
            endforeach;
        endif;

        /**
         * Settings Job Application Form         *          
         */
        if (NULL != $jobapp_removed_options):
            if (!isset($_GET['action'])):
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
                            echo '<li class="' . $jobapp_field_name . '"><label for="">' . ucwords(str_replace('_', ' ', substr($jobapp_field_name, 7))) . '</label><select class="jobapp_field_type" name="' . $jobapp_field_name . '[type]">' . $fields . '</select>';
                            if (!($val['type'] == 'text' or $val['type'] == 'date' or $val['type'] == 'text_area' or $val['type'] == 'email' or $val['type'] == 'phone' ) ):
                                echo '<input type="text" name="' . $jobapp_field_name . '[options]" value="' . $val['option'] . '"  placeholder="Option1, option2, option3" />';
                            else:
                                echo '<input type="text" name="' . $jobapp_field_name . '[options]" placeholder="Option1, option2, option3" style="display:none;"  />';

                            endif; 
                            
                            // Set Fields as Optional or Required
                            if( isset($val['optional']) ){                                
                                echo '<input type="checkbox" class="jobapp-required-field" '.$val['optional'].' />' . __('Required', 'simple-job-board') . '&nbsp; '; 
                                echo '<input type="hidden"   class="jobapp-optional-field" name="' . $jobapp_field_name.'[optional]" value="'.$val['optional'].'"/>';
                            }
                            else{
                                echo '<input type="checkbox" class="jobapp-required-field" checked />' . __('Required', 'simple-job-board') . '&nbsp; '; 
                                echo '<input type="hidden"   class="jobapp-optional-field" name="' . $jobapp_field_name.'[optional]" value="checked"/>'; 
                            }
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
                    <td><input type="checkbox" id="jobapp_required_field" checked="checked"/><?php _e('Required', 'simple-job-board');?></td>
                    <td><div class="button" id="addField"><?php _e('Add Field', 'simple-job-board'); ?></div></td>
                </tr>
            </tbody>
        </table>
        <div class="clearfix clear"></div>
        <script type="text/javascript">
            jQuery('document').ready(function ($) {

                /*Job Application Field Type change*/
                $('#jobapp_field_type').on('change', function () {
                    var fieldType = $(this).val();

                    if (!(fieldType == 'text' || fieldType == 'date' || fieldType == 'text_area' || fieldType == 'email' || fieldType == 'phone')) {
                        $('#jobapp_field_options').show();
                    }
                    else {
                        $('#jobapp_field_options').hide();
                        $('#jobapp_field_options').val('');
                    }
                });

                /*Add Application Field (Group Fields)*/
                $('#addField').on("click", function () {
                    var fieldNameRaw = $('#jobapp_name').val(); // Get Raw value.
                    var fieldNameRaw = fieldNameRaw.trim();    // Remove White Spaces from both ends.
                    var fieldName = fieldNameRaw.split(' ').join('_').toLowerCase(); //Replace white space with _.
                    var fieldNameOption = fieldNameRaw.replace(/[&\/\\#,+()$~%.^!'"@:=*?|؟<>{}]/g, '').replace(/[_\s]/g, '_').toLowerCase(); //Replace white space with _.
                    var fieldType = $('#jobapp_field_type').val();
                    var fieldOptions = $('#jobapp_field_options').val();
                    var fieldRequired = $("#jobapp_required_field").attr("checked") ? "checked" : "unchecked";
                    var fieldTypeHtml = $('#jobapp_field_type').html();
                    
                    if (fieldName != '') {
                        if (fieldType == 'text' || fieldType == 'date' || fieldType == 'text_area' || fieldType == 'email' || fieldType == 'phone') {
                            $('#app_form_fields').append('<li class="' + fieldNameOption + '"><label for="' + fieldName + '">' + fieldNameRaw + '</label><select class="jobapp_field_type" name="jobapp_' + fieldName + '[type]">' + fieldTypeHtml + '</select>&nbsp;<input type="text" class="' + fieldName + ' jobapp_field_options" name="jobapp_' + fieldName + '[options]" value="' + fieldOptions + '" placeholder="Option1, option2, option3" style="display:none;" />&nbsp;<input type="checkbox" class="' + fieldName + ' jobapp_required_field"  ' + fieldRequired + '/><input type="hidden" name="jobapp_' + fieldName + '[optional]" value="' + fieldRequired + '"/><?php _e('Required', 'simple-job-board'); ?> &nbsp; <div class="button removeField"><?php _e('Delete', 'simple-job-board'); ?></div></li>');
                            $('.' + fieldNameOption + ' .' + fieldType).attr('selected', 'selected');
                            $('#jobapp_name').val('');
                            $('#jobapp_field_type').val('text');
                            $('#jobapp_required_field' ).prop( "checked", true );
                        }
                        else {
                            $('#app_form_fields').append('<li class="' + fieldNameOption + '"><label for="' + fieldName + '">' + fieldNameRaw + '</label><select class="jobapp_field_type" name="jobapp_' + fieldName + '[type]">' + fieldTypeHtml + '</select>&nbsp;<input type="text" class="' + fieldName + ' jobapp_field_options" name="jobapp_' + fieldName + '[options]" value="' + fieldOptions + '" /><input type="checkbox" class="' + fieldName + ' jobapp_required_field" ' + fieldRequired + ' /><input type="hidden" name="jobapp_' + fieldName + '[optional]" value="' + fieldRequired + '"/><?php _e('Required', 'simple-job-board'); ?> &nbsp; <div class="button removeField"><?php _e('Delete', 'simple-job-board'); ?></div></li>');
                            $('.' + fieldNameOption + ' .' + fieldType).attr('selected', 'selected');
                            $('#jobapp_name').val('');
                            $('#jobapp_field_type').val('text');
                            $('#jobapp_field_options').val('');
                            $('#jobapp_field_options').hide();
                            $('#jobapp_required_field' ).prop( "checked", true );
                        }
                    }
                    else {
                        alert( "<?php _e( 'Please fill out application form field name.', 'simple-job-board' );?>" );
                        $('#jobapp_name').focus(); //Keep focus on this input
                    }

                });
                
                /* Change the Required & Optional Field Parameter*/
                $('.jobapp-required-field').on("change", function () {
                   var input =$(this);
                   input.attr("checked") ? input.next().val("checked") : input.next().val("unchecked");
                });

                /* Job Application Field Type change (added) */
                $('#app_form_fields').on('change', 'li .jobapp_field_type', function () {

                    var fieldType = $(this).val();

                    if (!(fieldType == 'text' || fieldType == 'date' || fieldType == 'text_area' || fieldType == 'email' || fieldType == 'phone' )) {
                        $(this).next().show();
                    }
                    else {
                        $(this).next().hide();
                    }
                });

                /*Add Job Feature*/
                $('#addFeature').click(function () {
                    var fieldNameRaw = $('#jobfeature_name').val(); // Get Raw value.
                    var fieldNameRaw = fieldNameRaw.trim();    // Remove White Spaces from both ends.
                    var fieldName = fieldNameRaw.split(' ').join('_').toLowerCase(); //Replace white space with _.

                    var fieldVal = $('#jobfeature_value').val();
                    var fieldVal = fieldVal.trim();

                    if (fieldName != '' && fieldVal != '') {
                        $('#job_features').append('<li class="' + fieldName + '"><label for="' + fieldName + '">' + fieldNameRaw + '</label> <input type="text" name="jobfeature_' + fieldName + '" value="' + fieldVal + '" > &nbsp; <div class="button removeField"><?php _e('Delete', 'simple-job-board'); ?></div></li>');
                        $('#jobfeature_name').val(""); //Reset Field value.
                        $('#jobfeature_value').val(""); //Reset Field value.
                    }
                    else {
                        alert("<?php _e('Please fill out job feature.', 'simple-job-board');?>");
                        $('#jobfeature_name').focus(); //Keep focus on this input
                    }
                });

                /*Remove Job app or job Feature Fields*/
                $('.jobpost_fields').on('click', 'li .removeField', function () {
                    $(this).parent('li').remove();
                });
            });
        </script>
        <?php
    }

    /**
     * job_board_save_meta_boxes function.
     *
     * @access  public
     * @param   int     $post
     * @return  void
     */
    public function job_board_save_meta_boxes($post_id) {
        /*
         * We need to verify this came from our screen and with proper authorization,
         * because the save_post action can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST['jobpost_meta_box_nonce'])) {
            return;
        }

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['jobpost_meta_box_nonce'], 'sjb_jobpost_meta_awesome_box')) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions.
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {

            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }

        /* OK, it's safe for us to save the data now. */

        //Delete fields.
        $old_keys = get_post_custom_keys($post_id);
        foreach ($old_keys as $key => $val):
            if (substr($val, 0, 3) == 'job')
                delete_post_meta($post_id, $val); //Remove meta from the db.
        endforeach;
        
        // Add new value.
        foreach ($_POST as $key => $val):
            if (substr($key, 0, 11) == 'jobfeature_') { // Make sure that it is set.
                
                // Sanitize user input.
                $my_data = sanitize_text_field($val);
                update_post_meta($post_id, $key, $my_data); // Add new value.
            }

            // Make sure that it is set.
            elseif (substr($key, 0, 7) == 'jobapp_') {
                $my_data = serialize($_POST[$key]);
                update_post_meta($post_id, $key, $my_data); // Add new value.
            }            
        endforeach;
    }

}

new Simple_Job_Board_Writepanels();