<?php

require '../../../../../wp-load.php';

$aSettings = $_REQUEST['settings'];

foreach(array_keys($aSettings) as $sSetting) {
    //echo 'Save '.$sSetting.' = '.$aSettings[$sSetting];
    update_option($sSetting,str_replace(['\\'],[],$aSettings[$sSetting]));
}

$aResponse = ['state'=>'success','message'=>'Einstellungen erfolgreich gespeichert'];

echo json_encode($aResponse);