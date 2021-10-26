<?php
function get_prefix($guild_id){
    require($_SERVER['DOCUMENT_ROOT'].'/config.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/database/database.php');

    $data = $database->select('prefix', '*',["guild_id" => $guild_id]);
    if($data == null){
        return $config['default_prefix'];
    }else{
        return $data[0]["prefix"];
    }
}

?>