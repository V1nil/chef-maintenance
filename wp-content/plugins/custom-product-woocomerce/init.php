<?php

/**
* Plugin Name: Custom Product Woocomerce
* Description: Permite construir propiedades en productos de Woocomerce 
* Version: 1.0
* Author: Esencial Sistemas - Samuel Garcia Alfageme
**/


/**
 * SECCION DE PROMOCIONES
 */

/**
 * Registrar el producto durante la carga de plugins
 */
function register_promocion_product_type() {
	/**
	 * Deberia ir en otro archivo por motivos de organizacion pero lo dejamos aqui
	 */
	class WC_Product_Promocion extends WC_Product {
		public function __construct( $product ) {
			$this->product_type = 'promocion';
			parent::__construct( $product );
		}
	}
}
add_action( 'plugins_loaded', 'register_promocion_product_type' );
/**
 * Añadimos a la lista desplegable el objeto promo
 */
function add_promocion_product( $types ){
	$types[ 'promocion' ] = __( 'Promocion' );
	return $types;
}
add_filter( 'product_type_selector', 'add_promocion_product' );
/**
 * Mostramos las cajas de texo de los precios
 */
function promocion_custom_js() {
	if ( 'product' != get_post_type() ) :
		return;
	endif;
	?><script type='text/javascript'>
		jQuery( document ).ready( function() {
			jQuery( '.options_group.pricing' ).addClass( 'show_if_promocion' ).show();
		});
	</script><?php
}
add_action( 'admin_footer', 'promocion_custom_js' );

/**
 * Añadimos la sección de propiedades de la promo
 */
function custom_promocion_tabs( $tabs) {
	$tabs['promocion'] = array(
		'label'		=> __( 'Propiedades Promocion', 'woocommerce' ),
		'target'	=> 'promocion_options',
		'class'		=> array( 'show_if_promocion', 'hide_if_simple', 'hide_if_variable', 'hide_if_grouped', 'hide_if_external'),
	);
	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'custom_promocion_tabs' );

/**
 * Contenidos de la seccion que acabamos de crear
 */
function promocion_options_product_tab_content() {
	global $post;
	?><div id='promocion_options' class='panel woocommerce_options_panel'><?php
		?><div class='options_group'><?php
			woocommerce_wp_text_input( array(
				'id'			=> '_descuento_socios_promo',
				'label'			=> __( 'Descuento socios (%)', 'woocommerce' ),
				'type' 			=> 'text'
			) );
			woocommerce_wp_text_input( array(
				'id'			=> '_codigo_descuento_promo',
				'label'			=> __( 'Codigo de descuento', 'woocommerce' ),
				'type' 			=> 'text'
			) );
			woocommerce_wp_text_input( array(
				'id'			=> '_patrocinador_promo_nombre',
				'label'			=> __( 'Nombre patrocinador', 'woocommerce' ),
				'type' 			=> 'text',
			) );
			woocommerce_wp_text_input( array(
				'id'			=> '_patrocinador_promo',
				'label'			=> __( 'Imagen patrocinador (URL)', 'woocommerce' ),
				'desc_tip'		=> 'true',
				'description'	=> __( 'URL válida y accesible de la imagen del patrocinador', 'woocommerce' ),
				'type' 			=> 'text',
			) );
			woocommerce_wp_textarea_input( array(
				'id'			=> '_condiciones_promo',
				'label'			=> __( 'Condiciones', 'woocommerce' ),
				'type' 			=> 'text',
			) );
		?></div>

	</div><?php
}
add_action( 'woocommerce_product_data_panels', 'promocion_options_product_tab_content' );
/**
 * Guardamos los datos
 */
function save_promocion_option_field( $post_id ) {
    
    if ( isset( $_POST['_descuento_socios_promo'] ) ) {
        update_post_meta( $post_id, '_descuento_socios_promo', sanitize_text_field( $_POST['_descuento_socios_promo'] ) );
    }
    if ( isset( $_POST['_codigo_descuento_promo'] ) ) {
        update_post_meta( $post_id, '_codigo_descuento_promo', sanitize_text_field( $_POST['_codigo_descuento_promo'] ) );
    }
    if ( isset( $_POST['_patrocinador_promo_nombre'] ) ) {
        update_post_meta( $post_id, '_patrocinador_promo_nombre', sanitize_text_field( $_POST['_patrocinador_promo_nombre'] ) );
    }
    if ( isset( $_POST['_patrocinador_promo'] ) ) {
        update_post_meta( $post_id, '_patrocinador_promo', sanitize_text_field( $_POST['_patrocinador_promo'] ) );
    }
    if ( isset( $_POST['_condiciones_promo'] ) ) {
        update_post_meta( $post_id, '_condiciones_promo', sanitize_text_field( $_POST['_condiciones_promo'] ) );
    }
}
add_action( 'woocommerce_process_product_meta_promocion', 'save_promocion_option_field'  );

/**
 * SECCION DE TALLERES
 */

