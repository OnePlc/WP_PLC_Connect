<article class="plc-admin-page-general plc-admin-page" style="padding: 10px 40px 40px 40px;">
    <h1><?=__('General Settings','wp-plc-connect')?></h1>
    <p>Here you find the core settings for your onePlace to Wordpress Connection</p>

    <h3>onePlace Connection</h3>
    <?php if(get_option('plcconnect_server_url') != '') {
        $sHost = get_option('plcconnect_server_url');
        $sAuthKey = get_option('plcconnect_server_key');
        $sAuthToken = get_option('plcconnect_server_token');
        $sApiResponse = file_get_contents($sHost.'/api?authkey='.$sAuthKey.'&authtoken='.$sAuthToken);
        $oResponse = json_decode($sApiResponse);
        if(!is_object($oResponse)) {
            echo 'invalid response';
        } else {
            if($oResponse->state == 'success') {
                echo '<p style="color:green;">Response of '.get_option('plcconnect_server_url').': '.$oResponse->message.'</p>';
                echo '<a class="plc-admin-btn plc-admin-btn-primary" href="'.get_option('plcconnect_server_url').'" target="_blank" title="Login to onePlace">Login to onePlace</a>';
            } else {
                echo 'error: '.$oResponse->message;
            }
        }
        ?>
    <?php } else { ?>
        <p style="color:red;">OnePlace not connected!</p>
    <?php } ?>
        <!-- Enter Connection Details -->
        <div style="float:left; width:100%; display: inline-block;">
            <h3>Connection Details</h3>
            <!-- Server -->
            <div class="plc-admin-settings-field">
                <input type="text" class="plc-settings-value" name="plcconnect_server_url" value="<?=get_option('plcconnect_server_url')?>" />
                <span>onePlace URL</span>
            </div>
            <!-- Server -->

            <!-- Authkey -->
            <div class="plc-admin-settings-field">
                <input type="text" class="plc-settings-value" name="plcconnect_server_key" value="<?=get_option('plcconnect_server_key')?>" />
                <span>onePlace Authkey</span>
            </div>
            <!-- Authkey -->

            <!-- Authtoken-->
            <div class="plc-admin-settings-field">
                <input type="text" class="plc-settings-value" name="plcconnect_server_token" value="<?=get_option('plcconnect_server_token')?>" />
                <span>onePlace Authkey</span>
            </div>
            <!-- Authtoken -->
        </div>
        <!-- Enter Connection Details -->


    <h3>Plugin Info</h3>
    <?php if(is_plugin_active('wpplc-events/wpplc-events.php')) { ?>
        <p style="color:green;">Event Plugin loaded <?=WPPLC_EVENTS_VERSION?></p>
    <?php } ?>
    <?php if(is_plugin_active('wp-plc-shop/wp-plc-shop.php')) { ?>
        <p style="color:green;">Shop Plugin loaded <?=WPPLC_SHOP_VERSION?></p>
    <?php } ?>

    <!-- Save Button -->
    <hr/>
    <button class="plc-admin-settings-save plc-admin-btn plc-admin-btn-primary" plc-admin-page="page-general">Save General Settings</button>
    <!-- Save Button -->
</article>