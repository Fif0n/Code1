<?php
include 'conn.php';
$data = new Database;
$id = file_get_contents('php://input');
session_start();
$data->getOpinions($id);