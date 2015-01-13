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
 * @author     Mel Choyce
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

	remove_action( 'wp_head', array( Saga_Custom_Colors::get_instance(), 'wp_head_callback' ) );

	/* Handle content width for embeds and images. */
	hybrid_set_content_width( 920 );
}

/**
 * Enqueue scripts and styles.
 */
function edda_scripts() {
	wp_enqueue_script( 'edda', get_stylesheet_directory_uri() . '/js/edda.js', array( 'saga' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'edda_scripts', 25 );

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
