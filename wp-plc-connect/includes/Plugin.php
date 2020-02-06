<?php

/**
 * Plugin loader.
 *
 * @package   OnePlace\Connect
 * @copyright 2019 Verein onePlace
 * @license   https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html GNU General Public License, version 2
 * @link      https://1plc.ch/wordpress-plugins/swissknife
 */

namespace OnePlace\Connect;

/**
 * Main class for the plugin
 */
final class Plugin {
    /**
     * Main instance of the plugin.
     *
     * @since 0.1-stable
     * @var Plugin|null
     */
    private static $instance = null;

    /**
     * Retrieves the main instance of the plugin.
     *
     * @since 0.1-stable
     *
     * @return Plugin Plugin main instance.
     */
    public static function instance() {
        return static::$instance;
    }

    /**
     * Registers the plugin with WordPress.
     *
     * @since 0.1-stable
     */
    public function register() {
        // Enable Settings Page
        Modules\Settings::load();
    }

    /**
     * Loads the plugin main instance and initializes it.
     *
     * @since 0.1-stable
     *
     * @param string $main_file Absolute path to the plugin main file.
     * @return bool True if the plugin main instance could be loaded, false otherwise.
     */
    public static function load( $main_file ) {
        if ( null !== static::$instance ) {
            return false;
        }
        static::$instance = new static( $main_file );
        static::$instance->register();
        return true;
    }

    public static function getDataFromAPI($sUrl,$aParams = []) {
        $sHost = get_option('plcconnect_server_url');
        $sHostKey = get_option('plcconnect_server_key');
        $sHostToken = get_option('plcconnect_server_token');

        if($sHost == '') {
            echo 'oneplace not connected!';
        } else {
            $sExtraParams = '';
            if(count($aParams) > 0) {
                foreach(array_keys($aParams) as $sParamKey) {
                    $sExtraParams .= '&'.strtolower($sParamKey).'='.$aParams[$sParamKey];
                }
            }
            $sJsonInfo = file_get_contents($sHost . $sUrl . '?authkey=' . $sHostKey . '&authtoken=' . $sHostToken.$sExtraParams);
            $oCatInfo = json_decode($sJsonInfo);

            if(!is_object($oCatInfo)) {
                echo 'invalid response';
            } else {
                return $oCatInfo;
            }
        }

        return false;
    }

    public static function getCDNServerAddress() {
        $sHost = get_option('plcconnect_server_url');
        return $sHost;
    }
}