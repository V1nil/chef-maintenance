<?php
/**
 * Template for displaying job type filter
 *
 * Override this template by copying it to yourtheme/simple_job_board/search/type-filter.php
 *
 * @author 	PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/search
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_job_type_filter_template" filter.
 */
ob_start();

// Check For Settings Option and the Term Existance
if (NULL != get_terms('jobpost_job_type') && 'yes' === get_option('job_board_jobtype_filter')) {
    $selected_jobtype = isset($_GET['selected_jobtype']) ? esc_attr($_GET['selected_jobtype']) : FALSE;

    /**
     * Creating list on non-empty job type
     * 
     * Job Type Selectbox
     */
    // Job Type Arguments
    $jobtype_args = array(
        'show_option_none'  => __('Job Type', 'simple-job-board'),
        'orderby'           => 'NAME',
        'order'             => 'ASC',
        'hide_empty'        => 0,
        'echo'              => FALSE,
        'name'              => 'selected_jobtype',
        'class'             => 'sjb-form-control',
        'selected'          => $selected_jobtype,
        'hierarchical'      => TRUE,
        'taxonomy'          => 'jobpost_job_type',
        'value_field'       => 'slug',
    );

    // Display or retrieve the HTML dropdown list of job type     
    $jobtype_select = wp_dropdown_categories(apply_filters('sjb_job_type_filter_args', $jobtype_args, $atts));
    ?> 

    <!-- Job Type Filter -->
    <div class="sjb-search-job-type <?php echo apply_filters('sjb_job_type_filter_class', 'sjb-col-md-3'); ?>" id="sjb-form-padding">
        <?php
        if (NULL != $jobtype_select) {
            echo $jobtype_select;
        }
        ?>
    </div>
    <?php
}

$html_type_filter = ob_get_clean();

/**
 * Modify the Job Type Filter Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html_type_filter   Job Type Filter HTML.                   
 */
echo apply_filters( 'sjb_job_type_filter_template', $html_type_filter );