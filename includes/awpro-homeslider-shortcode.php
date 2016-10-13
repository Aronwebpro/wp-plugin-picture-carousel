<?php
if (!defined( 'ABSPATH')) {
    exit;
}

//Add custom pictures size for carousel pictures
function carousel_picture_size_setup() {
    add_image_size( 'category-thumb', 300 ); // 300 pixels wide (and unlimited height)
    add_image_size( 'carousel-picture-size', 1920, auto); // (cropped)
}

add_action( 'after_setup_theme', 'carousel_picture_size_setup' );

//Shortcode function to display carousel in front end
function awpro_sample_shortcode() {
 
    $displaycarousel = '<div id="front-page-carousel" class="container-fluid">';
    $displaycarousel .= '<div id="banner-carousel" class="carousel" data-ride="carousel">';
    $displaycarousel .=	'<div id="carousel-images-5" class="carousel-inner">';
		
		 			$args = array('post_per_page' => '1', 'post_type' => 'awpro_carousel', 'menu_order' => '0');                                   
                    $pics_query = new WP_Query( $args );
                    while ( $pics_query->have_posts() ) :$pics_query->the_post();
                    global $post; 
             
                    $carousel_picture =  get_the_post_thumbnail($post, 'carousel-picture-size');
                    
	$displaycarousel .= '<div class="item active">'. $carousel_picture .'</div>';
    				 endwhile;
                    wp_reset_postdata();
                    $args2 = array( 'post_type' => 'awpro_carousel', 'orderby'=>'menu_order', 'order'=>'ASC' );  
                    $pics_query2 = new WP_Query( $args2 );
                    while ( $pics_query2 -> have_posts() ) : $pics_query2 -> the_post(); 
                    global $post;
                    $carousel_picture_passive =  get_the_post_thumbnail($post, 'carousel-picture-size');

                    if (get_post($id)->menu_order !== 0) {
    $displaycarousel .= '<div class="item">'. $carousel_picture_passive.'</div>';
    				} endwhile;
                    wp_reset_postdata();
    $displaycarousel .= '<ol id="carousel-indicator" class="carousel-indicators">';
    $displaycarousel .= '<li class="active" data-target="#banner-carousel" ></li>';
    				$args3 = array( 'post_type' => 'awpro_carousel');              
                        $pics_query3 = new WP_Query( $args3 );
                        while ( $pics_query3 -> have_posts() ) :
                            $pics_query3 -> the_post();
                        if (get_post($id)->menu_order !== 0) { 
    $displaycarousel .=	'<li data-target="#banner-carousel"></li>';
    				} endwhile;
    				wp_reset_postdata();
    $displaycarousel .= '</ol>';
    $displaycarousel .= '</div>';
    $displaycarousel .= '<a id="carousel-left-indicator" class="left carousel-control" href="#banner-carousel" role="button" data-slide="next">';
    $displaycarousel .= '<span class="glyphicon glyphicon-chevron-left"></span>';
    $displaycarousel .=	'</a>';
    $displaycarousel .=	'<a id="carousel-right-indicator" class="right carousel-control" href="#banner-carousel" role="button" data-slide="prev">';
    $displaycarousel .= '<span class="glyphicon glyphicon-chevron-right"></span>';
    $displaycarousel .=	'</a>';
    $displaycarousel .=	'</div>';
    $displaycarousel .= '</div><!-- carousel -->';


return $displaycarousel;


}

//Add hook
add_shortcode('awpro_carousel_1', 'awpro_sample_shortcode');



