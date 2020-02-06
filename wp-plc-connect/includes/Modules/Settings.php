<?php

/**
 * Plugin General Settings
 *
 * @package   OnePlace\Connect\Modules
 * @copyright 2020 Verein onePlace
 * @license   https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html GNU General Public License, version 2
 * @link      https://1plc.ch/wordpress-plugins/connect
 */

namespace OnePlace\Connect\Modules;

use OnePlace\Connect\Plugin;

final class Settings {
    /**
     * Main instance of the module
     *
     * @var Plugin|null
     * @since 1.0.0
     */
    private static $instance = null;

    /**
     * Register Plugin
     *
     * @since 1.0.0
     */
    public function register() {
        # add custom scripts for admin section
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueScripts' ] );

        # Add submenu page for settings
        add_action("admin_menu", [ $this, 'addAdminMenu' ]);

        # Register Settings
        add_action( 'admin_init', [ $this, 'registerSettings' ] );

        # Add Plugin Languages
        add_action('plugins_loaded', [ $this, 'loadTextDomain' ] );
    }

    /**
     * load text domain (translations)
     *
     * @since 1.0.0
     */
    public function loadTextDomain() {
        load_plugin_textdomain( 'wp-plc-connect', false, dirname( plugin_basename(WPPLC_CONNECT_PLUGIN_MAIN_FILE) ) . '/language/' );
    }

    /**
     * Register Plugin Settings in Wordpress
     *
     * @since 1.0.0
     */
    public function registerSettings() {
        # Core Settings
        register_setting( 'wpplc_connect', 'plcconnect_server_url', false );
        register_setting( 'wpplc_connect', 'plcconnect_server_key', false );
        register_setting( 'wpplc_connect', 'plcconnect_server_token', false );
    }

    /**
     * Enqueue Style and Javascript for Admin Panel
     *
     * @since 1.0.0
     */
    public function enqueueScripts() {
        # add necessary javascript libs
        wp_enqueue_script( 'plc-admin-controls', WPPLC_CONNECT_PUB_DIR.'/assets/js/plc-admin.js', [ 'jquery' ] );

        # add necessary css files
        wp_enqueue_style( 'plc-admin-style', WPPLC_CONNECT_PUB_DIR.'/assets/css/plc-admin-style.css');
    }

    /**
     * Add Submenu Page to OnePlace Settings Menu
     *
     * @since 1.0.0
     */
    public function addAdminMenu() {
        $page_title = 'OnePlace Connect';
        $menu_title = 'OnePlace';
        $capability = 'manage_options';
        $menu_slug  = 'oneplace-connect';
        $function   = [$this,'renderSettingsPage'];
        $icon_url   = 'dashicons-media-code';
        $position   = 4;

        # Add Main Menu
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

        # Add Submenu (because there will be more from other oneplace plugins)
        add_submenu_page( $menu_slug, $page_title, $page_title, $capability, $menu_slug );
    }

    /**
     * Render Settings Page for Plugin
     *
     * @since 1.0.0
     */
    public function renderSettingsPage() {
        if(file_exists(__DIR__.'/../templates/settings.php')) {
            require_once __DIR__ . '/../templates/settings.php';
        } else {
            echo 'Could not find settings page template';
        }
    }

    /**
     * Loads the module main instance and initializes it.
     *
     * @return bool True if the plugin main instance could be loaded, false otherwise.
     * @since 1.0.0
     */
    public static function load() {
        if ( null !== static::$instance ) {
            return false;
        }
        static::$instance = new self();
        static::$instance->register();
        return true;
    }
}