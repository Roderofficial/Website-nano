<?php

@session_start();
//SECURE 
require($_SERVER['DOCUMENT_ROOT'] . '/api/secure.php');
require_login();
require_guild();
//END SECURE
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/database/Medoo.php');
require($_SERVER['DOCUMENT_ROOT'] . '/database/database.php');
use Medoo\Medoo;
$data = $database->select("stats", [
    "data",
    "datetime"
], [
    "guild_id" => $_SESSION['selected_guild'],
    "datetime[>]" => Medoo::raw('DATE_SUB(NOW(), INTERVAL 24 HOUR)')
]);
if($data == Null or $data == ''){
    http_response_code(204);
    exit();
}else{
    //GENERATE ACTUAL DATE
    $last_stats = end($data);
    $actual = json_decode($last_stats['data'], 1);
    $response['online'] = $actual['online'] + $actual['idle'] + $actual['dnd'];
    $response['members'] = $actual['members'];
    //Create array for datas
    $response['chart']['labels'] = array();
    $response['chart']['data']['online'] = array();
    $response['chart']['data']['dnd'] = array();
    $response['chart']['data']['idle'] = array();
    $response['chart']['data']['all_online'] = array();
    
    foreach ($data as &$value) {
        //GENERATE LABELS FOR CHART
        $date_object = date_create($value['datetime']);
        $date = date_format($date_object, 'H:i');
        $response['chart']['labels'][] = $date;

        $decoded_data = json_decode($value['data'], 1);
        $response['chart']['data']['online'][] = $decoded_data['online'];
        $response['chart']['data']['dnd'][] = $decoded_data['dnd'];
        $response['chart']['data']['idle'][] = $decoded_data['idle'];
        $response['chart']['data']['all_online'][] = $decoded_data['idle'] + $decoded_data['online'] + $decoded_data['dnd'];

    }
    


}

echo json_encode($response);

?>