<?php
/**
 * Načítání stylů a skriptů.
 *
 * @package jipech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'jipech_enqueue' );
function jipech_enqueue() {
	// Kompilovaný Tailwind + design systém.
	wp_enqueue_style( 'jipech-theme', JIPECH_URI . '/assets/css/theme.css', array(), JIPECH_VERSION );

	// Hlavní JS (galerie, lightbox, menu, slider, formuláře, reveal).
	wp_enqueue_script( 'jipech-main', JIPECH_URI . '/assets/js/main.js', array(), JIPECH_VERSION, true );
	wp_localize_script( 'jipech-main', 'JIPECH_DATA', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'jipech_form' ),
	) );

	// (Úvodní galerie se předává přímo v šabloně jako atribut data-gallery-json.)

	// Podstránka Kuchyně.
	if ( is_page_template( 'template-kuchyne.php' ) ) {
		wp_enqueue_script( 'jipech-kuchyne', JIPECH_URI . '/assets/js/kuchyne.js', array( 'jipech-main' ), JIPECH_VERSION, true );
		wp_localize_script( 'jipech-kuchyne', 'JIPECH_KUCHYNE', array(
			'realizace' => jipech_get_kuchyne_realizace(),
		) );
	}
}
