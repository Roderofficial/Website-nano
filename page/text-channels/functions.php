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


    $text_logs = module_settings_download($_SESSION['selected_guild'], 'text_logs');

    $data['remove_logs_enable'] = (isset($text_logs['remove_logs_enable'])) ? $text_logs['remove_logs_enable'] : 0;
    $data['remove_logs_channel'] = (isset($text_logs['remove_logs_channel'])) ? $text_logs['remove_logs_channel'] : null;


    $data['edit_logs_enable'] = (isset($text_logs['edit_logs_enable'])) ? $text_logs['edit_logs_enable'] : 0;
    $data['edit_logs_channel'] = (isset($text_logs['edit_logs_channel'])) ? $text_logs['edit_logs_channel'] : null;

    return $data;
    
}
?>