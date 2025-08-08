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

// Create updater instance
$updater = new BD_Plugin_Updater(
    plugin_dir_path(__FILE__) . 'product-carousel-pro.php',
    'buenedata',
    'bd-product-carousel-pro'
);

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
        echo '<p>Latest Release: ' . ($data['tag_name'] ?? 'Unknown') . '</p>';
        echo '<p>Published: ' . ($data['published_at'] ?? 'Unknown') . '</p>';
    }
}

// Test plugin data
echo '<h3>Plugin Data</h3>';
if (!function_exists('get_plugin_data')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
$plugin_data = get_plugin_data(plugin_dir_path(__FILE__) . 'product-carousel-pro.php');
echo '<p>Current Version: ' . $plugin_data['Version'] . '</p>';
echo '<p>Plugin Basename: ' . plugin_basename(plugin_dir_path(__FILE__) . 'product-carousel-pro.php') . '</p>';

// Test update check
echo '<h3>Update Check Test</h3>';
$transient = new stdClass();
$transient->checked = [];
$transient->response = [];

// Add our plugin to the checked list
$plugin_basename = plugin_basename(plugin_dir_path(__FILE__) . 'product-carousel-pro.php');
$transient->checked[$plugin_basename] = $plugin_data['Version'];

// Simulate update check
$result = $updater->check_for_update($transient);

if (isset($result->response[$plugin_basename])) {
    echo '<p style="color: green;">Update Available!</p>';
    echo '<pre>' . print_r($result->response[$plugin_basename], true) . '</pre>';
} else {
    echo '<p style="color: orange;">No update available or update check failed.</p>';
}

// Clear update cache
echo '<h3>Cache Management</h3>';
$cache_key = 'bd_update_' . md5($plugin_basename);
delete_transient($cache_key);
echo '<p>Update cache cleared. Next check will fetch fresh data.</p>';

echo '<p><a href="' . admin_url('plugins.php') . '">Go to Plugins Page</a></p>';