<?php 
/*
Plugin Name: AronWebpro Pictures Carousel
Version: 1.0
Description: Add Carousel to your page of your website.
Author: AronWebpro
Author URI: http://www.aronwebpro.com
Plugin URI: http://www.aronwebpro.com/plugins
License: GPLv2
*/
/*Block direct requests */
if (!defined( 'ABSPATH')) {
    exit;
}

function awpro_pictures_carousel_activate() {

    /* Version check */
    function aron_carousel_plugin_check() {
        global $wp_version;

        $exit_msg = 'WP AronWebpro Plugin requires WordPress 4.5 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress" target="_blank">Please update!</a>';

        if (version_compare($wp_version, "4.5", "<")) {

            exit ($exit_msg);
        }
    }
}

register_activation_hook(__FILE__, 'awpro_pictures_carousel_activate');

$carousel_path = plugin_dir_path(__FILE__);


if (is_admin()) {   
    require_once($carousel_path.'includes/awpro-post-type.php');
    require_once($carousel_path.'includes/awpro-orders-submenu.php');
}

require($carousel_path.'includes/awpro-homeslider-shortcode.php');


//Add Admin  style and script 
function awpro_pictures_carousel_admin_enqueue_scripts() {
    
    global $pagenow, $typenow;

    if ($typenow == 'awpro_carousel') {
        wp_enqueue_style('aronwebpro-admin-css', plugins_url('css/admin-homeslide.css', __FILE__) );
    }
    if ( ($pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow == 'awpro_carousel' ) {

        wp_enqueue_style('aronwebpro-admin-css', plugins_url('css/admin-homeslide.css', __FILE__) );
        wp_enqueue_script('aronwebpro-admin-js', plugins_url('js/admin-homeslide.js', __FILE__), array('jquery'), '20160910', true );
    }
    if ($pagenow == 'edit.php' && $typenow == 'awpro_carousel') {
        wp_enqueue_script('reorder-js', plugins_url('js/reorder.js', __FILE__), array('jquery', 'jquery-ui-sortable'), '20160911', true );

        //add security to ajax request
        wp_localize_script('reorder-js', 'WP_HOME_SLIDER', array(
            'security' => wp_create_nonce('wp_aronwebpro_homeslider_nonce'),
            'success' => 'Your carousel pictures order have been changed successfully!',
            'failure' => 'Something goes wrong!'
        ));
    }

    
}

add_action('admin_enqueue_scripts', 'awpro_pictures_carousel_admin_enqueue_scripts');


//Add style and scripts
function awpro_carousel_styles_scripts() {
    //Add front end styles
    wp_enqueue_style('aronwebpro-css-style', plugins_url('css/style.css', __FILE__) );
    //Add Boostrap framework
    wp_enqueue_style('aronwebpro-bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
    //Add Bostrap framework
    wp_enqueue_script('aronwebpro-bootsrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), '20160910', true );
}

add_action('wp_enqueue_scripts', 'awpro_carousel_styles_scripts');











