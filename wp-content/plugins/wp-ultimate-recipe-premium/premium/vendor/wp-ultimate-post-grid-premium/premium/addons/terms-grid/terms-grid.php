<?php

class WPUPG_Terms_Grid extends WPUPG_Premium_Addon {

    public function __construct( $name = 'terms-grid' ) {
        parent::__construct( $name );

        global $wp_version;
        if ( $wp_version >= 4.4 ) {
            add_action( 'admin_init', array( $this, 'init') );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_media') );
        }
    }

    public function init() {
        $taxonomies = get_taxonomies( '', 'objects' );

        foreach( $taxonomies as $taxonomy => $options ) {
            add_action( $taxonomy . '_add_form_fields', array( $this, 'add_term_form' ) );
            add_action( $taxonomy . '_edit_form_fields', array( $this, 'edit_term_form' ) );
            add_action( 'created_' . $taxonomy, array( $this, 'update_term' ) );
            add_action( 'edited_' . $taxonomy, array( $this, 'update_term' ) );

            add_filter( 'manage_edit-' . $taxonomy . '_columns', array( $this, 'overview_columns' )  );
            add_filter( 'manage_' . $taxonomy . '_custom_column', array( $this, 'overview_content' ), 10, 3 );
        }
    }

    public function enqueue_media() {
        wp_enqueue_media();
    }

    public function add_term_form( $taxonomy ) {
?>
        <div class="form-field term-custom-link">
            <label for="wpupg_custom_link"><?php _e( 'Grid Custom Link', 'wp-ultimate-post-grid' ); ?></label>
            <input name="wpupg_custom_link" id="wpupg_custom_link" type="text" value="" size="">
            <p><?php _e( 'Override the default link for this term.', 'wp-ultimate-post-grid' ); ?></p>
        </div>
        <div class="form-field term-custom-link-behaviour">
            <label for="wpupg_custom_link_behaviour"><?php _e( 'Grid Custom Link Behaviour', 'wp-ultimate-post-grid' ); ?></label>
            <select name="wpupg_custom_link_behaviour" id="wpupg_custom_link_behaviour">
                <?php
                $custom_link_behaviour_options = array(
                    'default' => __( 'Use grid default', 'wp-ultimate-post-grid' ),
                    '_self' => __( 'Open in same tab', 'wp-ultimate-post-grid' ),
                    '_blank' => __( 'Open in new tab', 'wp-ultimate-post-grid' ),
                    'none' => __( "Don't use links", 'wp-ultimate-post-grid' ),
                );

                foreach( $custom_link_behaviour_options as $custom_link_behaviour => $custom_link_behaviour_name ) {
                    echo '<option value="' . esc_attr( $custom_link_behaviour ) . '">' . $custom_link_behaviour_name . '</option>';
                }
                ?>
            </select>
            <p><?php _e( 'Override the link behaviour for this term.', 'wp-ultimate-post-grid' ); ?></p>
        </div>
        <div class="form-field term-custom-image">
            <label for="wpupg_custom_image"><?php _e( 'Grid Image', 'wp-ultimate-post-grid' ); ?></label>
            <img style="max-width: 100px; max-height: 100px;" id="wpupg_custom_image_img" src="">
            <input type="hidden" id="wpupg_custom_image" name="wpupg_custom_image" value="">
            <input type="button" id="wpupg_custom_image_button" class="button button-add" value="<?php _e( 'Add Grid Image', 'wp-ultimate-post-grid' ); ?>">
            <p><?php _e( 'Image to use in the grid.', 'wp-ultimate-post-grid' ); ?></p>
        </div>
<?php
    }

