<?php
    include 'conn.php';
    $data = new Database;
    $str_json = file_get_contents('php://input');
    $fields = json_decode($str_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if($data->requiredValidation($fields)){
        session_start();
        $data->editSoftData("user", $fields, $_SESSION['username']);
    } 