<?php

/**
* Plugin Name: Load More Chefs
* Description: Emula el sistema de carga de Ajax Load More para un conjunto de chefs (WP_Users) 
* Version: 1.0
* Author: Esencial Sistemas - Samuel Garcia Alfageme
**/

require_once 'load_more_chefs.php';

/**
 * Carga de assets
 */
function load_more_chefs_assets(){
   wp_enqueue_script('load-more-chefs-js', plugins_url('assets/js/load_more_chefs.js',__FILE__));    
   wp_enqueue_style('load-more-chefs-css', plugins_url('assets/css/load_more_chefs.css',__FILE__));
}
add_action( 'wp_enqueue_scripts', 'load_more_chefs_assets' );

/**
 * Accion ajax para carga de mas chefs
 */
add_action('wp_ajax_loadMore_chefs', 'loadmorechefs_func');
add_action('wp_ajax_nopriv_loadMore_chefs', 'loadmorechefs_func');

/**
 * Cargamos el template inicial con los 4 primeros chefs
 * 
 * @param type $atts
 * @return type
 */
function loadmorechefs_func($atts) {
    
    $offset = filter_input(INPUT_POST, 'offset');
    $action = filter_input(INPUT_POST, 'action');
    $filter = filter_input(INPUT_POST, 'filter');
    
    //SI se trata de la carga inicial...
    if($offset == null || $offset == '' || empty($offset) || !isset($offset)){
        $offset = 0; //...offset a 0
        $hidden_param= $atts['filter']."_".$atts['city'];  //...parametros ocultos para la llamada AJAX
    }else{ //...si no, aprovechamos para emular el $atts de shortcode con el paso de argumentos hidden via AJAX                
        $atts_array = explode('_',$filter);
        $atts['filter'] = $atts_array[0];
        $atts['city'] = $atts_array[1];        
    }
    
    $response = get_chefs_offset($offset,$atts);

    //Si se trata de la carga inicial, ponemos el boton de cargar mas
    if($action == null || $action == '' || empty($action) || !isset($action)){
        $response = $response."<div class='load-more-chefs-reveal'><button class='loadmore-chefs'>Cargar más</button></div>"
                . "<input type='hidden' name='filter-loadmorechefs' value='".$hidden_param."'>";
        echo $response;
    }else{
        echo $response; 
        die();
    }
}
add_shortcode( 'loadmorechefs', 'loadmorechefs_func' );

function loadmorechefs_reveal(){
    
    $response ='';
    
    return $response;
}
