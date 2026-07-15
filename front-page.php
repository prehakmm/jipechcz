<?php
/**
 * Úvodní strana – Truhlářství JIPECH.
 *
 * @package jipech
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$phone       = jipech_contact( 'phone' );
$phone_href  = 'tel:' . jipech_contact( 'phone_href' );
$email       = jipech_contact( 'email' );
$logo        = jipech_asset( 'logo' );
$hero        = jipech_asset( 'hero' );
$workshop    = jipech_asset( 'workshop' );
$kitchen     = jipech_asset( 'kitchen' );
$cedule      = jipech_asset( 'cedule' );
$kuchyne_url = jipech_kuchyne_url();
$b2b_url     = jipech_b2b_url();
$gallery_json = wp_json_encode( jipech_get_home_gallery() );
$sent        = isset( $_GET['jipech_sent'] );
$form_err    = isset( $_GET['jipech_error'] ) ? sanitize_text_field( wp_unslash( $_GET['jipech_error'] ) ) : '';
$post_url    = esc_url( admin_url( 'admin-post.php' ) );
$nonce       = wp_create_nonce( 'jipech_form' );

$services = array(
	array( 'name' => 'Kuchyně', 'key' => 'kuchyne', 'link' => $kuchyne_url ),
	array( 'name' => 'Knihovny', 'key' => 'knihovny' ),
	array( 'name' => 'Vestavěný nábytek', 'key' => 'vestaveny' ),
	array( 'name' => 'Šatní skříně', 'key' => 'satni' ),
	array( 'name' => 'Úložné prostory', 'key' => 'ulozne' ),
	array( 'name' => 'Obývací pokoje', 'key' => 'obyvaci' ),
	array( 'name' => 'Pracovny', 'key' => 'pracovny' ),
	array( 'name' => 'Kanceláře', 'key' => 'kancelare' ),
	array( 'name' => 'Dětské pokoje', 'key' => 'detske' ),
	array( 'name' => 'Lůžkový nábytek', 'key' => 'luzko' ),
	array( 'name' => 'Dveře', 'key' => 'dvere' ),
	array( 'name' => 'Schodiště', 'key' => 'schodiste' ),
	array( 'name' => 'Okna', 'key' => 'okna' ),
	array( 'name' => 'Stoly', 'key' => 'stoly' ),
	array( 'name' => 'Altánky a pergoly', 'key' => 'altanky' ),
	array( 'name' => 'Dřevěné obložení', 'key' => 'oblozeni' ),
);

get_header();
?>
<div style="background-color: oklch(0.97 0.01 80); color: oklch(0.22 0.03 40);">

	<!-- ===== STICKY PHONE CTA ===== -->
	<a href="<?php echo esc_attr( $phone_href ); ?>" class="hidden lg:flex fixed bottom-6 right-6 z-50 items-center gap-2 rounded-full px-5 py-3 shadow-2xl transition-all hover:scale-105 active:scale-95" style="background-color: oklch(0.32 0.09 145); color: white; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 0.95rem;">
		<?php jipech_icon( 'phone-call', 20 ); ?>
		<span class="hidden sm:inline"><?php echo esc_html( $phone ); ?></span>
		<span class="sm:hidden">Zavolat</span>
	</a>

	<!-- ===== NAVIGATION ===== -->
	<nav class="fixed top-0 left-0 right-0 z-40 transition-all duration-300" style="background-color: oklch(0.99 0.005 80); box-shadow: 0 2px 20px oklch(0.25 0.04 40 / 0.10);">
		<div class="container flex items-center justify-between py-3">
			<a href="#hero" class="flex items-center gap-3">
				<img src="<?php echo esc_url( $logo ); ?>" alt="JIPECH Truhlářství" class="h-14 w-auto" />
			</a>
			<div class="hidden md:flex items-center gap-7">
				<a href="#sluzby" class="text-sm font-semibold tracking-widest uppercase transition-colors hover:opacity-60" style="font-family: 'Montserrat', sans-serif; color: oklch(0.22 0.03 40);">Služby</a>
				<a href="#reference" class="text-sm font-semibold tracking-widest uppercase transition-colors hover:opacity-60" style="font-family: 'Montserrat', sans-serif; color: oklch(0.22 0.03 40);">Reference</a>
				<a href="#o-nas" class="text-sm font-semibold tracking-widest uppercase transition-colors hover:opacity-60" style="font-family: 'Montserrat', sans-serif; color: oklch(0.22 0.03 40);">O nás</a>
				<a href="#kontakt" class="text-sm font-semibold tracking-widest uppercase transition-colors hover:opacity-60" style="font-family: 'Montserrat', sans-serif; color: oklch(0.22 0.03 40);">Kontakt</a>
				<div class="relative" data-dropdown>
					<a href="#galerie" class="text-sm font-semibold tracking-widest uppercase transition-colors hover:opacity-60 flex items-center gap-1" style="font-family: 'Montserrat', sans-serif; color: oklch(0.22 0.03 40);">
						Galerie
						<svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor"><path d="M6 8L1 3h10z"></path></svg>
					</a>
					<div class="absolute top-full left-0 mt-1 bg-white rounded-lg shadow-xl border border-amber-100 py-2 min-w-[160px] z-50" data-dropdown-menu hidden>
						<a href="#galerie" class="block w-full text-left px-4 py-2 text-sm font-medium hover:bg-amber-50 transition-colors" style="font-family: 'Montserrat', sans-serif; color: oklch(0.35 0.04 45);">Všechny realizace</a>
						<a href="<?php echo esc_url( $kuchyne_url ); ?>" class="flex items-center gap-2 px-4 py-2 text-sm font-medium hover:bg-amber-50 transition-colors" style="font-family: 'Montserrat', sans-serif; color: oklch(0.50 0.10 50);">
							<span style="color: oklch(0.62 0.12 55);"><?php jipech_service_icon( 'kuchyne', '', 'width:16px;height:16px;' ); ?></span>
							Kuchyně
						</a>
					</div>
				</div>
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
			<div class="container py-4 flex flex-col gap-4">
				<a href="#sluzby" class="text-left text-sm font-semibold tracking-widest uppercase py-2" style="font-family: 'Montserrat', sans-serif;">Služby</a>
				<a href="#reference" class="text-left text-sm font-semibold tracking-widest uppercase py-2" style="font-family: 'Montserrat', sans-serif;">Reference</a>
				<a href="#o-nas" class="text-left text-sm font-semibold tracking-widest uppercase py-2" style="font-family: 'Montserrat', sans-serif;">O nás</a>
				<a href="#kontakt" class="text-left text-sm font-semibold tracking-widest uppercase py-2" style="font-family: 'Montserrat', sans-serif;">Kontakt</a>
				<a href="<?php echo esc_url( $kuchyne_url ); ?>" class="text-left text-sm font-semibold tracking-widest uppercase py-2 flex items-center gap-2" style="font-family: 'Montserrat', sans-serif; color: oklch(0.50 0.10 50);">
					<span style="color: oklch(0.62 0.12 55);"><?php jipech_service_icon( 'kuchyne', '', 'width:16px;height:16px;' ); ?></span>
					Galerie Kuchyně
				</a>
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

	<!-- ===== HERO ===== -->
	<section id="hero" class="relative min-h-screen flex items-center overflow-hidden">
		<div class="absolute inset-0">
			<img src="<?php echo esc_url( $hero ); ?>" alt="Truhlářská dílna JIPECH" class="w-full h-full object-cover" />
			<div class="absolute inset-0" style="background: linear-gradient(135deg, oklch(0.15 0.04 40 / 0.78) 0%, oklch(0.25 0.04 40 / 0.50) 50%, transparent 100%);"></div>
		</div>
		<div class="container relative z-10 pt-28 pb-16">
			<div class="max-w-2xl" data-reveal>
				<p class="section-label mb-4" style="color: oklch(0.85 0.10 60);">Truhlářství od roku 1997</p>
				<h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6" style="font-family: 'Playfair Display', serif; color: white; text-shadow: 0 2px 20px oklch(0.1 0 0 / 0.5);">
					Nábytek<br /><em style="color: oklch(0.85 0.12 60);">z masívu</em>
				</h1>
				<p class="text-xl mb-2" style="color: oklch(0.90 0.02 80); font-family: 'Source Sans 3', sans-serif;">100 % dřevo, originální vzhled</p>
				<p class="text-base mb-10 max-w-lg" style="color: oklch(0.82 0.02 80); font-family: 'Source Sans 3', sans-serif;">Pečlivě zpracovaný nábytek na míru přesně podle vašich představ. Kuchyně, schody, okna, vestavěný nábytek – vše z kvalitního dřeva.</p>
				<div class="flex flex-col sm:flex-row gap-4">
					<a href="<?php echo esc_attr( $phone_href ); ?>" class="flex items-center justify-center gap-3 px-8 py-4 rounded font-bold text-lg transition-all hover:scale-105 shadow-xl" style="background-color: oklch(0.32 0.09 145); color: white; font-family: 'Montserrat', sans-serif;">
						<?php jipech_icon( 'phone', 22 ); ?><?php echo esc_html( $phone ); ?>
					</a>
					<a href="#kontakt" class="flex items-center justify-center gap-2 px-8 py-4 rounded font-semibold text-base transition-all hover:scale-105 border-2" style="border-color: white; color: white; font-family: 'Montserrat', sans-serif; background-color: transparent;">
						Nezávazná poptávka <?php jipech_icon( 'arrow-right', 18 ); ?>
					</a>
				</div>
				<div class="flex flex-wrap gap-6 mt-10">
					<div class="text-center"><div class="text-3xl font-bold" style="font-family: 'Playfair Display', serif; color: oklch(0.85 0.12 60);">29+</div><div class="text-xs uppercase tracking-wider" style="color: oklch(0.75 0.02 80); font-family: 'Montserrat', sans-serif;">let zkušeností</div></div>
					<div class="text-center"><div class="text-3xl font-bold" style="font-family: 'Playfair Display', serif; color: oklch(0.85 0.12 60);">1997</div><div class="text-xs uppercase tracking-wider" style="color: oklch(0.75 0.02 80); font-family: 'Montserrat', sans-serif;">rok založení</div></div>
					<div class="text-center"><div class="text-3xl font-bold" style="font-family: 'Playfair Display', serif; color: oklch(0.85 0.12 60);">100%</div><div class="text-xs uppercase tracking-wider" style="color: oklch(0.75 0.02 80); font-family: 'Montserrat', sans-serif;">spokojených zákazníků</div></div>
				</div>
			</div>
		</div>
		<div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
			<?php jipech_icon( 'chevron-down', 32, '', 'color: oklch(0.85 0.10 60);' ); ?>
		</div>
	</section>

	<!-- ===== PHONE BANNER ===== -->
	<section style="background-color: oklch(0.25 0.04 40);" class="py-6">
		<div class="container flex flex-col md:flex-row items-center justify-between gap-4">
			<div>
				<p class="text-sm uppercase tracking-widest mb-1" style="color: oklch(0.62 0.12 55); font-family: 'Montserrat', sans-serif;">Nejrychlejší cesta k vašemu nábytku</p>
				<p class="text-lg font-semibold" style="color: oklch(0.90 0.02 80); font-family: 'Source Sans 3', sans-serif;">Zavolejte nám – rádi probereme vaše představy a nacenění</p>
			</div>
			<a href="<?php echo esc_attr( $phone_href ); ?>" class="flex items-center gap-3 px-8 py-4 rounded font-bold text-xl transition-all hover:scale-105 whitespace-nowrap" style="background-color: oklch(0.62 0.12 55); color: white; font-family: 'Montserrat', sans-serif;">
				<?php jipech_icon( 'phone', 24 ); ?><?php echo esc_html( $phone ); ?>
			</a>
		</div>
	</section>

	<!-- ===== SERVICES ===== -->
	<section id="sluzby" class="py-20">
		<div class="container">
			<div class="text-center mb-14">
				<p class="section-label mb-3">Co vyrábíme</p>
				<h2 class="text-4xl md:text-5xl font-bold" style="font-family: 'Playfair Display', serif;">Naše služby</h2>
				<hr class="wood-divider mt-6 max-w-xs mx-auto" />
			</div>
			<div class="grid md:grid-cols-2 gap-6 mb-14">
				<div class="rounded-lg p-8" data-reveal="left" style="background-color: oklch(0.88 0.04 55);">
					<p class="section-label mb-2">Prémiová kategorie</p>
					<h3 class="text-3xl font-bold mb-3" style="font-family: 'Playfair Display', serif;">Nábytek z masívu</h3>
					<p class="text-base leading-relaxed mb-4" style="color: oklch(0.35 0.04 45);">100 % dřevo, originální vzhled. Masivní dřevo využíváme při výrobě oken, dveří, schodů a exkluzivního nábytku.</p>
					<a href="#kontakt" class="btn-primary inline-block">Nezávazně poptat</a>
				</div>
				<div class="rounded-lg p-8" data-reveal="right" style="background-color: oklch(0.93 0.02 70);">
					<p class="section-label mb-2">Dostupná kategorie</p>
					<h3 class="text-3xl font-bold mb-3" style="font-family: 'Playfair Display', serif;">Dřevotřískový nábytek</h3>
					<p class="text-base leading-relaxed mb-4" style="color: oklch(0.35 0.04 45);">LDTD materiál pro vnitřní prostory. Kuchyňské linky, skříně a další nábytek na míru přesně podle vašeho přání.</p>
					<a href="#kontakt" class="btn-primary inline-block">Nezávazně poptat</a>
				</div>
			</div>
			<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8 gap-4">
				<?php foreach ( $services as $svc ) :
					$is_link = ! empty( $svc['link'] );
					$tag     = $is_link ? 'a' : 'div';
					$attrs   = $is_link ? ' href="' . esc_url( $svc['link'] ) . '"' : '';
					$cursor  = $is_link ? 'cursor-pointer group' : 'cursor-default';
					?>
					<<?php echo $tag; // phpcs:ignore ?><?php echo $attrs; // phpcs:ignore ?> class="flex flex-col items-center text-center p-4 rounded-lg transition-all hover:shadow-md <?php echo esc_attr( $cursor ); ?>" data-reveal style="background-color: oklch(0.99 0.005 80);">
						<span style="color: oklch(0.62 0.12 55);"><?php jipech_service_icon( $svc['key'] ); ?></span>
						<span class="text-xs font-semibold leading-tight mt-2" style="font-family: 'Montserrat', sans-serif; color: oklch(0.35 0.04 45);"><?php echo esc_html( $svc['name'] ); ?></span>
						<?php if ( $is_link ) : ?><span class="text-[10px] mt-1 opacity-0 group-hover:opacity-100 transition-opacity" style="color: oklch(0.50 0.10 50);">Zobrazit →</span><?php endif; ?>
					</<?php echo $tag; // phpcs:ignore ?>>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ===== WORKSHOP BANNER ===== -->
	<section class="relative py-24 overflow-hidden">
		<div class="absolute inset-0">
			<img src="<?php echo esc_url( $workshop ); ?>" alt="Truhlářská dílna" class="w-full h-full object-cover" style="object-position: center 40%;" />
			<div class="absolute inset-0" style="background: oklch(0.15 0.04 40 / 0.72);"></div>
		</div>
		<div class="container relative z-10 text-center">
			<div data-reveal="scale">
				<h2 class="text-4xl md:text-5xl font-bold mb-4" style="font-family: 'Playfair Display', serif; color: white;">Dobře odvedená práce</h2>
				<p class="text-xl max-w-2xl mx-auto mb-8" style="color: oklch(0.85 0.02 80);">…je u nás samozřejmostí a cílem. Naši zákazníci jsou s výsledkem práce vždy spokojeni a mají důvod se k nám pravidelně vracet.</p>
				<div class="mb-8 flex justify-center">
					<img src="<?php echo esc_url( $cedule ); ?>" alt="České řemeslo – Kvalita od roku 1997" style="width: 220px; height: auto; border-radius: 4px; box-shadow: 0 4px 16px oklch(0.08 0.02 40 / 0.6);" />
				</div>
				<div class="block">
					<a href="#galerie" class="inline-flex items-center gap-2 px-8 py-4 rounded font-semibold transition-all hover:scale-105" style="background-color: oklch(0.62 0.12 55); color: white; font-family: 'Montserrat', sans-serif;">Galerie nábytku <?php jipech_icon( 'arrow-right', 18 ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<!-- ===== ABOUT ===== -->
	<section id="o-nas" class="py-20">
		<div class="container">
			<div class="grid md:grid-cols-2 gap-16 items-center">
				<div data-reveal="left">
					<p class="section-label mb-3">O nás</p>
					<h2 class="text-4xl md:text-5xl font-bold mb-6" style="font-family: 'Playfair Display', serif;">Pečlivost.<br />Kvalita.<br />Spokojenost.</h2>
					<p class="text-lg leading-relaxed mb-4" style="color: oklch(0.40 0.03 45);">Na českém trhu působíme již <strong>29 let, od roku 1997</strong>. Naše truhlářské zkušenosti lze měřit letokruhy stromů.</p>
					<p class="text-base leading-relaxed mb-4" style="color: oklch(0.40 0.03 45);">Nebojíme se práce s <strong>masivem</strong>, který využíváme při výrobě oken, dveří i schodů. Najdete u nás také <strong>deskový materiál</strong>, ze kterého zpracováváme kuchyňské linky, skříně a další nábytek na míru přesně podle vašeho přání.</p>
					<p class="text-base leading-relaxed mb-8" style="color: oklch(0.40 0.03 45);">Celou naši nabídku jsme rozšířili o dětský nábytek, postele a v neposlední řadě také o pokládání dřevěných podlah.</p>
					<div class="flex flex-col sm:flex-row gap-4">
						<a href="<?php echo esc_attr( $phone_href ); ?>" class="btn-phone"><?php jipech_icon( 'phone', 20 ); ?>Zavolejte nám</a>
						<a href="#kontakt" class="px-6 py-3 rounded font-semibold border-2 transition-all inline-flex items-center justify-center" style="border-color: oklch(0.62 0.12 55); color: oklch(0.50 0.10 50); font-family: 'Montserrat', sans-serif;">Napsat zprávu</a>
					</div>
				</div>
				<div class="relative" data-reveal="right">
					<img src="<?php echo esc_url( $kitchen ); ?>" alt="Kuchyně na míru JIPECH" class="rounded-lg shadow-2xl w-full object-cover" style="height: 480px;" />
					<div class="absolute -bottom-6 -left-6 rounded-full w-28 h-28 flex flex-col items-center justify-center shadow-xl" style="background-color: oklch(0.62 0.12 55); color: white;">
						<span class="text-3xl font-bold" style="font-family: 'Playfair Display', serif;">26</span>
						<span class="text-xs text-center leading-tight" style="font-family: 'Montserrat', sans-serif;">let<br />zkušeností</span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ===== HOW IT WORKS ===== -->
	<section class="py-20" style="background-color: oklch(0.93 0.02 70);">
		<div class="container">
			<div class="text-center mb-14">
				<p class="section-label mb-3">Jak to funguje</p>
				<h2 class="text-4xl font-bold" style="font-family: 'Playfair Display', serif;">Postup spolupráce</h2>
				<hr class="wood-divider mt-6 max-w-xs mx-auto" />
			</div>
			<div class="grid md:grid-cols-3 gap-8">
				<div class="relative text-center p-8 rounded-lg" data-reveal style="background-color: oklch(0.99 0.005 80);">
					<div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold" style="background-color: oklch(0.62 0.12 55); color: white; font-family: 'Montserrat', sans-serif;">01</div>
					<div class="flex justify-center mb-4 mt-2" style="color: oklch(0.62 0.12 55);"><?php jipech_icon( 'clock', 32 ); ?></div>
					<h3 class="text-xl font-bold mb-3" style="font-family: 'Playfair Display', serif;">Konzultace a nacenění</h3>
					<p class="text-sm leading-relaxed" style="color: oklch(0.45 0.03 50);">Napište nám email nebo zavolejte, popište svoji představu na výrobu nábytku. Zašleme vám odhadovanou cenu.</p>
				</div>
				<div class="relative text-center p-8 rounded-lg" data-reveal style="background-color: oklch(0.99 0.005 80);">
					<div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold" style="background-color: oklch(0.62 0.12 55); color: white; font-family: 'Montserrat', sans-serif;">02</div>
					<div class="flex justify-center mb-4 mt-2" style="color: oklch(0.62 0.12 55);"><?php jipech_icon( 'ruler', 32 ); ?></div>
					<h3 class="text-xl font-bold mb-3" style="font-family: 'Playfair Display', serif;">Měření a výroba</h3>
					<p class="text-sm leading-relaxed" style="color: oklch(0.45 0.03 50);">Jakmile se dohodneme na designu a ceně, přijedeme zaměřit prostory, kam umístíme nábytek. Začneme s výrobou.</p>
				</div>
				<div class="relative text-center p-8 rounded-lg" data-reveal style="background-color: oklch(0.99 0.005 80);">
					<div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold" style="background-color: oklch(0.62 0.12 55); color: white; font-family: 'Montserrat', sans-serif;">03</div>
					<div class="flex justify-center mb-4 mt-2" style="color: oklch(0.62 0.12 55);"><?php jipech_icon( 'wrench', 32 ); ?></div>
					<h3 class="text-xl font-bold mb-3" style="font-family: 'Playfair Display', serif;">Montáž nábytku</h3>
					<p class="text-sm leading-relaxed" style="color: oklch(0.45 0.03 50);">V momentě, kdy dokončíme práci na výrobě, se domluvíme na termínu, kdy bude váš nábytek na místě nainstalován.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- ===== GALLERY ===== -->
	<section id="galerie" class="py-20">
		<div class="container">
			<div class="text-center mb-10">
				<p class="section-label mb-3">Naše realizace</p>
				<h2 class="text-4xl md:text-5xl font-bold" style="font-family: 'Playfair Display', serif;">Galerie nábytku</h2>
				<hr class="wood-divider mt-6 max-w-xs mx-auto" />
			</div>
			<div class="flex flex-wrap justify-center gap-3 mb-8" data-gallery-tabs data-gallery-json="<?php echo esc_attr( $gallery_json ); ?>"></div>
			<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3" data-gallery-grid></div>
		</div>
	</section>

	<!-- ===== WHY US ===== -->
	<section class="py-20" style="background-color: oklch(0.25 0.04 40);">
		<div class="container">
			<div class="text-center mb-12">
				<p class="section-label mb-3" style="color: oklch(0.62 0.12 55);">Proč JIPECH</p>
				<h2 class="text-4xl font-bold" style="font-family: 'Playfair Display', serif; color: white;">Naše přednosti</h2>
			</div>
			<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
				<?php
				$why = array(
					array( '29 let zkušeností', 'Na trhu od roku 1997, stovky spokojených zákazníků.' ),
					array( 'Masiv i LDTD', 'Pracujeme s masivním dřevem i laminovanou dřevotřískou.' ),
					array( 'Nábytek na míru', 'Každý kus navrhujeme a vyrábíme přesně podle vašich požadavků.' ),
					array( 'Montáž v ceně', 'Přijedeme zaměřit, vyrobíme a nainstalujeme – vše pod jednou střechou.' ),
				);
				foreach ( $why as $w ) : ?>
					<div class="p-6 rounded-lg" data-reveal style="background-color: oklch(0.32 0.04 40);">
						<?php jipech_icon( 'check', 28, 'mb-3', 'color: oklch(0.62 0.12 55);' ); ?>
						<h3 class="text-lg font-bold mb-2" style="font-family: 'Playfair Display', serif; color: white;"><?php echo esc_html( $w[0] ); ?></h3>
						<p class="text-sm leading-relaxed" style="color: oklch(0.72 0.02 70);"><?php echo esc_html( $w[1] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ===== B2B ===== -->
	<section class="py-20 overflow-hidden" style="background-color: oklch(0.25 0.04 40);">
		<div class="container">
			<div class="grid lg:grid-cols-2 gap-12 items-center">
				<div data-reveal="left">
					<div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-6" style="background-color: oklch(0.62 0.12 55 / 0.20); border: 1px solid oklch(0.62 0.12 55 / 0.40);">
						<?php jipech_icon( 'building2', 15, '', 'color: oklch(0.85 0.10 60);' ); ?>
						<span class="text-xs font-bold uppercase tracking-widest" style="color: oklch(0.85 0.10 60); font-family: 'Montserrat', sans-serif;">Pro firmy</span>
					</div>
					<h2 class="text-3xl md:text-4xl font-bold mb-5" style="font-family: 'Playfair Display', serif; color: white;">Vyrábíme nábytek<br /><em style="color: oklch(0.80 0.12 60);">i pro firmy</em></h2>
					<p class="text-base leading-relaxed mb-6" style="color: oklch(0.80 0.02 75);">Kanceláře, obchodní prostory, hotely, restaurace nebo developerské projekty – vyrábíme nábytek na míru pro firmy všech velikostí. Nabízíme platbu na fakturu, prioritní termíny a individuální ceník při opakované spolupráci.</p>
					<div class="grid sm:grid-cols-2 gap-4 mb-8">
						<div class="flex items-center gap-3 px-4 py-3 rounded-lg" style="background-color: oklch(0.32 0.04 40);"><span class="text-lg">🏢</span><span class="text-sm font-semibold" style="color: white; font-family: 'Montserrat', sans-serif;">Kancelářský nábytek</span></div>
						<div class="flex items-center gap-3 px-4 py-3 rounded-lg" style="background-color: oklch(0.32 0.04 40);"><span class="text-lg">🏨</span><span class="text-sm font-semibold" style="color: white; font-family: 'Montserrat', sans-serif;">Hotely a restaurace</span></div>
						<div class="flex items-center gap-3 px-4 py-3 rounded-lg" style="background-color: oklch(0.32 0.04 40);"><span class="text-lg">🏗️</span><span class="text-sm font-semibold" style="color: white; font-family: 'Montserrat', sans-serif;">Developerské projekty</span></div>
						<div class="flex items-center gap-3 px-4 py-3 rounded-lg" style="background-color: oklch(0.32 0.04 40);"><span class="text-lg">📄</span><span class="text-sm font-semibold" style="color: white; font-family: 'Montserrat', sans-serif;">Platba na fakturu</span></div>
					</div>
					<a href="<?php echo esc_url( $b2b_url ); ?>" class="inline-flex items-center gap-3 px-8 py-4 rounded-lg font-bold text-base transition-all hover:scale-105 shadow-lg" style="background-color: oklch(0.62 0.12 55); color: white; font-family: 'Montserrat', sans-serif;">
						<?php jipech_icon( 'building2', 20 ); ?> Firemní poptávka <?php jipech_icon( 'chevron-right', 18 ); ?>
					</a>
				</div>
				<div class="rounded-2xl p-8" data-reveal="right" style="background-color: oklch(0.32 0.04 40);">
					<h3 class="text-xl font-bold mb-6" style="font-family: 'Playfair Display', serif; color: white;">Výhody pro firemní zákazníky</h3>
					<ul class="space-y-4">
						<?php
						$adv = array(
							array( 'Platba na fakturu', 'Se splatností dle dohody, bez nutnosti zálohy předem.' ),
							array( 'Prioritní termíny', 'Při rámcové smlouvě garantujeme přednostní zařazení do výroby.' ),
							array( 'Individuální ceník', 'Pro větší objemy nebo opakované zakázky nabízíme slevy.' ),
							array( 'Montáž na klíč', 'Od měření přes výrobu až po finální montáž na místě.' ),
							array( 'Záruční servis', 'Záruční i pozáruční servis a opravy dodaného nábytku.' ),
						);
						foreach ( $adv as $a ) : ?>
							<li class="flex items-start gap-3">
								<?php jipech_icon( 'check', 18, 'mt-0.5 flex-shrink-0', 'color: oklch(0.62 0.12 55);' ); ?>
								<div><span class="text-sm font-bold" style="color: white; font-family: 'Montserrat', sans-serif;"><?php echo esc_html( $a[0] ); ?></span><span class="text-sm" style="color: oklch(0.72 0.02 70);"> – <?php echo esc_html( $a[1] ); ?></span></div>
							</li>
						<?php endforeach; ?>
					</ul>
					<div class="mt-8 pt-6" style="border-top: 1px solid oklch(0.40 0.04 40);">
						<p class="text-sm mb-3" style="color: oklch(0.72 0.02 70);">Máte zájem o spolupráci? Zavolejte nebo napište:</p>
						<a href="<?php echo esc_attr( $phone_href ); ?>" class="flex items-center gap-2 text-lg font-bold hover:underline" style="color: oklch(0.85 0.10 60); font-family: 'Montserrat', sans-serif;"><?php jipech_icon( 'phone', 18 ); ?> <?php echo esc_html( $phone ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ===== REFERENCE ===== -->
	<section id="reference" class="py-20">
		<div class="container">
			<div class="text-center mb-14">
				<p class="section-label mb-3">Co říkají zákazníci</p>
				<h2 class="text-4xl md:text-5xl font-bold" style="font-family: 'Playfair Display', serif;">Reference</h2>
				<hr class="wood-divider mt-6 max-w-xs mx-auto" />
			</div>
			<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php
				$reviews = array(
					array( 'Ing. Martin Kovář', 'Praha – Vinohrady', 'Kuchyňská linka z masívu', '2024', 'Pan Pecháček nám vyrobil kuchyňskou linku přesně podle našich představ. Práce byla odvedena precizně, termín dodržen a cena odpovídala domluvě. Rozhodně doporučuji.' ),
					array( 'Jana Horáčková', 'Nymburk', 'Vestavěné skříně do ložnice', '2024', 'Objednali jsme vestavěné skříně do celé ložnice. Výsledek předčil naše očekávání – krásné zpracování, přesné míry, vše sedí na milimetr. Velmi příjemná komunikace.' ),
					array( 'Petr Šimánek', 'Poděbrady', 'Dubové schodiště', '2023', 'Schodiště z dubového masívu – absolutní třída. Jiří Pecháček je skutečný řemeslník, který svou práci miluje. Každý detail je promyšlený. Schodiště je ozdobou celého domu.' ),
					array( 'Lucie Marková', 'Mladá Boleslav', 'Dětský pokoj komplet', '2023', 'Dětský pokoj na míru – postele, skříně, psací stůl. Vše krásně sladěné, bezpečné a odolné. Děti jsou nadšené a já taky. Přijde nám, že nábytek vydrží celou generaci.' ),
					array( 'Tomáš Blažek', 'Kolín', 'Zahradní pergola', '2023', 'Pergola na zahradu – přesně to, co jsme si přáli. Solidní konstrukce, hezké zpracování, rychlá montáž. Letos v létě jsme ji využívali každý den. Výborná práce!' ),
				);
				foreach ( $reviews as $r ) : ?>
					<div class="rounded-xl p-7 flex flex-col gap-4 relative" data-reveal style="background-color: oklch(0.99 0.005 80); box-shadow: 0 2px 16px oklch(0.25 0.04 40 / 0.07);">
						<?php jipech_icon( 'quote', 28, 'absolute top-5 right-6 opacity-10', 'color: oklch(0.62 0.12 55);' ); ?>
						<div class="flex gap-1"><?php for ( $s = 0; $s < 5; $s++ ) { jipech_icon( 'star', 16, '', 'color: oklch(0.62 0.12 55);', 'oklch(0.62 0.12 55)' ); } ?></div>
						<p class="text-sm leading-relaxed italic" style="color: oklch(0.38 0.03 45);">"<?php echo esc_html( $r[4] ); ?>"</p>
						<div class="mt-auto pt-3 border-t" style="border-color: oklch(0.90 0.02 70);">
							<p class="font-bold text-sm" style="font-family: 'Playfair Display', serif;"><?php echo esc_html( $r[0] ); ?></p>
							<p class="text-xs mt-0.5" style="color: oklch(0.55 0.04 50); font-family: 'Montserrat', sans-serif;"><?php echo esc_html( $r[1] . ' · ' . $r[2] . ' · ' . $r[3] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ===== CONTACT ===== -->
	<section id="kontakt" class="py-20" style="background-color: oklch(0.93 0.02 70);">
		<div class="container">
			<div class="text-center mb-14">
				<p class="section-label mb-3">Kontakt</p>
				<h2 class="text-4xl md:text-5xl font-bold" style="font-family: 'Playfair Display', serif;">Nezávazná poptávka</h2>
				<hr class="wood-divider mt-6 max-w-xs mx-auto" />
			</div>
			<div class="grid md:grid-cols-2 gap-12 items-start">
				<div data-reveal="left">
					<div class="rounded-xl p-8 mb-8 text-center" style="background-color: oklch(0.88 0.04 55);">
						<p class="section-label mb-2">Nejrychlejší způsob</p>
						<h3 class="text-2xl font-bold mb-4" style="font-family: 'Playfair Display', serif;">Zavolejte nám přímo</h3>
						<p class="text-sm mb-6" style="color: oklch(0.40 0.03 45);">Rádi s vámi proberu vaši představu a nastíním další postup. Volání je nejrychlejší cesta k vašemu novému nábytku.</p>
						<a href="<?php echo esc_attr( $phone_href ); ?>" class="flex items-center justify-center gap-3 w-full py-4 rounded-lg font-bold text-xl transition-all hover:scale-105 shadow-lg" style="background-color: oklch(0.32 0.09 145); color: white; font-family: 'Montserrat', sans-serif;"><?php jipech_icon( 'phone', 26 ); ?><?php echo esc_html( $phone ); ?></a>
					</div>
					<div class="rounded-xl p-8" style="background-color: oklch(0.99 0.005 80);">
						<h3 class="text-xl font-bold mb-6" style="font-family: 'Playfair Display', serif;">TRUHLÁŘSTVÍ JIŘÍ PECHÁČEK</h3>
						<div class="space-y-4">
							<div class="flex items-start gap-4">
								<?php jipech_icon( 'map-pin', 20, 'mt-0.5 shrink-0', 'color: oklch(0.62 0.12 55);' ); ?>
								<div><p class="text-xs uppercase tracking-wider mb-1" style="font-family: 'Montserrat', sans-serif; color: oklch(0.55 0.05 50);">Adresa</p><p class="font-semibold"><?php echo esc_html( jipech_contact( 'address_line1' ) . ' ' . jipech_contact( 'address_line2' ) ); ?></p></div>
							</div>
							<div class="flex items-start gap-4">
								<?php jipech_icon( 'phone', 20, 'mt-0.5 shrink-0', 'color: oklch(0.62 0.12 55);' ); ?>
								<div><p class="text-xs uppercase tracking-wider mb-1" style="font-family: 'Montserrat', sans-serif; color: oklch(0.55 0.05 50);">Telefon</p><a href="<?php echo esc_attr( $phone_href ); ?>" class="font-bold text-lg hover:underline" style="color: oklch(0.32 0.09 145);"><?php echo esc_html( $phone ); ?></a></div>
							</div>
							<div class="flex items-start gap-4">
								<?php jipech_icon( 'mail', 20, 'mt-0.5 shrink-0', 'color: oklch(0.62 0.12 55);' ); ?>
								<div><p class="text-xs uppercase tracking-wider mb-1" style="font-family: 'Montserrat', sans-serif; color: oklch(0.55 0.05 50);">Email</p><a href="mailto:<?php echo esc_attr( $email ); ?>" class="font-semibold hover:underline" style="color: oklch(0.35 0.04 45);"><?php echo esc_html( $email ); ?></a></div>
							</div>
						</div>
					</div>
				</div>

				<div data-reveal="right">
					<?php if ( $sent ) : ?>
						<div class="rounded-xl p-10 text-center" style="background-color: oklch(0.99 0.005 80);">
							<?php jipech_icon( 'check', 56, 'mx-auto mb-4', 'color: oklch(0.32 0.09 145);' ); ?>
							<h3 class="text-2xl font-bold mb-3" style="font-family: 'Playfair Display', serif;">Poptávka odeslána!</h3>
							<p class="text-base mb-6" style="color: oklch(0.40 0.03 45);">Děkujeme za vaši poptávku. Ozveme se vám co nejdříve. Pro rychlejší odpověď nás neváhejte zavolat.</p>
							<a href="<?php echo esc_attr( $phone_href ); ?>" class="inline-flex items-center gap-2 px-6 py-3 rounded font-bold" style="background-color: oklch(0.32 0.09 145); color: white; font-family: 'Montserrat', sans-serif;"><?php jipech_icon( 'phone', 18 ); ?><?php echo esc_html( $phone ); ?></a>
						</div>
					<?php else : ?>
						<form class="rounded-xl p-8 space-y-5" data-contact-form data-form-type="main" data-ajax="1" method="post" action="<?php echo $post_url; // phpcs:ignore ?>" enctype="multipart/form-data" style="background-color: oklch(0.99 0.005 80);">
							<input type="hidden" name="action" value="jipech_submit" />
							<input type="hidden" name="jipech_form_type" value="main" />
							<input type="hidden" name="jipech_nonce" value="<?php echo esc_attr( $nonce ); ?>" />
							<input type="text" name="website" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;" aria-hidden="true" />
							<h3 class="text-xl font-bold mb-2" style="font-family: 'Playfair Display', serif;">Popište a odešlete mi svoji představu</h3>
							<p class="text-sm mb-4" style="color: oklch(0.45 0.03 50);">Rád s vámi proberu případnou spolupráci a nastíním další postup.</p>
							<div class="grid sm:grid-cols-2 gap-4">
								<div>
									<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Jméno *</label>
									<input type="text" name="name" required placeholder="Vaše jméno" class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2" style="background-color: white; border-color: oklch(0.87 0.03 65); font-family: 'Source Sans 3', sans-serif;" />
								</div>
								<div>
									<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Telefon *</label>
									<input type="tel" name="phone" required placeholder="+420 xxx xxx xxx" class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2" style="background-color: white; border-color: oklch(0.87 0.03 65); font-family: 'Source Sans 3', sans-serif;" />
								</div>
							</div>
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Email</label>
								<input type="email" name="email" required placeholder="vas@email.cz" class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2" style="background-color: white; border-color: oklch(0.87 0.03 65); font-family: 'Source Sans 3', sans-serif;" />
							</div>
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Očekávaný termín dodání *</label>
								<select name="deliveryTerm" required class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2 appearance-none" style="background-color: white; border-color: oklch(0.62 0.12 55); font-family: 'Source Sans 3', sans-serif;">
									<option value="" disabled selected>— Vyberte termín —</option>
									<option value="3-6-mesicu">3–6 měsíců</option>
									<option value="6-12-mesicu">6–12 měsíců</option>
									<option value="vice-nez-rok">Více než rok</option>
									<option value="zatim-neznam">Zatím nevím</option>
								</select>
							</div>
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Lokalita realizace *</label>
								<input type="text" name="locality" required placeholder="Město / obec (např. Praha, Nymburk...)" class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2" style="background-color: white; border-color: oklch(0.87 0.03 65); font-family: 'Source Sans 3', sans-serif;" />
							</div>
							<div>
								<label class="block text-xs uppercase tracking-wider mb-3 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Představa o ceně</label>
								<div class="rounded-lg p-4" style="background-color: oklch(0.95 0.02 70);">
									<div class="flex justify-between items-baseline mb-4">
										<span class="text-xs" style="color: oklch(0.55 0.03 50);">Vaše představa o ceně:</span>
										<span class="text-lg font-bold" data-budget-value style="font-family: 'Montserrat', sans-serif; color: oklch(0.32 0.09 145);">50 000 Kč</span>
									</div>
									<div class="relative px-1" data-slider>
										<div class="relative h-2 rounded-full" style="background-color: oklch(0.82 0.04 65);">
											<div class="absolute top-0 left-0 h-2 rounded-full" data-slider-fill style="width: 13.79%; background-color: oklch(0.62 0.12 55);"></div>
										</div>
										<input type="range" name="budget" min="10000" max="300000" step="5000" value="50000" class="absolute inset-0 w-full opacity-0 cursor-pointer" style="height: 2rem; top: -0.75rem;" />
										<div class="absolute top-1/2 w-5 h-5 rounded-full border-2 shadow-md pointer-events-none" data-slider-thumb style="left: calc(13.79% - 10px); top: -5px; background-color: white; border-color: oklch(0.62 0.12 55); box-shadow: 0 2px 6px oklch(0.25 0.04 40 / 0.25);"></div>
									</div>
									<div class="flex justify-between mt-3">
										<span class="text-xs" style="color: oklch(0.55 0.03 50);">10 000 Kč</span>
										<span class="text-xs" style="color: oklch(0.55 0.03 50);">300 000 Kč+</span>
									</div>
								</div>
							</div>
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Vaše zpráva</label>
								<textarea rows="4" name="message" required placeholder="Popište svoji představu – co potřebujete vyrobit, rozměry, materiál..." class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2 resize-none" style="background-color: white; border-color: oklch(0.87 0.03 65); font-family: 'Source Sans 3', sans-serif;"></textarea>
							</div>
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Přiloha (nákres, fotografie)</label>
								<div class="relative flex flex-col items-center justify-center gap-2 px-4 py-6 rounded-lg border-2 border-dashed cursor-pointer transition-all" data-dropzone style="border-color: oklch(0.82 0.04 65); background-color: oklch(0.98 0.01 80);">
									<input id="file-upload-home" type="file" name="files[]" multiple accept="image/*,.pdf,.dwg,.dxf" class="hidden" />
									<?php jipech_icon( 'upload', 32, '', 'color: oklch(0.62 0.12 55);' ); ?>
									<p class="text-sm font-semibold" style="color: oklch(0.35 0.04 50);">Přetáhněte soubory sem nebo <span style="color: oklch(0.62 0.12 55);">klikněte pro výběr</span></p>
									<p class="text-xs" style="color: oklch(0.60 0.03 55);">Fotografie, PDF, nákresy – max. 5 souborů, každý do 10 MB</p>
								</div>
								<ul class="mt-3 space-y-2" data-file-list></ul>
							</div>
							<p class="text-sm font-semibold" data-form-error style="color: oklch(0.577 0.245 27.325); <?php echo $form_err ? '' : 'display:none;'; ?>"><?php echo esc_html( $form_err ); ?></p>
							<button type="submit" class="w-full py-4 rounded-lg font-bold text-base transition-all hover:scale-[1.02] hover:shadow-lg" style="background-color: oklch(0.25 0.04 40); color: white; font-family: 'Montserrat', sans-serif;">Odeslat poptávku</button>
							<p class="text-xs text-center" style="color: oklch(0.55 0.03 50);">* Povinné pole. Nebo nás rovnou zavolejte: <a href="<?php echo esc_attr( $phone_href ); ?>" class="font-bold hover:underline" style="color: oklch(0.32 0.09 145);"><?php echo esc_html( $phone ); ?></a></p>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- ===== FOOTER ===== -->
	<footer style="background-color: oklch(0.18 0.03 40);" class="py-10">
		<div class="container">
			<div class="grid sm:grid-cols-3 gap-8 mb-8">
				<div>
					<img src="<?php echo esc_url( $logo ); ?>" alt="JIPECH" class="h-16 w-auto mb-4" style="filter: brightness(1.2);" />
					<p class="text-sm leading-relaxed" style="color: oklch(0.65 0.02 60);">Truhlářství Jiří Pecháček – poctivá řemeslná výroba nábytku na míru od roku 1997.</p>
				</div>
				<div>
					<h4 class="text-sm font-bold uppercase tracking-wider mb-4" style="font-family: 'Montserrat', sans-serif; color: oklch(0.62 0.12 55);">Navigace</h4>
					<ul class="space-y-2">
						<li><a href="#sluzby" class="text-sm hover:underline" style="color: oklch(0.72 0.02 70);">Služby</a></li>
						<li><a href="#reference" class="text-sm hover:underline" style="color: oklch(0.72 0.02 70);">Reference</a></li>
						<li><a href="#o-nas" class="text-sm hover:underline" style="color: oklch(0.72 0.02 70);">O nás</a></li>
						<li><a href="#kontakt" class="text-sm hover:underline" style="color: oklch(0.72 0.02 70);">Kontakt</a></li>
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
</div>
<?php
get_footer();
