<?php
    if(!isset($_SESSION['username'])){
        header("Location: /Code1/home");
    }
?>
<section>
    <div class="user-panel-container">
        <div class="user-nav-panel">
            <div class="user-panel-icon">
                <div class="user-avatar"><span><?= strtoupper($_SESSION['username'][0])?></span></div>
                <p><?= $_SESSION['username']?></p>
            </div>
            <div class="user-panel-options">
                <ul class="panel-options">
                    <a href="/Code1/userPanel/editAccount"><li><div class="panel-option active"><p>Edytuj konto</p></div></li></a>
                    <a href="/Code1/userPanel/delAccount"><li><div class="panel-option"><p>Usuń konto</p></div></li></a>
                </ul>
            </div>
        </div>
        <div class="user-main-panel">
        <?php 
        
            if(isset($_GET['subPage'])){
                $subPage = $_GET['subPage'];
            } else {
                $subPage = "";
            }

            if($subPage == ""){
                echo "<h1>Twoje dane</h1>
                <form>
                    <p>Zmień dane: </p>
                    <input type='text' id='edit-soft-username' value='".$_SESSION['username']."' placeholder='Nazwa użytkownika'>
                    <input type='text' id='edit-soft-email' value='".$_SESSION['email']."' placeholder='E-mail'>
                    <input type='password' id='edit-soft-password' placeholder='Podaj aktualne hasło'>
                    <button type='submit' id='edit-soft-submit'>Zmień dane</button>
                    <ul id='edit-soft-error-message'>

                    </ul>
                </form>
                <form>
                    <p>Zmień hasło: </p>
                    <input type='password' id='edit-password-old' placeholder='Podaj stare hasło'>
                    <input type='password' id='edit-password-new' placeholder='Podaj nowe hasło'>
                    <input type='password' id='edit-password-repeat' placeholder='Powtórz nowe hasło'>
                    <button type='submit' id='edit-password-submit'>Zmień hasło</button>
                    <ul id='edit-password-error-message'>

                    </ul>
                </form>";
            } else if ($subPage == "delAccount"){
                echo "<h1>Usuń konto</h1>
                <div class='del-account'>
                    <button class='delete-button'>Usuń konto</button>
                    <p><em>Uwaga: </em>usunięcie konta jest nieodwracalne</p>
                </div>";
            } else if ($subPage == "editAccount"){
                echo "<h1>Twoje dane</h1>
                <form>
                <p>Zmień dane: </p>
                    <input type='text' id='edit-soft-username' value='".$_SESSION['username']."' placeholder='Nazwa użytkownika'>
                    <input type='text' id='edit-soft-email' value='".$_SESSION['email']."' placeholder='E-mail'>
                    <input type='password' id='edit-soft-password' placeholder='Podaj aktualne hasło'>
                    <button type='submit' id='edit-soft-submit'>Zmień dane</button>
                    <ul id='edit-soft-error-message'>

                    </ul>
                </form>
                <form>
                    <p>Zmień hasło: </p>
                    <input type='password' id='edit-password-old' placeholder='Podaj stare hasło'>
                    <input type='password' id='edit-password-new' placeholder='Podaj nowe hasło'>
                    <input type='password' id='edit-password-repeat' placeholder='Powtórz nowe hasło'>
                    <button type='submit' id='edit-password-submit'>Zmień hasło</button>
                    <ul id='edit-password-error-message'>

                    </ul>
                </form>";
            }
        ?>
            
        </div>
    </div>
    <div class="delete-popup">
            <div class="delete-content">
                <span class="close-delete-popup">&times;</span>
                <h1>Usuń konto</h1>
                <form>
                    <input type="password" id="password-delete" placeholder="Podaj hasło">
                    <button type="submit" id="submit-delete">Usuń konto</button>
                    <ul id="delete-error-message">

                    </ul>
                    <p><em>Uwaga: </em>usunięcie konta jest nieodwracalne, ale nadal będziesz w stanie założyć nowe konto. Wszystkie kursy przypisane do konta będą utracone.</p>
                </form>
            </div>
        </div>
</section>