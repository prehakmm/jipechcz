<?php
/**
 * Zpracování poptávkových formulářů (hlavní + B2B).
 * Odesílá e-mailem přes wp_mail (doručení řeší SMTP plugin).
 *
 * @package jipech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Popisky voleb pro e-mail.
 */
function jipech_form_labels() {
	return array(
		'delivery' => array(
			'3-6-mesicu'  => '3–6 měsíců',
			'6-12-mesicu' => '6–12 měsíců',
			'vice-nez-rok' => 'Více než rok',
			'zatim-neznam' => 'Zatím nevím',
		),
		'project' => array(
			'kancelare'  => 'Kancelářské prostory',
			'obchod'     => 'Obchodní prostory / prodejna',
			'hotel'      => 'Hotel / penzion',
			'restaurace' => 'Restaurace / kavárna / bar',
			'developer'  => 'Developerský projekt',
			'jine'       => 'Jiné',
		),
	);
}

/**
 * Zpracuje odeslání – vrací array( 'success'=>bool, 'message'=>string ).
 */
function jipech_process_submission() {
	// Nonce.
	$nonce = isset( $_POST['jipech_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['jipech_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'jipech_form' ) ) {
		return array( 'success' => false, 'message' => 'Vypršela platnost formuláře. Načtěte stránku znovu a zkuste to prosím ještě jednou.' );
	}

	// Honeypot (skryté pole „website" musí být prázdné).
	if ( ! empty( $_POST['website'] ) ) {
		return array( 'success' => true, 'message' => 'Děkujeme.' ); // tichý úspěch pro boty
	}

	$type   = ( isset( $_POST['jipech_form_type'] ) && 'b2b' === $_POST['jipech_form_type'] ) ? 'b2b' : 'main';
	$labels = jipech_form_labels();

	$f = function( $key ) {
		return isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
	};

	$name        = $f( 'name' );
	$company     = $f( 'company' );
	$contactName = $f( 'contactName' );
	$phone       = $f( 'phone' );
	$email       = sanitize_email( $f( 'email' ) );
	$ico         = $f( 'ico' );
	$projectType = $f( 'projectType' );
	$units       = $f( 'units' );
	$delivery    = $f( 'deliveryTerm' );
	$locality    = $f( 'locality' );
	$budget      = isset( $_POST['budget'] ) ? absint( $_POST['budget'] ) : 0;
	$message     = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	// Validace dle typu.
	$errors = array();
	if ( 'b2b' === $type ) {
		if ( '' === $company )     { $errors[] = 'Prosím vyplňte název firmy.'; }
		if ( '' === $contactName ) { $errors[] = 'Prosím vyplňte kontaktní osobu.'; }
		if ( '' === $phone )       { $errors[] = 'Prosím vyplňte telefon.'; }
		if ( '' === $projectType ) { $errors[] = 'Prosím vyberte typ projektu.'; }
		if ( '' === $delivery )    { $errors[] = 'Prosím vyberte očekávaný termín.'; }
		if ( '' === $locality )    { $errors[] = 'Prosím vyplňte lokalitu realizace.'; }
	} else {
		if ( '' === $delivery )    { $errors[] = 'Prosím vyberte očekávaný termín dodání.'; }
		if ( '' === $locality )    { $errors[] = 'Prosím vyplňte lokalitu realizace.'; }
		if ( '' === $name || '' === $phone ) { $errors[] = 'Prosím vyplňte jméno a telefon.'; }
	}
	if ( $errors ) {
		return array( 'success' => false, 'message' => implode( ' ', $errors ) );
	}

	// Sestavení e-mailu.
	$delivery_label = isset( $labels['delivery'][ $delivery ] ) ? $labels['delivery'][ $delivery ] : $delivery;
	$project_label  = isset( $labels['project'][ $projectType ] ) ? $labels['project'][ $projectType ] : $projectType;
	$budget_txt     = $budget ? number_format( $budget, 0, ',', ' ' ) . ' Kč' : '—';

	$lines = array();
	if ( 'b2b' === $type ) {
		$subject = 'Firemní B2B poptávka z webu – ' . ( $company ? $company : $contactName );
		$lines[] = 'FIREMNÍ B2B POPTÁVKA';
		$lines[] = '';
		$lines[] = 'Název firmy: ' . $company;
		$lines[] = 'IČO: ' . ( $ico ? $ico : '—' );
		$lines[] = 'Kontaktní osoba: ' . $contactName;
		$lines[] = 'Telefon: ' . $phone;
		$lines[] = 'E-mail: ' . ( $email ? $email : '—' );
		$lines[] = 'Typ projektu: ' . $project_label;
		$lines[] = 'Počet kusů / jednotek: ' . ( $units ? $units : '—' );
		$lines[] = 'Očekávaný termín: ' . $delivery_label;
		$lines[] = 'Lokalita realizace: ' . $locality;
		$lines[] = 'Předpokládaný rozpočet: ' . $budget_txt;
		$lines[] = '';
		$lines[] = 'Popis projektu:';
		$lines[] = $message ? $message : '—';
	} else {
		$subject = 'Poptávka z webu – ' . ( $name ? $name : $phone );
		$lines[] = 'POPTÁVKA Z WEBU';
		$lines[] = '';
		$lines[] = 'Jméno: ' . $name;
		$lines[] = 'Telefon: ' . $phone;
		$lines[] = 'E-mail: ' . ( $email ? $email : '—' );
		$lines[] = 'Očekávaný termín dodání: ' . $delivery_label;
		$lines[] = 'Lokalita realizace: ' . $locality;
		$lines[] = 'Představa o ceně: ' . $budget_txt;
		$lines[] = '';
		$lines[] = 'Zpráva:';
		$lines[] = $message ? $message : '—';
	}
	$lines[] = '';
	$lines[] = '— Odesláno z webu ' . home_url();
	$body = implode( "\n", $lines );

	// Přílohy.
	$attachments = jipech_handle_uploads();

	// Odeslání.
	$recipient = jipech_contact( 'form_recipient' );
	if ( ! is_email( $recipient ) ) {
		$recipient = get_option( 'admin_email' );
	}
	$headers = array();
	if ( $email && is_email( $email ) ) {
		$headers[] = 'Reply-To: ' . ( $name ? $name : $contactName ) . ' <' . $email . '>';
	}

	$sent = wp_mail( $recipient, $subject, $body, $headers, $attachments['paths'] );

	// Úklid dočasných příloh.
	foreach ( $attachments['cleanup'] as $path ) {
		@unlink( $path ); // phpcs:ignore
	}

	if ( ! $sent ) {
		return array( 'success' => false, 'message' => 'Odeslání se nezdařilo. Zavolejte nám prosím na ' . jipech_contact( 'phone' ) . '.' );
	}

	return array( 'success' => true, 'message' => 'Poptávka odeslána!' );
}

