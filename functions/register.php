<?php
    include 'conn.php';
    $data = new Database;
    $str_json = file_get_contents('php://input');
    $fields = json_decode($str_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if($data->required_validation($fields)){
        $data->can_register("user", $fields);
    }
    
