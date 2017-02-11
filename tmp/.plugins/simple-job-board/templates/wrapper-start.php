<?php

/**
 * Content wrappers
 *
 * @author 	PressTigers
 * @package 	simple-job-board/templates
 * @version     2.2.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$template = get_option('template');

if (get_option('job_board_container_class')) {
    $container_class = get_option('job_board_container_class');
    $container_class = strtolower(str_replace(',', ' ', $container_class ));
} else {
    $container_class = 'container sjb-container';
}

if (get_option('job_board_container_id')) {
    $container_id = strtolower(get_option('job_board_container_id'));
} else {
    $container_id = 'container';
}

switch ($template) {
    case 'twentyeleven' :
        echo '<div id="primary"><div role="main"><div class="sjb-archive-wrapper">';
        break;
    case 'twentytwelve' :
        echo '<div id="primary"><div id="content" role="main" class="twentytwelve">';
        break;
    case 'twentythirteen' :
        echo '<div id="primary" class="site-content"><div id="content" role="main" class="entry-content twentythirteen">';
        break;
    case 'twentyfourteen' :
        echo '<div id="primary" class="content-area"><div id="content" role="main" class="site-content twentyfourteen"><div class="tfwc"><div class="sjb-archive-wrapper">';
        break;
    case 'twentyfifteen' :
        echo '<div id="primary" role="main" class="content-area twentyfifteen"><div id="main" class="site-main t15wc"><div class="sjb-archive-wrapper">';
        break;
    case 'twentysixteen' :
        echo '<div id="primary" class="content-area twentysixteen"><main id="main" class="site-main" role="main"><div class="sjb-archive-wrapper">';
        break;
    default :
        echo '<div class="' . $container_class . '" id="' . $container_id . '"><div id="content" role="main"><div class="sjb-wrap">';
        break;
}