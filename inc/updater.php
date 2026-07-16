<?php
/**
 * Vestavěný aktualizátor tématu z GitHubu (bez pluginu).
 *
 * Porovná verzi ve `style.css` v repozitáři s nainstalovanou; když je novější,
 * nabídne WordPressu aktualizaci a stáhne ZIP větve main přímo z GitHubu.
 *
 * @package jipech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class JIPECH_Theme_Updater {

	const REPO   = 'prehakmm/jipechcz';
	const BRANCH = 'main';

	/** @var string Adresář tématu (stylesheet). */
	private $slug;

	public function __construct() {
		$this->slug = get_template();
		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_update' ) );
		add_filter( 'upgrader_source_selection', array( $this, 'fix_source_dir' ), 10, 4 );
	}

	/**
	 * Verze ve `style.css` na GitHubu (s cache; ?force-check ji obejde).
	 */
	private function remote_version() {
		$transient_key = 'jipech_remote_version';
		$force = is_admin() && ! empty( $_GET['force-check'] ); // phpcs:ignore WordPress.Security.NonceVerification

		if ( ! $force ) {
			$cached = get_transient( $transient_key );
			if ( false !== $cached ) {
				return $cached;
			}
		}

		$url = 'https://raw.githubusercontent.com/' . self::REPO . '/' . self::BRANCH . '/style.css';
		$res = wp_remote_get( $url, array( 'timeout' => 10 ) );

		$ver = '';
		if ( ! is_wp_error( $res ) && 200 === wp_remote_retrieve_response_code( $res ) ) {
			$body = wp_remote_retrieve_body( $res );
			if ( preg_match( '/^[ \t\/*#@]*Version:\s*(.+)$/mi', $body, $m ) ) {
				$ver = trim( $m[1] );
			}
		}

		set_transient( $transient_key, $ver, HOUR_IN_SECONDS );
		return $ver;
	}

	/**
	 * Vloží informaci o dostupné aktualizaci do transientu WordPressu.
	 */
	public function check_update( $transient ) {
		if ( ! is_object( $transient ) ) {
			$transient = new stdClass();
		}
		if ( ! isset( $transient->response ) || ! is_array( $transient->response ) ) {
			$transient->response = array();
		}

		$theme = wp_get_theme( $this->slug );
		if ( ! $theme->exists() ) {
			return $transient;
		}

		$installed = $theme->get( 'Version' );
		$remote    = $this->remote_version();

		if ( $remote && version_compare( $remote, $installed, '>' ) ) {
			$transient->response[ $this->slug ] = array(
				'theme'       => $this->slug,
				'new_version' => $remote,
				'url'         => 'https://github.com/' . self::REPO,
				'package'     => 'https://github.com/' . self::REPO . '/archive/refs/heads/' . self::BRANCH . '.zip',
			);
		} else {
			unset( $transient->response[ $this->slug ] );
		}

		return $transient;
	}

	/**
	 * ZIP z GitHubu má složku „jipechcz-main" – přejmenuje ji zpět na adresář tématu,
	 * aby se aktualizace nainstalovala na správné místo.
	 */
	public function fix_source_dir( $source, $remote_source, $upgrader, $args = array() ) {
		global $wp_filesystem;

		if ( empty( $args['theme'] ) || $args['theme'] !== $this->slug ) {
			return $source;
		}

		$desired = trailingslashit( $remote_source ) . $this->slug;
		if ( untrailingslashit( $source ) === untrailingslashit( $desired ) ) {
			return $source;
		}

		if ( $wp_filesystem && $wp_filesystem->move( untrailingslashit( $source ), untrailingslashit( $desired ), true ) ) {
			return trailingslashit( $desired );
		}

		return $source;
	}
}

new JIPECH_Theme_Updater();
