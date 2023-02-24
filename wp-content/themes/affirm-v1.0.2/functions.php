<?php

/**
 * level functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package uicore-theme
 */
defined('ABSPATH') || exit;

//Global Constants
define('UICORE_THEME_VERSION', '1.0.2');
define('UICORE_THEME_NAME', 'Affirm');
define('UICORE_FRAMEWORK_VERSION', '3.2.4');


$level_includes = array(
	'/setup.php',
	'/default.php',
	'/template-tags.php',
	'/plugin-activation.php'
);

foreach ($level_includes as $file) {
	require_once get_template_directory() . '/inc' . $file;
}


//Required
if ( ! isset( $content_width ) ) {
	$content_width = 1000;
}
if ( is_singular() ) {
	wp_enqueue_script( "comment-reply" );
}

add_filter('uicore_settings_default_admin', 'uicore_default_admin_options');
function uicore_default_admin_options($default) {
	$settings = array(
		'pFont' => [
			'f' => 'DM Sans',
			'st' => '700',
		],
		'sFont' => [
			'f' => 'DM Sans',
			'st' => '600',
		],
		'tFont' => [
			'f' => 'DM Sans',
			'st' => 'normal',
		],
		'aFont' => [
			'f' => 'DM Sans',
			'st' => '500',
		],
	);
	return wp_parse_args($settings, $default);
}

add_filter('uicore_settings_default_front', 'uicore_default_front_options');
function uicore_default_front_options($default) {
	$settings = [
		'pColor'					=> '#4787FA',
		'sColor'					=> '#1E52B4',
		'aColor'					=> '#FEAA47',
		'hColor'					=> '#002159',
		'bColor'					=> '#8A909A',
		'dColor'					=> '#4B58DB',
		'lColor'					=> '#EEF4FB',
		'logo'						=> 'https://affirm.uicore.co/wp-content/uploads/2021/03/affirm-logo.png',
		'fav'						=> 'https://affirm.uicore.co/wp-content/uploads/2021/03/affirm-favicon.png',
		'pagetitle_bg' 				=> [
			'type' 			=> 'gradient',
			'solid' 		=> '#EDF6F7',
			'gradient' 		=> [
				'angle' 		=> '180',
				'color1' 		=> '#EEF4FB',
				'color2' 		=> '#eef4fb00',
			],
			'image' 		=> [
				'url' 			=> '',
				'attachment' 	=> 'scroll',
				'position' 		=> [
					'd' => 'bottom center',
					't' => 'center center',
					'm' => 'center center',
				],
				'repeat' 		=> 'no-repeat',
				'size' 			=> [
					'd' => 'cover',
					't' => 'cover',
					'm' => 'contain',
				],
			],
		],
		'pagetitle_color'			=> 'Dark Neutral'
	];
	return wp_parse_args($settings, $default);
}

//disable element pack self update
function ui_disable_plugin_updates( $value ) {

    $pluginsToDisable = [
        'bdthemes-element-pack/bdthemes-element-pack.php',
        'metform-pro/metform-pro.php'
    ];

    if ( isset($value) && is_object($value) ) {
        foreach ($pluginsToDisable as $plugin) {
            if ( isset( $value->response[$plugin] ) ) {
                unset( $value->response[$plugin] );
            }
        }
    }
    return $value;
}
add_filter( 'site_transient_update_plugins', 'ui_disable_plugin_updates' );