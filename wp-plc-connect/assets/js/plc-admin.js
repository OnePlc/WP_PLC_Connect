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
     * Ajax based settings toggle
     */
    jQuery('input.plc-admin-ajax-checkbox').on('change',function() {
        var sName = jQuery(this).attr('name');
        var sVal = 0;
        if(jQuery(this).is(':checked')) {
            sVal = 1;
        }

        // show we are working
        jQuery('.plc-admin-alert-container').html('<img src="/wp-content/plugins/wp-plc-shop/assets/img/ajax-loader.gif" style="position: absolute;" />');

        // update setting
        jQuery.post('/wp-content/plugins/wp-plc-connect/includes/ajax/setting_update.php',{setting_name:sName,setting_val:sVal},function(retVal) {
           jQuery('.plc-admin-alert-container').html(retVal);
        });
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

        jQuery('.plc-admin-alert-container').html('<img style="position:fixed;" src="/wp-content/plugins/wp-plc-connect/assets/img/ajax-loader.gif" />');
        jQuery.post('/wp-content/plugins/wp-plc-connect/includes/ajax/settingsupdate.php',{settings:oData},function(retVal) {
           var oInfo = jQuery.parseJSON(retVal);
           jQuery('.plc-admin-alert-container').html('<div class="plc-alert plc-alert-'+oInfo.state+'" style="position:fixed;">'+oInfo.message+'</div>');
        });

        return false;
    });
});