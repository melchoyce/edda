<?php
/**
 * @package    Edda
 * @author     Mel Choyce
 * @copyright  Copyright (c) 2014, Mel Choyce
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

	function edda_slug_fonts_url() {
	    $fonts_url = '';

	    /* Translators: If there are characters in your language that are not
	    * supported by vollkorn, translate this to 'off'. Do not translate
	    * into your own language.
	    */
	    $vollkorn = _x( 'on', 'Vollkorn font: on or off', 'theme-slug' );

	    /* Translators: If there are characters in your language that are not
	    * supported by alegreya, translate this to 'off'. Do not translate
	    * into your own language.
	    */
	    $alegreya = _x( 'on', 'Alegreya font: on or off', 'theme-slug' );

	    /* Translators: If there are characters in your language that are not
	    * supported by alegreya, translate this to 'off'. Do not translate
	    * into your own language.
	    */
	    $ubuntu = _x( 'on', 'Ubuntu font: on or off', 'theme-slug' );

	    if ( 'off' !== $vollkorn || 'off' !== $alegreya || 'off' !== $ubuntu ) {
	        $font_families = array();

	        if ( 'off' !== $vollkorn ) {
	            $font_families[] = 'vollkorn:400';
	        }

	        if ( 'off' !== $alegreya ) {
	            $font_families[] = 'alegreya:400italic,700italic,400,700';
	        }

	        if ( 'off' !== $ubuntu ) {
	            $font_families[] = 'ubuntu:500';
	        }

	        $query_args = array(
	            'family' => urlencode( implode( '|', $font_families ) ),
	            'subset' => urlencode( 'latin,latin-ext' ),
	        );

	        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	    }

	    return $fonts_url;
	}

	/* Handle content width for embeds and images. */
	hybrid_set_content_width( 920 );
}

/**
 * Enqueue scripts and styles.
 */
function edda_scripts() {
	wp_dequeue_style( 'saga-fonts' );
	wp_enqueue_style( 'edda-fonts', edda_slug_fonts_url(), array(), null );
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
	$wp_customize->remove_control( 'saga-header-icon' );
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
