<?php
@session_start();
//SECURE 
require($_SERVER['DOCUMENT_ROOT'] . '/api/secure.php');
require_login(false);
require_guild(false);
//END SECURE
if(!isset($_POST['prefix']) || $_POST['prefix'] == null){
    http_response_code(400);
    exit();
}
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/database/database.php');

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
    echo 'update';
    $data = $database->update("prefix", [
        "prefix" => $_POST['prefix']
    ], [
        "guild_id" => $_SESSION['selected_guild']
    ]);

}

http_response_code(200);




?>