<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code1</title>
    <link rel="stylesheet" href="/Code1/style/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <header>
            <a href="/Code1/home">
                <img src="/Code1/photos/logo.png">
            </a>
            <form action="/Code1/search" method="POST">
                <input type="text" placeholder="Wyszukaj kurs" name="s">
            </form>
            <nav>
                <ul class="nav-button">
                    <li class="button-text">
                        <span>Kategorie</span>
                        <div class="sub-menu">
                            <ul>
                                <?php
                                include 'functions/conn.php';
                                $conn = new Database;
                                    $categories = $conn->con->prepare("SELECT tags FROM course");
                                    $categories->execute();
                                    $categoriesArr = array();
                                    while($row = $categories->fetch(PDO::FETCH_ASSOC)){
                                        $tags = json_decode($row['tags']);
                                        foreach($tags as $tag){
                                            if(!in_array($tag, $categoriesArr)){
                                                $categoriesArr[] = $tag;
                                            }
                                        }
                                    }
                                    foreach($categoriesArr as $categorie){
                                        echo "<li><a href='/Code1/search/$categorie/'>$categorie</a></li>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </li>
                    <?php 
                        if(isset($_SESSION['username'])){
                            echo "
                        <a href='/Code1/yourCourses'>
                            <li class='button-text'>
                                <span>Twoje kursy</span> 
                            </li>
                        </a>
                    </ul>
                    <div class='user-icon'>
                        <span>".strtoupper($_SESSION['username'][0])."</span>
                        <div class='user-sub-menu'>
                            <ul>
                                <div class='username'>
                                    <li>Zalogowany jako: ".$_SESSION['username']."</li>
                                </div>
                                <li><a href='/Code1/userPanel'>Zarządzaj kontem</a></li>
                                <li><a href='/Code1/yourCourses'>Twoje kursy</a></li>
                                <li><a href='/Code1/purchaseHistory'>Historia zakupów</a></li>
                                <li><form action='/Code1/functions/logout.php' method='POST'><button type='submit'>Wyloguj się</button></form></li>
                            </ul>
                        </div>
                    </div>";
                        } else if(!isset($_SESSION['username'])){
                            echo "
                            <div class='sign-buttons'>
                                <button class='log-in'>
                                    <a href=''>
                                        <span>Zaloguj się</span>
                                    </a>
                                </button>
                                <button class='sign-in'>
                                    <a href='/Code1/registerForm'>
                                        <span>Zarejestruj się</span>
                                    </a>
                                </button>
                            </div>";
                        }
                ?>
            </nav>     
        </header>
        <div class="login-popup">
            <div class="login-content">
                <span class="close">&times;</span>
                <h1>Logowanie</h1>
                <form>
                    <input type="text" id="l_username" placeholder="Nazwa użytkownika">
                    <input type="password" id="l_password" placeholder="Hasło">
                    <button type="submit" id="submit-login">Zaloguj się</button>
                    <ul id="login-error-message">

                    </ul>
                </form>
                <p>Nie posiadasz konta?</p>
                <a href="/Code1/registerForm"><p>Zarejestruj się</p></a>
            </div>
        </div>
    