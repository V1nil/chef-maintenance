<?php

/**
* Plugin Name: Chef Custom Taxonomies
* Description: Registra las taxonomias de Tipos de Cocina y de Areas de interes 
* Version: 1.0
* Author: Esencial Sistemas - Samuel Garcia Alfageme
**/

add_action( 'init', 'create_areas_de_interes_taxonomy', 0 );

function create_areas_de_interes_taxonomy() {

// Back GUI menu
  $labels = array(
    'name' => _x( 'Áreas Interés', 'taxonomy general name' ),
    'singular_name' => _x( 'Área Interés', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar áreas' ),
    'popular_items' => __( 'Áreas más populares' ),
    'all_items' => __( 'Todas las áreas' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar Área' ), 
    'update_item' => __( 'Actualizar Área' ),
    'add_new_item' => __( 'Añadir Área' ),
    'new_item_name' => __( 'Nuevo nombre de área' ),
    'separate_items_with_commas' => __( 'Separe las áreas con comas' ),
    'add_or_remove_items' => __( 'Añadir o quitar áreas' ),
    'choose_from_most_used' => __( 'Elija de entre las áreas más utilizadas' ),
    'menu_name' => __( 'Áreas de Interés' ),
  ); 

// Registramos las areas como tags
  register_taxonomy('areas-interes','post',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'area-interes' ),
  ));
}

add_action( 'init', 'create_tipos_de_cocina_taxonomy', 0 );

function create_tipos_de_cocina_taxonomy() {

// Back GUI menu
  $labels = array(
    'name' => _x( 'Tipos de Cocina', 'taxonomy general name' ),
    'singular_name' => _x( 'Tipo de cocina', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar tipos' ),
    'popular_items' => __( 'Tipos más populares' ),
    'all_items' => __( 'Todos los tipos' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar tipo' ), 
    'update_item' => __( 'Actualizar tipo' ),
    'add_new_item' => __( 'Añadir tipo' ),
    'new_item_name' => __( 'Nuevo nombre de tipo' ),
    'separate_items_with_commas' => __( 'Separe los tipos de cocina con comas' ),
    'add_or_remove_items' => __( 'Añadir o quitar tipos' ),
    'choose_from_most_used' => __( 'Elija de entre los tipos más utilizados' ),
    'menu_name' => __( 'Tipos de cocina' ),
  ); 

// Registramos las areas como tags
  register_taxonomy('tipos-cocina','post',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'tipos-cocina' ),
  ));
}