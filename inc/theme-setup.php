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

/**
 * Zajistí, že existují stránky s šablonami B2B a Kuchyně (jinak je vytvoří).
 * Řeší mizející /b2b/ – běží jednou (option guard).
 */
add_action( 'admin_init', 'jipech_ensure_pages' );
function jipech_ensure_pages() {
	if ( get_option( 'jipech_pages_created' ) ) {
		return;
	}
	$pages = array(
		'template-b2b.php'     => array( 'title' => 'Pro firmy', 'slug' => 'b2b' ),
		'template-kuchyne.php' => array( 'title' => 'Kuchyně', 'slug' => 'kuchyne' ),
	);
	foreach ( $pages as $template => $info ) {
		// Už existuje stránka s touto šablonou?
		$existing = get_posts( array(
			'post_type'   => 'page',
			'post_status' => 'any',
			'numberposts' => 1,
			'fields'      => 'ids',
			'meta_key'    => '_wp_page_template',
			'meta_value'  => $template,
		) );
		if ( $existing ) {
			continue;
		}
		// Existuje stránka s tímto slugem? Přiřaď jí šablonu.
		$by_slug = get_page_by_path( $info['slug'] );
		if ( $by_slug ) {
			update_post_meta( $by_slug->ID, '_wp_page_template', $template );
			if ( 'publish' !== $by_slug->post_status ) {
				wp_update_post( array( 'ID' => $by_slug->ID, 'post_status' => 'publish' ) );
			}
			continue;
		}
		// Vytvoř novou.
		$pid = wp_insert_post( array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => $info['title'],
			'post_name'   => $info['slug'],
		) );
		if ( ! is_wp_error( $pid ) && $pid ) {
			update_post_meta( $pid, '_wp_page_template', $template );
		}
	}
	update_option( 'jipech_pages_created', 1 );
}

function jipech_b2b_url() {
	$url = jipech_page_url_by_template( 'template-b2b.php' );
	return $url ? $url : home_url( '/b2b/' );
}

/**
 * Favicon / ikona webu z tématu (pokud není nastavená vlastní ve WP).
 */
add_action( 'wp_head', 'jipech_favicon', 2 );
add_action( 'admin_head', 'jipech_favicon', 2 );
add_action( 'login_head', 'jipech_favicon', 2 );
function jipech_favicon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return; // vlastní ikona webu nastavená v administraci má přednost
	}
	$u = JIPECH_URI . '/assets/img/';
	$v = '?v=' . JIPECH_VERSION;
	echo '<link rel="icon" href="' . esc_url( $u . 'favicon.ico' . $v ) . '" sizes="any" />' . "\n";
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( $u . 'favicon-32.png' . $v ) . '" />' . "\n";
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url( $u . 'favicon-16.png' . $v ) . '" />' . "\n";
	echo '<link rel="apple-touch-icon" href="' . esc_url( $u . 'apple-touch-icon.png' . $v ) . '" />' . "\n";
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
