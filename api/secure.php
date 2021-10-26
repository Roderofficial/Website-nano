<?php 
function require_login($redirect = true){
    @session_start();
    if(!isset($_SESSION["access_token"])){
       if($redirect == true){
            http_response_code(401);
            header('Location: /');
            exit();
       }else{
           http_response_code(401);
           exit();

       }
    }
}
function require_guild($redirect = true){
    @session_start();
    if (!isset($_SESSION["selected_guild"])) {
        if ($redirect == true) {
            http_response_code(401);
            header('Location: /');
            exit();
        } else {
            http_response_code(401);
            exit();
        }
    }

}

?>