<?php
/**
 * Debug version of plugin to find WSOD cause
 */

// Prevent direct access
defined('ABSPATH') || exit;

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Debug: Plugin loading started...<br>";

// Plugin constants
define('BD_PRODUCT_CAROUSEL_PRO_VERSION', '2.6.2');
define('BD_PRODUCT_CAROUSEL_PRO_FILE', __FILE__);
define('BD_PRODUCT_CAROUSEL_PRO_PATH', plugin_dir_path(__FILE__));
define('BD_PRODUCT_CAROUSEL_PRO_URL', plugin_dir_url(__FILE__));
define('BD_PRODUCT_CAROUSEL_PRO_BASENAME', plugin_basename(__FILE__));

echo "Debug: Constants defined...<br>";

// Test updater class
if (is_admin() && file_exists(BD_PRODUCT_CAROUSEL_PRO_PATH . 'includes/class-bd-updater.php')) {
    echo "Debug: Loading updater class...<br>";
    try {
        require_once BD_PRODUCT_CAROUSEL_PRO_PATH . 'includes/class-bd-updater.php';
        echo "Debug: Updater class loaded...<br>";
        
        if (class_exists('BD_Plugin_Updater')) {
            echo "Debug: Creating updater instance...<br>";
            new BD_Plugin_Updater(BD_PRODUCT_CAROUSEL_PRO_FILE, 'buenedata', 'bd-product-carousel-pro');
            echo "Debug: Updater instance created...<br>";
        } else {
            echo "Debug: BD_Plugin_Updater class not found!<br>";
        }
    } catch (Exception $e) {
        echo "Debug: Error loading updater: " . $e->getMessage() . "<br>";
    }
}

// Test other includes
$files_to_test = [
    'bd-menu-helper.php',
    'includes/shortcode.php',
    'includes/admin-page.php'
];

foreach ($files_to_test as $file) {
    $full_path = plugin_dir_path(__FILE__) . $file;
    if (file_exists($full_path)) {
        echo "Debug: Loading $file...<br>";
        try {
            require_once $full_path;
            echo "Debug: $file loaded successfully...<br>";
        } catch (Exception $e) {
            echo "Debug: Error loading $file: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "Debug: $file not found!<br>";
    }
}

echo "Debug: Plugin loading completed!<br>";