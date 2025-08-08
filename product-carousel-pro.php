<?php
/**
 * Plugin Name: BD Product Carousel Pro
 * Description: Displays a responsive product carousel from WooCommerce, with options for latest, sale, featured, best-sellers, and more.
 * Version: 2.6.0
 * Author: Buene Data
 * Author URI: https://buenedata.no
 * Plugin URI: https://github.com/buenedata/bd-product-carousel-pro
 * Update URI: https://github.com/buenedata/bd-product-carousel-pro
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Network: false
 * Text Domain: product-carousel-pro
 * Domain Path: /languages
 */

defined('ABSPATH') || exit;

// Plugin constants
define('BD_PRODUCT_CAROUSEL_PRO_VERSION', '2.6.0');
define('BD_PRODUCT_CAROUSEL_PRO_FILE', __FILE__);
define('BD_PRODUCT_CAROUSEL_PRO_PATH', plugin_dir_path(__FILE__));
define('BD_PRODUCT_CAROUSEL_PRO_URL', plugin_dir_url(__FILE__));
define('BD_PRODUCT_CAROUSEL_PRO_BASENAME', plugin_basename(__FILE__));

// Initialize updater
if (is_admin()) {
    require_once BD_PRODUCT_CAROUSEL_PRO_PATH . 'includes/class-bd-updater.php';
    new BD_Plugin_Updater(BD_PRODUCT_CAROUSEL_PRO_FILE, 'buenedata', 'bd-product-carousel-pro');
}

// Include BD Menu Helper
require_once plugin_dir_path(__FILE__) . 'bd-menu-helper.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';


function bdpc_enqueue_styles() {
    wp_enqueue_style('bdpc-carousel-style', plugin_dir_url(__FILE__) . 'assets/style.css');
}
add_action('wp_enqueue_scripts', 'bdpc_enqueue_styles');

// Enqueue admin styles
function bdpc_enqueue_admin_styles($hook) {
    // Only load on our admin page
    if ($hook !== 'buene-data_page_bd-product-carousel-pro') {
        return;
    }
    
    // Enqueue WordPress default admin styles that work well with our design
    wp_enqueue_style('wp-admin');
    wp_enqueue_style('common');
    wp_enqueue_style('forms');
}
add_action('admin_enqueue_scripts', 'bdpc_enqueue_admin_styles');

// Check WooCommerce dependency
function bdpc_check_woocommerce_dependency() {
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p><strong>BD Product Carousel Pro:</strong> Dette pluginet krever WooCommerce for å fungere. Vennligst installer og aktiver WooCommerce.</p></div>';
        });
        return false;
    }
    return true;
}

// Initialize plugin only if WooCommerce is active
function bdpc_initialize_plugin() {
    if (bdpc_check_woocommerce_dependency()) {
        // Plugin is ready to use
        add_action('init', function() {
            // Add any initialization code here
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('BD Product Carousel Pro: Plugin initialized successfully');
            }
        });
    }
}
add_action('plugins_loaded', 'bdpc_initialize_plugin');

// Add plugin action links
function bdpc_add_action_links($links) {
    $action_links = array(
        'settings' => '<a href="' . admin_url('admin.php?page=bd-product-carousel-pro') . '">Innstillinger</a>',
    );
    return array_merge($action_links, $links);
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'bdpc_add_action_links');

// Add plugin meta links
function bdpc_add_meta_links($links, $file) {
    if ($file === plugin_basename(__FILE__)) {
        $links[] = '<a href="https://buenedata.no" target="_blank">Buene Data</a>';
        $links[] = '<a href="mailto:support@buenedata.no">Support</a>';
    }
    return $links;
}
add_filter('plugin_row_meta', 'bdpc_add_meta_links', 10, 2);

// Plugin activation hook
function bdpc_activate_plugin() {
    // Check if WooCommerce is installed
    if (!class_exists('WooCommerce')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(
            __('BD Product Carousel Pro krever WooCommerce for å fungere. Vennligst installer og aktiver WooCommerce først.', 'product-carousel-pro'),
            __('Plugin Activation Error', 'product-carousel-pro'),
            array('back_link' => true)
        );
    }
    
    // Set default options if they don't exist
    if (!get_option('bdpc_version')) {
        add_option('bdpc_version', '2.0.0');
        add_option('bdpc_activation_date', current_time('mysql'));
    }
}
register_activation_hook(__FILE__, 'bdpc_activate_plugin');

// Plugin deactivation hook
function bdpc_deactivate_plugin() {
    // Clean up if needed (but preserve settings)
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('BD Product Carousel Pro: Plugin deactivated');
    }
}
register_deactivation_hook(__FILE__, 'bdpc_deactivate_plugin');
