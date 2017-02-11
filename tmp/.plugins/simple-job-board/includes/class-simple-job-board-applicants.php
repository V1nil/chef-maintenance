<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Simple_Job_Board_Applicants class.
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
class Simple_Job_Board_Applicants {

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     */
    public function __construct() {
        // Hook -> Job Applicants Data
        add_action('edit_form_after_title', array($this, 'jobpost_applicants_detail_page_content'));
    }

    /**
     * Creates Detail Page for Applicants
     * 
     * 
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function jobpost_applicants_detail_page_content() {
        global $post;
        
        if (!empty($post) and 'jobpost_applicants' === $post->post_type):
            $keys = get_post_custom_keys($post->ID);
            do_action('sjb_applicants_details_before'); ?>

            <div class="wrap"><div id="icon-tools" class="icon32"></div>
                <h3>
                    <?php
                    if (in_array('jobapp_name', $keys)):
                        echo get_post_meta($post->ID, 'jobapp_name', true);
                    endif;
                    
                    if (in_array('resume', $keys)):
                        ?>
                        &nbsp; &nbsp; <small><a href="<?php echo get_post_meta($post->ID, 'resume', true); ?>" target="_blank" ><?php echo __('Resume', 'simple-job-board'); ?></a></small>
                    <?php endif; ?>

                </h3>                
                <table class="widefat striped">
                    <?php
                    do_action('sjb_applicants_details_start');
                    
                    foreach ($keys as $key):
                        if (substr($key, 0, 7) == 'jobapp_') {
                            echo '<tr><td>' . ucwords( str_replace('_', ' ', substr($key, 7))) . '</td><td>' . get_post_meta($post->ID, $key, true) . '</td></tr>';
                        }
                    endforeach;
                    
                    do_action('sjb_applicants_details_end'); ?>
                </table>
            </div>

            <?php do_action('sjb-applicants-details-after'); ?>

            <h2><?php _e('Application Notes', 'simple-job-board'); ?></h2>
            
            <?php do_action('sjb_applicantion_notes');
        endif;
    }

}

new Simple_Job_Board_Applicants();