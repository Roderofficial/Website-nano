<?php
require_once($_SERVER['DOCUMENT_ROOT']. '/database/Medoo.php');
// Using Medoo namespace.
use Medoo\Medoo;

$database = new Medoo([
    // [required]
    'type' => 'mysql',
    'host' => 'localhost',
    'database' => 'nano',
    'username' => 'root',
    'password' => 'usbw',
    'charset' => 'utf8',
 

    'option' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ],

]);
?>