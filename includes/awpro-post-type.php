<?php
if (!defined( 'ABSPATH')) {
    exit;
}
/**
 * Register NEW Post types:
 *
 * Carousel Pictures
 *
 *
 */

//Register new Post type
function  awpro_register_picture_carousel_post_type() {

    $singular = 'Carousel Picture';
    $plural = 'Carousel Pictures';

    $labels = array(
        'name' => $plural,
        'singular_name' => $singular,
        'add_new' => 'Add New '.$singular,
        'add_new_item' => 'Add '. $singular,
        'edit_item' => 'Edit '.$singular,
        'new_item' => 'New'.$singular,
        'all_items' => 'All '.  $plural,
        'view_item' => 'View '. $plural
    );


    $args = array(
        'public'        => true,
        'labels'        => $labels,
        'supports'      => array('title', 'thumbnail', 'page-attributes'),
        'menu_icon'     => 'dashicons-images-alt',
        'menu_position' => 5,

    );

    register_post_type('awpro_carousel', $args);
}

//Add an action hook to register Carousel Pictures
add_action('init', 'awpro_register_picture_carousel_post_type' );





