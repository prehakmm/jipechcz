<?php
/**
 * Importér obsahu – stáhne obrázky z původního CDN do Media Library
 * a založí realizace/ukázky galerie. Běží dávkově přes AJAX.
 *
 * @package jipech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'JIPECH_CDN', 'https://d2xsxph8kpxj0f.cloudfront.net/310519663409095007/oBVC2k3JKqHB8LtcWPftZ3' );

/**
 * Samostatné obrázky použité v šablonách (klíč => soubor).
 */
function jipech_import_singles() {
	return array(
		'logo'     => 'logo_66d12615.png',
		'hero'     => 'jipech_hero-Xt3HJAWHfyFaYaK4zXmova.webp',
		'workshop' => 'jipech_workshop_1997_f0fe39f8.jpg',
		'kitchen'  => 'jipech_kitchen_hero-9eDZMNZZQCmfbmHFFRCdRA.webp',
		'cedule'   => 'jipech_cedule_1997_c3b80463.png',
	);
}

/**
 * Definice položek galerie k založení.
 * key => unikátní klíč importu; category => slug taxonomie; home => ukázka na úvodní straně.
 */
function jipech_import_posts() {
	return array(
		// --- Úvodní galerie (home=1) ---
		array( 'key' => 'home-kuchyne', 'title' => 'Ukázky kuchyní', 'category' => 'kuchyne', 'home' => true, 'order' => 0, 'files' => array(
			'PB050181-scaled_8f3296c9.jpg','PB050180-scaled_54875797.jpg','PB050179-scaled_a2547d7c.jpg','PB050178-1-scaled_6b51dbf6.jpg','PB050177-scaled_5a38bb90.jpg','PB050176-scaled_f0b7b779.jpg','SAM1650-scaled_349a67f6.jpg','SAM1632-scaled_552fdae0.jpg','SAM1639-scaled_01de02e5.jpg','SAM1642-scaled_2885b074.jpg','P8040944-scaled_db728c8a.jpg','P8040943-scaled_41dbc8e1.jpg',
		) ),
		array( 'key' => 'home-obyvaci', 'title' => 'Obývací pokoje', 'category' => 'obyvaci', 'home' => true, 'order' => 0, 'files' => array(
			'20161002_223515-scaled_dee9e1a6.jpg','20161008_201517-scaled_1673502d.jpg','20161008_201529-scaled_14f2f16e.jpg','20161008_201544-scaled_8809d30c.jpg','IMG_20170105_153341-scaled_7872a8b9.jpg','IMG_20170105_153349-scaled_d9ece2f8.jpg',
		) ),
		array( 'key' => 'home-schody', 'title' => 'Schody', 'category' => 'schody', 'home' => true, 'order' => 0, 'files' => array(
			'2013-04-10-006-scaled_52561fd6.jpg','2013-04-10-007-scaled_5bde440e.jpg','2013-04-10-008-scaled_a2c3c65f.jpg',
		) ),
		array( 'key' => 'home-stoly', 'title' => 'Stoly', 'category' => 'stoly', 'home' => true, 'order' => 0, 'files' => array(
			'20150810_202600-scaled_cd7beb90.jpg','20150813_201613-scaled_01178c32.jpg','20150813_201618-scaled_b02336c0.jpg',
		) ),
		array( 'key' => 'home-pergoly', 'title' => 'Pergoly', 'category' => 'pergoly', 'home' => true, 'order' => 0, 'files' => array(
			'20072010124_9df6c56e.jpg','20072010126_35b12829.jpg','20072010128_5fffd019.jpg',
		) ),

		// --- Kuchyně realizace A–M (home=0) ---
		array( 'key' => 'kuchyne-A', 'title' => 'Realizace A', 'category' => 'kuchyne', 'home' => false, 'order' => 1, 'files' => array( 'realizace_A_01_47d6989c.jpg','realizace_A_02_9219aa0d.jpg','realizace_A_03_0f3a2dae.jpg','realizace_A_04_b0a44f11.jpg','realizace_A_05_d68522a5.jpg','realizace_A_06_3f211531.jpg','realizace_A_07_4d24edbb.jpg','realizace_A_08_dc74f21b.jpg','realizace_A_09_a3a69910.jpg','realizace_A_10_e6cffb2b.jpg','realizace_A_11_bf55a0b5.jpg' ) ),
		array( 'key' => 'kuchyne-B', 'title' => 'Realizace B', 'category' => 'kuchyne', 'home' => false, 'order' => 2, 'files' => array( 'realizace_B_01_193bf295.jpg','realizace_B_02_6f4b2af5.jpg','realizace_B_03_bb5582ac.jpg','realizace_B_04_73efe22c.jpg','realizace_B_05_3568e50a.jpg','realizace_B_06_5ba48d20.jpg','realizace_B_07_a0834785.jpg','realizace_B_08_d1585d0b.jpg','realizace_B_09_19e7801f.jpg','realizace_B_10_fffc6257.jpg','realizace_B_11_bbf89b15.jpg','realizace_B_12_d3ed39af.jpg','realizace_B_13_40a1a839.jpg','realizace_B_14_fcba5b79.jpg','realizace_B_15_a655c07a.jpg' ) ),
		array( 'key' => 'kuchyne-C', 'title' => 'Realizace C', 'category' => 'kuchyne', 'home' => false, 'order' => 3, 'files' => array( 'realizace_C_01_c5071963.jpg','realizace_C_02_ef50c3a7.jpg','realizace_C_03_217d689e.jpg','realizace_C_04_53d27169.jpg','realizace_C_05_e7130836.jpg','realizace_C_06_3e7b755c.jpg','realizace_C_07_c0ab682b.jpg' ) ),
		array( 'key' => 'kuchyne-D', 'title' => 'Realizace D', 'category' => 'kuchyne', 'home' => false, 'order' => 4, 'files' => array( 'realizace_D_01_06884091.jpg','realizace_D_02_9fd4ce5b.jpg','realizace_D_03_59373b26.jpg','realizace_D_04_6a95ca73.jpg','realizace_D_05_6eaec25b.jpg','realizace_D_06_8132cfbc.jpg','realizace_D_07_bca88e2e.jpg','realizace_D_08_0c0f3962.jpg','realizace_D_09_1e331eb7.jpg','realizace_D_10_5b2013d8.jpg','realizace_D_11_78290ad5.jpg','realizace_D_12_8b6d3efd.jpg','realizace_D_13_73c328ce.jpg','realizace_D_14_a85ca24b.jpg','realizace_D_15_33f4fc2c.jpg' ) ),
		array( 'key' => 'kuchyne-E', 'title' => 'Realizace E', 'category' => 'kuchyne', 'home' => false, 'order' => 5, 'files' => array( 'realizace_E_01_f1dba34a.jpg','realizace_E_02_49b1d5e1.jpg','realizace_E_03_2f460265.jpg','realizace_E_04_b594424e.jpg','realizace_E_05_3de9246c.jpg','realizace_E_06_f3f1afac.jpg','realizace_E_07_5e76dac3.jpg','realizace_E_08_e286b6d6.jpg','realizace_E_09_5b4e7521.jpg','realizace_E_10_7fdc4b53.jpg','realizace_E_11_f4f5c428.jpg','realizace_E_12_f30b3457.jpg' ) ),
		array( 'key' => 'kuchyne-F', 'title' => 'Realizace F', 'category' => 'kuchyne', 'home' => false, 'order' => 6, 'files' => array( 'realizace_F_01_35eda94e.jpg','realizace_F_02_80172cb9.jpg','realizace_F_03_19b0049b.jpg','realizace_F_04_240d124b.jpg','realizace_F_05_99f73c5f.jpg','realizace_F_06_7e9f6f5d.jpg' ) ),
		array( 'key' => 'kuchyne-G', 'title' => 'Realizace G', 'category' => 'kuchyne', 'home' => false, 'order' => 7, 'files' => array( 'realizace_G_01_0a4c086e.jpg','realizace_G_02_e39b6664.jpg','realizace_G_03_c5249b71.jpg','realizace_G_04_30cf544f.jpg','realizace_G_05_02478e6c.jpg','realizace_G_06_f7cd73b9.jpg','realizace_G_07_ce02bec3.jpg','realizace_G_08_e247349b.jpg','realizace_G_09_16d211f5.jpg' ) ),
		array( 'key' => 'kuchyne-H', 'title' => 'Realizace H', 'category' => 'kuchyne', 'home' => false, 'order' => 8, 'files' => array( 'realizace_H_01_1b4ba10d.jpg','realizace_H_02_bb1d8987.jpg','realizace_H_03_e988c7f2.jpg','realizace_H_04_c64e00e6.jpg' ) ),
		array( 'key' => 'kuchyne-I', 'title' => 'Realizace I', 'category' => 'kuchyne', 'home' => false, 'order' => 9, 'files' => array( 'realizace_I_01_ead701ca.jpg','realizace_I_02_9c86383a.jpg','realizace_I_03_e86dcdad.jpg','realizace_I_04_fb582276.jpg','realizace_I_05_48b0d404.jpg' ) ),
		array( 'key' => 'kuchyne-J', 'title' => 'Realizace J', 'category' => 'kuchyne', 'home' => false, 'order' => 10, 'files' => array( 'realizace_J_01_57174991.jpg','realizace_J_02_db35a839.jpg','realizace_J_03_2476cd1d.jpg','realizace_J_04_d1007c94.jpg','realizace_J_05_ea0607e8.jpg','realizace_J_06_8a5f3292.jpg','realizace_J_07_418b7cf4.jpg','realizace_J_08_def81d2a.jpg','realizace_J_09_ef1d5615.jpg','realizace_J_10_01d4a854.jpg','realizace_J_11_69645535.jpg','realizace_J_12_adf4ebb7.jpg','realizace_J_13_063e622b.jpg','realizace_J_14_ec980e6e.jpg','realizace_J_15_e005be85.jpg' ) ),
		array( 'key' => 'kuchyne-K', 'title' => 'Realizace K', 'category' => 'kuchyne', 'home' => false, 'order' => 11, 'files' => array( 'realizace_K_01_1b4b5e0f.jpg','realizace_K_02_6ac9c758.jpg','realizace_K_03_205980ea.jpg','realizace_K_04_8797c252.jpg','realizace_K_05_4f4a7f91.jpg','realizace_K_06_82d49acd.jpg','realizace_K_07_76c8a835.jpg','realizace_K_08_d604efb2.jpg','realizace_K_09_dcd1cecf.jpg','realizace_K_10_65a7cbe6.jpg','realizace_K_11_27d64084.jpg','realizace_K_12_76a62787.jpg','realizace_K_13_56ff5d54.jpg','realizace_K_14_8f65b6b4.jpg','realizace_K_15_4e43f7c2.jpg','realizace_K_16_0c0a1e3a.jpg','realizace_K_17_69425f98.jpg' ) ),
		array( 'key' => 'kuchyne-L', 'title' => 'Realizace L', 'category' => 'kuchyne', 'home' => false, 'order' => 12, 'files' => array( 'realizace_L_01_7553db4f.jpg','realizace_L_02_18d6e325.jpg','realizace_L_03_07b483b5.jpg','realizace_L_04_f631fb16.jpg','realizace_L_05_95e44c39.jpg','realizace_L_06_bca261a0.jpg','realizace_L_07_52d3b241.jpg','realizace_L_08_ef19f27c.jpg','realizace_L_09_44f86762.jpg','realizace_L_10_fb9809ba.jpg','realizace_L_11_37e1ddd9.jpg','realizace_L_12_15935d0f.jpg','realizace_L_13_d4ae9211.jpg','realizace_L_14_c2168345.jpg','realizace_L_15_08a3b619.jpg','realizace_L_16_d455c0d2.jpg','realizace_L_17_dbea5a0e.jpg','realizace_L_18_8980620a.jpg','realizace_L_19_13129d22.jpg','realizace_L_20_6c18a737.jpg','realizace_L_21_f8535dfa.jpg','realizace_L_22_551e0877.jpg' ) ),
		array( 'key' => 'kuchyne-M', 'title' => 'Realizace M', 'category' => 'kuchyne', 'home' => false, 'order' => 13, 'files' => array( 'realizace_M_01_8286bcc6.jpg','realizace_M_02_a4525efc.jpg','realizace_M_03_d04127cf.jpg','realizace_M_04_723db3c0.jpg','realizace_M_05_a18915dc.jpg','realizace_M_06_48a7d9b9.jpg','realizace_M_07_b16f2238.jpg','realizace_M_09_88ddd75c.jpg' ) ),
	);
}

