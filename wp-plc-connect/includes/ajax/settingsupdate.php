<?php
/**
 * Update Settings by AJAX
 *
 * @package   OnePlace\Connect
 * @copyright 2019 Verein onePlace
 * @license   https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html GNU General Public License, version 2
 * @link      https://1plc.ch/wordpress-plugins/connect
 */

# only execute if started from our javascript
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bRunUpdate = true;
    # Do some basic checks to prevent script is run outside our context
    if(!isset($_REQUEST['basic_check'])) {
        $bRunUpdate = false;
    } elseif ($_REQUEST['basic_check'] != 'wp_plc_setting') {
        $bRunUpdate = false;
    }

    # only run if everything is ok
    if($bRunUpdate) {
        # go up to ./ajax/includes/wp-plc-connect/plugins/wp-content
        require '../../../../../wp-load.php';

        # get settings and nonce
        $aSettings = $_REQUEST['settings'];
        $sWPNonce = $_REQUEST['nonce'];

        # only save settings if we have valid nonce
        if (wp_verify_nonce($sWPNonce, 'oneplace-settings-update')) {
            # update all settings
            foreach (array_keys($aSettings) as $sSetting) {
                # another basic check if the setting is really ours
                $bIsPlcSetting = stripos($sSetting, 'plc');
                if ($bIsPlcSetting === false) {
                    # its not a field we sent
                } else {
                    update_option($sSetting, str_replace(['\\'], [], $aSettings[$sSetting]));
                }
            }
            $aResponse = ['state' => 'success', 'message' => 'Settings saved successfully'];
        } else {
            $aResponse = ['state' => 'error', 'message' => 'invalid wordpress nonce'];
        }

        # Response is JSON
        echo json_encode($aResponse);
    }
}