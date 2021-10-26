<?php
function api_request($request){
    require($_SERVER['DOCUMENT_ROOT'].'/config.php');
    $authToken = $config['bot_token'];
    $url=$request;

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL            => $url,
        CURLOPT_HTTPHEADER     => array('Authorization: Bot '.$authToken),
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_VERBOSE        => 1,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HEADER         => 1,
    ));
    
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    #data
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);
    
    #curl_close($ch);
    //var_dump($response);
    // /echo $httpcode;
    $data = array();
    $data['body'] = $body;
    $data['response_code'] = $httpcode;



    
    return $data;
}
function bot_request($request, $post_val = NULL)
{
    require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
    $url = $config['bot_api']['ip'].":".$config['bot_api']['port'].$request;

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL            => $url,
        CURLOPT_USERPWD     => $config['bot_api']['login'] . ":" . $config['bot_api']['password'],
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_VERBOSE        => 1,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HEADER         => 1,
    ));

    if ($post_val != NULL){
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_val);
    }

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    #data
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    #curl_close($ch);
    //var_dump($response);
    // /echo $httpcode;
    $data = array();
    $data['body'] = $body;
    $data['response_code'] = $httpcode;




    return $data;
}
?>