<?php
require_once($_SERVER['DOCUMENT_ROOT']. '/database/Medoo.php');
// Using Medoo namespace.
use Medoo\Medoo;

$database = new Medoo([
    // [required]
    'type' => 'mysql',
    'host' => '167.86.120.16',
    'database' => 'nano',
    'username' => 'roder',
    'password' => '@Maniaczyn123mysql',
    'charset' => 'utf8',
 

    'option' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ],

]);
?>