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
