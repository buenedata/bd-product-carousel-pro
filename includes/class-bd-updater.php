<?php
/**
 * BD Plugin Updater
 * Håndterer automatisk oppdatering via GitHub
 *
 * @package BD_Product_Carousel_Pro
 * @since 2.6.0
 *
 * Note: Intelephense errors about undefined WordPress functions are normal
 * when not running in WordPress environment. These are not real errors.
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('BD_Product_Carousel_Updater')) {
class BD_Product_Carousel_Updater {
    private $plugin_file;
    private $github_username;
    private $github_repo;
    private $version;
    private $plugin_slug;
    private $plugin_basename;

    public function __construct($plugin_file, $github_username, $github_repo) {
        $this->plugin_file = $plugin_file;
        $this->github_username = $github_username;
        $this->github_repo = $github_repo;
        $this->plugin_basename = plugin_basename($plugin_file);
        
        // Fix plugin slug - use the repository name instead of directory name
        $this->plugin_slug = $github_repo;
        
        // Get version from plugin header
        if (!function_exists('get_plugin_data')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $plugin_data = get_plugin_data($plugin_file);
        $this->version = $plugin_data['Version'];

        // Hook into WordPress update system
        add_filter('pre_set_site_transient_update_plugins', [$this, 'check_for_update']);
        add_filter('plugins_api', [$this, 'plugin_info'], 20, 3);
        add_filter('upgrader_pre_download', [$this, 'download_package'], 10, 3);
        
        // Add debug logging
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log("BD_Plugin_Updater initialized for {$this->plugin_basename} (slug: {$this->plugin_slug}, version: {$this->version})");
        }
    }

    /**
     * Check for plugin updates
     */
    public function check_for_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        // Only check if our plugin is in the checked list
        if (!isset($transient->checked[$this->plugin_basename])) {
            return $transient;
        }

        // Get remote version
        $remote_version = $this->get_remote_version();
        
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log("BD Update Check: Current version: {$this->version}, Remote version: {$remote_version}");
        }
        
        if (version_compare($this->version, $remote_version, '<')) {
            $transient->response[$this->plugin_basename] = (object) [
                'slug' => $this->plugin_slug,
                'plugin' => $this->plugin_basename,
                'new_version' => $remote_version,
                'url' => "https://github.com/{$this->github_username}/{$this->github_repo}",
                'package' => $this->get_download_url($remote_version),
                'tested' => '6.4',
                'requires_php' => '7.4',
                'compatibility' => new stdClass(),
                'id' => $this->plugin_basename,
            ];
            
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log("BD Update Available: {$this->plugin_basename} can be updated from {$this->version} to {$remote_version}");
            }
        } else {
            // Remove from response if no update needed
            unset($transient->response[$this->plugin_basename]);
            
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log("BD Update Check: No update needed for {$this->plugin_basename}");
            }
        }

        return $transient;
    }

    /**
     * Get remote version from GitHub
     */
    private function get_remote_version() {
        // Use transient to cache the result for 12 hours
        $cache_key = 'bd_update_' . md5($this->plugin_basename);
        $cached_version = get_transient($cache_key);
        
        if ($cached_version !== false) {
            return $cached_version;
        }
        
        $request = wp_remote_get("https://api.github.com/repos/{$this->github_username}/{$this->github_repo}/releases/latest", [
            'timeout' => 10,
            'headers' => [
                'User-Agent' => 'BD-Plugin-Updater/1.0'
            ]
        ]);
        
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log("BD GitHub API Request: " . wp_remote_retrieve_response_code($request));
        }
        
        if (!is_wp_error($request) && wp_remote_retrieve_response_code($request) === 200) {
            $body = wp_remote_retrieve_body($request);
            $data = json_decode($body, true);
            
            if (isset($data['tag_name'])) {
                $version = ltrim($data['tag_name'], 'v');
                // Cache for 12 hours
                set_transient($cache_key, $version, 12 * HOUR_IN_SECONDS);
                return $version;
            }
        } else {
            if (defined('WP_DEBUG') && WP_DEBUG) {
                $error_message = is_wp_error($request) ? $request->get_error_message() : 'HTTP ' . wp_remote_retrieve_response_code($request);
                error_log("BD GitHub API Error: " . $error_message);
            }
        }

        return $this->version;
    }

    /**
     * Get download URL for specific version
     */
    private function get_download_url($version) {
        return "https://github.com/{$this->github_username}/{$this->github_repo}/releases/download/v{$version}/{$this->github_repo}.zip";
    }

    /**
     * Provide plugin information for update screen
     */
    public function plugin_info($result, $action, $args) {
        // Check if this is a request for our plugin
        if ($action !== 'plugin_information') {
            return $result;
        }
        
        // Check if the slug matches our plugin
        if (!isset($args->slug) || $args->slug !== $this->plugin_slug) {
            return $result;
        }

        $request = wp_remote_get("https://api.github.com/repos/{$this->github_username}/{$this->github_repo}/releases/latest", [
            'timeout' => 10,
            'headers' => [
                'User-Agent' => 'BD-Plugin-Updater/1.0'
            ]
        ]);
        
        if (!is_wp_error($request) && wp_remote_retrieve_response_code($request) === 200) {
            $body = wp_remote_retrieve_body($request);
            $data = json_decode($body, true);
            
            $result = (object) [
                'name' => $data['name'] ?? 'BD Product Carousel Pro',
                'slug' => $this->plugin_slug,
                'version' => ltrim($data['tag_name'] ?? $this->version, 'v'),
                'author' => '<a href="https://buenedata.no">Buene Data</a>',
                'author_profile' => 'https://buenedata.no',
                'homepage' => "https://github.com/{$this->github_username}/{$this->github_repo}",
                'short_description' => 'Displays a responsive product carousel from WooCommerce, with options for latest, sale, featured, best-sellers, and more.',
                'sections' => [
                    'description' => $this->format_description($data['body'] ?? 'Ingen beskrivelse tilgjengelig.'),
                    'changelog' => $this->format_changelog($data['body'] ?? 'Se GitHub for endringer.'),
                    'installation' => 'Last ned ZIP-filen og installer via WordPress Admin → Plugins → Legg til ny → Last opp plugin.',
                ],
                'download_link' => $this->get_download_url(ltrim($data['tag_name'] ?? $this->version, 'v')),
                'requires' => '5.0',
                'tested' => '6.4',
                'requires_php' => '7.4',
                'last_updated' => $data['published_at'] ?? date('Y-m-d H:i:s'),
                'active_installs' => false,
                'downloaded' => false,
            ];
            
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log("BD Plugin Info: Returning info for {$this->plugin_slug}");
            }
        }

        return $result;
    }
    
    /**
     * Format description from GitHub release
     */
    private function format_description($body) {
        // Convert markdown-style formatting to HTML
        $description = wp_kses_post($body);
        $description = wpautop($description);
        return $description;
    }
    
    /**
     * Format changelog from GitHub release
     */
    private function format_changelog($body) {
        // Extract changelog section if it exists
        if (strpos($body, '### Nye funksjoner og forbedringer:') !== false) {
            $parts = explode('### Nye funksjoner og forbedringer:', $body);
            if (isset($parts[1])) {
                $changelog = trim(explode('###', $parts[1])[0]);
                return wpautop(wp_kses_post($changelog));
            }
        }
        
        return wpautop(wp_kses_post($body));
    }

    /**
     * Download package from GitHub
     */
    public function download_package($result, $package, $upgrader) {
        if (strpos($package, 'github.com') === false) {
            return $result;
        }

        // WordPress will handle the download
        return $result;
    }
}
}