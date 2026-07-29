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
 * Kategorie galerie seřazené dle term meta jipech_order, pak dle definovaného pořadí.
 *
 * @param bool $hide_empty Skrýt kategorie bez realizací.
 * @return WP_Term[]
 */
function jipech_ordered_terms( $hide_empty = true ) {
	$terms = get_terms( array(
		'taxonomy'   => 'jipech_kategorie',
		'hide_empty' => $hide_empty,
	) );
	if ( is_wp_error( $terms ) || ! $terms ) {
		return array();
	}
	$defined = array_keys( jipech_gallery_categories() );
	usort( $terms, function ( $a, $b ) use ( $defined ) {
		$oa = get_term_meta( $a->term_id, 'jipech_order', true );
		$ob = get_term_meta( $b->term_id, 'jipech_order', true );
		$oa = ( '' === $oa ) ? 999 : (int) $oa;
		$ob = ( '' === $ob ) ? 999 : (int) $ob;
		if ( $oa !== $ob ) {
			return $oa - $ob;
		}
		$ia = array_search( $a->slug, $defined, true );
		$ib = array_search( $b->slug, $defined, true );
		$ia = ( false === $ia ) ? 999 : $ia;
		$ib = ( false === $ib ) ? 999 : $ib;
		return $ia - $ib;
	} );
	return $terms;
}

/**
 * Data úvodní galerie: kategorie, každá se sadou obrázků.
 *
 * @return array [ ['label'=>..,'images'=>[url,..]], .. ]
 */
function jipech_get_home_gallery() {
	$out = array();

	foreach ( jipech_ordered_terms( false ) as $term ) {
		$images = jipech_term_images( $term->slug );
		if ( $images ) {
			$out[] = array(
				'label'  => $term->name,
				'images' => $images,
			);
		}
	}

	return $out;
}

/**
 * Obrázky kategorie pro úvodní galerii – přednostně z „home" realizací, jinak ze všech.
 */
function jipech_term_images( $slug ) {
	$images = array();

	$base = array(
		'post_type'      => 'jipech_realizace',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
		'tax_query'      => array(
			array( 'taxonomy' => 'jipech_kategorie', 'field' => 'slug', 'terms' => $slug ),
		),
	);

	$q = new WP_Query( array_merge( $base, array(
		'meta_query' => array( array( 'key' => '_jipech_home', 'value' => '1' ) ),
	) ) );
	if ( ! $q->have_posts() ) {
		$q = new WP_Query( $base );
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

	return array_values( array_unique( $images ) );
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
