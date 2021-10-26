<?php
require($_SERVER['DOCUMENT_ROOT'] . '/api/secure.php');
require_login();
require_guild();
//END SECURE
@session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/assets/Formr/class.formr.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/module_settings.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/guild.php';
$form = new Formr\Formr('bootstrap');
$data = $form->validate('join_enable, join_channel');

// show a success message if no errors
if ($form->ok()) {
    //validate empty data
    if($data["join_enable"] == null){
      http_response_code(400);
      exit();
    }

  //GET CHANNEL IDS FOR ARRAY
  $channels_raw = guild_channels($_SESSION['selected_guild']);
  $channels = json_decode($channels_raw['body'],true);
  
  $channels_ids = array();
  for ($i = 0; $i < sizeof($channels); $i++) {
      $channels_ids[] = $channels[$i]["id"];

    }

    //JOIN MESSAGE
    //CHECK RADIO DATA
    if($data['join_enable'] == 0){
      //DISABLE MODULE
      module_settings_update($_SESSION['selected_guild'],"join_messages","enable",0);

    }elseif($data['join_enable'] == 1){
      //VALIDATE CHANNEL AND ENABLE MODULE
      if (in_array($data['join_channel'], $channels_ids)) {
      //GOOD CHANNEL
      module_settings_update($_SESSION['selected_guild'], "join_messages", "channel_id", $data['join_channel']);
      module_settings_update($_SESSION['selected_guild'], "join_messages", "enable", 1);
      } else {
        http_response_code(403);
        exit();
      }


    }else{
      http_response_code(400);
      exit();
    }

}else{
    http_response_code(400);
}
?>