<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code1</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <header>
            <a href="">
                <img src="photos/logo.png">
            </a>
            <input type="text" placeholder="Wyszukaj kurs">
            <nav>
            
                <ul class="nav-button">
                    <a href="">
                        <li class="button-text">
                            <span>Kategorie</span>
                            <div class="sub-menu">
                                <ul>
                                    <!-- tu będą na z bazy danych -->
                                    <li><a href="">Php</a></li>
                                    <li><a href="">Javasrcipt</a></li>
                                    <li><a href="">SQL</a></li>
                                    <li><a href="">Python</a></li>
                                    <li><a href="">Java</a></li>
                                </ul>
                            </div>
                        </li>
                    </a>
                    <a href="">
                        <li class="button-text">
                            <span>Twoje kursy</span> 
                        </li>
                    </a>
                </ul>
                <div class="user-icon">
                    <span>U</span>
                    <div class="user-sub-menu">
                        <ul>
                            <div class="username">
                                <li>Zalogowany jako: User</li>
                            </div>
                            <li><a href="">Zarządzaj kontem</a></li>
                            <li><a href="">Twoje kursy</a></li>
                            <li><a href="">Historia zakupów</a></li>
                            <li><a href="">Wyloguj się</a></li>
                        </ul>
                    </div>
                </div>
                <!-- <div class="sign-buttons">
                    <button class="log-in">
                        <a href="">
                            <span>Zaloguj się</span>
                        </a>
                    </button>
                    <button class="sign-in">
                        <a href="">
                            <span>Zarejestruj się</span>
                        </a>
                    </button>
                </div> -->
            </nav>     
        </header>
        <div class="login-popup">
            <div class="login-content">
                <span class="close">&times;</span>
                <h1>Logowanie</h1>
                <form action="/blog/includes/login.inc.php" method="POST">
                    <input type="text" name="username" placeholder="Nazwa użytkownika">
                    <input type="password" name="password" placeholder="Hasło">
                    <button type="submit" name="login-submit">Zaloguj się</button>
                </form>
                <p>Nie posiadasz konta?</p>
                <a href=""><p>Zarejestruj się</p></a>
            </div>
        </div>
        
        
    