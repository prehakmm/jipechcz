<?php
/**
 * Archiv kategorie realizací – /realizace/<kategorie>/.
 * Zobrazí všechny fotky dané kategorie s lightboxem.
 *
 * @package jipech
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$term       = get_queried_object();
$photos     = ( $term && isset( $term->slug ) ) ? jipech_term_images( $term->slug ) : array();
$phone      = jipech_contact( 'phone' );
$phone_href = 'tel:' . jipech_contact( 'phone_href' );

get_header();
?>
<div style="background-color: oklch(0.97 0.01 80); color: oklch(0.22 0.03 40);">

	<?php get_template_part( 'template-parts/site-nav' ); ?>

	<!-- Hero -->
	<section style="padding-top: 7rem; background: linear-gradient(135deg, oklch(0.92 0.04 60) 0%, oklch(0.97 0.01 80) 100%);" class="pb-12">
		<div class="container">
			<p class="section-label mb-3">Realizace</p>
			<h1 class="text-4xl md:text-5xl font-bold mb-3" style="font-family: 'Playfair Display', serif; color: oklch(0.22 0.03 40);"><?php echo esc_html( $term ? $term->name : 'Realizace' ); ?></h1>
			<?php if ( $term && $term->description ) : ?>
				<p class="text-lg max-w-2xl mb-4" style="color: oklch(0.40 0.03 45); font-family: 'Source Sans 3', sans-serif;"><?php echo esc_html( $term->description ); ?></p>
			<?php endif; ?>
			<div class="flex items-center gap-6 text-sm" style="color: oklch(0.50 0.04 45);">
				<span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full inline-block" style="background-color: oklch(0.62 0.12 55);"></span><?php echo (int) count( $photos ); ?>&nbsp;fotografií</span>
			</div>
		</div>
	</section>

	<!-- Galerie -->
	<div class="container py-10">
		<?php if ( $photos ) : ?>
			<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3" data-lightbox-grid>
				<?php foreach ( $photos as $i => $src ) : ?>
					<div class="group relative overflow-hidden rounded-lg cursor-pointer" style="aspect-ratio: 4/3; background-color: oklch(0.93 0.02 70);" data-full="<?php echo esc_url( $src ); ?>">
						<img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( ( $term ? $term->name : '' ) . ' – foto ' . ( $i + 1 ) ); ?>" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy" />
						<div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-2" style="background: linear-gradient(to top, oklch(0.15 0.04 40 / 0.7) 0%, transparent 60%);">
							<span class="text-xs font-bold text-white" style="font-family: 'Montserrat', sans-serif;">Zobrazit</span>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="text-center py-10" style="color: oklch(0.50 0.04 45);">V této kategorii zatím nejsou žádné fotografie.</p>
		<?php endif; ?>
	</div>

	<!-- CTA -->
	<section class="py-16 text-center" style="background-color: oklch(0.92 0.04 60);">
		<div class="container max-w-2xl">
			<h2 class="text-3xl font-bold mb-4" style="font-family: 'Playfair Display', serif; color: oklch(0.22 0.03 40);">Líbí se vám naše práce?</h2>
			<p class="text-base mb-8" style="color: oklch(0.35 0.04 45); font-family: 'Source Sans 3', sans-serif;">Zavolejte nám nebo pošlete nezávaznou poptávku. Rádi vám navrhneme nábytek přesně podle vašich představ.</p>
			<div class="flex flex-col sm:flex-row gap-4 justify-center">
				<a href="<?php echo esc_attr( $phone_href ); ?>" class="flex items-center justify-center gap-2 px-8 py-4 rounded font-bold text-white" style="background-color: oklch(0.32 0.09 145); font-family: 'Montserrat', sans-serif;"><?php jipech_icon( 'phone', 20 ); ?><?php echo esc_html( $phone ); ?></a>
				<a href="<?php echo esc_url( home_url( '/#kontakt' ) ); ?>" class="flex items-center justify-center gap-2 px-8 py-4 rounded font-semibold border-2 transition-all hover:scale-105" style="border-color: oklch(0.62 0.12 55); color: oklch(0.50 0.10 50); font-family: 'Montserrat', sans-serif;">Nezávazná poptávka</a>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/site-footer' ); ?>
</div>
<?php
get_footer();
