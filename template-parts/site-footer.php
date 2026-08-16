<?php
/**
 * Patička (sdílená úvodní stranou i archivy kategorií).
 *
 * @package jipech
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$phone      = jipech_contact( 'phone' );
$phone_href = 'tel:' . jipech_contact( 'phone_href' );
$email      = jipech_contact( 'email' );
$logo       = jipech_asset( 'logo' );
$home       = home_url( '/' );
$b2b_url    = jipech_b2b_url();
?>
<footer style="background-color: oklch(0.18 0.03 40);" class="py-10">
	<div class="container">
		<div class="grid sm:grid-cols-3 gap-8 mb-8">
			<div>
				<img src="<?php echo esc_url( jipech_asset( 'logo_light' ) ); ?>" alt="JIPECH" class="h-16 w-auto mb-4" />
				<p class="text-sm leading-relaxed" style="color: oklch(0.65 0.02 60);">Truhlářství Jiří Pecháček – poctivá řemeslná výroba nábytku na míru od roku 1997.</p>
			</div>
			<div>
				<h4 class="text-sm font-bold uppercase tracking-wider mb-4" style="font-family: 'Montserrat', sans-serif; color: oklch(0.62 0.12 55);">Navigace</h4>
				<ul class="space-y-2">
					<li><a href="<?php echo esc_url( $home . '#sluzby' ); ?>" class="text-sm hover:underline" style="color: oklch(0.72 0.02 70);">Služby</a></li>
					<li><a href="<?php echo esc_url( $home . '#reference' ); ?>" class="text-sm hover:underline" style="color: oklch(0.72 0.02 70);">Reference</a></li>
					<li><a href="<?php echo esc_url( $home . '#o-nas' ); ?>" class="text-sm hover:underline" style="color: oklch(0.72 0.02 70);">O nás</a></li>
					<li><a href="<?php echo esc_url( $home . '#galerie' ); ?>" class="text-sm hover:underline" style="color: oklch(0.72 0.02 70);">Realizace</a></li>
					<li><a href="<?php echo esc_url( $home . '#kontakt' ); ?>" class="text-sm hover:underline" style="color: oklch(0.72 0.02 70);">Kontakt</a></li>
					<li><a href="<?php echo esc_url( $b2b_url ); ?>" class="text-sm hover:underline flex items-center gap-1.5" style="color: oklch(0.72 0.02 70);"><?php jipech_icon( 'building2', 13 ); ?> Pro firmy (B2B)</a></li>
				</ul>
			</div>
			<div>
				<h4 class="text-sm font-bold uppercase tracking-wider mb-4" style="font-family: 'Montserrat', sans-serif; color: oklch(0.62 0.12 55);">Kontakt</h4>
				<div class="space-y-3">
					<div class="flex items-center gap-2"><?php jipech_icon( 'phone', 14, '', 'color: oklch(0.62 0.12 55);' ); ?><a href="<?php echo esc_attr( $phone_href ); ?>" class="text-sm font-bold hover:underline" style="color: white;"><?php echo esc_html( $phone ); ?></a></div>
					<div class="flex items-center gap-2"><?php jipech_icon( 'mail', 14, '', 'color: oklch(0.62 0.12 55);' ); ?><a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-sm hover:underline" style="color: oklch(0.72 0.02 70);"><?php echo esc_html( $email ); ?></a></div>
					<div class="flex items-start gap-2"><?php jipech_icon( 'map-pin', 14, 'mt-0.5 shrink-0', 'color: oklch(0.62 0.12 55);' ); ?><span class="text-sm" style="color: oklch(0.72 0.02 70);"><?php echo esc_html( jipech_contact( 'address_line1' ) ); ?><br /><?php echo esc_html( jipech_contact( 'address_line2' ) ); ?></span></div>
				</div>
			</div>
		</div>
		<div class="border-t pt-6 text-center" style="border-color: oklch(0.28 0.03 40);">
			<p class="text-xs" style="color: oklch(0.50 0.02 50);">© <?php echo esc_html( gmdate( 'Y' ) ); ?> JIPECH – Truhlářství Jiří Pecháček. Všechna práva vyhrazena.</p>
		</div>
	</div>
</footer>
<?php
