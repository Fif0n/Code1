<?php
include 'conn.php';
$data = new Database;
session_start();
$data->createCourse();
