<?php
/**
 * Truhlářství JIPECH – funkce tématu
 *
 * @package jipech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'JIPECH_VERSION', '1.0.0' );
define( 'JIPECH_DIR', get_template_directory() );
define( 'JIPECH_URI', get_template_directory_uri() );

/**
 * Firemní kontaktní údaje – jediné místo pro úpravu.
 * (Lze přepsat filtrem 'jipech_contact'.)
 */
function jipech_contact( $key = null ) {
	$data = apply_filters(
		'jipech_contact',
		array(
			'phone'         => '+420 603 265 873',
			'phone_href'    => '+420603265873',
			'email'         => 'jipech@jipech.cz',
			'company'       => 'Truhlářství Jiří Pecháček',
			'address_line1' => 'Kostelní 47, 289 07',
			'address_line2' => 'Libice nad Cidlinou',
			// Příjemce poptávek (necháme prázdné => použije se admin e-mail, resp. níže email).
			'form_recipient' => 'jipech@jipech.cz',
			// Skrytá kopie poptávek (Bcc). Prázdné = bez kopie.
			'form_bcc'       => 'web@pavelrehak.com',
			// Google hodnocení (hero). Vyplňte rating a počet recenzí.
			'google_url'     => 'https://www.google.com/maps/place/Truhl%C3%A1%C5%99stv%C3%AD+Ji%C5%99%C3%AD+Pech%C3%A1%C4%8Dek/data=!4m8!3m7!1s0x470c110a26828397:0x470b13df16bb5918!9m1!1b1',
			'google_rating'  => '',
			'google_reviews' => '',
		)
	);

	if ( null === $key ) {
		return $data;
	}
	return isset( $data[ $key ] ) ? $data[ $key ] : '';
}

require_once JIPECH_DIR . '/inc/theme-setup.php';
require_once JIPECH_DIR . '/inc/enqueue.php';
require_once JIPECH_DIR . '/inc/icons.php';
require_once JIPECH_DIR . '/inc/cpt.php';
require_once JIPECH_DIR . '/inc/gallery.php';
require_once JIPECH_DIR . '/inc/forms.php';
require_once JIPECH_DIR . '/inc/importer.php';
require_once JIPECH_DIR . '/inc/importer-fotky.php';

// Aktualizace tématu přímo z GitHubu (bez pluginu) – v administraci i při cron kontrole.
if ( is_admin() || ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) ) {
	require_once JIPECH_DIR . '/inc/updater.php';
}
