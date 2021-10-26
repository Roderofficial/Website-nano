<?php
function get_guild($guild_id){
    require_once('request.php');
    require($_SERVER['DOCUMENT_ROOT'].'/config.php');
    $url=$config['discord_api_url']."/guilds/".$guild_id;

    $data = api_request($url);
    //var_dump($data);

    #return
    return $data;
}

function guild_access($guild_id){
    $data = get_guild($guild_id);
    if($data['response_code'] == 200){
        return True;
    }else{
        return False;
    }

}
function guild_channels($guild_id){
    require_once('request.php');
    require($_SERVER['DOCUMENT_ROOT'].'/config.php');
    $url=$config['discord_api_url']."/guilds/".$guild_id.'/channels';

    $data = api_request($url);
    //var_dump($data);

    #return
    return $data;
}
function guild_roles($guild_id){
    require_once('request.php');
    require($_SERVER['DOCUMENT_ROOT'].'/config.php');
    $url=$config['discord_api_url']."/guilds/".$guild_id.'/roles';

    $data = api_request($url);
    //var_dump($data);

    #return
    return $data;
}
function guild_members($guild_id){
    require_once('request.php');
    require($_SERVER['DOCUMENT_ROOT'].'/config.php');
    $url=$config['discord_api_url']."/guilds/".$guild_id.'/members';

    $data = api_request($url);
    //var_dump($data);

    #return
    return $data;
}
function guild_roles_list($guild_id){
    $data = guild_roles($guild_id);
    $roles = json_decode($data['body'], true);

    //CREATE RETURN VARIABLE
    $html = "";
    
    //LOOP WITH ROLES
    for($i = 0; $i < sizeof($roles); $i++){
        //SET COLOR
        if($roles[$i]["color"] == null){
            $color = "#fff";
        }else{
            $color = "#".dechex($roles[$i]["color"]);
        }
        $html = $html.'<option value="'.$roles[$i]["id"].'" style="color: '.$color.';">'.$roles[$i]["name"].'</option>';
    }
    
    return $html;
}
function guild_text_channels_list($guild_id,$selected_channel_id=null)
{
    $data = guild_channels($guild_id);
    $channels = json_decode($data['body'], true);

    $html = "";
    for ($i = 0; $i < sizeof($channels); $i++) {
        //ADD CHECKED VALUE
        if($channels[$i]['id'] == $selected_channel_id){
            $selected = 'selected';
        }else{
            $selected = null;
        }
        if($channels[$i]["type"] == 0){
            $html = $html . '<option value="' . $channels[$i]["id"] . '" ' . $selected.'>#' . $channels[$i]["name"] . '</option>';
        }
    }

    #return
    return $html;
}
function guild_text_channels($guild_id)
{
    require_once('request.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
    $url = $config['discord_api_url'] . "/guilds/" . $guild_id . '/channels';

    $data = api_request($url);
    //var_dump($data);

    #return
    return $data;
}
function get_attachment($id){
    $data = bot_request('/attachment?id=886600565025538118');
    if($data['response_code' == 200]){

    }else{
        return 'ERROR: '.$data['response_code'];
    }
}

?>