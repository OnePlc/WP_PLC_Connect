/**
 * Main Javascript File for WP PLC Connect
 *
 * @package   OnePlace\Connect
 * @copyright 2020 Verein onePlace
 * @license   https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html GNU General Public License, version 2
 * @link      https://1plc.ch/wordpress-plugins/connect
 */

jQuery(function () {
    /**
     * Show first page
     */
    jQuery('article.plc-admin-page-general').show();

    /**
     * Ajax based navigation
     */
    jQuery('nav.plc-admin-menu ul li a').on('click',function() {
        var sPage = jQuery(this).attr('href').substring('#/'.length);

        jQuery('article.plc-admin-page').hide();
        jQuery('article.plc-admin-page-'+sPage).show();

        return false;
    });

    /**
     * Save Button
     */
    jQuery('button.plc-admin-settings-save').on('click',function() {
        // get page to save
        var sPage = jQuery(this).attr('plc-admin-page');

        // Load all fields for page
        var oData = {};
        jQuery('.plc-admin-'+sPage).find('.plc-settings-value').each(function() {
            var sField = jQuery(this).attr('name');
            var sType = jQuery(this).attr('type');
            if(sType == 'checkbox') {
                oData[sField] = 0;
                if(jQuery(this).prop('checked')) {
                    oData[sField] = 1;
                }
            } else {
                oData[sField] = jQuery(this).val();
            }
        });

        // show ajax loader
        jQuery('.plc-admin-alert-container').html('<img style="position:fixed;" src="/wp-content/plugins/wp-plc-connect/assets/img/ajax-loader.gif" />');

        // get nonce
        var sWPNonce = jQuery('#_wpnonce').val();

        // save settings
        jQuery.post('/wp-content/plugins/wp-plc-connect/includes/ajax/settingsupdate.php',{settings:oData,nonce:sWPNonce,basic_check:'wp_plc_setting'},function(retVal) {
            // parse response
            var oInfo = jQuery.parseJSON(retVal);
            // show message
            jQuery('.plc-admin-alert-container').html('<div class="plc-alert plc-alert-'+oInfo.state+'" style="position:fixed;">'+oInfo.message+'</div>');
        });

        return false;
    });
});