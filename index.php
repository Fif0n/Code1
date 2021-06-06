<?php
    session_start();
    include 'includes/header.php';
    
    if(isset($_GET['view'])){
        $view = $_GET['view'];
    } else {
        $view = "";
    }

    if($view == ''){
        include 'includes/home.php';
    } else if ($view == 'home'){
        include 'includes/home.php';
    } else if ($view == 'registerForm'){
        include 'includes/registerForm.php';
    } else if ($view == 'userPanel'){
        include 'includes/userPanel.php';
    } else if ($view == 'yourCourses'){
        include 'includes/yourCourses.php';
    } else if ($view == 'yourCourse'){
        include 'includes/yourCourse.php';
    } else if ($view == 'createCourse'){
        include 'includes/createCourseForm.php';
    } else if ($view == 'purchaseHistory') {
        include 'includes/purchaseHistory.php';
    } else if ($view == 'search') {
        include 'includes/search.php';
    } else {
        include 'includes/notFound.php';
    }
    
    include 'includes/footer.php';
?>