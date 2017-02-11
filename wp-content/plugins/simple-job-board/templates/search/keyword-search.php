<?php
/**
 * Template for displaying keyword search
 *
 * Override this template by copying it to yourtheme/simple_job_board/search/keyword-search.php
 *
 * @author 	PressTigers
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/templates/search
 * @version     1.0.0
 * @since       2.2.3
 * @since       2.3.0   Added "sjb_keyword_search_template" filter.
 */
ob_start();

if ('yes' === get_option('job_board_search_bar')) {
?>

    <!-- Keywords Search-->
    <div class="sjb-search-keywords sjb-col-md-12" id="sjb-form-padding">
        <?php
        $search_keyword = isset($_GET['search_keywords']) ? esc_attr($_GET['search_keywords']) : '';        
            
        // Append Query string With Page ID When Permalinks are not Set
        if ( !get_option('permalink_structure') && !is_home() && !is_front_page() ) {
        ?>
            <input type="hidden" value="<?php echo get_the_ID(); ?>" name="page_id" >
        <?php } ?>
        <input type="text" class="sjb-search-keyword sjb-form-control" value="<?php echo $search_keyword; ?>" placeholder="<?php _e('Keywords', 'simple-job-board'); ?>" id="search_keywords" name="search_keywords">
    </div>
    <?php
}

$html_keyword_search = ob_get_clean();

/**
 * Modify the Keyword Search Template. 
 *                                       
 * @since   2.3.0
 * 
 * @param   html    $html_keyword_search   Keyword Search HTML.                   
 */
echo apply_filters( 'sjb_keyword_search_template', $html_keyword_search );