<?php
/**
 * Template for displaying category filter dropdown
 *
 * Override this template by copying it to yourtheme/simple_job_board/search/category-filter.php
 *
 * @author 	PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/search
 * @version     1.0.0
 * @since       2.3.0   Added "sjb_category_filter_template" filter.
 */

ob_start();

// Check for setting page option and the term existance
if ((NULL != get_terms('jobpost_category')) && ('yes' === get_option('job_board_category_filter'))) {
    $selected_category = isset($_GET['selected_category']) ? esc_attr($_GET['selected_category']) : FALSE;

    /**
     * Creating list on non-empty job category
     * 
     * Job Category Selectbox
     */
    
    // Job Category Arguments
    $category_args = array(
        'show_option_none' => __('Category', 'simple-job-board'),
        'orderby'          => 'NAME',
        'order'            => 'ASC',
        'hide_empty'       => 0,
        'echo'             => FALSE,
        'hierarchical'     => TRUE,
        'name'             => 'selected_category',
        'class'            => 'sjb-form-control',
        'selected'         => $selected_category,
        'taxonomy'         => 'jobpost_category',
        'value_field'      => 'slug',
    );

    // Display or retrieve the HTML dropdown list of job category
    $category_select = wp_dropdown_categories( apply_filters( 'sjb_category_filter_args', $category_args, $atts ) );
    ?>

    <!-- Category Filter-->
    <div class="sjb-search-categories <?php echo apply_filters( 'sjb_category_filter_class', 'sjb-col-md-4' ); ?>" id="sjb-form-padding">
        <?php
        if (isset($category_select) && (NULL != $category_select )) {
            echo $category_select;
        }
        ?>
    </div>
    <?php
}

$html_category_filter = ob_get_clean();

/**
 * Modify the Category Filter Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html_category_filter   Category Filter HTML.                   
 */
echo apply_filters( 'sjb_category_filter_template', $html_category_filter );