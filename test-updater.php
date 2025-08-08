<?php
/**
 * Test script for BD Plugin Updater
 * Run this in WordPress admin to test the update system
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Only run for administrators
if (!current_user_can('manage_options')) {
    wp_die('Access denied');
}

echo '<h2>BD Plugin Updater Test</h2>';

// Include the updater class
require_once plugin_dir_path(__FILE__) . 'includes/class-bd-updater.php';

// Get plugin info
if (!function_exists('get_plugin_data')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
$plugin_file = plugin_dir_path(__FILE__) . 'product-carousel-pro.php';
$plugin_data = get_plugin_data($plugin_file);
$plugin_basename = plugin_basename($plugin_file);

echo '<h3>Plugin Information</h3>';
echo '<p><strong>Plugin File:</strong> ' . $plugin_file . '</p>';
echo '<p><strong>Plugin Basename:</strong> ' . $plugin_basename . '</p>';
echo '<p><strong>Current Version:</strong> ' . $plugin_data['Version'] . '</p>';
echo '<p><strong>Update URI:</strong> ' . ($plugin_data['UpdateURI'] ?? 'Not set') . '</p>';

// Test GitHub API connection
echo '<h3>GitHub API Test</h3>';
$api_url = 'https://api.github.com/repos/buenedata/bd-product-carousel-pro/releases/latest';
$response = wp_remote_get($api_url);

if (is_wp_error($response)) {
    echo '<p style="color: red;">Error: ' . $response->get_error_message() . '</p>';
} else {
    $code = wp_remote_retrieve_response_code($response);
    echo '<p style="color: ' . ($code === 200 ? 'green' : 'red') . ';">HTTP Response Code: ' . $code . '</p>';
    
    if ($code === 200) {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        $remote_version = ltrim($data['tag_name'] ?? '', 'v');
        echo '<p><strong>Latest Release:</strong> ' . ($data['tag_name'] ?? 'Unknown') . '</p>';
        echo '<p><strong>Remote Version:</strong> ' . $remote_version . '</p>';
        echo '<p><strong>Published:</strong> ' . ($data['published_at'] ?? 'Unknown') . '</p>';
        echo '<p><strong>Version Compare:</strong> ' . (version_compare($plugin_data['Version'], $remote_version, '<') ? 'UPDATE AVAILABLE' : 'UP TO DATE') . '</p>';
    }
}

// Create updater instance
$updater = new BD_Product_Carousel_Updater($plugin_file, 'buenedata', 'bd-product-carousel-pro');

// Test update check manually
echo '<h3>Manual Update Check</h3>';
$transient = new stdClass();
$transient->checked = [];
$transient->response = [];
$transient->checked[$plugin_basename] = $plugin_data['Version'];

echo '<p><strong>Simulating WordPress update check...</strong></p>';
$result = $updater->check_for_update($transient);

if (isset($result->response[$plugin_basename])) {
    echo '<p style="color: green; font-weight: bold;">✅ UPDATE AVAILABLE!</p>';
    echo '<pre style="background: #f0f0f0; padding: 10px;">' . print_r($result->response[$plugin_basename], true) . '</pre>';
} else {
    echo '<p style="color: red; font-weight: bold;">❌ NO UPDATE DETECTED</p>';
    echo '<p>This could mean:</p>';
    echo '<ul>';
    echo '<li>Current version is same or newer than remote</li>';
    echo '<li>GitHub API call failed</li>';
    echo '<li>Plugin slug mismatch</li>';
    echo '<li>Update logic error</li>';
    echo '</ul>';
}

// Test WordPress update system
echo '<h3>WordPress Update System Test</h3>';
$wp_transient = get_site_transient('update_plugins');
if ($wp_transient && isset($wp_transient->response[$plugin_basename])) {
    echo '<p style="color: green;">✅ Plugin found in WordPress update queue!</p>';
    echo '<pre style="background: #f0f0f0; padding: 10px;">' . print_r($wp_transient->response[$plugin_basename], true) . '</pre>';
} else {
    echo '<p style="color: orange;">⚠️ Plugin not found in WordPress update queue</p>';
    echo '<p>WordPress may not have checked for updates yet, or our updater is not working.</p>';
}

// Clear all caches
echo '<h3>Cache Management</h3>';
$cache_key = 'bd_update_' . md5($plugin_basename);
delete_transient($cache_key);
delete_site_transient('update_plugins');
echo '<p>✅ All update caches cleared</p>';

// Force WordPress to check for updates
echo '<h3>Force Update Check</h3>';
echo '<p><a href="' . admin_url('update-core.php?force-check=1') . '" class="button button-primary">Force WordPress Update Check</a></p>';
echo '<p><a href="' . admin_url('plugins.php') . '" class="button">Go to Plugins Page</a></p>';

// Debug info
echo '<h3>Debug Information</h3>';
echo '<p><strong>WP_DEBUG:</strong> ' . (defined('WP_DEBUG') && WP_DEBUG ? 'Enabled' : 'Disabled') . '</p>';
echo '<p><strong>WP_DEBUG_LOG:</strong> ' . (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG ? 'Enabled' : 'Disabled') . '</p>';
if (defined('WP_DEBUG') && WP_DEBUG) {
    echo '<p>Check /wp-content/debug.log for detailed logs</p>';
}