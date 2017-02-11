<?php
// Grid should never be null. Construct just allows easy access to WPUPG_Grid functions in IDE.
if( is_null( $grid ) ) $grid = new WPUPG_Grid(0);
$premium_only = WPUltimatePostGrid::is_premium_active() ? '' : ' (' . __( 'Premium only', 'wp-ultimate-post-grid' ) . ')';
?>

<table id="wpupg_form_data_source_terms" class="wpupg_form">
    <tr class="wpupg_type_terms">
        <td><label for="wpupg_taxonomies"><?php _e( 'Taxonomies', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <select name="wpupg_taxonomies" id="wpupg_taxonomies" class="wpupg-select2">
                <?php
                $taxonomies = get_taxonomies( '', 'objects' );

                foreach( $taxonomies as $taxonomy => $options ) {
                    $selected = in_array( $taxonomy, $grid->taxonomies() ) ? ' selected="selected"' : '';
                    echo '<option value="' . esc_attr( $taxonomy ) . '"' . $selected . '>' . $options->labels->name . '</option>';
                }
                ?>
            </select>
        </td>
        <td><?php _e( 'Taxonomies to be displayed in the grid.', 'wp-ultimate-post-grid' ); ?></td>
    </tr>
    <tr class="wpupg_divider">
        <td><label for="wpupg_terms_order_by"><?php _e( 'Order By', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <select name="wpupg_terms_order_by" id="wpupg_terms_order_by" class="wpupg-select2">
                <?php
                $order_by_options = array(
                    'name' => __( 'Name', 'wp-ultimate-post-grid' ),
                    'slug' => __( 'Slug', 'wp-ultimate-post-grid' ),
                    'term_id' => __( 'ID', 'wp-ultimate-post-grid' ),
                    'description' => __( 'Description', 'wp-ultimate-post-grid' ),
                    'count' => __( 'Post Count', 'wp-ultimate-post-grid' ),
                );

                foreach( $order_by_options as $order_by => $order_by_name ) {
                    $selected = $order_by == $grid->terms_order_by() ? ' selected="selected"' : '';
                    echo '<option value="' . esc_attr( $order_by ) . '"' . $selected . '>' . $order_by_name . '</option>';
                }
                ?>
            </select>
        </td>
        <td><?php _e( 'How to order the items in the grid.', 'wp-ultimate-post-grid' ); ?></td>
    </tr>
    <tr>
        <td><label for="wpupg_terms_order"><?php _e( 'Order', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <select name="wpupg_terms_order" id="wpupg_terms_order" class="wpupg-select2">
                <?php
                $order_options = array(
                    'asc' => __( 'Ascending', 'wp-ultimate-post-grid' ),
                    'desc' => __( 'Descending', 'wp-ultimate-post-grid' ),
                );

                foreach( $order_options as $order => $order_name ) {
                    $selected = $order == $grid->terms_order() ? ' selected="selected"' : '';
                    echo '<option value="' . esc_attr( $order ) . '"' . $selected . '>' . $order_name . '</option>';
                }
                ?>
            </select>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="wpupg_divider">
        <td><label for="wpupg_terms_hide_empty"><?php _e( 'Hide Empty', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <input type="checkbox" name="wpupg_terms_hide_empty" id="wpupg_terms_hide_empty" <?php if( $grid->terms_hide_empty() ) echo 'checked="true" '?>/>
        </td>
        <td><?php _e( 'Hide terms without associated posts.', 'wp-ultimate-post-grid' ); ?></td>
    </tr>
    <tr>
        <td><label for="wpupg_terms_images_only"><?php _e( 'Images Only', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <input type="checkbox" name="wpupg_terms_images_only" id="wpupg_terms_images_only" <?php if( $grid->terms_images_only() ) echo 'checked="true" '?>/>
        </td>
        <td><?php _e( 'Only display items with a featured image.', 'wp-ultimate-post-grid' ); ?></td>
    </tr>
</table>