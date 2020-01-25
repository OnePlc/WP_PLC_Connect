<?php

/**
 * Wordress Comments Mods
 *
 * @package   OnePlace\Swissknife\Modules
 * @copyright 2019 Verein onePlace
 * @license   https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html GNU General Public License, version 2
 * @link      https://1plc.ch/wordpress-plugins/swissknife
 */

namespace OnePlace\Connect\Modules;

use OnePlace\Connect\Plugin;

final class Settings {
    /**
     * Main instance of the module
     *
     * @since 0.1-stable
     * @var Plugin|null
     */
    private static $instance = null;

    /**
     * Disable wordpress comments entirely
     *
     * @since 0.1-stable
     */
    public function register() {
        // add custom scripts for admin section
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueScripts' ] );

        // Add submenu page for settings
        add_action("admin_menu", [ $this, 'addAdminMenu' ]);

        // Register Settings
        add_action( 'admin_init', [ $this, 'registerSettings' ] );

        // Add Plugin Languages
        add_action('plugins_loaded', [ $this, 'loadTextDomain' ] );
    }

    /**
     * load text domain (translations)
     *
     * @since 0.3.4
     */
    public function loadTextDomain() {
        load_plugin_textdomain( 'wp-plc-connect', false, dirname( plugin_basename(WPPLC_CONNECT_PLUGIN_MAIN_FILE) ) . '/language/' );
    }

    /**
     * Register Plugin Settings in Wordpress
     *
     * @since 0.3.4
     */
    public function registerSettings() {
        // Core Settings
        register_setting( 'wpplc_connect', 'plcconnect_server_url', false );
        register_setting( 'wpplc_connect', 'plcconnect_server_key', false );
    }

    /**
     * Enqueue Style and Javascript for Admin Panel
     *
     * @since 0.3.4
     */
    public function enqueueScripts() {
        // add necessary javascript libs
        wp_enqueue_script( 'plc-admin-controls', WPPLC_CONNECT_PUB_DIR.'/assets/js/plc-admin.js', [ 'jquery' ] );

        // add necessary css files
        wp_enqueue_style( 'plc-admin-style', WPPLC_CONNECT_PUB_DIR.'/assets/css/plc-admin-style.css');
    }

    /**
     * Add Submenu Page to OnePlace Settings Menu
     *
     * @since 0.3.4
     */
    public function addAdminMenu() {
        $page_title = 'OnePlace Connect';
        $menu_title = 'OnePlace';
        $capability = 'manage_options';
        $menu_slug  = 'oneplace-connect';
        $function   = [$this,'renderSettingsPage'];
        $icon_url   = 'dashicons-media-code';
        $position   = 4;

        add_menu_page(
            $page_title,
            $menu_title,
            $capability,
            $menu_slug,
            $function,
            $icon_url,
            $position );
    }

    /**
     * Render Settings Page for Plugin
     *
     * @since 0.3.4
     */
    public function renderSettingsPage() {
        require_once __DIR__.'/../templates/settings.php';
    }

    /**
     * Loads the module main instance and initializes it.
     *
     * @since 0.1-stable
     *
     * @return bool True if the plugin main instance could be loaded, false otherwise.
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