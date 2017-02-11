<?php
// Grid should never be null. Construct just allows easy access to WPUPG_Grid functions in IDE.
if( is_null( $grid ) ) $grid = new WPUPG_Grid(0);
$premium_only = WPUltimatePostGrid::is_premium_active() ? '' : ' (' . __( 'Premium only', 'wp-ultimate-post-grid' ) . ')';
?>

<input type="hidden" name="wpupg_nonce" value="<?php echo wp_create_nonce( 'grid' ); ?>" />
<table id="wpupg_form_general" class="wpupg_form">
    <tr>
        <td><label for="wpupg_type"><?php _e( 'Type', 'wp-ultimate-post-grid' ); ?></label></td>
        <td>
            <select name="wpupg_type" id="wpupg_type" class="wpupg-select2">
                <?php
                $grid_type_options = array(
                    'posts' => __( 'Grid of Posts or Pages', 'wp-ultimate-post-grid' ),
                    'terms' => __( 'Grid of Category or Taxonomy Terms', 'wp-ultimate-post-grid' ) . $premium_only,
                );

                foreach( $grid_type_options as $grid_type => $grid_type_name ) {
                    $selected = $grid_type == $grid->type() ? ' selected="selected"' : '';
                    echo '<option value="' . esc_attr( $grid_type ) . '"' . $selected . '>' . $grid_type_name . '</option>';
                }
                ?>
            </select>
        </td>
        <td><?php _e( 'Type of grid to use.', 'wp-ultimate-post-grid' ); ?></td>
    </tr>
</table>