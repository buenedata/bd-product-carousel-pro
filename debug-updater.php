<?php
/**
 * Simple debug script - add this to functions.php temporarily
 */

// Force WordPress to check for updates every time
add_filter('pre_set_site_transient_update_plugins', function($transient) {
    error_log('BD Debug: pre_set_site_transient_update_plugins called');
    error_log('BD Debug: Transient data: ' . print_r($transient, true));
    return $transient;
});

// Log when our updater is initialized
add_action('init', function() {
    if (is_admin()) {
        error_log('BD Debug: WordPress admin init - updater should be loaded');
    }
});

// Force update check on plugins page
add_action('load-plugins.php', function() {
    error_log('BD Debug: Plugins page loaded - forcing update check');
    delete_site_transient('update_plugins');
});