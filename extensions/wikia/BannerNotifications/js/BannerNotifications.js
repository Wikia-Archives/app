/*
 * Handles the color-coded notification messages that generally appear
 * at the top of the screen or inside a modal.
 * Use like:
 * BannerNotifications.show('Some success message', 'confirm')
 * BannerNotifications.show('Some error message', 'error', $('.myDiv'), 3000)
 */
define('BannerNotifications', ['jquery', 'wikia.window'], function ($, window) {
	'use strict';

	var defaultTimeout = 10000,
		types = {
			'notify': 'blue',
			'confirm': 'green',
			'error': 'red',
			'warn': 'yellow'
		},
		classes = Object.keys(types).join(' '),
		pageContainer,
		wikiaHeader,
		headerHeight,
		modal,
		isModal,
		backendNotification;

	/**
	 * Constructs jQuery element with the notification
	 * @param {String} content
	 * @param {String} [type]
	 * @returns {jQuery}
	 */
	function createMarkup(content, type) {
		return $('<div class="banner-notification">' +
			'<button class="close wikia-chiclet-button">' +
			'<img src="' + window.stylepath + '/oasis/images/icon_close.png">' +
			'</button><div class="msg">' + content + '</div></div>')
			.addClass(type)
			.hide();
	}

	/**
	 * Adds given markup to DOM
	 * @param {jQuery} $element
	 * @param {jQuery} $parentElement
	 */
	function addToDOM($element, $parentElement) {
		// allow notification wrapper element to be passed by extension
		var $parent = $parentElement || isModalShown() ? modal : pageContainer,
			$bannerNotificationsWrapper = $parent.find('.banner-notifications-wrapper');
		if (!$bannerNotificationsWrapper.length) {
			$bannerNotificationsWrapper = $('<div></div>').addClass('banner-notifications-wrapper');
			$parent.prepend($bannerNotificationsWrapper);
		}
		$bannerNotificationsWrapper.prepend($element);

		$element.fadeIn('slow');
	}

	function BannerNotification(content, type, $parent, timeout) {
		if (content instanceof jQuery && content.hasClass('banner-notification')) {
			//create a notification object from already existing markup
			this.content = content.find('.msg').html();
			this.$element = content;
			this.$parent = content.parent();
			this.hidden = false;
		} else {
			this.content = content;
			this.$element = createMarkup(this.content, this.type);
			this.$parent = $parent;
			this.hidden = true;
			this.type = type;
			this.timeout = timeout;
		}
	}

	BannerNotification.prototype.show = function () {
		var self;
		if (!this.hidden) {
			return this;
		}
		if (!this.$element) {
			this.$element = createMarkup(this.content, this.type);
		}
		this.setType(this.type);

		setUpClose(this);

		isModal = isModalShown();

		// Modal notifications have no close button so set a timeout
		if (isModal && typeof this.timeout !== 'number') {
			this.timeout = defaultTimeout;
		}

		addToDOM(this.$element, this.$parent);

		this.hidden = false;

		// Close notification after specified amount of time
		if (typeof this.timeout === 'number') {
			self = this;
			setTimeout(function () {
				self.hide();
			}, this.timeout);
		}
		return this;
	};

	BannerNotification.prototype.hide = function (callback) {
		if (!this.hidden) {
			removeFromDOM(this.$element, callback);
			this.$element = null;
			this.hidden = true;
		}
		return this;
	};

	BannerNotification.prototype.setType = function (type) {
		if (type !== this.type && types.hasOwnProperty(type) && this.$element) {
			this.$element
				.removeClass(classes)
				.addClass(type);
			this.type = type;
		}
		return this;
	};

	BannerNotification.prototype.setContent = function (content) {
		if (content && content !== this.content) {
			this.$element
				.find('.msg')
				.html(content);
		}
		return this;
	};

	BannerNotification.prototype.showConnectionError = function () {
		return this
			.setType('error')
			.setContent($.msg('bannernotifications-general-ajax-failure'))
			.show();
	};

	/**
	 * Called once to instantiate this feature
	 */
	function init() {
		var pageContainerSelector =
			window.skin === 'monobook' ? '#content' : '.WikiaPageContentWrapper';
		createBackendNotification();

		pageContainer = $(pageContainerSelector);
		wikiaHeader = $('#globalNavigation');
		headerHeight = wikiaHeader.height();
		window.addEventListener('scroll', onScroll);
	}

	function createBackendNotification() {
		var $notification = $('.banner-notification'),
			i;

		for (i = 0; i < $notification.length; i++) {
			backendNotification = new BannerNotification($notification);
			setUpClose(backendNotification);
		}
	}

	/**
	 * Determine if a modal is present and visible so we can apply the notification to the modal instead of the page.
	 * @returns {boolean}
	 */
	function isModalShown() {
		// handle all types of modals since the begining of time!
		modal = $('.modalWrapper, .yui-panel, .modal');

		// returns false if there's no modal or it's hidden
		return modal.is(':visible');
	}

	/**
	 * Removes notification element from DOM and executes callback
	 * @param {jQuery} $elements - elements to be removed from DOM
	 * @param {function} [callback]
	 */
	function removeFromDOM($elements, callback) {
		if ($elements.length) {
			$elements.animate({
				'height': 0,
				'padding': 0,
				'opacity': 0
			}, 400, function () {
				$elements.remove();
				if (typeof callback === 'function') {
					callback();
				}
			});
		} else {
			if (typeof callback === 'function') {
				callback();
			}
		}
	}

	/**
	 * Bind close event to close button
	 */
	function setUpClose(notification) {
		$(notification.$element).on('click', '.close', function () {
			notification.hide();
		});
	}

	/**
	 * Pin the notification to the top of the screen when scrolled down the page.
	 * Shares the scroll event with WikiaFooter.js
	 */
	function onScroll() {
		var containerTop,
			notificationWrapper = pageContainer.children('.banner-notifications-wrapper');

		if (!pageContainer.length || !notificationWrapper.length) {
			return;
		}

		// get the position of the wrapper element relative to the top of the viewport
		containerTop = pageContainer[0].getBoundingClientRect().top;

		if (containerTop < headerHeight) {
			notificationWrapper.addClass('float');
		} else {
			notificationWrapper.removeClass('float');
		}
	}

	//Window global stays for legacy reasons
	window.BannerNotification = BannerNotification;

	init();
	return BannerNotification;
});
