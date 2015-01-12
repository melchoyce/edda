<?php
/**
 * This is your theme's `functions.php` file.  It's a dangerous but really powerful tool.  It essentially
 * gives you the power of a plugin developer from within the confines of a theme.  Use this feature
 * wisely, please.
 *
 * Make sure to change the `edda_` function prefix to a prefix that matches your theme name.  For
 * example, if your theme name is "Super Duper", your slug should be `super_duper_`.
 *
 * @package    Edda
 * @author     Mel Choyce <melchoyce@gmail.com>
 * @copyright  Copyright (c) 2014, Mel Choyce
 * @link       http://yoursite.com/link/to/theme
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Always set up theme on the `after_setup_theme` hook. */
add_action( 'after_setup_theme', 'edda_theme_setup' );

/**
 * Theme setup function.  This is where the theme should register things like headers and add its
 * callback functions for action/filter hooks.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function edda_theme_setup() {

	/*
	 * Add a custom background to overwrite the defaults.  Remove this section if you want to use
	 * the parent theme defaults instead.
	 *
	 * @link http://codex.wordpress.org/Custom_Backgrounds
	 */
	add_theme_support(
		'custom-background',
		array(
			'default-color' => '2b261f',
			'default-image' => '',
		)
	);

	/*
	 * Add a custom header to overwrite the defaults.  Remove this section if you want to use the
	 * the parent theme defaults instead.
	 *
	 * @link http://codex.wordpress.org/Custom_Headers
	 */
	add_theme_support(
		'custom-header',
		array(
			'default-text-color' => 'ffffff',
			'default-image'      => '',
			'random-default'     => false,
		)
	);

	/*
	 * Registers default headers for the theme.  If you don't want to add custom headers, remove
	 * this section. Note: Header thumbnail sizes should be 230x78.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_default_headers
	 */
	//register_default_headers();

	/*
	 * Uncomment to add custom default backgrounds.  See the `edda_default_backgrounds()`
	 * function below.  Remove this section and that function if you do not wish to use this feature.
	 */
	//add_filter( 'hybrid_default_backgrounds', 'edda_default_backgrounds' );

	remove_action( 'wp_head', array( Saga_Custom_Colors::get_instance(), 'wp_head_callback' ) );
}

/**
 * Enqueue scripts and styles.
 */
function edda_scripts() {
	wp_enqueue_script( 'edda', get_stylesheet_directory_uri() . '/js/edda.js', array( 'saga' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'edda_scripts', 25 );


/**
 * This works just like the WordPress `register_default_headers()` function.  You're just setting up an
 * array of backgrounds.  The following backgrounds are merely examples from the parent theme.  Please
 * don't use them.  Use your own backgrounds.  Or, remove this section (and the `add_filter()` call earlier)
 * if you don't want to register custom backgrounds.
 *
 * Note: Background thumbnail sizes should be 230x78.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $backgrounds
 * @return array
 */
function edda_default_backgrounds( $backgrounds ) {

	$new_backgrounds = array(
		'example-1' => array(
			'url'           => '%2$s/images/backgrounds/example-1.png',
			'thumbnail_url' => '%2$s/images/backgrounds/example-1-thumb.png',
		),
		'example-2' => array(
			'url'           => '%2$s/images/backgrounds/example-2.png',
			'thumbnail_url' => '%2$s/images/backgrounds/example-2-thumb.png',
		),
	);

	return array_merge( $new_backgrounds, $backgrounds );
}

/**
 * Remove icon from the before the site title
 */
function edda_remove_customizer_settings( $wp_customize ) {
	$wp_customize->remove_setting( 'header_icon' );
	$wp_customize->remove_setting( 'color_menu' );
	$wp_customize->remove_setting( 'color_primary' );
	$wp_customize->remove_control( 'custom-colors-menu' );
	$wp_customize->remove_control( 'custom-colors-primary' );
}
add_action( 'customize_register', 'edda_remove_customizer_settings', 100 );
add_filter( 'theme_mod_header_icon', '__return_false', 100 );

/**
 * Increase length of excerpt
 */
function edda_excerpt_length( $length ) {
	return 45;
}
add_filter( 'excerpt_length', 'edda_excerpt_length', 20 );
