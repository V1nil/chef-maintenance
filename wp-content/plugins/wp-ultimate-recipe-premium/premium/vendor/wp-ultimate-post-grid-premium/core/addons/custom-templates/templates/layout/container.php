<?php

class WPUPG_Template_Container extends WPUPG_Template_Block {

    public $editorField = 'container';

    public function __construct( $type = 'container' )
    {
        parent::__construct( $type );

        // This is always the starting point of the template
        $this->parent = -1;
        $this->row = 0;
        $this->column = 0;
        $this->order = 0;
    }

    public function output( $post, $args = array() )
    {
        if( !$this->output_block( $post, $args ) ) return '';

        $this->add_style( 'position', '' ); // Make sure position is handled by Isotope

        // Default arguments
        $args['desktop'] = true;
        $args['max_width'] = 9999;
        $args['max_height'] = 9999;

        $args['max_width'] = $this->max_width && $args['max_width'] > $this->max_width ? $this->max_width : $args['max_width'];
        $args['max_height'] = $this->max_height && $args['max_height'] > $this->max_height ? $this->max_height : $args['max_height'];

        if( isset( $args['classes'] ) ) {
            $this->classes = $args['classes'];
        }

        if( isset( $post->term ) && $post->term ) {
            $link = get_term_link( intval( $post->ID ), $post->post_type );
            $custom_link = get_term_meta( intval( $post->ID ), 'wpupg_custom_link', true );
            $custom_link_behaviour = get_term_meta( intval( $post->ID ), 'wpupg_custom_link_behaviour', true );
            $image = intval( get_term_meta( intval( $post->ID ), 'wpupg_custom_image', true ) );
            $image_url = $image ? wp_get_attachment_url( $image ) : '';
        } else {
            $link = get_permalink( $post->ID );
            $custom_link = trim( get_post_meta( $post->ID, 'wpupg_custom_link', true ) );
            $custom_link_behaviour = trim( get_post_meta( $post->ID, 'wpupg_custom_link_behaviour', true ) );
            $image = $post->post_type == 'attachment' ? $post->ID : get_post_thumbnail_id( $post->ID );
            $image_url = $image ? wp_get_attachment_url( $image ) : '';
        }

        $output = $this->before_output();

        ob_start();
?>
<div id="wpupg-container-post-<?php echo $post->ID; ?>"
     data-id="<?php echo $post->ID; ?>"
     data-permalink="<?php echo esc_attr( $link ); ?>"
     data-custom-link="<?php echo esc_attr( $custom_link ); ?>"
     data-custom-link-behaviour="<?php echo esc_attr( $custom_link_behaviour ); ?>"
     data-image="<?php echo esc_attr( $image_url ); ?>"
     <?php echo $this->style(); ?>>
    <?php $this->output_children( $post, 0, 0, $args ) ?>
</div>
<?php
        $output .= ob_get_contents();
        ob_end_clean();

        return $this->after_output( $output, $post );
    }
}