/**
 * Uloží nahrané soubory do dočasného adresáře pro přílohu e-mailu.
 *
 * @return array( 'paths'=>[..], 'cleanup'=>[..] )
 */
function jipech_handle_uploads() {
	$paths   = array();
	$cleanup = array();

	if ( empty( $_FILES['files'] ) || ! is_array( $_FILES['files']['name'] ) ) {
		return array( 'paths' => $paths, 'cleanup' => $cleanup );
	}

	$allowed = array( 'jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'dwg', 'dxf' );
	$upload  = wp_upload_dir();
	$tmp_dir = trailingslashit( $upload['basedir'] ) . 'jipech-tmp';
	if ( ! file_exists( $tmp_dir ) ) {
		wp_mkdir_p( $tmp_dir );
	}

	$count = count( $_FILES['files']['name'] );
	$added = 0;
	for ( $i = 0; $i < $count && $added < 5; $i++ ) {
		if ( UPLOAD_ERR_OK !== $_FILES['files']['error'][ $i ] ) {
			continue;
		}
		$size = (int) $_FILES['files']['size'][ $i ];
		if ( $size <= 0 || $size > 10 * 1024 * 1024 ) {
			continue;
		}
		$orig = sanitize_file_name( $_FILES['files']['name'][ $i ] );
		$ext  = strtolower( pathinfo( $orig, PATHINFO_EXTENSION ) );
		if ( ! in_array( $ext, $allowed, true ) ) {
			continue;
		}
		$tmp  = $_FILES['files']['tmp_name'][ $i ];
		if ( ! is_uploaded_file( $tmp ) ) {
			continue;
		}
		$dest = trailingslashit( $tmp_dir ) . wp_unique_filename( $tmp_dir, $orig );
		if ( move_uploaded_file( $tmp, $dest ) ) {
			$paths[]   = $dest;
			$cleanup[] = $dest;
			$added++;
		}
	}

	return array( 'paths' => $paths, 'cleanup' => $cleanup );
}

/* ---- AJAX ---- */
add_action( 'wp_ajax_jipech_submit', 'jipech_ajax_submit' );
add_action( 'wp_ajax_nopriv_jipech_submit', 'jipech_ajax_submit' );
function jipech_ajax_submit() {
	$result = jipech_process_submission();
	if ( $result['success'] ) {
		wp_send_json_success( array( 'message' => $result['message'] ) );
	}
	wp_send_json_error( array( 'message' => $result['message'] ) );
}

/* ---- Non-JS fallback (admin-post) ---- */
add_action( 'admin_post_jipech_submit', 'jipech_post_submit' );
add_action( 'admin_post_nopriv_jipech_submit', 'jipech_post_submit' );
function jipech_post_submit() {
	$result   = jipech_process_submission();
	$referer  = wp_get_referer();
	$referer  = $referer ? $referer : home_url( '/' );
	$referer  = remove_query_arg( array( 'jipech_sent', 'jipech_error' ), $referer );
	if ( $result['success'] ) {
		$referer = add_query_arg( 'jipech_sent', '1', $referer );
	} else {
		$referer = add_query_arg( 'jipech_error', rawurlencode( $result['message'] ), $referer );
	}
	$is_b2b = ( isset( $_POST['jipech_form_type'] ) && 'b2b' === $_POST['jipech_form_type'] );
	$anchor = $is_b2b ? '#b2b-form' : '#kontakt';
	wp_safe_redirect( $referer . $anchor );
	exit;
}
