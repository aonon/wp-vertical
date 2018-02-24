/**
 * plugin.js
 *
 * Copyright, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

// Forked for WordPress so it can be turned on/off after loading.

/*global tinymce:true */
/*eslint no-nested-ternary:0 */

/**
 * Auto Resize
 *
 * This plugin automatically resizes the content area to fit its content width.
 * It will retain a minimum width, which is the width of the content area when
 * it's initialized.
 */
tinymce.PluginManager.add( 'wpautoresize', function( editor ) {
	var settings = editor.settings,
		oldSize = 300,
		isActive = false;

	if ( editor.settings.inline || tinymce.Env.iOS ) {
		return;
	}

	function isFullscreen() {
		return editor.plugins.fullscreen && editor.plugins.fullscreen.isFullscreen();
	}

	function getInt( n ) {
		return parseInt( n, 10 ) || 0;
	}

	/**
	 * This method gets executed each time the editor needs to resize.
	 */
	function resize( e ) {
		var deltaSize, doc, body, docElm, DOM = tinymce.DOM, resizeWidth, myWidth,
			marginLeft, marginRight, paddingLeft, paddingRight, borderLeft, borderRight;

		if ( ! isActive ) {
			return;
		}

		doc = editor.getDoc();
		if ( ! doc ) {
			return;
		}

		e = e || {};
		body = doc.body;
		docElm = doc.documentElement;
		resizeWidth = settings.autoresize_min_height;

		if ( ! body || ( e && e.type === 'setcontent' && e.initial ) || isFullscreen() ) {
			if ( body && docElm ) {
				body.style.overflowY = 'auto';
				docElm.style.overflowY = 'auto'; // Old IE
			}

			return;
		}

		// Calculate outer width of the body element using CSS styles
		marginLeft = editor.dom.getStyle( body, 'marginleft', true );
		marginRight = editor.dom.getStyle( body, 'marginright', true );
		paddingLeft = editor.dom.getStyle( body, 'paddingleft', true );
		paddingRight = editor.dom.getStyle( body, 'paddingright', true );
		borderLeft = editor.dom.getStyle( body, 'borderleft-width', true );
		borderRight = editor.dom.getStyle( body, 'borderright-width', true );
		myWidth = body.offsetWidth + getInt( marginLeft ) + getInt( marginRight ) +
			getInt( paddingLeft ) + getInt( paddingRight ) +
			getInt( borderLeft ) + getInt( borderRight );

		// IE < 11, other?
		if ( myWidth && myWidth < docElm.offsetWidth ) {
			myWidth = docElm.offsetWidth;
		}

		// Make sure we have a valid width
		if ( isNaN( myWidth ) || myWidth <= 0 ) {
			// Get width differently depending on the browser used
			myWidth = tinymce.Env.ie ? body.scrollWidth : ( tinymce.Env.webkit && body.clientWidth === 0 ? 0 : body.offsetWidth );
		}

		// Don't make it smaller than the minimum width
		if ( myWidth > settings.autoresize_min_height ) {
			resizeWidth = myWidth;
		}

		// If a maximum width has been defined don't exceed this width
		if ( settings.autoresize_max_height && myWidth > settings.autoresize_max_height ) {
			resizeWidth = settings.autoresize_max_height;
			body.style.overflowY = 'auto';
			docElm.style.overflowY = 'auto'; // Old IE
		} else {
			body.style.overflowY = 'hidden';
			docElm.style.overflowY = 'hidden'; // Old IE
			body.scrollLeft = 0;
		}

		// Resize content element
		if (resizeWidth !== oldSize) {
			deltaSize = resizeWidth - oldSize;
			DOM.setStyle( editor.iframeElement, 'width', resizeWidth + 'px' );
			oldSize = resizeWidth;

			// WebKit doesn't decrease the size of the body element until the iframe gets resized
			// So we need to continue to resize the iframe down until the size gets fixed
			if ( tinymce.isWebKit && deltaSize < 0 ) {
				resize( e );
			}

			editor.fire( 'wp-autoresize', { width: resizeWidth, deltaWidth: e.type === 'nodechange' ? deltaSize : null } );
		}
	}

	/**
	 * Calls the resize x times in 100ms intervals. We can't wait for load events since
	 * the CSS files might load async.
	 */
	function wait( times, interval, callback ) {
		setTimeout( function() {
			resize();

			if ( times-- ) {
				wait( times, interval, callback );
			} else if ( callback ) {
				callback();
			}
		}, interval );
	}

	// Define minimum width
	settings.autoresize_min_height = parseInt(editor.getParam( 'autoresize_min_height', editor.getElement().offsetWidth), 10 );

	// Define maximum width
	settings.autoresize_max_height = parseInt(editor.getParam( 'autoresize_max_height', 0), 10 );

	function on() {
		if ( ! editor.dom.hasClass( editor.getBody(), 'wp-autoresize' ) ) {
			isActive = true;
			editor.dom.addClass( editor.getBody(), 'wp-autoresize' );
			// Add appropriate listeners for resizing the content area
			editor.on( 'nodechange setcontent keyup FullscreenStateChanged', resize );
			resize();
		}
	}

	function off() {
		var doc;

		// Don't turn off if the setting is 'on'
		if ( ! settings.wp_autoresize_on ) {
			isActive = false;
			doc = editor.getDoc();
			editor.dom.removeClass( editor.getBody(), 'wp-autoresize' );
			editor.off( 'nodechange setcontent keyup FullscreenStateChanged', resize );
			doc.body.style.overflowY = 'auto';
			doc.documentElement.style.overflowY = 'auto'; // Old IE
			oldSize = 0;
		}
	}

	if ( settings.wp_autoresize_on ) {
		// Turn resizing on when the editor loads
		isActive = true;

		editor.on( 'init', function() {
			editor.dom.addClass( editor.getBody(), 'wp-autoresize' );
		});

		editor.on( 'nodechange keyup FullscreenStateChanged', resize );

		editor.on( 'setcontent', function() {
			wait( 3, 100 );
		});

		if ( editor.getParam( 'autoresize_on_init', true ) ) {
			editor.on( 'init', function() {
				// Hit it 10 times in 200 ms intervals
				wait( 10, 200, function() {
					// Hit it 5 times in 1 sec intervals
					wait( 5, 1000 );
				});
			});
		}
	}

	// Reset the stored size
	editor.on( 'show', function() {
		oldSize = 0;
	});

	// Register the command
	editor.addCommand( 'wpAutoResize', resize );

	// On/off
	editor.addCommand( 'wpAutoResizeOn', on );
	editor.addCommand( 'wpAutoResizeOff', off );
});
