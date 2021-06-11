<?php
if(isset($_POST['submit'])){
    include 'conn.php';
    $data = new Database;
    session_start();
    $data->buyCourse($_POST['courseID'], $_SESSION['userID']);
    header("Location: /Code1/course/".$_POST['courseID']."/description");
}
