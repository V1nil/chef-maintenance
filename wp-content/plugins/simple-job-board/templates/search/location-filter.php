<?php
/**
 * Template for displaying job location filter
 *
 * Override this template by copying it to yourtheme/simple_job_board/search/location-filter.php
 *
 * @author 	PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/search
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_job_location_filter_template" filter.
 */
ob_start();

// Check For Settings Option and the Term Existance
if (NULL != get_terms('jobpost_location') && 'yes' === get_option('job_board_location_filter')) {
    $selected_location = isset($_GET['selected_location']) ? esc_attr($_GET['selected_location']) : FALSE;

    /**
     * Creating list on non-empty job location
     * 
     * Job Location Selectbox
     */
    // Job Location Arguments
    $jobloc_args = array(
        'show_option_none' => __('Location', 'simple-job-board'),
        'orderby' => 'NAME',
        'order' => 'ASC',
        'hide_empty' => 0,
        'echo' => FALSE,
        'name' => 'selected_location',
        'class' => 'sjb-form-control',
        'selected' => $selected_location,
        'hierarchical' => TRUE,
        'taxonomy' => 'jobpost_location',
        'value_field' => 'slug',
    );

    // Display or retrieve the HTML dropdown list of job locations                  
    $jobloc_select = wp_dropdown_categories(apply_filters('sjb_job_location_filter_args', $jobloc_args, $atts));
    ?>

    <!-- Job Location Filter-->
    <div class="sjb-search-location <?php echo apply_filters('sjb_job_location_filter_class', 'sjb-col-md-3'); ?>" id="sjb-form-padding">
        <?php
        if (NULL != $jobloc_select)
            echo $jobloc_select;
        ?>
    </div>
    <?php
}

$html_location_filter = ob_get_clean();

/**
 * Modify the Job Location Filter Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html_location_filter   Job Location Filter HTML.                   
 */
echo apply_filters( 'sjb_job_location_filter_template', $html_location_filter );