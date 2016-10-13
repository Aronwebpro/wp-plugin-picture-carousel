<?php
//if uninstall not caled from Wordpress exit

if(!define('WP_UNINSTALL_PLUGIN')){
    exit();
}


//Delete option from option table
delete_option('aronwebpro_plugin_options');
