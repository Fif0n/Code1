<?php
include 'conn.php';
$str_json = file_get_contents('php://input');
$fields = json_decode($str_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$data = new Database;
session_start();
$data->setCurrentTime($fields['currentTime'], $fields['id'],$_SESSION['userID']);