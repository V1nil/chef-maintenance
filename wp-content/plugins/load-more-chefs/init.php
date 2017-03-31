<?php

/**
* Plugin Name: Load More Chefs
* Description: Emula el sistema de carga de Ajax Load More para un conjunto de chefs (WP_Users) 
* Version: 1.0
* Author: Esencial Sistemas - Samuel Garcia Alfageme
**/

/**
 * Carga de assets
 */
function load_more_chefs_assets(){
   // wp_enqueue_script('load-more-chefs', plugins_url('/assets/js/load_more_chefs.js',__FILE__));    
}
add_action( 'wp_enqueue_scripts', 'load_more_chefs_assets' );


/**
 * Cargamos el template inicial con los 4 primeros chefs
 * 
 * @param type $atts
 * @return type
 */
function loadmorechefs_func() {
    
    $response = get_chefs_offset(4);
 
    return $response;

}
add_shortcode( 'loadmorechefs', 'loadmorechefs_func' );

function loadmorechefs_reveal(){
    
    $response ='';
    
    return $response;
}
