<?php


/*
Plugin Name: Mongol Bichig Admin
Plugin URI: http://talchir.com/wp-monoglbichig
Description: Mongol Bichig Admin Theme
Author: Aonon Itegel
Version: 1.0.2
Author URI: http://talchir.com
*/

function load_chanai() {
	//f	ront load chanai,js
	wp_register_script( 'chanai', 'http://cdn.mongol-bichig.top/chanai2/chanai.js', array(), '', false);
	wp_enqueue_script( 'chanai' );
	wp_add_inline_script('chanai',"document.addEventListener('DOMContentLoaded',
        function () {
            var list = document.querySelectorAll('input[type=text], input[type=search], textarea');
            var ime = new chanai.IME({
              xhr: 'http://mongol-bichig.top/ime/',
              url: 'http://cdn.mongol-bichig.top/'
            });
            ime.bindIME(list);
        }
    );");
}

add_action( 'init', 'load_chanai' );


/*
* The below is a replacement of the wp_default_styles
 * function found in wp-includes/script-loader.php.
 */
function mong_wp_default_styles( &$styles ) {
	include( ABSPATH . WPINC . '/version.php' );
	// 	include an unmodified $wp_version
	
	if ( ! defined( 'SCRIPT_DEBUG' ) )
			define( 'SCRIPT_DEBUG', false !== strpos( $wp_version, '-src' ) );
	
	if ( ! $guessurl = site_url() )
			$guessurl = wp_guess_url();
	
	$styles->base_url = $guessurl;
	$styles->content_url = defined('WP_CONTENT_URL')? WP_CONTENT_URL : '';
	$styles->default_version = get_bloginfo( 'version' );
	$styles->text_direction = function_exists( 'is_rtl' ) && is_rtl() ? 'rtl' : 'ltr';
	$styles->default_dirs = array('/wp-content/plugins/mong-bichig-admin/', '/wp-content/plugins/mong-bichig-admin/css/');
	// 	$styles->default_dirs = array('/wp-admin/', '/wp-includes/css/');
	
	// 	Register a stylesheet for the selected admin color scheme.
		$styles->add( 'colors', true, array( 'wp-admin', 'buttons', 'normalize', 'dashicons' ) );
	
	$plugins_url = plugins_url('', __FILE__);
	$suffix = SCRIPT_DEBUG ? '' : '.min';
	
	// 	Admin CSS
	$styles->add( 'wp-admin',            "$plugins_url/css/wp-admin.css", array( 'normalize', 'dashicons' ) );
	$styles->add( 'login',               "$plugins_url/css/login.css", array(  'normalize', 'buttons', 'dashicons' ) );
	$styles->add( 'install',             "$plugins_url/css/install.css", array( 'normalize', 'buttons' ) );
	$styles->add( 'wp-color-picker',     "$plugins_url/css/color-picker.css" );
	$styles->add( 'customize-controls',  "$plugins_url/css/customize-controls.css", array( 'wp-admin', 'colors', 'ie', 'imgareaselect' ) );
	$styles->add( 'customize-widgets',   "$plugins_url/css/customize-widgets.css", array( 'wp-admin', 'colors' ) );
	$styles->add( 'customize-nav-menus', "$plugins_url/css/customize-nav-menus.css", array( 'wp-admin', 'colors' ) );
	$styles->add( 'press-this',          "$plugins_url/css/press-this.css", array(  'normalize', 'buttons' ) );
	
	$styles->add( 'ie', "$plugins_url/css/ie.css" );
	$styles->add_data( 'ie', 'conditional', 'lte IE 7' );
	
	// 	Common dependencies
		$styles->add( 'buttons',   plugins_url('/css/buttons.css', __FILE__) );
	$styles->add( 'dashicons', plugins_url('/css/dashicons.css', __FILE__) );
	$styles->add( 'normalize', plugins_url('/css/normalize.css', __FILE__) );
	
	// 	Includes CSS
		$styles->add( 'admin-bar',            "$plugins_url/css/admin-bar.css", array(  'dashicons' ) );
	$styles->add( 'wp-auth-check',        "$plugins_url/css/wp-auth-check.css", array( 'dashicons' ) );
	$styles->add( 'editor-buttons',       "$plugins_url/css/editor.css", array( 'dashicons' ) );
	$styles->add( 'media-views',          "$plugins_url/css/media-views.css", array( 'buttons', 'dashicons', 'wp-mediaelement' ) );
	$styles->add( 'wp-pointer',           "$plugins_url/css/wp-pointer.css", array( 'dashicons' ) );
	$styles->add( 'customize-preview',    "$plugins_url/css/customize-preview.css" );
	
	$styles->add( 'wp-embed-template-ie', "$plugins_url/css/wp-embed-template-ie.css" );
	$styles->add_data( 'wp-embed-template-ie', 'conditional', 'lte IE 8' );
	
	// 	External libraries and friends
		$styles->add( 'imgareaselect',       "$plugins_url/js/imgareaselect/imgareaselect.css", array(), '0.9.8' );
	$styles->add( 'wp-jquery-ui-dialog', "$plugins_url/css/jquery-ui-dialog.css", array( 'dashicons' ) );
	$styles->add( 'mediaelement',        "$plugins_url/js/mediaelement/mediaelementplayer.min.css", array(), '2.18.1' );
	$styles->add( 'wp-mediaelement',     "$plugins_url/js/mediaelement/wp-mediaelement.css", array( 'mediaelement' ) );
	$styles->add( 'thickbox',            "$plugins_url/js/thickbox/thickbox.css", array( 'dashicons' ) );
	
	// 	Deprecated CSS
		$styles->add( 'media',      "$plugins_url/css/deprecated-media.css" );
	$styles->add( 'farbtastic', "$plugins_url/css/farbtastic.css", array(), '1.3u1' );
	$styles->add( 'jcrop',      "$plugins_url/js/jquery.Jcrop.min.css", array(), '0.9.12' );
	$styles->add( 'colors-fresh', false, array( 'wp-admin', 'buttons' ) );
	// 	Old handle.*/
	
	// 	RTL CSS
		$rtl_styles = array(
			// 	wp-admin
			'wp-admin', 'install', 'wp-color-picker', 'customize-controls', 'customize-widgets', 'customize-nav-menus', 'ie', 'login', 'press-this',
			// 	wp-includes
			'buttons', 'admin-bar', 'wp-auth-check', 'editor-buttons', 'media-views', 'wp-pointer',
			'wp-jquery-ui-dialog',
			// 	deprecated
			'media', 'farbtastic',
		);
	
	foreach ( $rtl_styles as $rtl_style ) {
		$styles->add_data( $rtl_style, 'rtl', 'replace' );
		if ( $suffix ) {
			$styles->add_data( $rtl_style, 'suffix', $suffix );
		}
	}
}

