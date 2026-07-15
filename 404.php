<?php
/**
 * 404 – stránka nenalezena.
 *
 * @package jipech
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$phone      = jipech_contact( 'phone' );
$phone_href = 'tel:' . jipech_contact( 'phone_href' );
$logo       = jipech_asset( 'logo' );

get_header();
?>
<div style="background-color: oklch(0.97 0.01 80); color: oklch(0.22 0.03 40);">
	<nav class="sticky top-0 z-40" style="background-color: oklch(0.99 0.005 80); box-shadow: 0 2px 20px oklch(0.25 0.04 40 / 0.10);">
		<div class="container flex items-center justify-between py-3">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3"><img src="<?php echo esc_url( $logo ); ?>" alt="JIPECH" class="h-14 w-auto" /></a>
			<a href="<?php echo esc_attr( $phone_href ); ?>" class="hidden sm:flex items-center gap-2 px-5 py-2.5 rounded text-sm font-bold" style="background-color: oklch(0.62 0.12 55); color: white; font-family: 'Montserrat', sans-serif;"><?php jipech_icon( 'phone', 15 ); ?> <?php echo esc_html( $phone ); ?></a>
		</div>
	</nav>

	<main class="container text-center" style="padding-top: 8rem; padding-bottom: 8rem;">
		<p class="section-label mb-3">Chyba 404</p>
		<h1 class="text-5xl md:text-6xl font-bold mb-4" style="font-family: 'Playfair Display', serif;">Stránka nenalezena</h1>
		<p class="text-lg mb-8" style="color: oklch(0.40 0.03 45);">Omlouváme se, tuto stránku se nepodařilo najít.</p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-2 px-8 py-4 rounded font-bold text-white" style="background-color: oklch(0.62 0.12 55); font-family: 'Montserrat', sans-serif;"><?php jipech_icon( 'arrow-left', 18 ); ?> Zpět na hlavní stránku</a>
	</main>
</div>
<?php
get_footer();