/**
 * URL šablonového obrázku – z Media Library, fallback na CDN.
 */
function jipech_asset( $key ) {
	$id = get_option( 'jipech_asset_' . $key );
	if ( $id ) {
		$url = wp_get_attachment_url( $id );
		if ( $url ) {
			return $url;
		}
	}
	$singles = jipech_import_singles();
	if ( isset( $singles[ $key ] ) ) {
		return JIPECH_CDN . '/' . $singles[ $key ];
	}
	return '';
}

/* ============================================================
   Admin stránka importu
   ============================================================ */

add_action( 'admin_menu', 'jipech_import_menu' );
function jipech_import_menu() {
	add_submenu_page(
		'edit.php?post_type=jipech_realizace',
		__( 'Import obsahu', 'jipech' ),
		__( 'Import obsahu', 'jipech' ),
		'manage_options',
		'jipech-import',
		'jipech_import_page'
	);
}

function jipech_import_page() {
	$total = 0;
	foreach ( jipech_import_singles() as $f ) { $total++; }
	foreach ( jipech_import_posts() as $p ) { $total += count( $p['files'] ); }
	$map = get_option( 'jipech_import_map', array() );
	$done = is_array( $map ) ? count( $map ) : 0;
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Import obsahu JIPECH', 'jipech' ); ?></h1>
		<p><?php esc_html_e( 'Tlačítko níže stáhne všechny obrázky z původního webu do knihovny médií a založí položky galerie (kuchyně A–M + ukázky na úvodní straně). Lze spustit opakovaně – již stažené obrázky se přeskočí.', 'jipech' ); ?></p>
		<p>
			<strong><?php esc_html_e( 'Obrázků celkem:', 'jipech' ); ?></strong> <?php echo (int) $total; ?> &nbsp;|&nbsp;
			<strong><?php esc_html_e( 'Již staženo:', 'jipech' ); ?></strong> <span id="jipech-done"><?php echo (int) $done; ?></span>
		</p>
		<p>
			<button class="button button-primary button-hero" id="jipech-import-start"><?php esc_html_e( 'Spustit import', 'jipech' ); ?></button>
		</p>
		<div id="jipech-import-progress" style="max-width:600px;display:none;">
			<div style="background:#e2e2e2;border-radius:6px;overflow:hidden;height:22px;">
				<div id="jipech-import-bar" style="background:#c8873a;height:100%;width:0;transition:width .2s;"></div>
			</div>
			<p id="jipech-import-status" style="margin-top:8px;"></p>
		</div>
	</div>
	<script>
	(function(){
		var btn = document.getElementById('jipech-import-start');
		var bar = document.getElementById('jipech-import-bar');
		var wrap = document.getElementById('jipech-import-progress');
		var status = document.getElementById('jipech-import-status');
		var doneEl = document.getElementById('jipech-done');
		var ajaxUrl = <?php echo wp_json_encode( admin_url( 'admin-ajax.php' ) ); ?>;
		var nonce = <?php echo wp_json_encode( wp_create_nonce( 'jipech_import' ) ); ?>;
		function step(reset){
			var body = new URLSearchParams();
			body.set('action','jipech_import_step');
			body.set('nonce', nonce);
			if(reset) body.set('reset','1');
			fetch(ajaxUrl,{method:'POST',credentials:'same-origin',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:body.toString()})
			.then(function(r){return r.json();})
			.then(function(res){
				if(!res.success){ status.textContent = 'Chyba: ' + (res.data && res.data.message || 'neznámá'); btn.disabled=false; return; }
				var d = res.data;
				var pct = d.total ? Math.round(d.processed/d.total*100) : 100;
				bar.style.width = pct + '%';
				status.textContent = 'Zpracováno ' + d.processed + ' / ' + d.total + (d.lastError ? ' — poslední chyba: ' + d.lastError : '');
				doneEl.textContent = d.imported;
				if(d.finished){ status.textContent = 'Hotovo! Naimportováno ' + d.imported + ' obrázků. Můžete zavřít stránku.'; btn.disabled=false; }
				else { step(false); }
			})
			.catch(function(e){ status.textContent='Chyba spojení: '+e; btn.disabled=false; });
		}
		btn.addEventListener('click', function(){ btn.disabled=true; wrap.style.display='block'; status.textContent='Připravuji...'; step(true); });
	})();
	</script>
	<?php
}

