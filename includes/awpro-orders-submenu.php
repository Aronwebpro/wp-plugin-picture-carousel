<?php
if (!defined( 'ABSPATH')) {
    exit;
}

//Add sub menu item to Carousel Pictures
function awpro_add_submenu_page() {
    add_submenu_page(
        'edit.php?post_type=awpro_carousel',
        __('Reorder'),
        __('Reorder'),
        'manage_options',
        'reorder_carousel',
        'awpro_reorder_homslider_callback'
    );
}

//Hook to initiate function
add_action('admin_menu', 'awpro_add_submenu_page' );




//Call back function to return admin view in sub menu window
function awpro_reorder_homslider_callback() {

    $args = array(
        'post_type'  => 'awpro_carousel',
        'orderby'    => 'menu_order',
        'order'      => 'ASC',
        'no_found_rows'  => true, //increase wordpress speed by not overlook other posts
        'update_post_term_cache' => false,
        'post_per_post' => 50
    );

    $homeslidelisting = new WP_Query($args);
    
    ?>
        <div id="homeslider-sort">
            <div >
                <h1>Carousel Pictures</h1>
            </div>
            <div>
                <h2 id="name-title">Pictures Order List: <img src="<?php echo esc_url( admin_url().'/images/loading.gif'); ?>" id="loading-animation"></h2>
                <?php if ($homeslidelisting -> have_posts()) : 
                         ?>
                <ul id="custom-type-list" class="ui-sortable reorder-post-block">
                    <?php while ($homeslidelisting -> have_posts()): $homeslidelisting -> the_post();
                            $menu_order_value = get_post($id)->menu_order;
                            $order_number = $menu_order_value+1 ?>
                        <li id="<?php esc_attr(the_id()); ?>" class="list-of-pictures"><h2 class="list-post-title"><?php esc_html(the_title()); ?></h2><p class="list-post-picture"><?php esc_html(the_post_thumbnail('thumbnail')); ?></p></li>
                    <?php endwhile; ?>
                </ul>
                <?php else: ?>
                    <p>You don't have carousel pictures</p>

                <?php endif; ?>
            </div>
        </div>

<?php
}


//Function add Ajax security to plugin
function aronwebpro_save_reorder() {

    if (!check_ajax_referer('wp_aronwebpro_homeslider_nonce', 'security' )) {
        return wp_send_json_error('Invalid Nonce');
    }

    if (! current_user_can('manage_options' )) {
        return wp_send_json_error('You are not allow to do this');
    }
    $homeslider = $_POST['order'];
    $counter = 0;
    foreach( $homeslider as $item_id ) {
       $post = array(
            'ID' => (int)$item_id,
           'menu_order' => $counter,
       );


        wp_update_post($post);

        $counter++;
    }
    
    wp_send_json_success('Post Saved');

}

add_action('wp_ajax_save_carousel_order', 'aronwebpro_save_reorder');