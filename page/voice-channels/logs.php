<?php

@session_start();
//SECURE 
require($_SERVER['DOCUMENT_ROOT'] . '/api/secure.php');
require_login();
require_guild();
//END SECURE
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/database/Medoo.php');
require($_SERVER['DOCUMENT_ROOT'] . '/database/database.php');

use Medoo\Medoo;

$data = $database->select("voice_channel-logs", [
    "client_id",
    "channel_id",
    "action",
    "timestamp",
    "client_name",
    "channel_name"
], [
    "guild_id" => $_SESSION['selected_guild'],
    "ORDER" => [
        "timestamp" => "DESC"
    ],
    'LIMIT' => 300
]);
echo json_encode($data);
?>