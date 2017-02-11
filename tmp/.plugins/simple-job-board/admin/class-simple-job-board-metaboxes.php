<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Simple_Job_Board_Metaboxes class
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
class Simple_Job_Board_Metaboxes {

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     */
    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'admin_script_loader'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    /**
     * Load backend scripts
     */
    function admin_script_loader() {
        global $pagenow;

        if (is_admin() && ( in_array($pagenow, array('post-new.php', 'post.php')) )) {
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
        }
    }

    /**
     * add_meta_boxes function.
     *
     * @access public
     * @return void
     */
    public function add_meta_boxes() {
        $this->add_meta_box('post_options', __('Job Data', 'simple-job-board'), 'jobpost', 'normal');
    }

    public function add_meta_box($id, $label, $post_type) {
        add_meta_box('simple-job-board-' . $id, $label, array($this, $id), $post_type , 'normal');
    }

    public function save_meta_boxes($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        foreach ($_POST as $key => $value) {
            if (strstr($key, 'simple_job_board')) {
                update_post_meta($post_id, $key, $value);
            }
        }
    }

    public function post_options() {
        echo '<div class="simple-job-board-metabox">';
        $this->text('_company_name', __('Company Name', 'simple-job-board'), '');
        $this->text('_company_website', __('Company Website', 'simple-job-board'), '');
        $this->text('_company_tagline', __('Company Tagline', 'simple-job-board'), '');
        $this->upload('_company_logo', __('Company Logo', 'simple-job-board'), '');
        echo '</div>';
    }

    public function text($id, $label, $desc = '') {
        global $post;
        $html = '<p class="metabox-field">';
        $html .= '<label for="simple_job_board' . $id . '">' . $label . ' <span class="tips">[?]</span></label>';
        $html .= '<input type="text" id="simple_job_board' . $id . '" name="simple_job_board' . $id . '" value="' . get_post_meta($post->ID, 'simple_job_board' . $id, TRUE) . '" />';
        if ($desc) {
            $html .= '<span class="tips">' . $desc . '</span>';
        }
        $html .= '</p>';

        echo $html;
    }

    public function upload($id, $label, $desc = '') {
        global $post;
        ?>
        <p class="metabox-field">
            <label for="simple_job_board<?php echo $id; ?>"><?php echo $label; ?></label>
            <span class="file_url">
                <input type="text" name="simple_job_board<?php echo $id; ?>" id="simple_job_board<?php echo $id; ?>" class="upload_field" placeholder="URL to the company logo" value="<?php echo get_post_meta($post->ID, 'simple_job_board' . $id, TRUE); ?>" />
                <button type="button" class="button simple-job-board-upload-button"><?php _e('Upload', 'simple-job-board'); ?></button>
            </span>
            <?php if ($desc) : ?>
            <p><?php echo $desc; ?></p>
        <?php endif; ?>
        </p>
        <?php
    }
}

$metaboxes = new Simple_Job_Board_Metaboxes;