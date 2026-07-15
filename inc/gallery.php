<?php
/**
 * Načítání dat galerií pro šablony.
 *
 * @package jipech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Vrátí ID příloh galerie realizace.
 */
function jipech_realizace_ids( $post_id ) {
	$ids = get_post_meta( $post_id, '_jipech_gallery', true );
	if ( ! $ids ) {
		return array();
	}
	return array_filter( array_map( 'absint', explode( ',', $ids ) ) );
}

/**
 * URL obrázku pro dlaždici/lightbox.
 */
function jipech_img_url( $id, $size = 'large' ) {
	$src = wp_get_attachment_image_src( $id, $size );
	return $src ? $src[0] : '';
}

/**
 * Data úvodní galerie: 5 kategorií, každá se sadou obrázků.
 *
 * @return array [ ['label'=>..,'images'=>[url,..]], .. ]
 */
function jipech_get_home_gallery() {
	$out = array();

	foreach ( jipech_gallery_categories() as $slug => $label ) {
		$images = array();

		// Přednostně realizace označená „home" v této kategorii.
		$q = new WP_Query( array(
			'post_type'      => 'jipech_realizace',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'no_found_rows'  => true,
			'tax_query'      => array(
				array(
					'taxonomy' => 'jipech_kategorie',
					'field'    => 'slug',
					'terms'    => $slug,
				),
			),
			'meta_query'     => array(
				array( 'key' => '_jipech_home', 'value' => '1' ),
			),
		) );

		// Fallback: pokud žádná „home" realizace, vezmi všechny v kategorii.
		if ( ! $q->have_posts() ) {
			$q = new WP_Query( array(
				'post_type'      => 'jipech_realizace',
				'posts_per_page' => -1,
				'orderby'        => 'menu_order title',
				'order'          => 'ASC',
				'no_found_rows'  => true,
				'tax_query'      => array(
					array(
						'taxonomy' => 'jipech_kategorie',
						'field'    => 'slug',
						'terms'    => $slug,
					),
				),
			) );
		}

		foreach ( $q->posts as $p ) {
			foreach ( jipech_realizace_ids( $p->ID ) as $id ) {
				$url = jipech_img_url( $id );
				if ( $url ) {
					$images[] = $url;
				}
			}
		}
		wp_reset_postdata();

		if ( $images ) {
			$out[] = array(
				'label'  => $label,
				'images' => array_values( array_unique( $images ) ),
			);
		}
	}

	return $out;
}

/**
 * Data pro podstránku Kuchyně: jednotlivé realizace (mimo „home" ukázku).
 *
 * @return array [ ['title'=>..,'letter'=>..,'photos'=>[url,..]], .. ]
 */
function jipech_get_kuchyne_realizace() {
	$out = array();

	$q = new WP_Query( array(
		'post_type'      => 'jipech_realizace',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
		'tax_query'      => array(
			array(
				'taxonomy' => 'jipech_kategorie',
				'field'    => 'slug',
				'terms'    => 'kuchyne',
			),
		),
		'meta_query'     => array(
			'relation' => 'OR',
			array( 'key' => '_jipech_home', 'value' => '1', 'compare' => '!=' ),
			array( 'key' => '_jipech_home', 'compare' => 'NOT EXISTS' ),
		),
	) );

	foreach ( $q->posts as $p ) {
		$photos = array();
		foreach ( jipech_realizace_ids( $p->ID ) as $id ) {
			$url = jipech_img_url( $id );
			if ( $url ) {
				$photos[] = $url;
			}
		}
		if ( ! $photos ) {
			continue;
		}
		$title  = get_the_title( $p );
		$parts  = preg_split( '/\s+/', trim( $title ) );
		$letter = $parts ? end( $parts ) : $title;

		$out[] = array(
			'title'  => $title,
			'letter' => $letter,
			'photos' => $photos,
		);
	}
	wp_reset_postdata();

	return $out;
}
