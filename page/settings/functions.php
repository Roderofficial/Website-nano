<?php
function get_prefix($guild_id){
    require($_SERVER['DOCUMENT_ROOT'].'/config.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/database/database.php');

    $data = $database->select('prefix', '*',["guild_id" => $guild_id]);
    if($data == null){
        return $config['default_prefix'];
    }else{
        return $data[0]["prefix"];
    }
}

function get_lang($guild_id)
{
    require $_SERVER['DOCUMENT_ROOT'] . '/api/module_settings.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

    $settings = module_settings_download($guild_id, 'global');
    if(isset($settings['lang'])){
        return $settings['lang'];
    }else{
        return $config['default_bot_lang'];
    }
}
?>