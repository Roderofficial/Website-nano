<?php
    function find_attachment($data, $attachment_id){
        $data = json_decode($data, 1);
        foreach($data as $att){
            if($att['id'] == $attachment_id){
                return [True, $att];
            }
        }
        
        return [False];
    }
    
    if(!isset($_GET['message_id'] ) || !is_numeric($_GET['message_id'])){
        exit();

    }
    if (!isset($_GET['attachment_id']) || !is_numeric($_GET['attachment_id'])) {
        exit();
    }
    @session_start();
    require_once('secure.php');
    require_login(false);
    require_guild();
    require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/database/Medoo.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/database/database.php');

    //CHECK ATTACHMENT PERMISSIONS
    use Medoo\Medoo;

    $data = $database->select("message-logs", [
        "attachments"
    ], [
        "guild_id" => $_SESSION['selected_guild'],
        "message_id" => $_GET['message_id']

    ]);
    if($data != null){
        $att_info = find_attachment($data[0]["attachments"], $_GET['attachment_id']);
        if ($att_info[0] == True) {
            require_once('request.php');
            require($_SERVER['DOCUMENT_ROOT'] . '/config.php');

            $data = bot_request('/attachment?id=' . $_GET['attachment_id']);
            if ($data['response_code'] == 200) {
                header('Content-Type: ' . $att_info[1]['content_type']);
                echo $data['body'];
            } else {
                http_response_code($data['response_code']);
            }
        }else{
            http_response_code(400);
            exit();
        }

    }else{
        //ATTACHMENT NOT EXIST
        http_response_code(404);
        exit();

    }


?>
