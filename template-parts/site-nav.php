<?php
/**
 * Hlavní navigace (sdílená úvodní stranou i archivy kategorií).
 *
 * @package jipech
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$phone      = jipech_contact( 'phone' );
$phone_href = 'tel:' . jipech_contact( 'phone_href' );
$logo       = jipech_asset( 'logo' );
$home       = home_url( '/' );
$b2b_url    = jipech_b2b_url();
$cats       = jipech_ordered_terms( true );
?>
<nav class="fixed top-0 left-0 right-0 z-40 transition-all duration-300" style="background-color: oklch(0.99 0.005 80); box-shadow: 0 2px 20px oklch(0.25 0.04 40 / 0.10);">
	<div class="container flex items-center justify-between py-3">
		<a href="<?php echo esc_url( $home ); ?>" class="flex items-center gap-3">
			<img src="<?php echo esc_url( $logo ); ?>" alt="JIPECH Truhlářství" class="h-14 w-auto" />
		</a>
		<div class="hidden md:flex items-center gap-7">
			<a href="<?php echo esc_url( $home . '#sluzby' ); ?>" class="text-sm font-semibold tracking-widest uppercase transition-colors hover:opacity-60" style="font-family: 'Montserrat', sans-serif; color: oklch(0.22 0.03 40);">Služby</a>
			<a href="<?php echo esc_url( $home . '#reference' ); ?>" class="text-sm font-semibold tracking-widest uppercase transition-colors hover:opacity-60" style="font-family: 'Montserrat', sans-serif; color: oklch(0.22 0.03 40);">Reference</a>
			<a href="<?php echo esc_url( $home . '#o-nas' ); ?>" class="text-sm font-semibold tracking-widest uppercase transition-colors hover:opacity-60" style="font-family: 'Montserrat', sans-serif; color: oklch(0.22 0.03 40);">O nás</a>
			<a href="<?php echo esc_url( $home . '#kontakt' ); ?>" class="text-sm font-semibold tracking-widest uppercase transition-colors hover:opacity-60" style="font-family: 'Montserrat', sans-serif; color: oklch(0.22 0.03 40);">Kontakt</a>
			<?php if ( $cats ) : ?>
			<div class="relative" data-dropdown>
				<a href="<?php echo esc_url( $home . '#galerie' ); ?>" class="text-sm font-semibold tracking-widest uppercase transition-colors hover:opacity-60 flex items-center gap-1" style="font-family: 'Montserrat', sans-serif; color: oklch(0.22 0.03 40);">
					Realizace
					<svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor"><path d="M6 8L1 3h10z"></path></svg>
				</a>
				<div class="absolute top-full left-0 mt-1 bg-white rounded-lg shadow-xl border border-amber-100 py-2 min-w-[220px] z-50" data-dropdown-menu hidden>
					<a href="<?php echo esc_url( $home . '#galerie' ); ?>" class="block w-full text-left px-4 py-2 text-sm font-medium hover:bg-amber-50 transition-colors" style="font-family: 'Montserrat', sans-serif; color: oklch(0.35 0.04 45);">Všechny realizace</a>
					<?php foreach ( $cats as $term ) : ?>
						<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="block w-full text-left px-4 py-2 text-sm font-medium hover:bg-amber-50 transition-colors" style="font-family: 'Montserrat', sans-serif; color: oklch(0.50 0.10 50);"><?php echo esc_html( $term->name ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>
			<a href="<?php echo esc_url( $b2b_url ); ?>" class="flex items-center gap-1.5 text-sm font-semibold tracking-widest uppercase transition-colors hover:opacity-60" style="font-family: 'Montserrat', sans-serif; color: oklch(0.32 0.09 145);">
				<?php jipech_icon( 'building2', 14 ); ?>
				Pro firmy
			</a>
			<a href="<?php echo esc_attr( $phone_href ); ?>" class="flex items-center gap-2 px-5 py-2.5 rounded text-sm font-bold transition-all hover:scale-105" style="background-color: oklch(0.62 0.12 55); color: white; font-family: 'Montserrat', sans-serif;">
				<?php jipech_icon( 'phone', 15 ); ?>
				Zavolejte nám
			</a>
		</div>
		<button class="md:hidden p-2" data-mobile-toggle aria-label="Menu">
			<span data-icon-menu><?php jipech_icon( 'menu', 24 ); ?></span>
			<span data-icon-close hidden><?php jipech_icon( 'x', 24 ); ?></span>
		</button>
	</div>
	<div class="md:hidden border-t" data-mobile-menu hidden style="background-color: oklch(0.99 0.005 80); border-color: oklch(0.87 0.03 65);">
		<div class="container py-4 flex flex-col gap-3">
			<a href="<?php echo esc_url( $home . '#sluzby' ); ?>" class="text-left text-sm font-semibold tracking-widest uppercase py-2" style="font-family: 'Montserrat', sans-serif;">Služby</a>
			<a href="<?php echo esc_url( $home . '#reference' ); ?>" class="text-left text-sm font-semibold tracking-widest uppercase py-2" style="font-family: 'Montserrat', sans-serif;">Reference</a>
			<a href="<?php echo esc_url( $home . '#o-nas' ); ?>" class="text-left text-sm font-semibold tracking-widest uppercase py-2" style="font-family: 'Montserrat', sans-serif;">O nás</a>
			<a href="<?php echo esc_url( $home . '#kontakt' ); ?>" class="text-left text-sm font-semibold tracking-widest uppercase py-2" style="font-family: 'Montserrat', sans-serif;">Kontakt</a>
			<?php if ( $cats ) : ?>
				<p class="text-xs font-bold uppercase tracking-widest pt-2" style="font-family: 'Montserrat', sans-serif; color: oklch(0.62 0.12 55);">Realizace</p>
				<?php foreach ( $cats as $term ) : ?>
					<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="text-left text-sm font-semibold py-1.5 pl-3" style="font-family: 'Montserrat', sans-serif; color: oklch(0.50 0.10 50);"><?php echo esc_html( $term->name ); ?></a>
				<?php endforeach; ?>
			<?php endif; ?>
			<a href="<?php echo esc_url( $b2b_url ); ?>" class="text-left text-sm font-semibold tracking-widest uppercase py-2 flex items-center gap-2" style="font-family: 'Montserrat', sans-serif; color: oklch(0.32 0.09 145);">
				<?php jipech_icon( 'building2', 14 ); ?> Pro firmy
			</a>
			<a href="<?php echo esc_attr( $phone_href ); ?>" class="flex items-center justify-center gap-2 px-5 py-3 rounded font-bold text-white" style="background-color: oklch(0.32 0.09 145); font-family: 'Montserrat', sans-serif;">
				<?php jipech_icon( 'phone', 18 ); ?>
				<?php echo esc_html( $phone ); ?>
			</a>
		</div>
	</div>
</nav>
<?php
