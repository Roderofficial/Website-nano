<?php
@session_start();
//SECURE 
require($_SERVER['DOCUMENT_ROOT'] . '/api/secure.php');
require_login(false);
require_guild(false);
//END SECURE

//CHECK IF PREFIX EXIST
if(!isset($_POST['prefix']) || $_POST['prefix'] == null){
    http_response_code(400);
    exit();
}
//CHECK IF LANG EXIST
if (!isset($_POST['lang']) || $_POST['lang'] == null) {
    http_response_code(400);
    exit();
}

require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/database/database.php');
require($_SERVER['DOCUMENT_ROOT'] . '/api/module_settings.php');


//VALIDATE PREFIX
$data = $database->select('prefix', '*', ["guild_id" => $_SESSION['selected_guild']]);
if ($data == null) {
    //PREFIX DONT EXIST IN DATABASE
    echo 'insert';
    $database->insert("prefix", [
        "prefix" => $_POST['prefix'],
        "guild_id" => $_SESSION['selected_guild']
    ]);

} else {
    //PREFIX EXIST IN DATABASE
    $data = $database->update("prefix", [
        "prefix" => $_POST['prefix']
    ], [
        "guild_id" => $_SESSION['selected_guild']
    ]);

}

//VALIDATE LANG
$langs = (array) $config['allowed_bot_lang'];
if(in_array($_POST['lang'], $langs, TRUE)){
    module_settings_update($_SESSION['selected_guild'], "global", "lang", $_POST['lang']);

}else{
    http_response_code(400);
    exit();
}

http_response_code(200);




?>