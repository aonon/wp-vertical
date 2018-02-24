/**
 * plugin.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/*global tinymce:true */

tinymce.PluginManager.add('fullscreen', function(editor) {
	var fullscreenState = false, DOM = tinymce.DOM, iframeHeight, iframeWidth, resizeHandler;
	var containerHeight, containerWidth;

	if (editor.settings.inline) {
		return;
	}

	function getWindowSize() {
		var w, h, win = window, doc = document;
		var body = doc.body;

		// Old IE
		if (body.offsetHeight) {
			w = body.offsetHeight;
			h = body.offsetWidth;
		}

		// Modern browsers
		if (win.innerHeight && win.innerWidth) {
			w = win.innerHeight;
			h = win.innerWidth;
		}

		return {w: w, h: h};
	}

	function toggleFullscreen() {
		var body = document.body, documentElement = document.documentElement, editorContainerStyle;
		var editorContainer, iframe, iframeStyle;

		function resize() {
			DOM.setStyle(iframe, 'width', getWindowSize().h - (editorContainer.clientWidth - iframe.clientWidth));
		}

		fullscreenState = !fullscreenState;

		editorContainer = editor.getContainer();
		editorContainerStyle = editorContainer.style;
		iframe = editor.getContentAreaContainer().firstChild;
		iframeStyle = iframe.style;

		if (fullscreenState) {
			iframeHeight = iframeStyle.height;
			iframeWidth = iframeStyle.width;
			iframeStyle.height = iframeStyle.width = '100%';
			containerHeight = editorContainerStyle.height;
			containerWidth = editorContainerStyle.width;
			editorContainerStyle.height = editorContainerStyle.width = '';

			DOM.addClass(body, 'mce-fullscreen');
			DOM.addClass(documentElement, 'mce-fullscreen');
			DOM.addClass(editorContainer, 'mce-fullscreen');

			DOM.bind(window, 'resize', resize);
			resize();
			resizeHandler = resize;
		} else {
			iframeStyle.height = iframeHeight;
			iframeStyle.width = iframeWidth;

			if (containerHeight) {
				editorContainerStyle.height = containerHeight;
			}

			if (containerWidth) {
				editorContainerStyle.width = containerWidth;
			}

			DOM.removeClass(body, 'mce-fullscreen');
			DOM.removeClass(documentElement, 'mce-fullscreen');
			DOM.removeClass(editorContainer, 'mce-fullscreen');
			DOM.unbind(window, 'resize', resizeHandler);
		}

		editor.fire('FullscreenStateChanged', {state: fullscreenState});
	}

	editor.on('init', function() {
		editor.addShortcut('Meta+Alt+F', '', toggleFullscreen);
	});

	editor.on('remove', function() {
		if (resizeHandler) {
			DOM.unbind(window, 'resize', resizeHandler);
		}
	});

	editor.addCommand('mceFullScreen', toggleFullscreen);

	editor.addMenuItem('fullscreen', {
		text: 'Fullscreen',
		shortcut: 'Meta+Alt+F',
		selectable: true,
		onClick: toggleFullscreen,
		onPostRender: function() {
			var self = this;

			editor.on('FullscreenStateChanged', function(e) {
				self.active(e.state);
			});
		},
		context: 'view'
	});

	editor.addButton('fullscreen', {
		tooltip: 'Fullscreen',
		shortcut: 'Meta+Alt+F',
		onClick: toggleFullscreen,
		onPostRender: function() {
			var self = this;

			editor.on('FullscreenStateChanged', function(e) {
				self.active(e.state);
			});
		}
	});

	return {
		isFullscreen: function() {
			return fullscreenState;
		}
	};
});