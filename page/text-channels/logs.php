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
ini_set('precision', 17);
ini_set('serialize_precision', -1);

use Medoo\Medoo;

#$data = $database->query("SELECT `client_id`,`channel_id`,`message_id`,`content`,`attachments`,`create_time`,`edit_time`,`remove_time`,`removed`,`edited`,`author_name`, COALESCE(GREATEST( `remove_time`, `edit_time` ), `remove_time`, `edit_time`) as latest_date FROM `message-logs` WHERE `guild_id` = ". $_SESSION['selected_guild']." AND (`removed` = 1 OR `edited` = 1) ORDER BY latest_date DESC")->fetchAll();

$data = $database->select("message-logs", [
    "client_id",
    "channel_id",
    "message_id",
    "content",
    "attachments",
    "create_time",
    "edit_time",
    "remove_time",
    "removed",
    "edited",
    "author_name",
    "last_action" => Medoo::raw('COALESCE(GREATEST( `remove_time`, `edit_time` ), `remove_time`, `edit_time`)')
], [
    "guild_id" => $_SESSION['selected_guild'],
    	"OR" => [
		"removed" => 1,
		"edited" => 1
        ],
    "ORDER" => [
        "last_action" => "DESC"
    ],
    "LIMIT" => 200
]);

for ($i = 0; $i < sizeof($data); ++$i) {
    // Docode content
    $data[$i]['content'] = json_decode($data[$i]['content'],true, 512, JSON_BIGINT_AS_STRING);
    
    // Decode attchments
    $attachments = json_decode($data[$i]['attachments'],true, 512, JSON_BIGINT_AS_STRING);
    
    //Create array for attachments
    $attachments_list_restricted = array();
    
    for($a = 0; $a < sizeof($attachments); ++$a){
        //Create temponary array for data
        $temp_array = array();

        //Append filtered data into array
        $temp_array['id'] = strval($attachments[$a]['id']);
        if(isset($attachments[$a]['removed']) && $attachments[$a]['removed'] == 1){
            $temp_array['removed'] = strval($attachments[$a]['removed']);
            $temp_array['remove_time'] = strval($attachments[$a]['remove_time']);
        }
        $attachments_list_restricted[] = $temp_array;
        unset($temp_array);
    }
    
    $data[$i]['attachments'] = $attachments_list_restricted;
    unset($attachments_list_restricted);
}
echo json_encode($data);
?>
