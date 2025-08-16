<?php
/**
 * Plugin Name: IRANELEMENT
 * Plugin URI: https://iranelement.ir
 * Description: ایرانی‌سازی وردپرس و المنتور - امکان تنظیم فونت، سایز، وزن و استایل برای تگ‌های مختلف
 * Version: 1.0.0
 * Author: Sajjad Azizi
 * Author URI: https://iranelement.ir
 * License: GPL v2 or later
 * Text Domain: iranelement
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('IRANELEMENT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('IRANELEMENT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('IRANELEMENT_VERSION', '1.0.0');

class IranElement {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'));
        add_action('elementor/frontend/after_enqueue_styles', array($this, 'elementor_styles'));
        add_action('wp_head', array($this, 'add_custom_css'));
        add_action('admin_head', array($this, 'add_admin_custom_css'));
        add_action('admin_init', array($this, 'check_for_updates'));
        add_filter('pre_set_site_transient_update_plugins', array($this, 'check_plugin_update'));
        add_filter('plugins_api', array($this, 'plugin_info'), 10, 3);
        add_action('admin_notices', array($this, 'admin_update_notice'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    public function init() {
        load_plugin_textdomain('iranelement', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    public function activate() {
        // Set default options
        $default_options = array(
            'enable_vazir_font' => true,
            'dashboard_font' => true,
            'elementor_font' => true,
            'font_weights' => array('100', '200', '300', '400', '500', '600', '700', '800', '900'),
            'elementor_settings' => array(
                'h1' => array('font_family' => 'Vazirmatn', 'font_size' => '32px', 'font_weight' => '700', 'font_style' => 'normal'),
                'h2' => array('font_family' => 'Vazirmatn', 'font_size' => '28px', 'font_weight' => '600', 'font_style' => 'normal'),
                'h3' => array('font_family' => 'Vazirmatn', 'font_size' => '24px', 'font_weight' => '600', 'font_style' => 'normal'),
                'h4' => array('font_family' => 'Vazirmatn', 'font_size' => '20px', 'font_weight' => '500', 'font_style' => 'normal'),
                'h5' => array('font_family' => 'Vazirmatn', 'font_size' => '18px', 'font_weight' => '500', 'font_style' => 'normal'),
                'h6' => array('font_family' => 'Vazirmatn', 'font_size' => '16px', 'font_weight' => '500', 'font_style' => 'normal'),
                'p' => array('font_family' => 'Vazirmatn', 'font_size' => '16px', 'font_weight' => '400', 'font_style' => 'normal'),
                'span' => array('font_family' => 'Vazirmatn', 'font_size' => '14px', 'font_weight' => '400', 'font_style' => 'normal'),
                'a' => array('font_family' => 'Vazirmatn', 'font_size' => '16px', 'font_weight' => '400', 'font_style' => 'normal'),
                'button' => array('font_family' => 'Vazirmatn', 'font_size' => '16px', 'font_weight' => '500', 'font_style' => 'normal'),
            ),
            'global_settings' => array(
                'font_family' => 'Vazirmatn',
                'font_size' => '16px',
                'font_weight' => '400',
                'font_style' => 'normal'
            )
        );
        
        add_option('iranelement_options', $default_options);
    }
    
    public function deactivate() {
        // Cleanup if needed
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'ایران المنت',
            'ایران المنت',
            'manage_options',
            'iranelement',
            array($this, 'admin_page'),
            'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><defs><linearGradient id="iran" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" style="stop-color:#239F40;stop-opacity:1" /><stop offset="50%" style="stop-color:#FFFFFF;stop-opacity:1" /><stop offset="100%" style="stop-color:#DA0000;stop-opacity:1" /></linearGradient></defs><circle cx="12" cy="12" r="10" fill="url(#iran)" stroke="#333" stroke-width="1"/><circle cx="12" cy="12" r="3" fill="#DA0000"/><path d="M12 2v20M2 12h20" stroke="#DA0000" stroke-width="0.5" opacity="0.7"/></svg>'),
            30
        );
    }
    
    public function admin_scripts($hook) {
        if ($hook != 'settings_page_iranelement') {
            return;
        }
        
        // Load Vazirmatn font for admin panel
        wp_enqueue_style('vazir-font', IRANELEMENT_PLUGIN_URL . 'assets/fonts/vazirmatn.css', array(), IRANELEMENT_VERSION);
        wp_enqueue_style('iranelement-admin-style', IRANELEMENT_PLUGIN_URL . 'assets/css/admin.css', array('vazir-font'), IRANELEMENT_VERSION);
        wp_enqueue_script('iranelement-admin-script', IRANELEMENT_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), IRANELEMENT_VERSION, true);
        wp_localize_script('iranelement-admin-script', 'iranelement_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('iranelement_nonce')
        ));
    }
    
    public function frontend_scripts() {
        $options = get_option('iranelement_options');
        
        if (!empty($options['enable_vazir_font'])) {
            wp_enqueue_style('vazir-font', IRANELEMENT_PLUGIN_URL . 'assets/fonts/vazirmatn.css', array(), IRANELEMENT_VERSION);
        }
    }
    
    public function elementor_styles() {
        $options = get_option('iranelement_options');
        
        if (!empty($options['elementor_font'])) {
            wp_enqueue_style('vazir-font', IRANELEMENT_PLUGIN_URL . 'assets/fonts/vazirmatn.css', array(), IRANELEMENT_VERSION);
        }
    }
    
    public function add_custom_css() {
        $options = get_option('iranelement_options');
        if (empty($options['enable_vazir_font'])) {
            return;
        }
        
        $css = $this->generate_custom_css($options);
        if (!empty($css)) {
            echo '<style id="iranelement-custom-css">' . $css . '</style>';
        }
    }
    
    public function add_admin_custom_css() {
        $options = get_option('iranelement_options');
        if (empty($options['dashboard_font'])) {
            return;
        }
        
        $css = $this->generate_admin_css($options);
        if (!empty($css)) {
            echo '<style id="iranelement-admin-custom-css">' . $css . '</style>';
        }
    }
    
    private function generate_custom_css($options) {
        $css = '';
        
        // Global settings
        if (!empty($options['global_settings'])) {
            $global = $options['global_settings'];
            $css .= "body, html { font-family: '{$global['font_family']}', sans-serif !important; font-size: {$global['font_size']} !important; font-weight: {$global['font_weight']} !important; font-style: {$global['font_style']} !important; }\n";
        }
        
        // Elementor specific settings
        if (!empty($options['elementor_settings'])) {
            foreach ($options['elementor_settings'] as $tag => $settings) {
                $css .= ".elementor h1, .elementor h2, .elementor h3, .elementor h4, .elementor h5, .elementor h6, .elementor p, .elementor span, .elementor a, .elementor button { font-family: '{$settings['font_family']}', sans-serif !important; }\n";
                $css .= ".elementor {$tag} { font-family: '{$settings['font_family']}', sans-serif !important; font-size: {$settings['font_size']} !important; font-weight: {$settings['font_weight']} !important; font-style: {$settings['font_style']} !important; }\n";
            }
        }
        
        return $css;
    }
    
    private function generate_admin_css($options) {
        $css = '';
        
        // Admin dashboard font
        $css .= "#wpadminbar, #adminmenu, #adminmenuback, #adminmenuwrap, #wpcontent, #wpfooter { font-family: 'Vazirmatn', sans-serif !important; }\n";
        $css .= ".wp-admin { font-family: 'Vazirmatn', sans-serif !important; }\n";
        
        return $css;
    }
    
    public function admin_page() {
        if (isset($_POST['iranelement_save_settings'])) {
            $this->save_settings();
        }
        
        $options = get_option('iranelement_options');
        include IRANELEMENT_PLUGIN_PATH . 'templates/admin-page.php';
    }
    
    private function save_settings() {
        if (!wp_verify_nonce($_POST['iranelement_nonce'], 'iranelement_save_settings')) {
            wp_die('Security check failed');
        }
        
        $options = array();
        $options['enable_vazir_font'] = isset($_POST['enable_vazir_font']);
        $options['dashboard_font'] = isset($_POST['dashboard_font']);
        $options['elementor_font'] = isset($_POST['elementor_font']);
        
        // Global settings
        $options['global_settings'] = array(
            'font_family' => sanitize_text_field($_POST['global_font_family']),
            'font_size' => sanitize_text_field($_POST['global_font_size']),
            'font_weight' => sanitize_text_field($_POST['global_font_weight']),
            'font_style' => sanitize_text_field($_POST['global_font_style'])
        );
        
        // Elementor settings
        $elementor_settings = array();
        $tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'a', 'button');
        
        foreach ($tags as $tag) {
            $elementor_settings[$tag] = array(
                'font_family' => sanitize_text_field($_POST["elementor_{$tag}_font_family"]),
                'font_size' => sanitize_text_field($_POST["elementor_{$tag}_font_size"]),
                'font_weight' => sanitize_text_field($_POST["elementor_{$tag}_font_weight"]),
                'font_style' => sanitize_text_field($_POST["elementor_{$tag}_font_style"])
            );
        }
        
        $options['elementor_settings'] = $elementor_settings;
        
        update_option('iranelement_options', $options);
        
        echo '<div class="notice notice-success"><p>تنظیمات با موفقیت ذخیره شد.</p></div>';
    }
    
    /**
     * Check for plugin updates
     */
    public function check_for_updates() {
        // Check for updates every 12 hours
        $last_check = get_option('iranelement_last_update_check', 0);
        if (time() - $last_check > 43200) { // 12 hours
            $this->check_plugin_update(null);
            update_option('iranelement_last_update_check', time());
        }
    }
    
    /**
     * Check plugin update from GitHub
     */
    public function check_plugin_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }
        
        $plugin_slug = basename(dirname(__FILE__)) . '/' . basename(__FILE__);
        $plugin_data = get_plugin_data(__FILE__);
        
        // GitHub repository information
        $github_repo = 'sajjadazizi/iran-element';
        $github_api_url = "https://api.github.com/repos/{$github_repo}/releases/latest";
        
        $response = wp_remote_get($github_api_url, array(
            'timeout' => 15,
            'headers' => array(
                'User-Agent' => 'WordPress/IranElement-Plugin'
            )
        ));
        
        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            $release_data = json_decode(wp_remote_retrieve_body($response), true);
            
            if ($release_data && isset($release_data['tag_name'])) {
                $latest_version = ltrim($release_data['tag_name'], 'v');
                
                if (version_compare($latest_version, $plugin_data['Version'], '>')) {
                    // Get download URL from assets
                    $download_url = '';
                    if (isset($release_data['assets']) && is_array($release_data['assets'])) {
                        foreach ($release_data['assets'] as $asset) {
                            if ($asset['name'] === 'iranelement.zip') {
                                $download_url = $asset['browser_download_url'];
                                break;
                            }
                        }
                    }
                    
                    if ($download_url) {
                        $transient->response[$plugin_slug] = (object) array(
                            'slug' => basename(dirname(__FILE__)),
                            'new_version' => $latest_version,
                            'url' => $release_data['html_url'],
                            'package' => $download_url,
                            'requires' => '5.0',
                            'requires_php' => '7.4',
                            'tested' => '6.4',
                            'last_updated' => $release_data['published_at'],
                            'sections' => array(
                                'description' => $plugin_data['Description'],
                                'changelog' => $this->format_changelog($release_data['body'])
                            )
                        );
                    }
                }
            }
        }
        
        return $transient;
    }
    
    /**
     * Get plugin information for update from GitHub
     */
    public function plugin_info($result, $action, $args) {
        if ($action !== 'plugin_information') {
            return $result;
        }
        
        $plugin_slug = basename(dirname(__FILE__)) . '/' . basename(__FILE__);
        
        if ($args->slug !== basename(dirname(__FILE__))) {
            return $result;
        }
        
        // GitHub repository information
        $github_repo = 'sajjadazizi/iran-element';
        $github_api_url = "https://api.github.com/repos/{$github_repo}/releases/latest";
        
        $response = wp_remote_get($github_api_url, array(
            'timeout' => 15,
            'headers' => array(
                'User-Agent' => 'WordPress/IranElement-Plugin'
            )
        ));
        
        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            $release_data = json_decode(wp_remote_retrieve_body($response), true);
            
            if ($release_data) {
                $plugin_data = get_plugin_data(__FILE__);
                
                $result = (object) array(
                    'name' => 'IRANELEMENT',
                    'slug' => 'iranelement',
                    'version' => ltrim($release_data['tag_name'], 'v'),
                    'author' => 'Sajjad Azizi',
                    'author_profile' => 'https://iranelement.ir',
                    'requires' => '5.0',
                    'requires_php' => '7.4',
                    'tested' => '6.4',
                    'last_updated' => $release_data['published_at'],
                    'homepage' => $release_data['html_url'],
                    'sections' => array(
                        'description' => $plugin_data['Description'],
                        'changelog' => $this->format_changelog($release_data['body'])
                    )
                );
            }
        }
        
        return $result;
    }
    
    /**
     * Format changelog from GitHub release body
     */
    private function format_changelog($body) {
        if (empty($body)) {
            return '<p>هیچ تغییری ثبت نشده است.</p>';
        }
        
        // Convert markdown to HTML
        $changelog = $body;
        
        // Convert headers
        $changelog = preg_replace('/^### (.*$)/m', '<h3>$1</h3>', $changelog);
        $changelog = preg_replace('/^## (.*$)/m', '<h2>$1</h2>', $changelog);
        $changelog = preg_replace('/^# (.*$)/m', '<h1>$1</h1>', $changelog);
        
        // Convert lists
        $changelog = preg_replace('/^\* (.*$)/m', '<li>$1</li>', $changelog);
        $changelog = preg_replace('/^- (.*$)/m', '<li>$1</li>', $changelog);
        
        // Wrap lists in ul tags
        $changelog = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $changelog);
        
        // Convert line breaks
        $changelog = nl2br($changelog);
        
        return $changelog;
    }
    
    /**
     * Add update notification in admin
     */
    public function admin_update_notice() {
        $plugin_data = get_plugin_data(__FILE__);
        $current_version = $plugin_data['Version'];
        
        // Check if update is available
        $update_plugins = get_site_transient('update_plugins');
        $plugin_slug = basename(dirname(__FILE__)) . '/' . basename(__FILE__);
        
        if (isset($update_plugins->response[$plugin_slug])) {
            $update_data = $update_plugins->response[$plugin_slug];
            if (version_compare($update_data->new_version, $current_version, '>')) {
                echo '<div class="notice notice-warning is-dismissible">';
                echo '<p><strong>ایران المنت:</strong> نسخه جدید ' . $update_data->new_version . ' در دسترس است. ';
                echo '<a href="' . admin_url('update-core.php') . '">بروزرسانی کنید</a></p>';
                echo '</div>';
            }
        }
    }
}

// Initialize the plugin
new IranElement();
