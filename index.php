<?php 
@session_start();
#var_dump($_SESSION);
#auto rediect
echo isset($_SESSION['selected_guild']);
if(isset($_SESSION['access_token']) && isset($_SESSION['selected_guild'])){
    echo 'rediect dashboard';
    header("Location: /page/dashboard");

}elseif(isset($_SESSION['access_token']) && !isset($_SESSION['selected_guild'])){
        #user is logged and server is DONT selected
        echo 'select guild';
        header("Location: /selectserver");


    }elseif(!isset($_SESSION['access_token']) && !isset($_SESSION['selected_guild'])){
        #uzytkownik niezalogowany
        echo 'REDIECT LOGIN';
        header("Location: /login");
    }

?>