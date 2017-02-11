<?php
/**
 * Single view Job Fetures
 *
 * @author 	PressTigers
 * @package 	simple-job-board/Templates
 * @version     1.0.0
 * @since       2.0
 */
global $post;
do_action("sjb_job_features_before");
?>
<section class="sjb-job-features">
    <?php
    $keys = sjb_job_features_count();
    $job_category = wp_get_post_terms($post->ID, 'jobpost_category');
    $metas = '';

    if (0 > $keys || NULL != $job_category):
        ?>
        <h3><?php echo apply_filters('sjb_job_features_title', __('Job Features', 'simple-job-board')); ?></h3>
        <?php
    endif;

    do_action("sjb_job_features_start");
    ?>
    <div class="sjb-row">
        <div class="sjb-col-md-10">
            <div class="sjb-row">
                <table class="sjb-table">
                    <tbody>
                        <?php
                        do_action("sjb_job_features_listing_start");

                        $job_category = wp_get_post_terms($post->ID, 'jobpost_category');

                        if (NULL != $job_category):
                            $count = sizeof($job_category);
                            $metas.= '<tr><th>' . __('Job Category', 'simple-job-board') . '</th><td>';
                            foreach ($job_category as $cat) {
                                $metas.=$cat->name;
                                if ($count > 1) {
                                    $metas.=',&nbsp';
                                }
                                $count--;
                            }
                            $metas.='</td></tr>';
                        endif;

                        $keys = get_post_custom_keys(get_the_ID());
                        if ($keys != NULL):
                            foreach ($keys as $key):
                                if (substr($key, 0, 11) == 'jobfeature_') {
                                    $val = get_post_meta($post->ID, $key, TRUE);
                                    if ($val != '')
                                        $metas.= '<tr><th>' . ucwords(str_replace('_', ' ', substr($key, 11))) . '</th><td>' . $val . ' </td></tr>';
                                }
                            endforeach;
                        endif;
                        echo apply_filters('sjb_job_features', $metas);
                        ?>
                        <?php do_action("sjb_job_features_listing_end"); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php
do_action("sjb_job_features_after");