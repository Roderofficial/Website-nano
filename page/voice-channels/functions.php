<?php
function checked($value,$option){
    if($value == $option){
        echo 'checked';
    }
}
function data_preview(){
    @session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/api/module_settings.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/api/guild.php';


    $data_leave = module_settings_download($_SESSION['selected_guild'], 'leave_messages');
    $data_join = module_settings_download($_SESSION['selected_guild'], 'join_messages');

    $data['join_enable'] = (isset($data_join['enable'])) ? $data_join['enable'] : 0;
    $data['join_channel'] = (isset($data_join['channel_id'])) ? $data_join['channel_id'] : null;


    $data['leave_enable'] = (isset($data_leave['enable'])) ? $data_leave['enable'] : 0;
    $data['leave_channel'] = (isset($data_leave['channel_id'])) ? $data_leave['channel_id'] : null;

    return $data;
    
}
?>