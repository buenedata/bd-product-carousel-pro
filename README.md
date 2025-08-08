# BD Product Carousel Pro

**Modern produktkarusell for WooCommerce med BD Design Guide v3.0**

## Nye funksjoner i v2.6.0

### 🎨 Moderne BD Design
- Implementert komplett BD Design Guide v3.0
- Moderne gradient-baserte farger og effekter
- Responsivt kort-basert design
- Avanserte hover-effekter og animasjoner
- Konsistent med andre BD-plugins

### 🔧 Integrert BD Menu System
- Bruker bd-menu-helper.php for unified admin opplevelse
- Automatisk integrering i Buene Data hovedmeny
- 🎠 ikon for enkel gjenkjenning

### 📱 Forbedret Admin Interface
- Moderne tab-basert grensesnitt
- Live shortcode generering
- Integrert dokumentasjon
- Forbedret forhåndsvisning
- Responsiv admin design

### ⚡ Avanserte Carousel Funksjoner
- Dynamisk hastighet per carousel
- Forbedret touch-støtte
- Pagination med dynamiske bullets
- Bedre tilgjengelighet (a11y)
- Optimalisert for mobile enheter

## Installasjon og Oppsett

1. Aktiver pluginen i WordPress admin
2. Gå til **Buene Data → 🎠 Product Carousel Pro**
3. Bruk shortcode-generatoren for å lage tilpassede karuseller
4. Kopier og lim inn shortcode på ønsket side/innlegg
4. Use the shortcode generator in the admin panel under "Product Carousel Pro"

## 🚀 Automatisk Oppdatering via GitHub

Dette pluginet bruker BD GitHub Update System for automatisk oppdatering direkte fra GitHub.

### ✨ Funksjoner
- **Automatiske releases** via GitHub Actions når du pusher endringer
- **WordPress-native oppdateringsnotifikasjoner** i admin-panelet
- **En-klikks oppdatering** direkte i WordPress
- **Versjonshåndtering** og changelog-generering
- **Sikker nedlasting** og installasjon

### 🔧 Implementering Fullført

Pluginet er nå konfigurert med:

1. **Moderne BD_Plugin_Updater klasse** (`includes/class-bd-updater.php`)
2. **GitHub Actions workflow** (`.github/workflows/release.yml`)
3. **Oppdatert plugin header** med Update URI
4. **Automatisk release-generering** ved push til main branch

### 📋 Slik fungerer det

1. **Push endringer** til GitHub via GitHub Desktop
2. **GitHub Actions** oppdager endringer og lager automatisk release
3. **WordPress** sjekker for oppdateringer via standard API
4. **Brukere** får notifikasjon i WordPress admin
5. **En-klikks oppdatering** installerer ny versjon

### 🔄 Release Prosess

For å lage en ny versjon:

1. Oppdater versjonsnummer i `product-carousel-pro.php`
2. Commit og push endringene til GitHub
3. GitHub Actions lager automatisk en release med:
   - ZIP-fil av pluginet
   - Automatisk generert changelog
   - Versjonstagging

### 📖 Dokumentasjon

Se `BD-GitHub-Update-System-Guide.txt` for komplett dokumentasjon av systemet.

## Usage

Use the admin panel to generate shortcodes:

1. Go to WordPress Admin → Product Carousel Pro
2. Configure your settings
3. Copy the generated shortcode
4. Paste it into any post, page, or widget

Example shortcode:
```
[bd_product_carousel mode="latest" limit="8" shadow="true"]
```

## Support

For support and questions, please visit [Buene Data](https://buenedata.no)

## License

This plugin is proprietary software. All rights reserved.