/* ============================================================
   AJAX krok importu
   ============================================================ */

add_action( 'wp_ajax_jipech_import_step', 'jipech_import_step' );
function jipech_import_step() {
	if ( ! current_user_can( 'manage_options' ) || ! check_ajax_referer( 'jipech_import', 'nonce', false ) ) {
		wp_send_json_error( array( 'message' => 'Nedostatečná oprávnění.' ) );
	}

	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$reset = ! empty( $_POST['reset'] );

	if ( $reset ) {
		jipech_import_build_queue();
	}

	$queue = get_option( 'jipech_import_queue', array() );
	$total = (int) get_option( 'jipech_import_total', 0 );
	$map   = get_option( 'jipech_import_map', array() );
	if ( ! is_array( $map ) ) { $map = array(); }

	$batch      = 4;
	$last_error = '';
	$processed_now = 0;

	while ( $processed_now < $batch && ! empty( $queue ) ) {
		$task = array_shift( $queue );
		$processed_now++;

		$file = $task['file'];
		$att_id = isset( $map[ $file ] ) ? (int) $map[ $file ] : 0;

		if ( ! $att_id ) {
			$url = JIPECH_CDN . '/' . $file;
			$att_id = media_sideload_image( $url, 0, null, 'id' );
			if ( is_wp_error( $att_id ) ) {
				$last_error = $file . ': ' . $att_id->get_error_message();
				$att_id = 0;
			} else {
				update_post_meta( $att_id, '_jipech_src', $file );
				$map[ $file ] = $att_id;
			}
		}

		if ( $att_id ) {
			if ( 'single' === $task['type'] ) {
				update_option( 'jipech_asset_' . $task['key'], $att_id );
			} elseif ( 'gallery' === $task['type'] ) {
				$pid = (int) $task['post'];
				$cur = get_post_meta( $pid, '_jipech_gallery', true );
				$cur = $cur ? array_filter( array_map( 'absint', explode( ',', $cur ) ) ) : array();
				if ( ! in_array( $att_id, $cur, true ) ) {
					$cur[] = $att_id;
					update_post_meta( $pid, '_jipech_gallery', implode( ',', $cur ) );
				}
				if ( ! empty( $task['first'] ) && ! has_post_thumbnail( $pid ) ) {
					set_post_thumbnail( $pid, $att_id );
				}
			}
		}
	}

	update_option( 'jipech_import_queue', $queue, false );
	update_option( 'jipech_import_map', $map, false );

	$remaining = count( $queue );
	$processed = $total - $remaining;

	wp_send_json_success( array(
		'total'     => $total,
		'processed' => $processed,
		'imported'  => count( $map ),
		'finished'  => 0 === $remaining,
		'lastError' => $last_error,
	) );
}