    public function edit_term_form( $term ) {
        $custom_link = get_term_meta( $term->term_id, 'wpupg_custom_link', true );
        $custom_link_behaviour = get_term_meta( $term->term_id, 'wpupg_custom_link_behaviour', true );
        $custom_image = get_term_meta( $term->term_id, 'wpupg_custom_image', true );

        $custom_image_url = '';
        if( $custom_image ) {
            $custom_image_src = wp_get_attachment_image_src( intval( $custom_image ), array( 100, 100 ) );
            $custom_image_url = isset( $custom_image_src[0] ) ? $custom_image_src[0] : '';
        }

        $custom_image_button = $custom_image ? __( 'Remove Grid Image', 'wp-ultimate-post-grid' ) : __( 'Add Grid Image', 'wp-ultimate-post-grid' );
        $custom_image_button_class = $custom_image ? 'button-remove' : 'button-add';

        ?>
        <tr class="form-field term-custom-link">
            <th scope="row"><label for="wpupg_custom_link"><?php _e( 'Grid Custom Link', 'wp-ultimate-post-grid' ); ?></label></th>
            <td><input name="wpupg_custom_link" id="wpupg_custom_link" type="text" value="<?php echo $custom_link; ?>" size="">
                <p class="description"><?php _e( 'Override the default link for this term.', 'wp-ultimate-post-grid' ); ?></p></td>
        </tr>
        <tr class="form-field term-custom-link-behaviour">
            <th scope="row"><label for="wpupg_custom_link_behaviour"><?php _e( 'Grid Custom Link Behaviour', 'wp-ultimate-post-grid' ); ?></label></th>
            <td><select name="wpupg_custom_link_behaviour" id="wpupg_custom_link_behaviour">
                    <?php
                    $custom_link_behaviour_options = array(
                        'default' => __( 'Use grid default', 'wp-ultimate-post-grid' ),
                        '_self' => __( 'Open in same tab', 'wp-ultimate-post-grid' ),
                        '_blank' => __( 'Open in new tab', 'wp-ultimate-post-grid' ),
                        'none' => __( "Don't use links", 'wp-ultimate-post-grid' ),
                    );

                    foreach( $custom_link_behaviour_options as $custom_link_behaviour_option => $custom_link_behaviour_name ) {
                        $selected = $custom_link_behaviour_option == $custom_link_behaviour ? ' selected="selected"' : '';
                        echo '<option value="' . esc_attr( $custom_link_behaviour_option ) . '"' . $selected . '>' . $custom_link_behaviour_name . '</option>';
                    }
                    ?>
                </select>
                <p class="description"><?php _e( 'Override the link behaviour for this term.', 'wp-ultimate-post-grid' ); ?></p></td>
        </tr>
        <tr class="form-field term-custom-image">
            <th scope="row"><label for="wpupg_custom_image"><?php _e( 'Grid Image', 'wp-ultimate-post-grid' ); ?></label></th>
            <td><img style="max-width: 100px; max-height: 100px;" id="wpupg_custom_image_img" src="<?php echo $custom_image_url; ?>">
                <input type="hidden" id="wpupg_custom_image" name="wpupg_custom_image" value="<?php echo $custom_image; ?>">
                <input type="button" id="wpupg_custom_image_button" class="button <?php echo $custom_image_button_class; ?>" value="<?php echo $custom_image_button; ?>">
                <p class="description"><?php _e( 'Image to use in the grid.', 'wp-ultimate-post-grid' ); ?></p></td>
        </tr>
    <?php
    }

    public function update_term( $term_id ) {
        if( isset( $_POST['wpupg_custom_link'] ) ) {
            $custom_link = trim( $_POST['wpupg_custom_link'] );
            update_term_meta( $term_id, 'wpupg_custom_link', $custom_link );
        }
        if( isset( $_POST['wpupg_custom_link_behaviour'] ) ) {
            $custom_link_behaviour = trim( $_POST['wpupg_custom_link_behaviour'] );
            update_term_meta( $term_id, 'wpupg_custom_link_behaviour', $custom_link_behaviour );
        }
        if( isset( $_POST['wpupg_custom_image'] ) ) {
            $custom_image = trim( $_POST['wpupg_custom_image'] );
            update_term_meta( $term_id, 'wpupg_custom_image', $custom_image );
        }
    }

    public function overview_columns( $columns ) {
        $columns['wpupg_custom_link'] = __( 'Custom Link', 'wp-ultimate-post-grid' );
        return $columns;
    }

    public function overview_content( $content, $column_name, $term_id ) {
        if( $column_name == 'wpupg_custom_link' ) {
            $content .= get_term_meta( intval( $term_id ), 'wpupg_custom_link', true );
        }

        return $content;
    }
}

WPUltimatePostGrid::loaded_addon( 'terms-grid', new WPUPG_Terms_Grid() );