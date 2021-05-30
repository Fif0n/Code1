<?php 
include 'conn.php';
$data = new Database;
$str_json = file_get_contents('php://input');
$fields = json_decode($str_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
session_start();
if($data->requiredValidation($fields)){
    $data->deleteCourse($fields);
}
