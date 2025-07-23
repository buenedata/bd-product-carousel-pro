# BD Product Carousel Pro

**Modern produktkarusell for WooCommerce med BD Design Guide v3.0**

## Nye funksjoner i v2.0.0

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

## Automatic Updates via GitHub

This plugin supports automatic updates directly from GitHub. To enable this feature:

### Setup for Plugin Developers

1. **Update Plugin Header**: Ensure your main plugin file includes these headers:
   ```php
   Plugin URI: https://github.com/your-username/product-carousel-pro
   GitHub Plugin URI: your-username/product-carousel-pro
   Primary Branch: main
   ```

2. **Update GitHub Username**: In `product-carousel-pro.php`, replace `'your-username'` with your actual GitHub username:
   ```php
   new BD_Product_Carousel_GitHub_Updater(__FILE__, 'your-actual-username', 'product-carousel-pro');
   ```

3. **Create Releases**: When you want to release a new version:
   - Update the version number in the plugin header
   - Create a new release on GitHub with a tag (e.g., `v2.1.0`)
   - The plugin will automatically detect and offer updates to users

### For Private Repositories

If your repository is private, you'll need to provide an access token:

```php
new BD_Product_Carousel_GitHub_Updater(__FILE__, 'your-username', 'product-carousel-pro', 'your-github-token');
```

### Release Process

1. Make your changes and commit them
2. Update the version number in `product-carousel-pro.php`
3. Create a new release on GitHub:
   - Go to your repository
   - Click "Releases" → "Create a new release"
   - Tag version: `v2.1.0` (or your version number)
   - Release title: `Version 2.1.0`
   - Describe your changes in the release notes
   - Click "Publish release"

The plugin will automatically check for updates every 12 hours and notify users when a new version is available.

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
