<?php
/**
 * Show filters for jobs
 *
 * @author 	PressTigers
 * @package 	simple-job-board/templates
 * @version     1.0.0
 * @since       2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
do_action('simple_job_board_job_filters_before');
?>
<article id="sjb-contain-bg" <?php post_class('sjb-job-filters'); ?>>
    <div class="sjb-row">
        <div class="sjb-form-inline">
            <form class="sjb-job-filters-form" action="<?php echo apply_filters( 'sjb_job_filters_form_action' , '');?>" method="<?php echo apply_filters( 'sjb_job_filters_form_method' , 'get');?>">
                <?php do_action('simple_job_board_job_filters_start'); ?>

                <?php
                if ('yes' === get_option('job_board_search_bar')) {
                    ?>
                    <div class="sjb-search-keywords sjb-col-md-12" id="sjb-form-padding">
                        <?php
                        $search_keyword = isset($_GET['search_keywords']) ? $_GET['search_keywords'] : '';

                        // Append Query string With Page ID When Permalinks are not Set
                        if (!get_option('permalink_structure')) {
                            ?>
                            <input type="hidden" value="<?php echo get_the_ID(); ?>" name="page_id" >
                        <?php } ?>
                        <input type="text" class="sjb-search-keyword sjb-form-control" value="<?php echo $search_keyword; ?>" placeholder="<?php _e('Keywords', 'simple-job-board'); ?>" id="search_keywords" name="search_keywords">
                    </div>
                    <?php
                }
                do_action('simple_job_board_job_filters_dropdowns_start');

                // check for setting page option and the term existance
                if ((NULL != get_terms('jobpost_category')) && ('yes' === get_option('job_board_category_filter'))) {

                    $selected_category = isset($_GET['selected_category']) ? $_GET['selected_category'] : FALSE;

                    // Creating List on Non-empty Job Categories
                    $category_select = wp_dropdown_categories(apply_filters('sjb_category_filter_args', array(
                        'show_option_none' => __('Category', 'simple-job-board'),
                        'orderby'          => 'NAME',
                        'order'            => 'ASC',
                        'class'            => 'sjb-form-control',
                        'hide_empty'       => 0,
                        'echo'             => FALSE,
                        'hierarchical'     => TRUE,
                        'name'             => 'selected_category',
                        'selected'         => $selected_category,
                        'taxonomy'         => 'jobpost_category',
                        'value_field'      => 'slug',
                    )));
                    ?>
                    <div class="sjb-search-categories <?php echo apply_filters( 'sjb_category_filter_class', 'sjb-col-md-4');?>" id="sjb-form-padding">
                        <?php
                        if (isset($category_select) && (NULL != $category_select )) {
                            echo $category_select;
                        }
                        ?>
                    </div>
                    <?php
                }
                // Check For Settings Option and the Term Existance
                if (NULL != get_terms('jobpost_job_type') && 'yes' === get_option('job_board_jobtype_filter')) {

                    $selected_jobtype = isset($_GET['selected_jobtype']) ? $_GET['selected_jobtype'] : FALSE;

                    // Creating list on non-empty job types       
                    $jobtype_select = wp_dropdown_categories(apply_filters('sjb_job_type_filter_args', array(
                        'show_option_none' => __('Job Type', 'simple-job-board'),
                        'orderby'          => 'NAME',
                        'order'            => 'ASC',
                        'class'            => 'sjb-form-control',
                        'hide_empty'       => 0,
                        'echo'             => FALSE,
                        'hierarchical'     => TRUE,
                        'name'             => 'selected_jobtype',
                        'taxonomy'         => 'jobpost_job_type',
                        'selected'         => $selected_jobtype,
                        'value_field'      => 'slug',
                    )));
                    ?>                
                    <div class="sjb-search-job-type <?php echo apply_filters( 'sjb_job_type_filter_class', 'sjb-col-md-3');?>" id="sjb-form-padding">
                        <?php
                        if (NULL != $jobtype_select) {
                            echo $jobtype_select;
                        }
                        ?>
                    </div>
                    <?php
                }

                // Check For Settings Option and the Term Existance
                if (NULL != get_terms('jobpost_location') && 'yes' === get_option('job_board_location_filter')) {
                    $selected_location = isset($_GET['selected_location']) ? $_GET['selected_location'] : FALSE;

                    // Creating list on non-empty job location                    
                    $jobloc_select = wp_dropdown_categories(apply_filters('sjb_job_location_filter_args', array(
                        'show_option_none' => __('Location', 'simple-job-board'),
                        'hide_empty'       => 0,
                        'name'             => 'selected_location',
                        'orderby'          => 'NAME',
                        'order'            => 'ASC',
                        'class'            => 'sjb-form-control',
                        'hierarchical'     => TRUE,
                        'value_field'      => 'slug',
                        'taxonomy'         => 'jobpost_location',                        
                        'selected'         => $selected_location,
                        'echo'             => FALSE,
                    )));
                    ?>                
                    <div class="sjb-search-location <?php echo apply_filters( 'sjb_job_location_filter_class', 'sjb-col-md-3');?>" id="sjb-form-padding">
                        <?php
                        if (NULL != $jobloc_select)
                            echo $jobloc_select;
                        ?>
                    </div>
                    <?php
                }
                do_action('simple_job_board_job_filters_dropdowns_end');

                if ((isset($category_select) && NULL != $category_select) || ( isset($jobtype_select) && NULL != $jobtype_select) || ( isset($jobloc_select) && NULL != $jobloc_select) || 'yes' === get_option('job_board_search_bar')) {
                    $search_button = '<div class="sjb-search-button '. apply_filters( 'sjb_filters_button_class', 'sjb-col-md-2').'" id="sjb-form-padding">'
                            . '<input type="submit" class="sjb-search" value=""/>'
                            . '</div>'; 
                    echo apply_filters( 'sjb_job_filters_search_button' , $search_button );
                }
                do_action('simple_job_board_job_filters_end');
                ?>
            </form>
        </div>
    </div>
</article>
<?php do_action('simple_job_board_job_filters_after');