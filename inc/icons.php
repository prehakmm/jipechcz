<?php
/**
 * SVG ikony (1:1 z původního webu – lucide + vlastní ikony služeb).
 *
 * @package jipech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Vnitřní markup lucide ikon (bez wrapperu <svg>).
 */
function jipech_icon_paths() {
	return array(
		'phone'         => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>',
		'phone-call'    => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path><path d="M14.05 2a9 9 0 0 1 8 7.94"></path><path d="M14.05 6A5 5 0 0 1 18 10"></path>',
		'building2'     => '<path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path><path d="M10 6h4"></path><path d="M10 10h4"></path><path d="M10 14h4"></path><path d="M10 18h4"></path>',
		'menu'          => '<line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line>',
		'x'             => '<path d="M18 6 6 18"></path><path d="m6 6 12 12"></path>',
		'arrow-right'   => '<path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>',
		'arrow-left'    => '<path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path>',
		'chevron-down'  => '<path d="m6 9 6 6 6-6"></path>',
		'chevron-right' => '<path d="m9 18 6-6-6-6"></path>',
		'chevron-left'  => '<path d="m15 18-6-6 6-6"></path>',
		'clock'         => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>',
		'ruler'         => '<path d="M21.3 15.3a2.4 2.4 0 0 1 0 3.4l-2.6 2.6a2.4 2.4 0 0 1-3.4 0L2.7 8.7a2.41 2.41 0 0 1 0-3.4l2.6-2.6a2.41 2.41 0 0 1 3.4 0Z"></path><path d="m14.5 12.5 2-2"></path><path d="m11.5 9.5 2-2"></path><path d="m8.5 6.5 2-2"></path><path d="m17.5 15.5 2-2"></path>',
		'wrench'        => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>',
		'check'         => '<path d="M21.801 10A10 10 0 1 1 17 3.335"></path><path d="m9 11 3 3L22 4"></path>',
		'quote'         => '<path d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"></path><path d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"></path>',
		'star'          => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>',
		'map-pin'       => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle>',
		'mail'          => '<rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>',
		'users'         => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>',
		'file-text'     => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path>',
		'upload'        => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line>',
	);
}

/**
 * Vypíše lucide ikonu.
 *
 * @param string     $name  Klíč ikony.
 * @param int        $size  Šířka/výška v px.
 * @param string     $class CSS třídy.
 * @param string     $style Inline styl.
 * @param string     $fill  Výplň (výchozí none; star => barva).
 */
function jipech_icon( $name, $size = 24, $class = '', $style = '', $fill = 'none' ) {
	$paths = jipech_icon_paths();
	if ( ! isset( $paths[ $name ] ) ) {
		return;
	}
	printf(
		'<svg width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="%2$s" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"%3$s%4$s>%5$s</svg>',
		(int) $size,
		esc_attr( $fill ),
		$class ? ' class="' . esc_attr( $class ) . '"' : '',
		$style ? ' style="' . esc_attr( $style ) . '"' : '',
		$paths[ $name ] // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- statické SVG.
	);
}

/**
 * Vlastní ikony služeb (16 kategorií), stroke-width 1.8.
 */
function jipech_service_icon_paths() {
	return array(
		'kuchyne'    => '<rect x="2" y="3" width="20" height="14" rx="1"></rect><line x1="2" y1="9" x2="22" y2="9"></line><line x1="8" y1="9" x2="8" y2="17"></line><circle cx="5" cy="6" r="1"></circle><circle cx="11" cy="6" r="1"></circle>',
		'knihovny'   => '<rect x="3" y="2" width="4" height="20" rx="0.5"></rect><rect x="10" y="6" width="4" height="16" rx="0.5"></rect><rect x="17" y="4" width="4" height="18" rx="0.5"></rect>',
		'vestaveny'  => '<rect x="2" y="2" width="20" height="20" rx="1"></rect><line x1="12" y1="2" x2="12" y2="22"></line><line x1="2" y1="8" x2="12" y2="8"></line><line x1="2" y1="14" x2="12" y2="14"></line><circle cx="7" cy="11" r="0.8" fill="currentColor"></circle>',
		'satni'      => '<path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.57a2 2 0 00-1.34-2.23z"></path>',
		'ulozne'     => '<path d="M21 8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 002 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line>',
		'obyvaci'    => '<path d="M20 9V7a2 2 0 00-2-2H6a2 2 0 00-2 2v2"></path><path d="M2 11v5a2 2 0 002 2h16a2 2 0 002-2v-5a1 1 0 00-1-1H3a1 1 0 00-1 1z"></path><path d="M4 18v2M20 18v2M12 4v5"></path>',
		'pracovny'   => '<rect x="2" y="14" width="20" height="2" rx="1"></rect><rect x="4" y="10" width="16" height="4"></rect><line x1="6" y1="16" x2="6" y2="20"></line><line x1="18" y1="16" x2="18" y2="20"></line>',
		'kancelare'  => '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline>',
		'detske'     => '<circle cx="12" cy="8" r="4"></circle><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"></path>',
		'luzko'      => '<path d="M2 4v16"></path><path d="M2 8h18a2 2 0 012 2v10"></path><path d="M2 17h20"></path><path d="M6 8v9"></path>',
		'dvere'      => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path><rect x="6" y="2" width="12" height="20" rx="1"></rect><circle cx="15" cy="12" r="1" fill="currentColor"></circle>',
		'schodiste'  => '<polyline points="4 20 4 16 8 16 8 12 12 12 12 8 16 8 16 4 20 4"></polyline><line x1="4" y1="20" x2="20" y2="20"></line><line x1="20" y1="4" x2="20" y2="20"></line>',
		'okna'       => '<rect x="3" y="3" width="18" height="18" rx="1"></rect><line x1="3" y1="12" x2="21" y2="12"></line><line x1="12" y1="3" x2="12" y2="21"></line>',
		'stoly'      => '<rect x="2" y="8" width="20" height="3" rx="1"></rect><line x1="5" y1="11" x2="5" y2="20"></line><line x1="19" y1="11" x2="19" y2="20"></line>',
		'altanky'    => '<polyline points="2 14 12 4 22 14"></polyline><line x1="4" y1="14" x2="4" y2="20"></line><line x1="20" y1="14" x2="20" y2="20"></line><line x1="4" y1="20" x2="20" y2="20"></line><line x1="8" y1="14" x2="8" y2="20"></line><line x1="12" y1="14" x2="12" y2="20"></line><line x1="16" y1="14" x2="16" y2="20"></line>',
		'oblozeni'   => '<rect x="2" y="2" width="20" height="5" rx="0.5"></rect><rect x="2" y="9.5" width="20" height="5" rx="0.5"></rect><rect x="2" y="17" width="20" height="5" rx="0.5"></rect>',
	);
}

/**
 * Vypíše ikonu služby.
 */
function jipech_service_icon( $key, $class = 'w-8 h-8', $style = '' ) {
	$paths = jipech_service_icon_paths();
	if ( ! isset( $paths[ $key ] ) ) {
		return;
	}
	printf(
		'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"%1$s%2$s>%3$s</svg>',
		$class ? ' class="' . esc_attr( $class ) . '"' : '',
		$style ? ' style="' . esc_attr( $style ) . '"' : '',
		$paths[ $key ] // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- statické SVG.
	);
}
