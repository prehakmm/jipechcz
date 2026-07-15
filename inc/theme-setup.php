<?php
/**
 * Nastavení tématu.
 *
 * @package jipech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'jipech_setup' );
function jipech_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo', array(
		'height'      => 120,
		'width'       => 360,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Obrázková velikost pro dlaždice galerie (poměr 4:3).
	add_image_size( 'jipech-tile', 640, 480, true );

	load_theme_textdomain( 'jipech', JIPECH_DIR . '/languages' );

	register_nav_menus( array(
		'primary' => __( 'Hlavní menu', 'jipech' ),
	) );
}

/**
 * Načtení Google Fontů (stejné jako původní web).
 */
add_action( 'wp_head', 'jipech_fonts', 1 );
function jipech_fonts() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com" />' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
	echo '<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600&family=Source+Sans+3:wght@300;400;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />' . "\n";
}

/**
 * URL stránky podle přiřazené šablony (Kuchyně / B2B).
 */
function jipech_page_url_by_template( $template ) {
	$cache_key = 'jipech_page_' . md5( $template );
	$found     = wp_cache_get( $cache_key, 'jipech' );
	if ( false === $found ) {
		$pages = get_posts( array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'numberposts' => 1,
			'fields'      => 'ids',
			'meta_key'    => '_wp_page_template',
			'meta_value'  => $template,
		) );
		$found = $pages ? (int) $pages[0] : 0;
		wp_cache_set( $cache_key, $found, 'jipech' );
	}
	return $found ? get_permalink( $found ) : '';
}

function jipech_kuchyne_url() {
	$url = jipech_page_url_by_template( 'template-kuchyne.php' );
	return $url ? $url : home_url( '/kuchyne/' );
}

function jipech_b2b_url() {
	$url = jipech_page_url_by_template( 'template-b2b.php' );
	return $url ? $url : home_url( '/b2b/' );
}

/**
 * Logo z Media Library (custom-logo), fallback na přiložený obrázek/text.
 */
function jipech_logo_url() {
	$id = get_theme_mod( 'custom_logo' );
	if ( $id ) {
		$src = wp_get_attachment_image_src( $id, 'full' );
		if ( $src ) {
			return $src[0];
		}
	}
	// Fallback – obrázek v assets (pokud existuje).
	return JIPECH_URI . '/assets/img/logo.png';
}
