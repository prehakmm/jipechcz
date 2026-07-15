<?php
/**
 * Základní fallback šablona (stránky, příspěvky, archivy).
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

	<main class="container py-16" style="min-height: 60vh;">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<article class="prose max-w-3xl mx-auto">
					<h1 class="text-4xl font-bold mb-6" style="font-family: 'Playfair Display', serif;"><?php the_title(); ?></h1>
					<div class="leading-relaxed" style="color: oklch(0.35 0.04 45);"><?php the_content(); ?></div>
				</article>
				<?php
			endwhile;
		else :
			?>
			<p class="text-center" style="color: oklch(0.45 0.03 50);"><?php esc_html_e( 'Nic nenalezeno.', 'jipech' ); ?></p>
		<?php endif; ?>
	</main>

	<footer style="background-color: oklch(0.18 0.03 40);" class="py-8">
		<div class="container text-center">
			<p class="text-xs" style="color: oklch(0.50 0.02 50);">© <?php echo esc_html( gmdate( 'Y' ) ); ?> JIPECH – Truhlářství Jiří Pecháček.</p>
		</div>
	</footer>
</div>
<?php
get_footer();