remove_action( 'wp_default_styles', 'wp_default_styles' );
// removes the default wp_default_styles function
add_action( 'wp_default_styles', 'mong_wp_default_styles' );
// adds our customized bootstrap_admin_wp_default_styles function

//add_action( 'wp_default_scripts', 'mong_wp_default_scripts' );
function mong_wp_default_scripts( &$scripts ) {
	include( ABSPATH . WPINC . '/version.php' );
	// 	include an unmodified $wp_version
	
	$develop_src = false !== strpos( $wp_version, '-src' );
	
	if ( ! defined( 'SCRIPT_DEBUG' ) ) {
		define( 'SCRIPT_DEBUG', $develop_src );
	}
	
	if ( ! $guessurl = site_url() ) {
		$guessed_url = true;
		$guessurl = wp_guess_url();
	}
	
	$plugins_url = plugins_url('', __FILE__);
	
	$scripts->base_url = $guessurl;
	$scripts->content_url = defined('WP_CONTENT_URL')? WP_CONTENT_URL : '';
	$scripts->default_version = get_bloginfo( 'version' );
	$scripts->default_dirs = array('/wp-content/plugins/mong-bichig-admin/js/', '/wp-content/plugins/mong-bichig-admin/js/');
	
	$scripts->add( 'utils', "$plugins_url/js/utils.js" );
	did_action( 'init' ) && $scripts->localize( 'utils', 'userSettings', array(
			'url' => (string) SITECOOKIEPATH,
			'uid' => (string) get_current_user_id(),
			'time' => (string) time(),
			'secure' => (string) ( 'https' === parse_url( site_url(), PHP_URL_SCHEME ) ),
		) );
	
	$scripts->add( 'common', "$plugins_url/js/common.js", array('jquery', 'hoverIntent', 'utils'), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'common', 'commonL10n', array(
			'warnDelete' => __( "You are about to permanently delete these items.\n  'Cancel' to stop, 'OK' to delete." ),
			'dismiss'    => __( 'Dismiss this notice.' ),
		) );
	
	$scripts->add( 'wp-a11y', "$plugins_url/js/wp-a11y.js", array( 'jquery' ), false, 1 );
	
	$scripts->add( 'sack', "$plugins_url/js/tw-sack.js", array(), '1.6.1', 1 );
	
	$scripts->add( 'quicktags', "$plugins_url/js/quicktags.js", array(), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'quicktags', 'quicktagsL10n', array(
			'closeAllOpenTags'      => __( 'Close all open tags' ),
			'closeTags'             => __( 'close tags' ),
			'enterURL'              => __( 'Enter the URL' ),
			'enterImageURL'         => __( 'Enter the URL of the image' ),
			'enterImageDescription' => __( 'Enter a description of the image' ),
			'textdirection'         => __( 'text direction' ),
			'toggleTextdirection'   => __( 'Toggle Editor Text Direction' ),
			'dfw'                   => __( 'Distraction-free writing mode' ),
			'strong'          => __( 'Bold' ),
			'strongClose'     => __( 'Close bold tag' ),
			'em'              => __( 'Italic' ),
			'emClose'         => __( 'Close italic tag' ),
			'link'            => __( 'Insert link' ),
			'blockquote'      => __( 'Blockquote' ),
			'blockquoteClose' => __( 'Close blockquote tag' ),
			'del'             => __( 'Deleted text (strikethrough)' ),
			'delClose'        => __( 'Close deleted text tag' ),
			'ins'             => __( 'Inserted text' ),
			'insClose'        => __( 'Close inserted text tag' ),
			'image'           => __( 'Insert image' ),
			'ul'              => __( 'Bulleted list' ),
			'ulClose'         => __( 'Close bulleted list tag' ),
			'ol'              => __( 'Numbered list' ),
			'olClose'         => __( 'Close numbered list tag' ),
			'li'              => __( 'List item' ),
			'liClose'         => __( 'Close list item tag' ),
			'code'            => __( 'Code' ),
			'codeClose'       => __( 'Close code tag' ),
			'more'            => __( 'Insert Read More tag' ),
		) );
	
	$scripts->add( 'colorpicker', "$plugins_url/js/colorpicker.js", array('prototype'), '3517m' );
	
	$scripts->add( 'editor', "$plugins_url/js/editor.js", array('utils','jquery'), false, 1 );
	
	// 	Back-compat for old DFW. To-do: remove at the end of 2016.
		$scripts->add( 'wp-fullscreen-stub', "$plugins_url/js/wp-fullscreen-stub.js", array(), false, 1 );
	
	$scripts->add( 'wp-ajax-response', "$plugins_url/js/wp-ajax-response.js", array('jquery'), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'wp-ajax-response', 'wpAjax', array(
			'noPerm' => __('You do not have permission to do that.'),
			'broken' => __('An unidentified error has occurred.')
		) );
	
	$scripts->add( 'wp-pointer', "$plugins_url/js/wp-pointer.js", array( 'jquery-ui' ), '20111129a', 1 );
	did_action( 'init' ) && $scripts->localize( 'wp-pointer', 'wpPointerL10n', array(
			'dismiss' => __('Dismiss'),
		) );
	
	$scripts->add( 'autosave', "$plugins_url/js/autosave.js", array('heartbeat'), false, 1 );
	
	$scripts->add( 'heartbeat', "$plugins_url/js/heartbeat.js", array('jquery'), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'heartbeat', 'heartbeatSettings',
			
	/**
	* Filter the Heartbeat settings.
			 *
			 * @since 3.6.0
			 *
			 * @param array $settings Heartbeat settings array.
			 */
			apply_filters( 'heartbeat_settings', array() )
		);
	
	$scripts->add( 'wp-auth-check', "$plugins_url/js/wp-auth-check.js", array('heartbeat'), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'wp-auth-check', 'authcheckL10n', array(
			'beforeunload' => __('Your session has expired. You can log in again from this page or go to the login page.'),
	
	
	/**
	* Filter the authentication check interval.
			 *
			 * @since 3.6.0
			 *
			 * @param int $interval The interval in which to check a user's authentication.
		 *                      Default 3 minutes in seconds, or 180.
		 */
		'interval' => apply_filters( 'wp_auth_check_interval', 3 * MINUTE_IN_SECONDS ),
	) );
	$scripts->add( 'wp-lists', "$plugins_url/js/wp-lists.js", array( 'wp-ajax-response', 'jquery-color' ), false, 1 );
	// WordPress no longer uses or bundles Prototype or script.aculo.us. These are now pulled from an external source.
	$scripts->add( 'prototype', 'https://a	jax.googleapis.com/ajax/libs/prototype/1.7.1.0/prototype.js', array(), '1.7.1');
	$scripts->add( 'scriptaculous-root', 'https://a	jax.googleapis.com/ajax/libs/scriptaculous/1.9.0/scriptaculous.js', array('prototype'), '1.9.0');
	$scripts->add( 'scriptaculous-builder', 'https://a	jax.googleapis.com/ajax/libs/scriptaculous/1.9.0/builder.js', array('scriptaculous-root'), '1.9.0');
	$scripts->add( 'scriptaculous-dragdrop', 'https://a	jax.googleapis.com/ajax/libs/scriptaculous/1.9.0/dragdrop.js', array('scriptaculous-builder', 'scriptaculous-effects'), '1.9.0');
	$scripts->add( 'scriptaculous-effects', 'https://a	jax.googleapis.com/ajax/libs/scriptaculous/1.9.0/effects.js', array('scriptaculous-root'), '1.9.0');
	$scripts->add( 'scriptaculous-slider', 'https://a	jax.googleapis.com/ajax/libs/scriptaculous/1.9.0/slider.js', array('scriptaculous-effects'), '1.9.0');
	$scripts->add( 'scriptaculous-sound', 'https://a	jax.googleapis.com/ajax/libs/scriptaculous/1.9.0/sound.js', array( 'scriptaculous-root' ), '1.9.0' );
	$scripts->add( 'scriptaculous-controls', 'https://a	jax.googleapis.com/ajax/libs/scriptaculous/1.9.0/controls.js', array('scriptaculous-root'), '1.9.0');
	$scripts->add( 'scriptaculous', false, array('scriptaculous-dragdrop', 'scriptaculous-slider', 'scriptaculous-controls') );
	// not used in core, replaced by Jcrop.js
	$scripts->add( 'cropper', "$plugins_url/js/crop/cropper.js", array('scriptaculous-dragdrop') );
	// jQuery
	$scripts->add( 'jquery', false, array( 'jquery-core', 'jquery-migrate' ), '2.2.4' );
	$scripts->add( 'jquery-core', "$plugins_url/js/jquery/jquery.js", array(), '2.2.4' );
	$scripts->add( 'jquery-migrate', "$plugins_url/js/jquery/jquery-migrate.js", array(), '1.4.1' );
	// full jQuery UI
	$scripts->add( 'jquery-ui', "$plugins_url/js/jquery-ui/jquery-ui.js", array('jquery'), '1.11.4', 1 );
	// deprecated, not used in core, most functionality is included in jQuery 1.3
	$scripts->add( 'jquery-form', "$plugins_url/js/jquery/jquery.form.js", array('jquery'), '3.37.0', 1 );
	// jQuery plugins
	$scripts->add( 'jquery-color', "$plugins_url/js/jquery/jquery.color.min.js", array('jquery'), '2.1.1', 1 );
	$scripts->add( 'suggest', "$plugins_url/js/jquery/suggest.js", array('jquery'), '1.1-20110113', 1 );
	$scripts->add( 'schedule', "$plugins_url/js/jquery/jquery.schedule.js", array('jquery'), '20m', 1 );
	$scripts->add( 'jquery-query', "$plugins_url/js/jquery/jquery.query.js", array('jquery'), '2.1.7', 1 );
	$scripts->add( 'jquery-serialize-object', "$plugins_url/js/jquery/jquery.serialize-object.js", array('jquery'), '0.2', 1 );
	$scripts->add( 'jquery-hotkeys', "$plugins_url/js/jquery/jquery.hotkeys.js", array('jquery'), '0.0.2m', 1 );
	$scripts->add( 'jquery-table-hotkeys', "$plugins_url/js/jquery/jquery.table-hotkeys.js", array('jquery', 'jquery-hotkeys'), false, 1 );
	$scripts->add( 'jquery-touch-punch', "$plugins_url/js/jquery/jquery.ui.touch-punch.js", array('jquery-ui'), '0.2.2', 1 );
	// Masonry 4.1 no jQuery and vertical.
	$scripts->add( 'masonry', "$plugins_url/js/masonry.vert.js", array(), '4.1.0', 1 );
	$scripts->add( 'thickbox', "$plugins_url/js/thickbox/thickbox.js", array('jquery'), '3.1-20121105', 1 );
	did_action( 'init' ) && $scripts->localize( 'thickbox', 'thickboxL10n', array(
			'next' => __('Next &gt;
	'),
			'prev' => __('&lt;
	Prev'),
			'image' => __('Image'),
			'of' => __('of'),
			'close' => __('Close'),
			'noiframes' => __('This feature requires inline frames. You have iframes disabled or your browser does not support them.'),
			'loadingAnimation' => includes_url('js/thickbox/loadingAnimation.gif'),
	) );
	$scripts->add( 'jcrop', "$plugins_url/js/jcrop/jquery.Jcrop.min.js", array('jquery'), '0.9.12');
	$scripts->add( 'swfobject', "$plugins_url/js/swfobject.js", array(), '2.2-20120417');
	// error message for both plupload and swfupload
	$uploader_l10n = array(
		'queue_limit_exceeded' => __('You have attempted to queue too many files.'),
		'file_exceeds_size_limit' => __('%s exceeds the maximum upload size for this site.'),
		'zero_byte_file' => __('This file is empty. Please try another.'),
		'invalid_filetype' => __('This file type is not allowed. Please try another.'),
		'not_an_image' => __('This file is not an image. Please try another.'),
		'image_memory_exceeded' => __('Memory exceeded. Please try another smaller file.'),
		'image_dimensions_exceeded' => __('This is larger than the maximum size. Please try another.'),
		'default_error' => __('An error occurred in the upload. Please try again later.'),
		'missing_upload_url' => __('There was a configuration error. Please contact the server administrator.'),
		'upload_limit_exceeded' => __('You may only upload 1 file.'),
		'http_error' => __('HTTP error.'),
		'upload_failed' => __('Upload failed.'),
		'big_upload_failed' => __('Please try uploading this file with the %1$sbrowser uploader%2$s.'),
		'big_upload_queued' => __('%s exceeds the maximum upload size for the multi-file uploader when used in your browser.'),
		'io_error' => __('IO error.'),
		'security_error' => __('Security error.'),
		'file_cancelled' => __('File canceled.'),
		'upload_stopped' => __('Upload stopped.'),
		'dismiss' => __('Dismiss'),
		'crunching' => __('Crunching&hellip;
	'),
		'deleted' => __('moved to the trash.'),
		'error_uploading' => __('&#8220;
	%s&#8221;
	has failed to upload.')
	);
	$scripts->add( 'plupload', "$plugins_url/js/plupload/plupload.full.min.js", array(), '2.1.8' );
	// Back compat handles:
	foreach ( array( 'all', 'html5', 'flash', 'silverlight', 'html4' ) as $handle ) {
		$scripts->add( "plupload-$handle", false, array( 'plupload' ), '2.1.1' );
	}
	$scripts->add( 'plupload-handlers', "$plugins_url/js/plupload/handlers.js", array( 'plupload', 'jquery' ) );
	did_action( 'init' ) && $scripts->localize( 'plupload-handlers', 'pluploadL10n', $uploader_l10n );
	$scripts->add( 'wp-plupload', "$plugins_url/js/plupload/wp-plupload.js", array( 'plupload', 'jquery', 'json2', 'media-models' ), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'wp-plupload', 'pluploadL10n', $uploader_l10n );
	// keep 'swfupload' for back-compat.
	$scripts->add( 'swfupload', "$plugins_url/js/swfupload/swfupload.js", array(), '2201-20110113');
	$scripts->add( 'swfupload-swfobject', "$plugins_url/js/swfupload/plugins/swfupload.swfobject.js", array('swfupload', 'swfobject'), '2201a');
	$scripts->add( 'swfupload-queue', "$plugins_url/js/swfupload/plugins/swfupload.queue.js", array('swfupload'), '2201');
	$scripts->add( 'swfupload-speed', "$plugins_url/js/swfupload/plugins/swfupload.speed.js", array('swfupload'), '2201');
	$scripts->add( 'swfupload-all', false, array('swfupload', 'swfupload-swfobject', 'swfupload-queue'), '2201');
	$scripts->add( 'swfupload-handlers', "$plugins_url/js/swfupload/handlers.js", array('swfupload-all', 'jquery'), '2201-20110524');
	did_action( 'init' ) && $scripts->localize( 'swfupload-handlers', 'swfuploadL10n', $uploader_l10n );
	$scripts->add( 'comment-reply', "$plugins_url/js/comment-reply.js", array(), false, 1 );
	$scripts->add( 'json2', "$plugins_url/js/json2.js", array(), '2015-05-03' );
	did_action( 'init' ) && $scripts->add_data( 'json2', 'conditional', 'lt IE 8' );
	$scripts->add( 'underscore', "$plugins_url/js/underscore.min.js", array(), '1.6.0', 1 );
	$scripts->add( 'backbone', "$plugins_url/js/backbone.min.js", array( 'underscore','jquery' ), '1.1.2', 1 );
	$scripts->add( 'wp-util', "$plugins_url/js/wp-util.js", array('underscore', 'jquery'), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'wp-util', '_wpUtilSettings', array(
		'ajax' => array(
			'url' => admin_url( 'admin-ajax.php', 'relative' ),
		),
	) );
	$scripts->add( 'wp-backbone', "$plugins_url/js/wp-backbone.js", array('backbone', 'wp-util'), false, 1 );
	$scripts->add( 'revisions', "$plugins_url/js/revisions.js", array( 'wp-backbone', 'jquery-ui', 'hoverIntent' ), false, 1 );
	$scripts->add( 'imgareaselect', "$plugins_url/js/imgareaselect/jquery.imgareaselect.js", array('jquery'), false, 1 );
	$scripts->add( 'mediaelement', "$plugins_url/js/mediaelement/mediaelement-and-player.min.js", array('jquery'), '2.18.1', 1 );
	did_action( 'init' ) && $scripts->localize( 'mediaelement', 'mejsL10n', array(
		'language' => get_bloginfo( 'language' ),
		'strings'  => array(
			'Close'               => __( 'Close' ),
			'Fullscreen'          => __( 'Fullscreen' ),
			'Download File'       => __( 'Download File' ),
			'Download Video'      => __( 'Download Video' ),
			'Play/Pause'          => __( 'Play/Pause' ),
			'Mute Toggle'         => __( 'Mute Toggle' ),
			'None'                => __( 'None' ),
			'Turn off Fullscreen' => __( 'Turn off Fullscreen' ),
			'Go Fullscreen'       => __( 'Go Fullscreen' ),
			'Unmute'              => __( 'Unmute' ),
			'Mute'                => __( 'Mute' ),
			'Captions/Subtitles'  => __( 'Captions/Subtitles' )
		),
	) );
	$scripts->add( 'wp-mediaelement', "$plugins_url/js/mediaelement/wp-mediaelement.js", array('mediaelement'), false, 1 );
	$mejs_settings = array(
		'pluginPath' => includes_url( 'js/mediaelement/', 'relative' ),
	);
	did_action( 'init' ) && $scripts->localize( 'mediaelement', '_wpmejsSettings',
		/**
		 * Filter the MediaElement configuration settings.
		 *
		 * @since 4.4.0
		 *
		 * @param array $mejs_settings MediaElement settings array.
		 */
		apply_filters( 'mejs_settings', $mejs_settings )
	);
	$scripts->add( 'froogaloop',  "$plugins_url/js/mediaelement/froogaloop.min.js", array(), '2.0' );
	$scripts->add( 'wp-playlist', "$plugins_url/js/mediaelement/wp-playlist.js", array( 'wp-util', 'backbone', 'mediaelement' ), false, 1 );
	$scripts->add( 'zxcvbn-async', "$plugins_url/js/zxcvbn-async.js", array(), '1.0' );
	did_action( 'init' ) && $scripts->localize( 'zxcvbn-async', '_zxcvbnSettings', array(
		'src' => empty( $guessed_url ) ? includes_url( '/js/zxcvbn.min.js' ) : $scripts->base_url . "$plugins_url/js/zxcvbn.min.js",
	) );
	$scripts->add( 'password-strength-meter', "$plugins_url/js/password-strength-meter.js", array( 'jquery', 'zxcvbn-async' ), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'password-strength-meter', 'pwsL10n', array(
		'short'    => _x( 'Very weak', 'password strength' ),
		'bad'      => _x( 'Weak', 'password strength' ),
		'good'     => _x( 'Medium', 'password strength' ),
		'strong'   => _x( 'Strong', 'password strength' ),
		'mismatch' => _x( 'Mismatch', 'password mismatch' ),
	) );
	$scripts->add( 'user-profile', "$plugins_url/js/user-profile.js", array( 'jquery', 'password-strength-meter', 'wp-util' ), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'user-profile', 'userProfileL10n', array(
		'warn'     => __( 'Your new password has not been saved.' ),
		'show'     => __( 'Show' ),
		'hide'     => __( 'Hide' ),
		'cancel'   => __( 'Cancel' ),
		'ariaShow' => esc_attr__( 'Show password' ),
		'ariaHide' => esc_attr__( 'Hide password' ),
	) );
	$scripts->add( 'language-chooser', "$plugins_url/js/language-chooser.js", array( 'jquery' ), false, 1 );
	$scripts->add( 'user-suggest', "$plugins_url/js/user-suggest.js", array( 'jquery-ui' ), false, 1 );
	$scripts->add( 'admin-bar', "$plugins_url/js/admin-bar.js", array(), false, 1 );
	$scripts->add( 'wplink', "$plugins_url/js/wplink.js", array( 'jquery' ), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'wplink', 'wpLinkL10n', array(
		'title' => __('Insert/edit link'),
		'update' => __('Update'),
		'save' => __('Add Link'),
		'noTitle' => __('(no title)'),
		'noMatchesFound' => __('No results found.')
	) );
	$scripts->add( 'wpdialogs', "$plugins_url/js/wpdialog.js", array( 'jquery-ui' ), false, 1 );
	$scripts->add( 'word-count', "$plugins_url/js/word-count.js", array(), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'word-count', 'wordCountL10n', array(
		/*
		 * translators: If your word count is based on single characters (e.g. East Asian characters),
		 * enter 'characters_excluding_spaces' or 'characters_including_spaces'. Otherwise, enter 'words'.
		 * Do not translate into your own language.
		 */
		'type' => _x( 'words', 'Word count type. Do not translate!' ),
		'shortcodes' => ! empty( $GLOBALS['shortcode_tags'] ) ? array_keys( $GLOBALS['shortcode_tags'] ) : array()
	) );
	$scripts->add( 'media-upload', "$plugins_url/js/media-upload.js", array( 'thickbox', 'shortcode' ), false, 1 );
	$scripts->add( 'hoverIntent', "$plugins_url/js/hoverIntent.js", array('jquery'), '1.8.1', 1 );
	$scripts->add( 'customize-base',     "$plugins_url/js/customize-base.js",     array( 'jquery', 'json2', 'underscore' ), false, 1 );
	$scripts->add( 'customize-loader',   "$plugins_url/js/customize-loader.js",   array( 'customize-base' ), false, 1 );
	$scripts->add( 'customize-preview',  "$plugins_url/js/customize-preview.js",  array( 'customize-base' ), false, 1 );
	$scripts->add( 'customize-models',   "$plugins_url/js/customize-models.js", array( 'underscore', 'backbone' ), false, 1 );
	$scripts->add( 'customize-views',    "$plugins_url/js/customize-views.js",  array( 'jquery', 'underscore', 'imgareaselect', 'customize-models', 'media-editor', 'media-views' ), false, 1 );
	$scripts->add( 'customize-controls', "$plugins_url/js/customize-controls.js", array( 'customize-base', 'wp-a11y' ), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'customize-controls', '_wpCustomizeControlsL10n', array(
		'activate'           => __( 'Save &amp;
	Activate' ),
		'save'               => __( 'Save &amp;
	Publish' ),
		'saveAlert'          => __( 'The changes you made will be lost if you navigate away from this page.' ),
		'saved'              => __( 'Saved' ),
		'cancel'             => __( 'Cancel' ),
		'close'              => __( 'Close' ),
		'cheatin'            => __( 'Cheatin&#8217;
	uh?' ),
		'notAllowed'         => __( 'You are not allowed to customize the appearance of this site.' ),
		'previewIframeTitle' => __( 'Site Preview' ),
		'loginIframeTitle'   => __( 'Session expired' ),
		'collapseSidebar'    => __( 'Collapse Sidebar' ),
		'expandSidebar'      => __( 'Expand Sidebar' ),
		// Used for overriding the file types allowed in plupload.
		'allowedFiles'       => __( 'Allowed Files' ),
	) );
	$scripts->add( 'customize-widgets', "$plugins_url/js/customize-widgets.js", array( 'jquery', 'jquery-ui', 'wp-backbone', 'customize-controls' ), false, 1 );
	$scripts->add( 'customize-preview-widgets', "$plugins_url/js/customize-preview-widgets.js", array( 'jquery', 'wp-util', 'customize-preview' ), false, 1 );
	$scripts->add( 'customize-nav-menus', "$plugins_url/js/customize-nav-menus.js", array( 'jquery', 'wp-backbone', 'customize-controls', 'accordion', 'nav-menu' ), false, 1 );
	$scripts->add( 'customize-preview-nav-menus', "$plugins_url/js/customize-preview-nav-menus.js", array( 'jquery', 'wp-util', 'customize-preview' ), false, 1 );
	$scripts->add( 'accordion', "$plugins_url/js/accordion.js", array( 'jquery' ), false, 1 );
	$scripts->add( 'shortcode', "$plugins_url/js/shortcode.js", array( 'underscore' ), false, 1 );
	$scripts->add( 'media-models', "$plugins_url/js/media-models.js", array( 'wp-backbone' ), false, 1 );
	did_action( 'init' ) && $scripts->localize( 'media-models', '_wpMediaModelsL10n', array(
		'settings' => array(
			'ajaxurl' => admin_url( 'admin-ajax.php', 'relative' ),
			'post' => array( 'id' => 0 ),
		),
	) );
	$scripts->add( 'wp-embed', "$plugins_url/js/wp-embed.js" );
	// To enqueue media-views or media-editor, call wp_enqueue_media().
	// Both rely on numerous settings, styles, and templates to operate correctly.
	$scripts->add( 'media-views',  "$plugins_url/js/media-views.js",  array( 'utils', 'media-models', 'wp-plupload', 'jquery-ui', 'wp-mediaelement' ), false, 1 );
	$scripts->add( 'media-editor', "$plugins_url/js/media-editor.js", array( 'shortcode', 'media-views' ), false, 1 );
	$scripts->add( 'media-audiovideo', "$plugins_url/js/media-audiovideo.js", array( 'media-editor' ), false, 1 );
	$scripts->add( 'mce-view', "$plugins_url/js/mce-view.js", array( 'shortcode', 'jquery', 'media-views', 'media-audiovideo' ), false, 1 );
	if ( is_admin() ) {
		$scripts->add( 'admin-tags', "$plugins_url/js/tags.js", array( 'jquery', 'wp-ajax-response' ), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'admin-tags', 'tagsl10n', array(
			'noPerm' => __('You do not have permission to do that.'),
			'broken' => __('An unidentified error has occurred.')
		));
		$scripts->add( 'admin-comments', "$plugins_url/js/edit-comments.js", array('wp-lists', 'quicktags', 'jquery-query'), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'admin-comments', 'adminCommentsL10n', array(
			'hotkeys_highlight_first' => isset($_GET['hotkeys_highlight_first']),
			'hotkeys_highlight_last' => isset($_GET['hotkeys_highlight_last']),
			'replyApprove' => __( 'Approve and Reply' ),
			'reply' => __( 'Reply' ),
			'warnQuickEdit' => __( "Are you sure you want to edit this comment?\nThe changes you made will be lost." ),
			'docTitleComments' => __( 'Comments' ),
			/* translators: %s: comments count */
			'docTitleCommentsCount' => __( 'Comments (%s)' ),
		) );
		$scripts->add( 'xfn', "$plugins_url/js/xfn.js", array('jquery'), false, 1 );
		$scripts->add( 'postbox', "$plugins_url/js/postbox.js", array('jquery-ui'), false, 1 );
		$scripts->add( 'tags-box', "$plugins_url/js/tags-box.js", array( 'jquery', 'suggest' ), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'tags-box', 'tagsBoxL10n', array(
			'tagDelimiter' => _x( ',', 'tag delimiter' ),
		) );
		$scripts->add( 'post', "$plugins_url/js/post.js", array( 'suggest', 'wp-lists', 'postbox', 'tags-box', 'underscore', 'word-count', 'wp-a11y' ), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'post', 'postL10n', array(
			'ok' => __('OK'),
			'cancel' => __('Cancel'),
			'publishOn' => __('Publish on:'),
			'publishOnFuture' =>  __('Schedule for:'),
			'publishOnPast' => __('Published on:'),
			/* translators: 1: month, 2: day, 3: year, 4: hour, 5: minute */
			'dateFormat' => __('%1$s %2$s, %3$s @ %4$s:%5$s'),
			'showcomm' => __('Show more comments'),
			'endcomm' => __('No more comments found.'),
			'publish' => __('Publish'),
			'schedule' => __('Schedule'),
			'update' => __('Update'),
			'savePending' => __('Save as Pending'),
			'saveDraft' => __('Save Draft'),
			'private' => __('Private'),
			'public' => __('Public'),
			'publicSticky' => __('Public, Sticky'),
			'password' => __('Password Protected'),
			'privatelyPublished' => __('Privately Published'),
			'published' => __('Published'),
			'saveAlert' => __('The changes you made will be lost if you navigate away from this page.'),
			'savingText' => __('Saving Draft&#8230;
	'),
			'permalinkSaved' => __( 'Permalink saved' ),
		) );
		$scripts->add( 'press-this', "$plugins_url/js/press-this.js", array( 'jquery', 'tags-box' ), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'press-this', 'pressThisL10n', array(
			'newPost' => __( 'Title' ),
			'serverError' => __( 'Connection lost or the server is busy. Please try again later.' ),
			'saveAlert' => __( 'The changes you made will be lost if you navigate away from this page.' ),
			/* translators: %d: nth embed found in a post */
			'suggestedEmbedAlt' => __( 'Suggested embed #%d' ),
			/* translators: %d: nth image found in a post */
			'suggestedImgAlt' => __( 'Suggested image #%d' ),
		) );
		$scripts->add( 'editor-expand', "$plugins_url/js/editor-expand.js", array( 'jquery' ), false, 1 );
		$scripts->add( 'link', "$plugins_url/js/link.js", array( 'wp-lists', 'postbox' ), false, 1 );
		$scripts->add( 'comment', "$plugins_url/js/comment.js", array( 'jquery', 'postbox' ) );
		$scripts->add_data( 'comment', 'group', 1 );
		did_action( 'init' ) && $scripts->localize( 'comment', 'commentL10n', array(
			'submittedOn' => __( 'Submitted on:' ),
			/* translators: 1: month, 2: day, 3: year, 4: hour, 5: minute */
			'dateFormat' => __( '%1$s %2$s, %3$s @ %4$s:%5$s' )
		) );
		$scripts->add( 'admin-gallery', "$plugins_url/js/gallery.js", array( 'jquery-ui' ) );
		$scripts->add( 'admin-widgets', "$plugins_url/js/widgets.js", array( 'jquery-ui' ), false, 1 );
		$scripts->add( 'theme', "$plugins_url/js/theme.js", array( 'wp-backbone', 'wp-a11y' ), false, 1 );
		$scripts->add( 'inline-edit-post', "$plugins_url/js/inline-edit-post.js", array( 'jquery', 'suggest' ), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'inline-edit-post', 'inlineEditL10n', array(
			'error' => __('Error while saving the changes.'),
			'ntdeltitle' => __('Remove From Bulk Edit'),
			'notitle' => __('(no title)'),
			'comma' => trim( _x( ',', 'tag delimiter' ) ),
		) );
		$scripts->add( 'inline-edit-tax', "$plugins_url/js/inline-edit-tax.js", array( 'jquery', 'wp-a11y' ), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'inline-edit-tax', 'inlineEditL10n', array(
			'error' => __( 'Error while saving the changes.' ),
			'saved' => __( 'Changes saved.' ),
		) );
		$scripts->add( 'plugin-install', "$plugins_url/js/plugin-install.js", array( 'jquery', 'thickbox' ), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'plugin-install', 'plugininstallL10n', array(
			'plugin_information' => __('Plugin Information:'),
			'ays' => __('Are you sure you want to install this plugin?')
		) );
		$scripts->add( 'updates', "$plugins_url/js/updates.js", array( 'jquery', 'wp-util', 'wp-a11y' ) );
		did_action( 'init' ) && $scripts->localize( 'updates', '_wpUpdatesSettings', array(
			'ajax_nonce' => wp_create_nonce( 'updates' ),
			'l10n'       => array(
				'updating'          => __( 'Updating...' ), // no ellipsis
				'updated'           => __( 'Updated!' ),
				'updateFailedShort' => __( 'Update Failed!' ),
				/* translators: Error string for a failed update */
				'updateFailed'      => __( 'Update Failed: %s' ),
				/* translators: Plugin name and version */
				'updatingLabel'     => __( 'Updating %s...' ), // no ellipsis
				/* translators: Plugin name and version */
				'updatedLabel'      => __( '%s updated!' ),
				/* translators: Plugin name and version */
				'updateFailedLabel' => __( '%s update failed' ),
				/* translators: JavaScript accessible string */
				'updatingMsg'       => __( 'Updating... please wait.' ), // no ellipsis
				/* translators: JavaScript accessible string */
				'updatedMsg'        => __( 'Update completed successfully.' ),
				/* translators: JavaScript accessible string */
				'updateCancel'      => __( 'Update canceled.' ),
				'beforeunload'      => __( 'Plugin updates may not complete if you navigate away from this page.' ),
			)
		) );
		$scripts->add( 'farbtastic', "$plugins_url/js/farbtastic.js", array('jquery'), '1.2' );
		$scripts->add( 'iris', "$plugins_url/js/iris.min.js", array( 'jquery-ui', 'jquery-touch-punch' ), '1.0.7', 1 );
		$scripts->add( 'wp-color-picker', "$plugins_url/js/color-picker.js", array( 'iris' ), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'wp-color-picker', 'wpColorPickerL10n', array(
			'clear' => __( 'Clear' ),
			'defaultString' => __( 'Default' ),
			'pick' => __( 'Select Color' ),
			'current' => __( 'Current Color' ),
		) );
		$scripts->add( 'dashboard', "$plugins_url/js/dashboard.js", array( 'jquery', 'admin-comments', 'postbox' ), false, 1 );
		$scripts->add( 'list-revisions', "$plugins_url/js/wp-list-revisions.js" );
		$scripts->add( 'media-grid', "$plugins_url/js/media-grid.js", array( 'media-editor' ), false, 1 );
		$scripts->add( 'media', "$plugins_url/js/media.js", array( 'jquery' ), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'media', 'attachMediaBoxL10n', array(
			'error' => __( 'An error has occurred. Please reload the page and try again.' ),
		));
		$scripts->add( 'image-edit', "$plugins_url/js/image-edit.js", array('jquery', 'json2', 'imgareaselect'), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'image-edit', 'imageEditL10n', array(
			'error' => __( 'Could not load the preview image. Please reload the page and try again.' )
		));
		$scripts->add( 'set-post-thumbnail', "$plugins_url/js/set-post-thumbnail.js", array( 'jquery' ), false, 1 );
		did_action( 'init' ) && $scripts->localize( 'set-post-thumbnail', 'setPostThumbnailL10n', array(
			'setThumbnail' => __( 'Use as featured image' ),
			'saving' => __( 'Saving...' ), // no ellipsis
			'error' => __( 'Could not set that as the thumbnail image. Try a different attachment.' ),
			'done' => __( 'Done' )
		) );
		// Navigation Menus
		$scripts->add( 'nav-menu', "$plugins_url/js/nav-menu.js", array( 'jquery-ui', 'wp-lists', 'postbox' ) );
		did_action( 'init' ) && $scripts->localize( 'nav-menu', 'navMenuL10n', array(
			'noResultsFound' => __( 'No results found.' ),
			'warnDeleteMenu' => __( "You are about to permanently delete this menu. \n 'Cancel' to stop, 'OK' to delete." ),
			'saveAlert' => __( 'The changes you made will be lost if you navigate away from this page.' ),
			'untitled' => _x( '(no label)', 'missing menu item navigation label' )
		) );
		$scripts->add( 'custom-header', "$plugins_url/js/custom-header.js", array( 'masonry' ), false, 1 );
		$scripts->add( 'custom-background', "$plugins_url/js/custom-background.js", array( 'wp-color-picker', 'media-views' ), false, 1 );
		$scripts->add( 'media-gallery', "$plugins_url/js/media-gallery.js", array('jquery'), false, 1 );
		$scripts->add( 'svg-painter', "$plugins_url/js/svg-painter.js", array( 'jquery' ), false, 1 );
	}
}
remove_action( 'wp_default_scripts', 'wp_default_scripts' );
add_action( 'wp_default_scripts', 'mong_wp_default_scripts' );

function mong_admin_bar_bump_cb(){
	if(is_admin_bar_showing()){
        $custom_css = "
				html { margin-left: 32px !important; }
				* html body { margin-left: 32px !important; }
               	@media screen and ( max-width: 782px ) {
				    html { margin-left: 46px !important;}
					* html body { margin-left: 46px !important;}
				}";
        wp_add_inline_style( 'custom-style', $custom_css );
	}
}
remove_action('wp_head', '_admin_bar_bump_cb');
add_action( 'wp_head', 'mong_admin_bar_bump_cb' );
