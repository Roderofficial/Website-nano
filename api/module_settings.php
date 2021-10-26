<?php
function module_settings_download($guild_id, $module_name){
    require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/database/database.php');
    $data = $database->select('modules_settings', 'settings', ["guild_id" => $guild_id,"module_name"=>$module_name]);
    if($data == null){
        return null;
    }else{
        $return_data = json_decode($data[0], true);
        return $return_data;
    }

    

}
function module_settings_update($guild_id, $module_name, $variable, $value){
    require($_SERVER['DOCUMENT_ROOT'] . '/database/database.php');
    $current_settings = module_settings_download($guild_id, $module_name);
    $new_settings = $current_settings;
    $new_settings[$variable] = $value;
    $json_encoded = json_encode($new_settings);
    if($current_settings == null){
        $database->insert("modules_settings", [
            "module_name" => $module_name,
            "guild_id" => $guild_id,
            "settings" => $json_encoded
        ]);

    }else{
        $database->update("modules_settings", ["settings" => $json_encoded], ["guild_id" => $guild_id, "module_name" => $module_name]);
    }

}
?>