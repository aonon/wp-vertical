/* global screenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

(function ($) {
	var $body, $window, $sidebar, adminbarOffset, left = false,
		right = false, windowWidth, windowHeight, lastWindowPos = 0,
		leftOffset = 0, bodyWidth, sidebarWidth, resizeTimer,
		secondary, button;

	function initMainNavigation(container) {
		// Add dropdown toggle that display child menu items.
		container.find('.menu-item-has-children > a').after('<div type="button" class="dropdown-toggle" aria-expanded="false">' + screenReaderText.expand + '</div>');

		// Toggle buttons and submenu items with active children menu items.
		container.find('.current-menu-ancestor > div[type="button"]').addClass('toggle-on');
		container.find('.current-menu-ancestor > .sub-menu').addClass('toggled-on');

		container.find('.dropdown-toggle').click(function (e) {
			var _this = $(this);
			e.preventDefault();
			_this.toggleClass('toggle-on');
			_this.next('.children, .sub-menu').toggleClass('toggled-on');
			_this.attr('aria-expanded', _this.attr('aria-expanded') === 'false' ? 'true' : 'false');
			_this.html(_this.html() === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand);
		});
	}
	initMainNavigation($('.main-navigation'));

	// Re-initialize the main navigation when it is updated, persisting any existing submenu expanded states.
	$(document).on('customize-preview-menu-refreshed', function (e, params) {
		if ('primary' === params.wpNavMenuArgs.theme_location) {
			initMainNavigation(params.newContainer);

			// Re-sync expanded states from oldContainer.
			params.oldContainer.find('.dropdown-toggle.toggle-on').each(function () {
				var containerId = $(this).parent().prop('id');
				$(params.newContainer).find('#' + containerId + ' > .dropdown-toggle').triggerHandler('click');
			});
		}
	});

	secondary = $('#secondary');
	button = $('.site-branding').find('.secondary-toggle');

	// Enable menu toggle for small screens.
	(function () {
		var menu, widgets, social;
		if (!secondary.length || !button.length) {
			return;
		}

		// Hide button if there are no widgets and the menus are missing or empty.
		menu = secondary.find('.nav-menu');
		widgets = secondary.find('#widget-area');
		social = secondary.find('#social-navigation');
		if (!widgets.length && !social.length && (!menu.length || !menu.children().length)) {
			button.hide();
			return;
		}

		button.on('click.twentyfifteen', function () {
			secondary.toggleClass('toggled-on');
			secondary.trigger('resize');
			$(this).toggleClass('toggled-on');
			if ($(this, secondary).hasClass('toggled-on')) {
				$(this).attr('aria-expanded', 'true');
				secondary.attr('aria-expanded', 'true');
			} else {
				$(this).attr('aria-expanded', 'false');
				secondary.attr('aria-expanded', 'false');
			}
		});
	})();

	/**
	 * @summary Add or remove ARIA attributes.
	 * Uses jQuery's width() function to determine the size of the window and add
	 * the default ARIA attributes for the menu toggle if it's visible.
	 * @since Twenty Fifteen 1.1
	 */
	function onResizeARIA() {
		var ww = window.innerWidth, wh = window.innerHeight;
		if (ww > window.outerWidth && wh > window.outerHeight) {
			var tmp = ww;
			ww = wh;
			wh = ww;
		}
		if (750 > wh) {
			button.attr('aria-expanded', 'false');
			secondary.attr('aria-expanded', 'false');
			button.attr('aria-controls', 'secondary');
		} else {
			button.removeAttr('aria-expanded');
			secondary.removeAttr('aria-expanded');
			button.removeAttr('aria-controls');
		}
	}

	// Sidebar scrolling.
	function resize() {
		var ww = window.innerWidth, wh = window.innerHeight;
		if (ww > window.outerWidth && wh > window.outerHeight) {
			var tmp = ww;
			ww = wh;
			wh = ww;
		}
		windowHeight = wh;

		if (755 > windowHeight) {
			left = right = false;
			$sidebar.removeAttr('style');
		}
	}

	function scroll() {
		var ww = window.innerWidth, wh = window.innerHeight;
		if (ww > window.outerWidth && wh > window.outerHeight) {
			var tmp = ww;
			ww = wh;
			wh = ww;
		}

		var x = window.pageXOffset,
			y = window.pageYOffset;
		if (x < 0 || y < 0) {
			var saveScrollX = x;
			x = -y;
			y = saveScrollX;
		}

		var windowPos = x;

		if (755 > windowHeight) {
			return;
		}

		sidebarWidth = $sidebar.width();
		windowWidth = ww;
		bodyWidth = $body.width();

		if (sidebarWidth + adminbarOffset > windowWidth) {
			if (windowPos > lastWindowPos) {
				if (left) {
					left = false;
					leftOffset = ($sidebar.offset().left > 0) ? $sidebar.offset().left - adminbarOffset : 0;
					$sidebar.attr('style', 'left: ' + leftOffset + 'px;');
				} else if (!right && windowPos + windowWidth > sidebarWidth + $sidebar.offset().left && sidebarWidth + adminbarOffset < bodyWidth) {
					right = true;
					$sidebar.attr('style', 'position: fixed; right: 0;');
				}
			} else if (windowPos < lastWindowPos) {
				if (right) {
					right = false;
					leftOffset = ($sidebar.offset().left > 0) ? $sidebar.offset().left - adminbarOffset : 0;
					$sidebar.attr('style', 'left: ' + leftOffset + 'px;');
				} else if (!left && windowPos + adminbarOffset < $sidebar.offset().left) {
					left = true;
					$sidebar.attr('style', 'position: fixed;');
				}
			} else {
				left = right = false;
				leftOffset = ($sidebar.offset().left > 0) ? $sidebar.offset().left - adminbarOffset : 0;
				$sidebar.attr('style', 'left: ' + leftOffset + 'px;');
			}
		} else if (!left) {
			left = true;
			$sidebar.attr('style', 'position: fixed;');
		}

		lastWindowPos = windowPos;
	}

	function resizeAndScroll() {
		resize();
		scroll();
	}

	$(document).ready(function () {
		$body = $(document.body);
		$window = $(window);
		$sidebar = $('#sidebar').first();
		adminbarOffset = $body.is('.admin-bar') ? $('#wpadminbar').width() : 0;

		$window
			.on('scroll.twentyfifteen', scroll)
			.on('load.twentyfifteen', onResizeARIA)
			.on('resize.twentyfifteen', function () {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(resizeAndScroll, 500);
				onResizeARIA();
			});
		$sidebar.on('click.twentyfifteen keydown.twentyfifteen', 'button', resizeAndScroll);

		resizeAndScroll();

		for (var i = 1; i < 6; i++) {
			setTimeout(resizeAndScroll, 100 * i);
		}
	});

})(jQuery);
