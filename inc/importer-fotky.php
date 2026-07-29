<?php
/**
 * Import vlastních fotek z FTP složky do Media Library a galerie.
 *
 * Fotky se nahrají přes FTP do wp-content/uploads/jipech-fotky/<slug>/,
 * kde <slug> = kategorie galerie. Tento importér je dávkově naimportuje
 * do knihovny médií a přiřadí k „home" realizaci dané kategorie.
 *
 * @package jipech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function jipech_fotky_base_dir() {
	$u = wp_upload_dir();
	return trailingslashit( $u['basedir'] ) . 'jipech-fotky';
}

function jipech_fotky_list( $dir ) {
	$out = array();
	if ( ! is_dir( $dir ) ) {
		return $out;
	}
	foreach ( scandir( $dir ) as $f ) {
		if ( '.' === $f || '..' === $f ) {
			continue;
		}
		$p = $dir . '/' . $f;
		if ( is_file( $p ) && preg_match( '/\.(jpe?g|png|webp|gif)$/i', $f ) ) {
			$out[] = $p;
		}
	}
	sort( $out );
	return $out;
}

add_action( 'admin_menu', 'jipech_fotky_menu' );
function jipech_fotky_menu() {
	add_submenu_page(
		'edit.php?post_type=jipech_realizace',
		__( 'Import fotek (FTP)', 'jipech' ),
		__( 'Import fotek (FTP)', 'jipech' ),
		'manage_options',
		'jipech-fotky',
		'jipech_fotky_page'
	);
}

function jipech_fotky_page() {
	$base  = jipech_fotky_base_dir();
	$cats  = jipech_gallery_categories();
	$rows  = array();
	$total = 0;
	if ( is_dir( $base ) ) {
		foreach ( glob( $base . '/*', GLOB_ONLYDIR ) as $dir ) {
			$slug          = basename( $dir );
			$n             = count( jipech_fotky_list( $dir ) );
			$rows[ $slug ] = $n;
			$total        += $n;
		}
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Import fotek galerie (z FTP)', 'jipech' ); ?></h1>
		<p><?php esc_html_e( 'Fotky nahrané přes FTP do složky níže (podsložky = kategorie) se naimportují do knihovny médií a přiřadí do galerie na úvodní straně.', 'jipech' ); ?></p>
		<p><code><?php echo esc_html( $base ); ?></code></p>
		<?php if ( ! $total ) : ?>
			<div class="notice notice-warning inline"><p><?php esc_html_e( 'Ve složce jipech-fotky zatím nejsou žádné fotky. Nahrajte je nejdřív přes FTP (skript upload-fotky.py).', 'jipech' ); ?></p></div>
		<?php else : ?>
			<table class="widefat striped" style="max-width:640px;margin-top:12px;">
				<thead><tr><th><?php esc_html_e( 'Kategorie (složka)', 'jipech' ); ?></th><th><?php esc_html_e( 'Fotek', 'jipech' ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( $rows as $slug => $n ) :
					$label = isset( $cats[ $slug ] ) ? $cats[ $slug ] : ucfirst( str_replace( '_', ' ', $slug ) ); ?>
					<tr><td><?php echo esc_html( $label ); ?> <code><?php echo esc_html( $slug ); ?></code></td><td><?php echo (int) $n; ?></td></tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p><strong><?php esc_html_e( 'Celkem:', 'jipech' ); ?></strong> <?php echo (int) $total; ?></p>
			<p><button class="button button-primary button-hero" id="jf-start"><?php esc_html_e( 'Spustit import fotek', 'jipech' ); ?></button></p>
			<div id="jf-progress" style="max-width:640px;display:none;">
				<div style="background:#e2e2e2;border-radius:6px;height:22px;overflow:hidden;"><div id="jf-bar" style="background:#c8873a;height:100%;width:0;transition:width .2s;"></div></div>
				<p id="jf-status" style="margin-top:8px;"></p>
			</div>
			<script>
			(function(){
				var btn=document.getElementById('jf-start'),bar=document.getElementById('jf-bar'),wrap=document.getElementById('jf-progress'),st=document.getElementById('jf-status');
				var url=<?php echo wp_json_encode( admin_url( 'admin-ajax.php' ) ); ?>,nonce=<?php echo wp_json_encode( wp_create_nonce( 'jipech_fotky' ) ); ?>;
				function step(reset){
					var b=new URLSearchParams();b.set('action','jipech_fotky_step');b.set('nonce',nonce);if(reset)b.set('reset','1');
					fetch(url,{method:'POST',credentials:'same-origin',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:b.toString()})
					.then(function(r){return r.json();}).then(function(res){
						if(!res.success){st.textContent='Chyba: '+(res.data&&res.data.message||'?');btn.disabled=false;return;}
						var d=res.data,pct=d.total?Math.round(d.processed/d.total*100):100;
						bar.style.width=pct+'%';
						st.textContent='Zpracováno '+d.processed+' / '+d.total+(d.lastError?' — přeskočeno: '+d.lastError:'');
						if(d.finished){st.textContent='Hotovo! Naimportováno '+d.processed+' fotek. Zkontrolujte úvodní stránku.';btn.disabled=false;}
						else step(false);
					}).catch(function(e){st.textContent='Chyba spojení: '+e;btn.disabled=false;});
				}
				btn.addEventListener('click',function(){btn.disabled=true;wrap.style.display='block';st.textContent='Připravuji...';step(true);});
			})();
			</script>
		<?php endif; ?>
	</div>
	<?php
}

add_action( 'wp_ajax_jipech_fotky_step', 'jipech_fotky_step' );
function jipech_fotky_step() {
	if ( ! current_user_can( 'manage_options' ) || ! check_ajax_referer( 'jipech_fotky', 'nonce', false ) ) {
		wp_send_json_error( array( 'message' => 'Nedostatečná oprávnění.' ) );
	}
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	if ( ! empty( $_POST['reset'] ) ) {
		jipech_fotky_build_queue();
	}

	$queue = get_option( 'jipech_fotky_queue', array() );
	$total = (int) get_option( 'jipech_fotky_total', 0 );

	$batch      = 3;
	$done_now   = 0;
	$last_error = '';

	while ( $done_now < $batch && ! empty( $queue ) ) {
		$task = array_shift( $queue );
		$done_now++;
		$id = jipech_sideload_local( $task['file'] );
		if ( ! $id ) {
			$last_error = basename( $task['file'] );
			continue;
		}
		$pid = (int) $task['post'];
		$cur = get_post_meta( $pid, '_jipech_gallery', true );
		$cur = $cur ? array_filter( array_map( 'absint', explode( ',', $cur ) ) ) : array();
		if ( ! in_array( $id, $cur, true ) ) {
			$cur[] = $id;
			update_post_meta( $pid, '_jipech_gallery', implode( ',', $cur ) );
		}
		if ( ! empty( $task['first'] ) && ! has_post_thumbnail( $pid ) ) {
			set_post_thumbnail( $pid, $id );
		}
	}

	update_option( 'jipech_fotky_queue', $queue, false );
	$remaining = count( $queue );

	wp_send_json_success( array(
		'total'     => $total,
		'processed' => $total - $remaining,
		'finished'  => 0 === $remaining,
		'lastError' => $last_error,
	) );
}

function jipech_sideload_local( $path ) {
	if ( ! file_exists( $path ) ) {
		return 0;
	}
	$tmp = wp_tempnam( basename( $path ) );
	if ( ! $tmp ) {
		return 0;
	}
	if ( ! @copy( $path, $tmp ) ) { // phpcs:ignore
		@unlink( $tmp ); // phpcs:ignore
		return 0;
	}
	$file_array = array(
		'name'     => basename( $path ),
		'tmp_name' => $tmp,
	);
	$id = media_handle_sideload( $file_array, 0 );
	if ( is_wp_error( $id ) ) {
		@unlink( $tmp ); // phpcs:ignore
		return 0;
	}
	return (int) $id;
}

function jipech_fotky_build_queue() {
	if ( ! taxonomy_exists( 'jipech_kategorie' ) ) {
		jipech_register_realizace();
	}
	$base  = jipech_fotky_base_dir();
	$cats  = jipech_gallery_categories();
	$queue = array();
	$order = 0;

	if ( is_dir( $base ) ) {
		// Nejdřív v definovaném pořadí kategorií.
		foreach ( array_keys( $cats ) as $slug ) {
			$files = jipech_fotky_list( $base . '/' . $slug );
			if ( ! $files ) {
				continue;
			}
			$pid = jipech_fotky_get_post( $slug, $cats[ $slug ], $order );
			$order++;
			if ( ! $pid ) {
				continue;
			}
			update_post_meta( $pid, '_jipech_gallery', '' );
			delete_post_thumbnail( $pid );
			$i = 0;
			foreach ( $files as $f ) {
				$queue[] = array( 'post' => $pid, 'file' => $f, 'first' => ( 0 === $i ) );
				$i++;
			}
		}
		// Pak případné složky mimo definované kategorie.
		foreach ( glob( $base . '/*', GLOB_ONLYDIR ) as $dir ) {
			$slug = basename( $dir );
			if ( isset( $cats[ $slug ] ) ) {
				continue;
			}
			$files = jipech_fotky_list( $dir );
			if ( ! $files ) {
				continue;
			}
			$label = ucfirst( str_replace( '_', ' ', $slug ) );
			$pid   = jipech_fotky_get_post( $slug, $label, $order );
			$order++;
			if ( ! $pid ) {
				continue;
			}
			update_post_meta( $pid, '_jipech_gallery', '' );
			delete_post_thumbnail( $pid );
			$i = 0;
			foreach ( $files as $f ) {
				$queue[] = array( 'post' => $pid, 'file' => $f, 'first' => ( 0 === $i ) );
				$i++;
			}
		}
	}

	update_option( 'jipech_fotky_queue', $queue, false );
	update_option( 'jipech_fotky_total', count( $queue ), false );
}

function jipech_fotky_get_post( $slug, $label, $order ) {
	$term = term_exists( $slug, 'jipech_kategorie' );
	if ( ! $term ) {
		$t = wp_insert_term( $label, 'jipech_kategorie', array( 'slug' => $slug ) );
		if ( ! is_wp_error( $t ) ) {
			update_term_meta( (int) $t['term_id'], 'jipech_order', $order );
		}
	} else {
		update_term_meta( (int) $term['term_id'], 'jipech_order', $order );
	}

	$key      = 'fotky-' . $slug;
	$existing = get_posts( array(
		'post_type'   => 'jipech_realizace',
		'post_status' => 'any',
		'numberposts' => 1,
		'fields'      => 'ids',
		'meta_key'    => '_jipech_import_key',
		'meta_value'  => $key,
	) );

	if ( $existing ) {
		$pid = (int) $existing[0];
	} else {
		$pid = wp_insert_post( array(
			'post_type'   => 'jipech_realizace',
			'post_status' => 'publish',
			'post_title'  => $label,
			'menu_order'  => $order,
		) );
		if ( is_wp_error( $pid ) || ! $pid ) {
			return 0;
		}
		update_post_meta( $pid, '_jipech_import_key', $key );
	}

	update_post_meta( $pid, '_jipech_home', '1' );
	wp_set_object_terms( $pid, $slug, 'jipech_kategorie', false );
	return $pid;
}
