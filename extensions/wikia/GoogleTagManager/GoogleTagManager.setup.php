<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Google Tag Manager',
	'description' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GoogleTagManager',
];

/**
 * Resources Loader modules
 */
$wgResourceModules['ext.wikia.GoogleTagManager'] = [
	'remoteExtPath' => 'wikia/GoogleTagManager',
	'localBasePath' => __DIR__,
	'scripts' => [
		'js/ext.GoogleTagManager.js'
	],
];

// hooks
$wgAutoloadClasses['GoogleTagManagerHooks'] = __DIR__ . '/GoogleTagManagerHooks.class.php';
$wgHooks['BeforePageDisplay'][] = 'GoogleTagManagerHooks::onBeforePageDisplay';
