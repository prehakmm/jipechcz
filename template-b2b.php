<?php
/**
 * Template Name: B2B – Pro firmy
 *
 * @package jipech
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$phone      = jipech_contact( 'phone' );
$phone_href = 'tel:' . jipech_contact( 'phone_href' );
$email      = jipech_contact( 'email' );
$logo       = jipech_asset( 'logo' );
$workshop   = jipech_asset( 'workshop' );
$cedule     = jipech_asset( 'cedule' );
$home_url   = home_url( '/' );
$sent       = isset( $_GET['jipech_sent'] );
$form_err   = isset( $_GET['jipech_error'] ) ? sanitize_text_field( wp_unslash( $_GET['jipech_error'] ) ) : '';
$post_url   = esc_url( admin_url( 'admin-post.php' ) );
$nonce      = wp_create_nonce( 'jipech_form' );

get_header();
?>
<div style="background-color: oklch(0.97 0.01 80); color: oklch(0.22 0.03 40);">

	<!-- Nav -->
	<nav class="sticky top-0 z-40" style="background-color: oklch(0.99 0.005 80); box-shadow: 0 2px 20px oklch(0.25 0.04 40 / 0.10);">
		<div class="container flex items-center justify-between py-3">
			<a href="<?php echo esc_url( $home_url ); ?>" class="flex items-center gap-3">
				<img src="<?php echo esc_url( $logo ); ?>" alt="JIPECH" class="h-14 w-auto" />
			</a>
			<div class="flex items-center gap-4">
				<a href="<?php echo esc_url( $home_url ); ?>" class="flex items-center gap-2 text-sm font-semibold hover:opacity-70 transition-opacity" style="font-family: 'Montserrat', sans-serif; color: oklch(0.40 0.03 45);">
					<?php jipech_icon( 'arrow-left', 16 ); ?> Zpět na hlavní stránku
				</a>
				<a href="<?php echo esc_attr( $phone_href ); ?>" class="hidden sm:flex items-center gap-2 px-5 py-2.5 rounded text-sm font-bold transition-all hover:scale-105" style="background-color: oklch(0.62 0.12 55); color: white; font-family: 'Montserrat', sans-serif;">
					<?php jipech_icon( 'phone', 15 ); ?> Zavolejte nám
				</a>
			</div>
		</div>
	</nav>

	<!-- Hero -->
	<section class="relative py-20 overflow-hidden">
		<div class="absolute inset-0">
			<img src="<?php echo esc_url( $workshop ); ?>" alt="Dílna JIPECH" class="w-full h-full object-cover" />
			<div class="absolute inset-0" style="background: oklch(0.15 0.04 40 / 0.80);"></div>
		</div>
		<div class="container relative z-10">
			<div class="max-w-2xl" data-reveal>
				<div class="inline-flex items-center gap-2 px-4 py-2 rounded-full mb-6" style="background-color: oklch(0.62 0.12 55 / 0.25); border: 1px solid oklch(0.62 0.12 55 / 0.5);">
					<?php jipech_icon( 'building2', 16, '', 'color: oklch(0.85 0.10 60);' ); ?>
					<span class="text-sm font-semibold uppercase tracking-wider" style="color: oklch(0.85 0.10 60); font-family: 'Montserrat', sans-serif;">B2B – Pro firmy</span>
				</div>
				<h1 class="text-4xl md:text-6xl font-bold mb-6" style="font-family: 'Playfair Display', serif; color: white;">Nábytek pro<br /><em style="color: oklch(0.85 0.12 60);">vaši firmu</em></h1>
				<p class="text-lg mb-8" style="color: oklch(0.85 0.02 80);">Kanceláře, obchodní prostory, hotely, restaurace nebo developerské projekty. Vyrábíme nábytek na míru pro firmy všech velikostí s možností rámcové smlouvy a platby na fakturu.</p>
				<div class="flex flex-col sm:flex-row gap-4 mb-8">
					<a href="<?php echo esc_attr( $phone_href ); ?>" class="flex items-center justify-center gap-3 px-8 py-4 rounded font-bold text-lg transition-all hover:scale-105 shadow-xl" style="background-color: oklch(0.32 0.09 145); color: white; font-family: 'Montserrat', sans-serif;"><?php jipech_icon( 'phone', 22 ); ?> <?php echo esc_html( $phone ); ?></a>
					<a href="#b2b-form" class="flex items-center justify-center gap-2 px-8 py-4 rounded font-semibold border-2 transition-all hover:scale-105" style="border-color: white; color: white; font-family: 'Montserrat', sans-serif;">Firemní poptávka <?php jipech_icon( 'chevron-right', 18 ); ?></a>
				</div>
				<img src="<?php echo esc_url( $cedule ); ?>" alt="České řemeslo – Kvalita od roku 1997" style="width: 180px; height: auto; border-radius: 4px; box-shadow: 0 4px 16px oklch(0.08 0.02 40 / 0.6);" />
			</div>
		</div>
	</section>

	<!-- Výhody -->
	<section class="py-16" style="background-color: oklch(0.25 0.04 40);">
		<div class="container">
			<div class="text-center mb-10">
				<p class="section-label mb-2" style="color: oklch(0.62 0.12 55);">Proč spolupracovat s JIPECH</p>
				<h2 class="text-3xl font-bold" style="font-family: 'Playfair Display', serif; color: white;">Výhody pro firemní zákazníky</h2>
			</div>
			<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
				<?php
				$adv = array(
					array( 'Platba na fakturu', 'Firemní zákazníci mohou platit na fakturu se splatností dle dohody.' ),
					array( 'Prioritní termíny', 'Při rámcové smlouvě garantujeme přednostní zařazení do výrobního plánu.' ),
					array( 'Individuální ceník', 'Pro opakované zakázky nebo větší objemy nabízíme individuální cenové podmínky.' ),
					array( 'Projektová dokumentace', 'Připravíme kompletní výkresovou dokumentaci pro stavební řízení nebo architekty.' ),
					array( 'Montáž na klíč', 'Zajistíme celý proces od měření přes výrobu až po finální montáž na místě.' ),
					array( 'Záruční servis', 'Poskytujeme záruční i pozáruční servis a opravy dodaného nábytku.' ),
				);
				foreach ( $adv as $a ) : ?>
					<div class="p-6 rounded-lg" data-reveal style="background-color: oklch(0.32 0.04 40);">
						<?php jipech_icon( 'check', 24, 'mb-3', 'color: oklch(0.62 0.12 55);' ); ?>
						<h3 class="font-bold mb-2" style="font-family: 'Playfair Display', serif; color: white;"><?php echo esc_html( $a[0] ); ?></h3>
						<p class="text-sm leading-relaxed" style="color: oklch(0.72 0.02 70);"><?php echo esc_html( $a[1] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Služby pro firmy -->
	<section class="py-16">
		<div class="container">
			<div class="text-center mb-12">
				<p class="section-label mb-3">Co nabízíme firmám</p>
				<h2 class="text-3xl md:text-4xl font-bold" style="font-family: 'Playfair Display', serif;">Firemní realizace</h2>
				<hr class="wood-divider mt-6 max-w-xs mx-auto" />
			</div>
			<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
				<?php
				$srv = array(
					array( 'building2', 'Kancelářský nábytek', 'Stoly, skříně, recepce, konferenční místnosti – vše na míru pro vaši firmu.' ),
					array( 'wrench', 'Obchodní prostory', 'Pulty, regály, výstavní vitríny a interiéry prodejen podle vašeho CI.' ),
					array( 'users', 'Hotely a restaurace', 'Barové pulty, stoly, sedací nábytek, recepce a dekorativní prvky.' ),
					array( 'file-text', 'Developerské projekty', 'Spolupráce na bytových i komerčních projektech – kuchyně, vestavěný nábytek pro celé domy.' ),
					array( 'clock', 'Servis a opravy', 'Opravy a renovace stávajícího nábytku, doplnění stávajícího vybavení.' ),
					array( 'check', 'Rámcové smlouvy', 'Dlouhodobá spolupráce s výhodami – prioritní termíny, individuální ceník, platba na fakturu.' ),
				);
				foreach ( $srv as $s ) : ?>
					<div class="p-7 rounded-xl" data-reveal style="background-color: oklch(0.99 0.005 80); box-shadow: 0 2px 12px oklch(0.25 0.04 40 / 0.07);">
						<div class="mb-4" style="color: oklch(0.62 0.12 55);"><?php jipech_icon( $s[0], 24 ); ?></div>
						<h3 class="text-lg font-bold mb-2" style="font-family: 'Playfair Display', serif;"><?php echo esc_html( $s[1] ); ?></h3>
						<p class="text-sm leading-relaxed" style="color: oklch(0.45 0.03 50);"><?php echo esc_html( $s[2] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Form -->
	<section id="b2b-form" class="py-16" style="background-color: oklch(0.93 0.02 70);">
		<div class="container max-w-3xl">
			<div class="text-center mb-12">
				<p class="section-label mb-3">Firemní poptávka</p>
				<h2 class="text-3xl md:text-4xl font-bold" style="font-family: 'Playfair Display', serif;">Nezávazná B2B poptávka</h2>
				<hr class="wood-divider mt-6 max-w-xs mx-auto" />
			</div>

			<?php if ( $sent ) : ?>
				<div class="rounded-xl p-12 text-center" style="background-color: oklch(0.99 0.005 80);">
					<?php jipech_icon( 'check', 64, 'mx-auto mb-5', 'color: oklch(0.32 0.09 145);' ); ?>
					<h3 class="text-2xl font-bold mb-3" style="font-family: 'Playfair Display', serif;">Firemní poptávka odeslána!</h3>
					<p class="text-base mb-6" style="color: oklch(0.40 0.03 45);">Děkujeme za váš zájem o spolupráci. Ozveme se vám do 24 hodin v pracovní dny. Pro rychlejší odpověď nás zavolejte.</p>
					<a href="<?php echo esc_attr( $phone_href ); ?>" class="inline-flex items-center gap-2 px-8 py-4 rounded font-bold text-lg" style="background-color: oklch(0.32 0.09 145); color: white; font-family: 'Montserrat', sans-serif;"><?php jipech_icon( 'phone', 20 ); ?> <?php echo esc_html( $phone ); ?></a>
				</div>
			<?php else : ?>
				<form class="rounded-xl p-8 space-y-5" data-contact-form data-form-type="b2b" data-ajax="1" method="post" action="<?php echo $post_url; // phpcs:ignore ?>" enctype="multipart/form-data" style="background-color: oklch(0.99 0.005 80);">
					<input type="hidden" name="action" value="jipech_submit" />
					<input type="hidden" name="jipech_form_type" value="b2b" />
					<input type="hidden" name="jipech_nonce" value="<?php echo esc_attr( $nonce ); ?>" />
					<input type="text" name="website" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;" aria-hidden="true" />
					<h3 class="text-xl font-bold mb-1" style="font-family: 'Playfair Display', serif;">Firemní kontaktní formulář</h3>
					<p class="text-sm mb-4" style="color: oklch(0.45 0.03 50);">Vyplňte formulář a my vás kontaktujeme s nabídkou na míru pro vaši firmu.</p>

					<div class="pb-2">
						<p class="text-xs uppercase tracking-widest font-bold mb-3" style="font-family: 'Montserrat', sans-serif; color: oklch(0.62 0.12 55);">Firemní údaje</p>
						<div class="grid sm:grid-cols-2 gap-4">
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Název firmy *</label>
								<input type="text" name="company" required placeholder="ABC s.r.o." class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2" style="background-color: white; border-color: oklch(0.87 0.03 65);" />
							</div>
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">IČO</label>
								<input type="text" name="ico" placeholder="12345678" class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2" style="background-color: white; border-color: oklch(0.87 0.03 65);" />
							</div>
						</div>
					</div>

					<div class="pb-2">
						<p class="text-xs uppercase tracking-widest font-bold mb-3" style="font-family: 'Montserrat', sans-serif; color: oklch(0.62 0.12 55);">Kontaktní osoba</p>
						<div class="grid sm:grid-cols-2 gap-4">
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Jméno a příjmení *</label>
								<input type="text" name="contactName" required placeholder="Jan Novák" class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2" style="background-color: white; border-color: oklch(0.87 0.03 65);" />
							</div>
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Telefon *</label>
								<input type="tel" name="phone" required placeholder="+420 xxx xxx xxx" class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2" style="background-color: white; border-color: oklch(0.87 0.03 65);" />
							</div>
						</div>
						<div class="mt-4">
							<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Firemní email</label>
							<input type="email" name="email" placeholder="jan.novak@firma.cz" class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2" style="background-color: white; border-color: oklch(0.87 0.03 65);" />
						</div>
					</div>

					<div class="pb-2">
						<p class="text-xs uppercase tracking-widest font-bold mb-3" style="font-family: 'Montserrat', sans-serif; color: oklch(0.62 0.12 55);">Projekt</p>
						<div class="grid sm:grid-cols-2 gap-4">
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Typ projektu *</label>
								<select name="projectType" required class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2 appearance-none" style="background-color: white; border-color: oklch(0.87 0.03 65);">
									<option value="" disabled selected>— Typ projektu —</option>
									<option value="kancelare">Kancelářské prostory</option>
									<option value="obchod">Obchodní prostory / prodejna</option>
									<option value="hotel">Hotel / penzion</option>
									<option value="restaurace">Restaurace / kavárna / bar</option>
									<option value="developer">Developerský projekt</option>
									<option value="jine">Jiné</option>
								</select>
							</div>
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Počet kusů / jednotek</label>
								<input type="text" name="units" placeholder="např. 10 kancelářských stolů" class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2" style="background-color: white; border-color: oklch(0.87 0.03 65);" />
							</div>
						</div>
						<div class="grid sm:grid-cols-2 gap-4 mt-4">
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Očekávaný termín dodání *</label>
								<select name="deliveryTerm" required class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2 appearance-none" style="background-color: white; border-color: oklch(0.87 0.03 65);">
									<option value="" disabled selected>— Vyberte termín —</option>
									<option value="3-6-mesicu">3–6 měsíců</option>
									<option value="6-12-mesicu">6–12 měsíců</option>
									<option value="vice-nez-rok">Více než rok</option>
									<option value="zatim-neznam">Zatím nevím</option>
								</select>
							</div>
							<div>
								<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Lokalita realizace *</label>
								<input type="text" name="locality" required placeholder="Město / kraj" class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2" style="background-color: white; border-color: oklch(0.87 0.03 65);" />
							</div>
						</div>
					</div>

					<div>
						<label class="block text-xs uppercase tracking-wider mb-3 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Předpokládaný rozpočet projektu</label>
						<div class="rounded-lg p-4" style="background-color: oklch(0.95 0.02 70);">
							<div class="flex justify-between items-baseline mb-4">
								<span class="text-xs" style="color: oklch(0.55 0.03 50);">Vaše představa o rozpočtu:</span>
								<span class="text-lg font-bold" data-budget-value style="font-family: 'Montserrat', sans-serif; color: oklch(0.32 0.09 145);">200 000 Kč</span>
							</div>
							<div class="relative px-1" data-slider>
								<div class="relative h-2 rounded-full" style="background-color: oklch(0.82 0.04 65);">
									<div class="absolute top-0 left-0 h-2 rounded-full" data-slider-fill style="width: 15.79%; background-color: oklch(0.62 0.12 55);"></div>
								</div>
								<input type="range" name="budget" min="50000" max="1000000" step="10000" value="200000" class="absolute inset-0 w-full opacity-0 cursor-pointer" style="height: 2rem; top: -0.75rem;" />
								<div class="absolute w-5 h-5 rounded-full border-2 shadow-md pointer-events-none" data-slider-thumb style="left: calc(15.79% - 10px); top: -5px; background-color: white; border-color: oklch(0.62 0.12 55); box-shadow: 0 2px 6px oklch(0.25 0.04 40 / 0.25);"></div>
							</div>
							<div class="flex justify-between mt-3">
								<span class="text-xs" style="color: oklch(0.55 0.03 50);">50 000 Kč</span>
								<span class="text-xs" style="color: oklch(0.55 0.03 50);">1 000 000 Kč+</span>
							</div>
						</div>
					</div>

					<div>
						<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Popis projektu</label>
						<textarea rows="5" name="message" placeholder="Popište váš projekt – co potřebujete, v jakém rozsahu, specifické požadavky na materiál nebo design..." class="w-full px-4 py-3 rounded-lg border text-sm outline-none focus:ring-2 resize-none" style="background-color: white; border-color: oklch(0.87 0.03 65);"></textarea>
					</div>

					<div>
						<label class="block text-xs uppercase tracking-wider mb-1.5 font-semibold" style="font-family: 'Montserrat', sans-serif; color: oklch(0.45 0.03 50);">Přílohy (nákresy, výkresy, fotografie)</label>
						<div class="relative flex flex-col items-center justify-center gap-2 px-4 py-6 rounded-lg border-2 border-dashed cursor-pointer transition-all" data-dropzone style="border-color: oklch(0.82 0.04 65); background-color: oklch(0.98 0.01 80);">
							<input id="file-upload-b2b" type="file" name="files[]" multiple accept="image/*,.pdf,.dwg,.dxf" class="hidden" />
							<?php jipech_icon( 'upload', 32, '', 'color: oklch(0.62 0.12 55);' ); ?>
							<p class="text-sm font-semibold" style="color: oklch(0.35 0.04 50);">Přetáhněte soubory sem nebo <span style="color: oklch(0.62 0.12 55);">klikněte pro výběr</span></p>
							<p class="text-xs" style="color: oklch(0.60 0.03 55);">Fotografie, PDF, výkresy DWG/DXF – max. 5 souborů, každý do 10 MB</p>
						</div>
						<ul class="mt-3 space-y-2" data-file-list></ul>
					</div>

					<p class="text-sm font-semibold" data-form-error style="color: oklch(0.577 0.245 27.325); <?php echo $form_err ? '' : 'display:none;'; ?>"><?php echo esc_html( $form_err ); ?></p>

					<button type="submit" class="w-full py-4 rounded-lg font-bold text-base transition-all hover:scale-[1.02] hover:shadow-lg" style="background-color: oklch(0.25 0.04 40); color: white; font-family: 'Montserrat', sans-serif;">Odeslat firemní poptávku</button>
					<p class="text-xs text-center" style="color: oklch(0.55 0.03 50);">* Povinné pole. Nebo nás rovnou zavolejte: <a href="<?php echo esc_attr( $phone_href ); ?>" class="font-bold hover:underline" style="color: oklch(0.32 0.09 145);"><?php echo esc_html( $phone ); ?></a></p>
				</form>
			<?php endif; ?>
		</div>
	</section>

	<!-- Footer mini -->
	<footer style="background-color: oklch(0.18 0.03 40);" class="py-8">
		<div class="container flex flex-col sm:flex-row items-center justify-between gap-4">
			<div class="flex items-center gap-4">
				<img src="<?php echo esc_url( $logo ); ?>" alt="JIPECH" class="h-12 w-auto" style="filter: brightness(1.2);" />
				<div>
					<p class="text-sm font-semibold" style="color: white;">Truhlářství Jiří Pecháček</p>
					<p class="text-xs" style="color: oklch(0.65 0.02 60);"><?php echo esc_html( jipech_contact( 'address_line1' ) . ' ' . jipech_contact( 'address_line2' ) ); ?></p>
				</div>
			</div>
			<div class="flex items-center gap-5">
				<a href="<?php echo esc_attr( $phone_href ); ?>" class="flex items-center gap-2 text-sm font-bold hover:underline" style="color: white;"><?php jipech_icon( 'phone', 15, '', 'color: oklch(0.62 0.12 55);' ); ?> <?php echo esc_html( $phone ); ?></a>
				<a href="mailto:<?php echo esc_attr( $email ); ?>" class="flex items-center gap-2 text-sm hover:underline" style="color: oklch(0.72 0.02 70);"><?php jipech_icon( 'mail', 15, '', 'color: oklch(0.62 0.12 55);' ); ?> <?php echo esc_html( $email ); ?></a>
			</div>
		</div>
	</footer>
</div>
<?php
get_footer();