/**
 * Registrar el producto durante la carga de plugins
 */
function register_taller_product_type() {
	/**
	 * Deberia ir en otro archivo por motivos de organizacion pero lo dejamos aqui
	 */
	class WC_Product_Taller extends WC_Product {
		public function __construct( $product ) {
			$this->product_type = 'taller';
			parent::__construct( $product );
		}
	}
}
add_action( 'plugins_loaded', 'register_taller_product_type' );
/**
 * Añadimos a la lista desplegable el objeto promo
 */
function add_taller_product( $types ){
	$types[ 'taller' ] = __( 'Taller' );
	return $types;
}
add_filter( 'product_type_selector', 'add_taller_product' );
/**
 * Mostramos las cajas de texo de los precios
 */
function taller_custom_js() {
	if ( 'product' != get_post_type() ) :
		return;
	endif;
	?><script type='text/javascript'>
		jQuery( document ).ready( function() {
			jQuery( '.options_group.pricing' ).addClass( 'show_if_taller' ).show();
		});
	</script><?php
}
add_action( 'admin_footer', 'taller_custom_js' );

/**
 * Añadimos la sección de propiedades de la promo
 */
function custom_taller_tabs( $tabs) {
	$tabs['taller'] = array(
		'label'		=> __( 'Propiedades Taller', 'woocommerce' ),
		'target'	=> 'taller_options',
		'class'		=> array( 'show_if_taller', 'hide_if_simple', 'hide_if_variable', 'hide_if_grouped', 'hide_if_external','hide_if_promocion'),
	);
	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'custom_taller_tabs' );

/**
 * Contenidos de la seccion que acabamos de crear
 */
function taller_options_product_tab_content() {
	global $post;
	?><div id='taller_options' class='panel woocommerce_options_panel'><?php
		?><div class='options_group'><?php
			woocommerce_wp_text_input( array(
				'id'			=> '_descuento_socios',
				'label'			=> __( 'Descuento socios (%)', 'woocommerce' ),
				'type' 			=> 'text'
			) );
			woocommerce_wp_text_input( array(
				'id'			=> '_codigo_descuento',
				'label'			=> __( 'Codigo de descuento', 'woocommerce' ),
				'type' 			=> 'text'
			) );
			woocommerce_wp_text_input( array(
				'id'			=> '_patrocinador_nombre',
				'label'			=> __( 'Nombre patrocinador', 'woocommerce' ),
				'type' 			=> 'text',
			) );
			woocommerce_wp_text_input( array(
				'id'			=> '_patrocinador',
				'label'			=> __( 'Imagen patrocinador (URL)', 'woocommerce' ),
				'desc_tip'		=> 'true',
				'description'	=> __( 'URL válida y accesible de la imagen del patrocinador', 'woocommerce' ),
				'type' 			=> 'text',
			) );
			woocommerce_wp_textarea_input( array(
				'id'			=> '_condiciones',
				'label'			=> __( 'Condiciones', 'woocommerce' ),
				'type' 			=> 'text',
			) );
			woocommerce_wp_text_input( array(
				'id'			=> '_fecha_inicio',
				'label'			=> __( 'Fecha de inicio', 'woocommerce' ),
				'desc_tip'		=> 'true',
				'placeholder'   =>  'dd/mm/aaaa',
				'type' 			=> 'date'
			) );
			woocommerce_wp_text_input( array(
				'id'			=> '_fecha_fin',
				'label'			=> __( 'Fecha de fin', 'woocommerce' ),
				'desc_tip'		=> 'true',
				'placeholder'   =>  'dd/mm/aaaa',
				'type' 			=> 'date'
			) );     
			woocommerce_wp_text_input( array(
				'id'			=> '_dias_semana',
				'label'			=> __( 'Dias de la semana', 'woocommerce' ),
				'desc_tip'		=> 'true',
				'description'	=> __( 'Dias de la semana en los que se imparte el taller, separados por coma y espacio', 'woocommerce' ),
                                'placeholder'   =>  'L, X, J',
				'type' 			=> 'text'
			) );
			woocommerce_wp_textarea_input( array(
				'id'			=> '_contenido',
				'label'			=> __( 'Contenido - Texto', 'woocommerce' ),
				'type' 			=> 'text',
			) );
                        woocommerce_wp_textarea_input( array(
				'id'			=> '_bloques_taller_titulos',
				'label'			=> __( 'Titulos Bloques', 'woocommerce' ),
                                'desc_tip'		=> 'true',
				'description'	=> __( 'Defina los titulos de las secciones separados por una barra vertical | ', 'woocommerce' ),
				'placeholder'   =>  'Titulo 1 | Titulo 2 | Titulo 3',
				'type' 			=> 'text',
			) );
			woocommerce_wp_textarea_input( array(
				'id'			=> '_bloques_taller_descripciones',
				'label'			=> __( 'Descripciones Bloques', 'woocommerce' ),
                                'desc_tip'		=> 'true',
				'description'	=> __( 'Defina las descripciones de cada seccion separados por una barra vertical | ', 'woocommerce' ),
				'placeholder'   =>  'Descripcion 1 | Descripcion 2 | Descripcion 3',
				'type' 			=> 'text',
			) );
			woocommerce_wp_textarea_input( array(
				'id'			=> '_bloques_taller_archivos',
				'label'			=> __( 'Archivos Bloques', 'woocommerce' ),
                                'desc_tip'		=> 'true',
				'description'	=> __( 'Defina los archivos de cada seccion por una barra vertical | y separe cada URL por una  coma , ', 'woocommerce' ),
				'placeholder'   =>  'Archivo1Seccion1, Archivo2Seccion | Archivo1Seccion2 | Archivo1Seccion3, Archivo2Seccion3, Archivo3Seccion3',
				'type' 			=> 'text',
			) );
			woocommerce_wp_textarea_input( array(
				'id'			=> '_bloques_taller_videos',
				'label'			=> __( 'Videos Bloques', 'woocommerce' ),
                                'desc_tip'		=> 'true',
				'description'	=> __( 'Defina los videos de cada seccion por una barra vertical | y separe cada URL por una  coma , ', 'woocommerce' ),
				'placeholder'   =>  'Video1Seccion1, Video2Seccion | Video1Seccion2 | Video1Seccion3, Video2Seccion3, Video3Seccion3',
				'type' 			=> 'text',
			) );
			woocommerce_wp_text_input( array(
				'id'			=> '_duracion_videos',
				'label'			=> __( 'Duracion videos (horas)', 'woocommerce' ),
                                'placeholder'   =>  '120',
				'type' 			=> 'number'
			) );

                        
		?></div>

	</div><?php
}
add_action( 'woocommerce_product_data_panels', 'taller_options_product_tab_content' );
/**
 * Guardamos los datos
 */
