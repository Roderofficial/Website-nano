<?php
//SECURE 
require($_SERVER['DOCUMENT_ROOT'] . '/api/secure.php');
require_login();
//END SECURE

    #chceck if isset id from get
    if(!isset($_GET['id'])){
        http_response_code(400);
        exit();
    }

    @session_start();

    #crete variable with id's array
    $id_list = array();

    #getting from servers ids
    for ($i = 0; $i < sizeof($_SESSION['guilds']); $i++) {

        #check is owner or admin server
        if ($_SESSION['guilds'][$i]['owner'] == true || $_SESSION['guilds'][$i]['permissions'] == "2147483647") {
            #push to array guilds
            array_push($id_list, $_SESSION['guilds'][$i]['id']);
        }

    }

    #check if server FROM get is in array $id_list
    if(in_array($_GET['id'],$id_list)){
        $_SESSION["selected_guild"] = $_GET['id'];
        header("Location: /");

    }else{
        http_response_code(403);
        exit();
    }


?>