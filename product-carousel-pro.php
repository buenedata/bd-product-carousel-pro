<?php
/**
 * Plugin Name: BD Product Carousel Pro
 * Description: Displays a responsive product carousel from WooCommerce, with options for latest, sale, featured, best-sellers, and more.
 * Version: 2.0.0
 * Author: Buene Data
 * Author URI: https://buenedata.no
 * Text Domain: product-carousel-pro
 * Domain Path: /languages
 * Plugin URI: https://github.com/buenedata/bd-product-carousel-pro
 * GitHub Plugin URI: buenedata/bd-product-carousel-pro
 * Primary Branch: main
 */

defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/github-updater.php';

// Initialize GitHub updater
if (is_admin()) {
    new BD_Product_Carousel_GitHub_Updater(__FILE__, 'buenedata', 'product-carousel-pro');
}


function bdpc_enqueue_styles() {
    wp_enqueue_style('bdpc-carousel-style', plugin_dir_url(__FILE__) . 'assets/style.css');
}
add_action('wp_enqueue_scripts', 'bdpc_enqueue_styles');