function save_taller_option_field( $post_id ) {

    if ( isset( $_POST['_descuento_socios'] ) ) {
        update_post_meta( $post_id, '_descuento_socios', sanitize_text_field( $_POST['_descuento_socios'] ) );
    }
    if ( isset( $_POST['_codigo_descuento'] ) ) {
        update_post_meta( $post_id, '_codigo_descuento', sanitize_text_field( $_POST['_codigo_descuento'] ) );
    }
    if ( isset( $_POST['_patrocinador_nombre'] ) ) {
        update_post_meta( $post_id, '_patrocinador_nombre', sanitize_text_field( $_POST['_patrocinador_nombre'] ) );
    }
    if ( isset( $_POST['_patrocinador'] ) ) {
        update_post_meta( $post_id, '_patrocinador', sanitize_text_field( $_POST['_patrocinador'] ) );
    }
    if ( isset( $_POST['_condiciones'] ) ) {
        update_post_meta( $post_id, '_condiciones', sanitize_text_field( $_POST['_condiciones'] ) );
    }
    if ( isset( $_POST['_contenido'] ) ) {
        update_post_meta( $post_id, '_contenido', sanitize_text_field( $_POST['_contenido'] ) );
    }
    if ( isset( $_POST['_fecha_inicio'] ) ) {
        update_post_meta( $post_id, '_fecha_inicio', sanitize_text_field( $_POST['_fecha_inicio'] ) );
    }
    if ( isset( $_POST['_fecha_fin'] ) ) {
        update_post_meta( $post_id, '_fecha_fin', sanitize_text_field( $_POST['_fecha_fin'] ) );
    }
    if ( isset( $_POST['_dias_semana'] ) ) {
        update_post_meta( $post_id, '_dias_semana', sanitize_text_field( $_POST['_dias_semana'] ) );
    }
    if ( isset( $_POST['_bloques_taller_titulos'] ) ) {
        update_post_meta( $post_id, '_bloques_taller_titulos', sanitize_text_field( $_POST['_bloques_taller_titulos'] ) );
    }
    if ( isset( $_POST['_bloques_taller_descripciones'] ) ) {
        update_post_meta( $post_id, '_bloques_taller_descripciones', sanitize_text_field( $_POST['_bloques_taller_descripciones'] ) );
    }
    if ( isset( $_POST['_bloques_taller_archivos'] ) ) {
        update_post_meta( $post_id, '_bloques_taller_archivos', sanitize_text_field( $_POST['_bloques_taller_archivos'] ) );
    }
    if ( isset( $_POST['_bloques_taller_videos'] ) ) {
        update_post_meta( $post_id, '_bloques_taller_videos', sanitize_text_field( $_POST['_bloques_taller_videos'] ) );
    }
    if ( isset( $_POST['_duracion_videos'] ) ) {
        update_post_meta( $post_id, '_duracion_videos', sanitize_text_field( $_POST['_duracion_videos'] ) );
    }
    
}
add_action( 'woocommerce_process_product_meta_taller', 'save_taller_option_field'  );

