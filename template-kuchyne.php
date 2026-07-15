<?php
/**
 * Template Name: Kuchyně (galerie realizací)
 *
 * @package jipech
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$phone      = jipech_contact( 'phone' );
$phone_href = 'tel:' . jipech_contact( 'phone_href' );
$home_url   = home_url( '/' );

$realizace   = jipech_get_kuchyne_realizace();
$count_real  = count( $realizace );
$count_photo = 0;
foreach ( $realizace as $r ) { $count_photo += count( $r['photos'] ); }

get_header();
?>
<div style="background-color: oklch(0.97 0.01 80);">

	<!-- Navigace -->
	<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" style="background-color: oklch(0.99 0.005 80); box-shadow: 0 1px 4px oklch(0.5 0.04 45 / 0.06); border-bottom: 1px solid oklch(0.87 0.03 65);">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center justify-between h-16">
				<a href="<?php echo esc_url( $home_url ); ?>" class="flex items-center gap-2 text-sm font-semibold hover:opacity-70 transition-opacity" style="font-family: 'Montserrat', sans-serif; color: oklch(0.50 0.10 50);">
					<?php jipech_icon( 'arrow-left', 16 ); ?>
					Zpět na hlavní stránku
				</a>
				<span class="text-lg font-bold" style="font-family: 'Playfair Display', serif; color: oklch(0.22 0.03 40);">Kuchyně na míru</span>
				<a href="<?php echo esc_attr( $phone_href ); ?>" class="hidden sm:flex items-center gap-2 px-4 py-2 rounded font-bold text-white text-sm" style="background-color: oklch(0.32 0.09 145); font-family: 'Montserrat', sans-serif;">
					<?php jipech_icon( 'phone', 14 ); ?>
					<?php echo esc_html( $phone ); ?>
				</a>
			</div>
		</div>
	</nav>

	<!-- Hero -->
	<div class="pt-16" style="background: linear-gradient(135deg, oklch(0.92 0.04 60) 0%, oklch(0.97 0.01 80) 100%);">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
			<p class="text-xs font-bold tracking-widest uppercase mb-3" style="color: oklch(0.62 0.12 55); font-family: 'Montserrat', sans-serif;">Galerie realizací</p>
			<h1 class="text-4xl md:text-5xl font-bold mb-3" style="font-family: 'Playfair Display', serif; color: oklch(0.22 0.03 40);">Kuchyně <em style="color: oklch(0.62 0.12 55);">na míru</em></h1>
			<p class="text-lg max-w-2xl mb-4" style="color: oklch(0.40 0.03 45); font-family: 'Source Sans 3', sans-serif;">Každá kuchyně je jedinečná realizace přizpůsobená přesně vašemu prostoru a stylu.</p>
			<div class="flex items-center gap-6 text-sm" style="color: oklch(0.50 0.04 45);">
				<span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full inline-block" style="background-color: oklch(0.62 0.12 55);"></span><span data-count-realizace><?php echo (int) $count_real; ?></span>&nbsp;realizací</span>
				<span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full inline-block" style="background-color: oklch(0.62 0.12 55);"></span><span data-count-photos><?php echo (int) $count_photo; ?></span>&nbsp;fotografií</span>
			</div>
		</div>
	</div>

	<!-- Filtr -->
	<div class="sticky top-16 z-40 shadow-sm" style="background-color: oklch(0.99 0.005 80); border-bottom: 1px solid oklch(0.90 0.02 65);">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex items-center gap-2 py-3 overflow-x-auto" style="scrollbar-width: none;" data-kuchyne-filter></div>
		</div>
	</div>

	<!-- Galerie -->
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
		<div class="mb-6" data-kuchyne-heading hidden>
			<h2 class="text-2xl font-bold" style="font-family: 'Playfair Display', serif; color: oklch(0.22 0.03 40);" data-kuchyne-heading-title></h2>
			<p class="text-sm mt-1" style="color: oklch(0.50 0.04 45);" data-kuchyne-heading-sub></p>
		</div>
		<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3" data-kuchyne-grid>
			<?php if ( ! $count_real ) : ?>
				<p class="col-span-full text-center py-10" style="color: oklch(0.50 0.04 45);">Zatím zde nejsou žádné realizace. Přidejte je v administraci (Realizace &rarr; Přidat realizaci) nebo spusťte import obsahu.</p>
			<?php endif; ?>
		</div>
	</div>

	<!-- CTA -->
	<section class="py-16 text-center" style="background-color: oklch(0.92 0.04 60);">
		<div class="container max-w-2xl">
			<h2 class="text-3xl font-bold mb-4" style="font-family: 'Playfair Display', serif; color: oklch(0.22 0.03 40);">Líbí se vám naše kuchyně?</h2>
			<p class="text-base mb-8" style="color: oklch(0.35 0.04 45); font-family: 'Source Sans 3', sans-serif;">Zavolejte nám nebo pošlete poptávku. Rádi vám navrhneme kuchyni přesně podle vašich představ.</p>
			<div class="flex flex-col sm:flex-row gap-4 justify-center">
				<a href="<?php echo esc_attr( $phone_href ); ?>" class="flex items-center justify-center gap-2 px-8 py-4 rounded font-bold text-white" style="background-color: oklch(0.32 0.09 145); font-family: 'Montserrat', sans-serif;"><?php jipech_icon( 'phone', 20 ); ?><?php echo esc_html( $phone ); ?></a>
				<a href="<?php echo esc_url( $home_url ); ?>#kontakt" class="flex items-center justify-center gap-2 px-8 py-4 rounded font-semibold border-2 transition-all hover:scale-105" style="border-color: oklch(0.62 0.12 55); color: oklch(0.50 0.10 50); font-family: 'Montserrat', sans-serif;">Nezávazná poptávka</a>
			</div>
		</div>
	</section>
</div>
<?php
get_footer();