/**
 * Postaví frontu importu: založí/najde posty a připraví seznam úloh.
 */
function jipech_import_build_queue() {
	if ( ! taxonomy_exists( 'jipech_kategorie' ) ) {
		jipech_register_realizace();
	}
	jipech_seed_terms();

	$queue = array();

	// Singles.
	foreach ( jipech_import_singles() as $key => $file ) {
		$queue[] = array( 'type' => 'single', 'key' => $key, 'file' => $file );
	}

	// Posty galerie.
	foreach ( jipech_import_posts() as $def ) {
		$pid = jipech_get_or_create_realizace( $def );
		if ( ! $pid ) {
			continue;
		}
		$i = 0;
		foreach ( $def['files'] as $file ) {
			$queue[] = array( 'type' => 'gallery', 'post' => $pid, 'file' => $file, 'first' => ( 0 === $i ) );
			$i++;
		}
	}

	update_option( 'jipech_import_queue', $queue, false );
	update_option( 'jipech_import_total', count( $queue ), false );
}

/**
 * Najde nebo založí realizaci dle importního klíče.
 */
function jipech_get_or_create_realizace( $def ) {
	$existing = get_posts( array(
		'post_type'   => 'jipech_realizace',
		'post_status' => 'any',
		'numberposts' => 1,
		'fields'      => 'ids',
		'meta_key'    => '_jipech_import_key',
		'meta_value'  => $def['key'],
	) );

	if ( $existing ) {
		$pid = (int) $existing[0];
	} else {
		$pid = wp_insert_post( array(
			'post_type'   => 'jipech_realizace',
			'post_status' => 'publish',
			'post_title'  => $def['title'],
			'menu_order'  => (int) $def['order'],
		) );
		if ( is_wp_error( $pid ) || ! $pid ) {
			return 0;
		}
		update_post_meta( $pid, '_jipech_import_key', $def['key'] );
	}

	update_post_meta( $pid, '_jipech_home', $def['home'] ? '1' : '' );
	wp_set_object_terms( $pid, $def['category'], 'jipech_kategorie', false );

	return $pid;
}
