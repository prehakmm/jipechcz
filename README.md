# Truhlářství JIPECH – WordPress téma

1:1 přepis původního React/Tailwind webu <https://jipech.manus.space> do nativního WordPressu.
Design „Warm Craft Heritage" (Playfair Display + Montserrat + Source Sans 3, teplé tóny dřeva, amber akcent).

## Co téma umí

- **Úvodní strana** (`front-page.php`) – hero, telefonní banner, 16 služeb, „Dobře odvedená práce", O nás, Postup, galerie s lightboxem, přednosti, B2B sekce, reference, kontaktní formulář, patička.
- **Kuchyně** (šablona *Kuchyně – galerie realizací*) – filtr realizací A–M, 146 fotek, lightbox s klávesnicí.
- **Pro firmy / B2B** (šablona *B2B – Pro firmy*) – firemní poptávkový formulář.
- **Galerie přes CPT „Realizace"** – spravovatelné v administraci (metabox s výběrem více fotek + řazení).
- **Formuláře** – odesílání e-mailem přes `wp_mail` (doručení řeší váš SMTP plugin), včetně příloh, honeypot proti spamu, plus fallback bez JavaScriptu.
- **Bez build-závislostí** – Tailwind je předkompilovaný v `assets/css/theme.css`.

## Požadavky

- WordPress 6.2+
- PHP 7.4+
- SMTP plugin (např. WP Mail SMTP / FluentSMTP) pro doručování formulářů

## Instalace

1. **Nahrání tématu:** Vzhled → Motivy → Přidat nový → Nahrát motiv → vyberte `jipech-theme.zip` → Instalovat → Aktivovat.
2. **Trvalé odkazy:** Nastavení → Trvalé odkazy → Uložit změny (obnoví strukturu URL).
3. **Podstránky:** Stránky → Vytvořit novou:
   - stránka **Kuchyně** (doporučený slug `kuchyne`) → vpravo *Atributy stránky → Šablona* = **Kuchyně – galerie realizací** → Publikovat.
   - stránka **Pro firmy** (slug `b2b`) → Šablona = **B2B – Pro firmy** → Publikovat.
   (Úvodní strana funguje automaticky – `front-page.php`.)
4. **Import obsahu:** Realizace → **Import obsahu** → *Spustit import*.
   Stáhne všechny obrázky z původního CDN do Knihovny médií a založí:
   - 13 realizací kuchyní (A–M) pro podstránku Kuchyně,
   - 5 ukázek pro galerii na úvodní straně,
   - logo, hero, dílnu a ceduli pro šablony.
   Import běží dávkově – lze spustit opakovaně, již stažené obrázky se přeskočí.
5. **SMTP plugin:** nainstalujte a nakonfigurujte odesílání e-mailů. Poptávky chodí na `jipech@jipech.cz`.

## Správa obsahu

- **Galerie kuchyní / ukázky:** Realizace → konkrétní položka → metabox *Fotogalerie realizace* (přidat/odebrat/přeřadit fotky). Zaškrtnutím *Zobrazit jako ukázku na úvodní straně* se realizace použije v úvodní galerii dané kategorie.
- **Kategorie úvodní galerie:** Realizace → Kategorie (Kuchyně, Obývací pokoje, Schody, Stoly, Pergoly).
- **Logo:** importér nastaví logo automaticky; případně změňte přes Vzhled → Přizpůsobit → Logo, nebo nahraďte obrázek v médiích.

## Kontaktní údaje (telefon, e-mail, adresa, příjemce poptávek)

Na jednom místě – funkce `jipech_contact()` v `functions.php`, nebo přepis filtrem:

```php
add_filter( 'jipech_contact', function ( $data ) {
    $data['form_recipient'] = 'poptavky@jipech.cz';
    return $data;
} );
```

## Poznámky

- **Barvy** jsou v OKLCH (jako originál). Globální design tokeny jsou v `assets/css/theme.css` (kompilováno z `../build/input.css`).
- **Rekompilace CSS** (jen při zásahu do tříd/tokenů): ve složce `../build/` spusťte `./tailwindcss -i input.css -o ../jipech-theme/assets/css/theme.css --minify`.
- **Statická referenční verze** webu je v `../build/static/` (index.html, kuchyne.html, b2b.html) – slouží pro vizuální porovnání 1:1.

## Automatické aktualizace z GitHubu (Git Updater)

Téma je připravené k aktualizacím přímo z repozitáře **github.com/prehakmm/jipechcz** –
WordPress si stahuje novou verzi přes HTTPS (žádné FTP, funguje i s geo-omezením FTP účtu).

**Jednorázové nastavení ve WordPressu:**
1. Nainstalujte plugin **Git Updater** (zdarma, <https://git-updater.com> → stáhnout ZIP → Pluginy → Nahrát plugin → Aktivovat).
2. **Git Updater → Install Theme** → zadejte `prehakmm/jipechcz`, větev `main` → *Install* → *Aktivovat*.
   (Tím se téma nainstaluje rovnou z GitHubu; není potřeba zip ani FTP.)

**Automatické zvyšování verze (volitelné, doporučené):**
GitHub Action po každém pushi zvýší patch verzi ve `style.css`, aby WordPress viděl aktualizaci.
Soubor workflow je připravený lokálně v `.github/workflows/auto-version.yml`, ale **do gitu se neposílá**
(běžný přístupový token nemá scope `workflow`). Vytvořte ho proto **jednou přes web GitHubu**:

1. Repo → *Add file → Create new file* → název `.github/workflows/auto-version.yml`
2. Vložte obsah z lokálního souboru `.github/workflows/auto-version.yml` → *Commit*
3. Repo → *Settings → Actions → General → Workflow permissions* → **Read and write permissions** → *Save*

**Jak to pak funguje:**
- Každý `git push` do `main` spustí tuto Action → zvýší verzi → Git Updater ve WordPressu nabídne **Aktualizovat**.
- Bez workflow to funguje taky, jen verzi ve `style.css` zvýšíte ručně před pushem, když chcete vydat aktualizaci.
- Okamžitou kontrolu verzí vyvoláte přes *Nástroje → Git Updater → Refresh Cache*.
