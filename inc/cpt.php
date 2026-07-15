<?php
/**
 * CPT „Realizace" + taxonomie kategorií + galerie metabox.
 *
 * Model:
 *  - CPT jipech_realizace = jedna realizace (kuchyně A–M) nebo ukázková sada pro úvodní stranu.
 *  - Taxonomie jipech_kategorie = 5 kategorií úvodní galerie (kuchyne, obyvaci, schody, stoly, pergoly).
 *  - Meta _jipech_gallery = ID příloh (čárkou oddělené).
 *  - Meta _jipech_home = „1" => použít jako dlaždici/kategorii na úvodní straně.
 *
 * @package jipech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Definice kategorií úvodní galerie (pořadí odpovídá původnímu webu).
 */
function jipech_gallery_categories() {
	return array(
		'kuchyne' => 'Kuchyně',
		'obyvaci' => 'Obývací pokoje',
		'schody'  => 'Schody',
		'stoly'   => 'Stoly',
		'pergoly' => 'Pergoly',
	);
}

add_action( 'init', 'jipech_register_realizace' );
function jipech_register_realizace() {

	register_taxonomy(
		'jipech_kategorie',
		'jipech_realizace',
		array(
			'labels'            => array(
				'name'          => __( 'Kategorie galerie', 'jipech' ),
				'singular_name' => __( 'Kategorie', 'jipech' ),
				'menu_name'     => __( 'Kategorie', 'jipech' ),
			),
			'hierarchical'      => true,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => false,
		)
	);

	register_post_type(
		'jipech_realizace',
		array(
			'labels'          => array(
				'name'               => __( 'Realizace', 'jipech' ),
				'singular_name'      => __( 'Realizace', 'jipech' ),
				'add_new'            => __( 'Přidat realizaci', 'jipech' ),
				'add_new_item'       => __( 'Přidat novou realizaci', 'jipech' ),
				'edit_item'          => __( 'Upravit realizaci', 'jipech' ),
				'new_item'           => __( 'Nová realizace', 'jipech' ),
				'view_item'          => __( 'Zobrazit realizaci', 'jipech' ),
				'search_items'       => __( 'Hledat realizace', 'jipech' ),
				'not_found'          => __( 'Žádné realizace', 'jipech' ),
				'menu_name'          => __( 'Realizace (galerie)', 'jipech' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => true,
			'menu_position'   => 25,
			'menu_icon'       => 'dashicons-format-gallery',
			'supports'        => array( 'title', 'thumbnail', 'page-attributes', 'excerpt' ),
			'has_archive'     => false,
			'rewrite'         => false,
			'hierarchical'    => false,
		)
	);
}

/**
 * Výchozí kategorie (jednou po aktivaci).
 */
add_action( 'after_switch_theme', 'jipech_seed_terms' );
function jipech_seed_terms() {
	if ( ! taxonomy_exists( 'jipech_kategorie' ) ) {
		jipech_register_realizace();
	}
	$i = 0;
	foreach ( jipech_gallery_categories() as $slug => $name ) {
		if ( ! term_exists( $slug, 'jipech_kategorie' ) ) {
			$term = wp_insert_term( $name, 'jipech_kategorie', array( 'slug' => $slug ) );
			if ( ! is_wp_error( $term ) ) {
				update_term_meta( $term['term_id'], 'jipech_order', $i );
			}
		}
		$i++;
	}
	flush_rewrite_rules();
}

/* ============================================================
   Galerie metabox
   ============================================================ */

add_action( 'add_meta_boxes', 'jipech_add_gallery_metabox' );
function jipech_add_gallery_metabox() {
	add_meta_box(
		'jipech_gallery',
		__( 'Fotogalerie realizace', 'jipech' ),
		'jipech_render_gallery_metabox',
		'jipech_realizace',
		'normal',
		'high'
	);
	add_meta_box(
		'jipech_home_flag',
		__( 'Zobrazení na úvodní straně', 'jipech' ),
		'jipech_render_home_metabox',
		'jipech_realizace',
		'side'
	);
}

function jipech_render_gallery_metabox( $post ) {
	wp_nonce_field( 'jipech_gallery_save', 'jipech_gallery_nonce' );
	$ids = get_post_meta( $post->ID, '_jipech_gallery', true );
	$ids = $ids ? array_filter( array_map( 'absint', explode( ',', $ids ) ) ) : array();
	?>
	<div class="jipech-gallery-metabox">
		<p class="description"><?php esc_html_e( 'Klikněte na „Přidat fotografie" a vyberte více obrázků z knihovny médií. Přetažením lze měnit pořadí.', 'jipech' ); ?></p>
		<ul class="jipech-gallery-list" id="jipech-gallery-list">
			<?php foreach ( $ids as $id ) :
				$thumb = wp_get_attachment_image( $id, array( 90, 90 ) );
				if ( ! $thumb ) { continue; }
				?>
				<li data-id="<?php echo esc_attr( $id ); ?>"><?php echo $thumb; // phpcs:ignore ?><button type="button" class="jipech-remove" aria-label="Odebrat">&times;</button></li>
			<?php endforeach; ?>
		</ul>
		<input type="hidden" name="jipech_gallery_ids" id="jipech-gallery-ids" value="<?php echo esc_attr( implode( ',', $ids ) ); ?>" />
		<p>
			<button type="button" class="button button-primary" id="jipech-gallery-add"><?php esc_html_e( 'Přidat fotografie', 'jipech' ); ?></button>
			<button type="button" class="button" id="jipech-gallery-clear"><?php esc_html_e( 'Vymazat vše', 'jipech' ); ?></button>
		</p>
	</div>
	<?php
}

function jipech_render_home_metabox( $post ) {
	$home = get_post_meta( $post->ID, '_jipech_home', true );
	?>
	<label>
		<input type="checkbox" name="jipech_home" value="1" <?php checked( $home, '1' ); ?> />
		<?php esc_html_e( 'Použít jako ukázku v galerii na úvodní straně', 'jipech' ); ?>
	</label>
	<p class="description"><?php esc_html_e( 'Pro každou kategorii úvodní galerie zaškrtněte jednu realizaci. Realizace kuchyní pro podstránku „Kuchyně" nechte nezaškrtnuté.', 'jipech' ); ?></p>
	<?php
}

add_action( 'save_post_jipech_realizace', 'jipech_save_gallery_meta', 10, 2 );
function jipech_save_gallery_meta( $post_id, $post ) {
	if ( ! isset( $_POST['jipech_gallery_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['jipech_gallery_nonce'] ), 'jipech_gallery_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$ids = isset( $_POST['jipech_gallery_ids'] ) ? sanitize_text_field( wp_unslash( $_POST['jipech_gallery_ids'] ) ) : '';
	$ids = implode( ',', array_filter( array_map( 'absint', explode( ',', $ids ) ) ) );
	update_post_meta( $post_id, '_jipech_gallery', $ids );

	update_post_meta( $post_id, '_jipech_home', isset( $_POST['jipech_home'] ) ? '1' : '' );
}

/**
 * Admin skripty pro galerie metabox.
 */
add_action( 'admin_enqueue_scripts', 'jipech_admin_assets' );
function jipech_admin_assets( $hook ) {
	$screen = get_current_screen();
	if ( $screen && 'jipech_realizace' === $screen->post_type && in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		wp_enqueue_media();
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jipech-admin-gallery', JIPECH_URI . '/assets/js/admin-gallery.js', array( 'jquery', 'jquery-ui-sortable' ), JIPECH_VERSION, true );
		wp_enqueue_style( 'jipech-admin', JIPECH_URI . '/assets/css/admin.css', array(), JIPECH_VERSION );
	}
}
