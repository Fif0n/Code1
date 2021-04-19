<?php
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
    } else {
        include 'includes/notFound.php';
    }
    

    include 'includes/footer.php';
?>