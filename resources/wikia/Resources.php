<?php

/**
 * This file contains shared Wikia-specific ResourceLoader modules
 */

return array(
	// AMD library
	'amd' => array(
		// modil.js is loaded using at the top of the page (using AssetsManager)
		// this file will make ResourceLoader think that amd module is loaded - via mw.loader.setState
		'scripts' => 'resources/wikia/libraries/modil/modil.setState.js',
	),

	// AMD modules
	'wikia.aim' => array(
		'scripts' => 'resources/wikia/modules/aim.js',
		'dependencies' => 'amd',
	),

	'wikia.uniqueId' => array(
		'scripts' => 'resources/wikia/modules/uniqueId.js',
		'dependencies' => 'amd',
	),

	'wikia.modernizr' => array(
		'scripts' => 'resources/wikia/modules/modernizr.js',
		'dependencies' => array(
			'amd',
			'modernizr'
		)
	),

	'wikia.mustache' => array(
		'scripts' => 'resources/wikia/libraries/mustache/mustache.js',
		'dependencies' => 'amd'
	),

	// module loaded via $.loadjQuery UI and is a wrapper for MediaWiki jQuery UI modules
	// this used to be static file located in /skins/common/jquery/jquery-ui-1.8.14.custom.js
	'wikia.jquery.ui' => array(
		'scripts' => 'resources/wikia/libraries/jquery-ui/jquery.ui.menu.js',
		'dependencies' => array(
			'jquery.ui.core',
			'jquery.ui.widget',
			'jquery.ui.mouse',
			'jquery.ui.position',
			'jquery.ui.draggable',
			'jquery.ui.droppable',
			'jquery.ui.sortable',
			'jquery.ui.autocomplete',
			'jquery.ui.slider',
			'jquery.ui.tabs',
			'jquery.ui.datepicker',
		),
		'group' => 'jquery.ui'
	),

	// libraries and jQuery plugins
	'jquery.mustache' => array(
		'scripts' => 'resources/wikia/libraries/mustache/jquery.mustache.js',
		'dependencies' => 'wikia.amd.mustache'
	),

	'jquery.autocomplete' => array(
		'scripts' => 'resources/wikia/libraries/jquery/autocomplete/jquery.autocomplete.js'
	),

	// moved here from AssetsManager by wladek
	'wikia.yui' => array(
		'scripts' => array(
			'resources/wikia/libraries/yui/wikia.yui-scope-workaround.js',
			'resources/wikia/libraries/yui/utilities/utilities.js',
			'resources/wikia/libraries/yui/cookie/cookie-beta.js',
			'resources/wikia/libraries/yui/container/container.js',
			'resources/wikia/libraries/yui/autocomplete/autocomplete.js',
			'resources/wikia/libraries/yui/animation/animation-min.js',
			'resources/wikia/libraries/yui/logger/logger.js',
			'resources/wikia/libraries/yui/menu/menu.js',
			'resources/wikia/libraries/yui/tabview/tabview.js',
			'resources/wikia/libraries/yui/slider/slider.js',
			'resources/wikia/libraries/yui/extra/tools-min.js',
			'resources/wikia/libraries/yui/extra/carousel-min.js',
		),
		'group' => 'yui',
	),

	// Wikia-specific assets for monobook-based skins
	'wikia.monobook' => array(
		'styles' => array(
			'skins/wikia/shared.css',
			'skins/wikia/css/Monobook.css',
			'resources/wikia/libraries/yui/container/assets/container.css',
			'resources/wikia/libraries/yui/logger/assets/logger.css',
			'resources/wikia/libraries/yui/tabview/assets/tabview.css',
			'extensions/wikia/RelatedPages/RelatedPages.monobook.css',
		)
	),

);
