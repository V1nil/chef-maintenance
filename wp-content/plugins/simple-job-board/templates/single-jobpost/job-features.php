<?php
/**
 * Single view Job Fetures
 *
 * Override this template by copying it to yourtheme/simple_job_board/single-jobpost/job-features.php
 * 
 * @author 	PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/Templates
 * @version     1.0.0
 * @since       2.1.0
 * @since       2.2.2   Added "sjb_job_features" filter.
 * @since       2.2.3   Modified the @hooks placement.
 * @since       2.3.0   Added "sjb_job_features_template" filter.
 */
ob_start();
global $post;

/**
 * Fires before displaying job features on job detail page .
 *                   
 * @since 2.1.0                   
 */
do_action("sjb_job_features_before");
?>

<!-- Start Job Features
================================================== -->
<section class="sjb-job-features">
    <?php
    $keys = sjb_job_features_count();
    $job_category = wp_get_post_terms($post->ID, 'jobpost_category');
    $metas = '';

    // Show Job Features Title, If Features Exist.
    if (0 < $keys || NULL != $job_category):
        ?>
        <h3><?php echo apply_filters('sjb_job_features_title', __('Job Features', 'simple-job-board')); ?></h3>
        <?php
    endif;
    ?>
    <div class="sjb-row">
        <div class="sjb-col-md-10">
            <table class="sjb-table">
                <tbody>
                    <?php
                    /**
                     * Fires before the job category under the job features section on job detail page.
                     * 
                     * @since   2.2.3
                     */
                    do_action("sjb_job_features_category_before");

                    // Job Category Under Job Features Section
                    if (sjb_get_the_job_category()):
                        echo '<tr><th>' . __('Job Category', 'simple-job-board') . '</th><td>';
                        sjb_the_job_category();
                        echo'</td></tr>';
                    endif;

                    /**
                     * Fires after the job category under the job features section on job detail page.
                     * 
                     * @since   2.2.3
                     */
                    do_action("sjb_job_features_category_after");

                    // Display Job Features
                    $keys = get_post_custom_keys(get_the_ID());
                    if ($keys != NULL):
                        foreach ($keys as $key):
                            if (substr($key, 0, 11) == 'jobfeature_') {
                                $val = get_post_meta($post->ID, $key, TRUE);
                                if ( is_serialized($val) ) {
                                    $val = unserialize($val);
                                }

                                /**
                                 * New Label Index Insertion:
                                 * 
                                 * - Addition of new index "label"
                                 * - Data Legacy Checking  
                                 */
                                $label = isset($val['label']) ? $val['label'] : __(ucwords(str_replace('_', ' ', substr($key, 11))), 'simple-job-board');
                                $value = isset($val['value']) ? $val['value'] : $val;

                                if ($val != '')
                                    $metas.= '<tr><th>' . $label . '</th><td>' . $value . ' </td></tr>';
                            }
                        endforeach;
                    endif;

                    /**
                     * Modify the output of job feature section. 
                     *                                       
                     * @since   2.2.0
                     * 
                     * @param string  $metas job features                   
                     */
                    echo apply_filters('sjb_job_features', $metas);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- ==================================================
End Job Features -->

<?php
/**
 * Fires after displaying job features on job detail page.
 *                   
 * @since   2.1.0                   
 */
do_action("sjb_job_features_after");

$html_job_features = ob_get_clean();

/**
 * Modify the Job Feature Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param  html $html_job_features Job Features HTML.                   
 */
echo apply_filters('sjb_job_features_template', $html_job_features);