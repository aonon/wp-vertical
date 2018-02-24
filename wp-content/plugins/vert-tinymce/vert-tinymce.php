<?php
/*
Plugin Name: Vertical TinyMCE
Plugin URI: http://www.talchir.com/
Description: Vertical Rich Editor for Wordpress.
Version: 0.1.0
Author: Aonon Itegel
Author URI: http://www.talchir.com/
*/

function init_vert_tinymce(){
    $plugins_path =  plugin_dir_path( __FILE__ ) ;
    if ( ! class_exists( '_WP_Editors' ) ) {
			require( $plugins_path . 'class-wp-editor.php' );
		};
    // new _WP_Editors;
}

init_vert_tinymce();
