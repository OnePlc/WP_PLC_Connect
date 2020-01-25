<article class="plc-admin-page-general plc-admin-page" style="padding: 10px 40px 40px 40px;">
    <h1><?=__('General Settings','wp-plc-connect')?></h1>
    <p>Here you find the core settings for your onePlace to Wordpress Connection</p>

    <h3>onePlace Connection</h3>
    <?php if(get_option('plcconnect_server_url') != '') { ?>
        <p style="color:green;">You are successfully connected to <b><?=get_option('plcconnect_server_url')?></b></p>
    <?php } else { ?>
        <p style="color:red;">OnePlace not connected!</p>
        <!-- Enter Connection Details -->
        <div style="float:left; width:100%; display: inline-block;">
            <h3>Connection Details</h3>
            <!-- Server -->
            <div class="plc-admin-settings-field">
                <input type="text" class="plc-settings-value" name="plcconnect_server_url" value="" />
                <span>onePlace URL</span>
            </div>
            <!-- Server -->

            <!-- Authkey -->
            <div class="plc-admin-settings-field">
                <input type="text" class="plc-settings-value" name="plcconnect_server_key" value="" />
                <span>onePlace Authkey</span>
            </div>
            <!-- Authkey -->
        </div>
        <!-- Enter Connection Details -->
    <?php } ?>


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