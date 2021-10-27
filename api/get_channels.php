<?php
    @session_start();
    require_once('secure.php');
    require_login(false);
    require_guild();

    

    
    require_once('request.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/config.php');

    $data = bot_request('/channels?id='. $_SESSION['selected_guild']);
    if($data['response_code'] == 200){
        echo $data['body'];

    }else{
        http_response_code($data['respone_code']);
    }


?>