<section>
    <div class="user-panel-container">
        <div class="user-nav-panel">
            <div class="user-panel-icon">
                <div class="user-avatar"><span>U</span></div>
                <p>User</p>
            </div>
            <div class="user-panel-options">
                <ul>
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
                    <input type='text' value='User'>
                    <input type='text' value='e-mail'>
                    <input type='password' placeholder='Podaj aktualne hasło'>
                    <button>Zmień dane</button>
                </form>
                <form>
                    <p>Zmieś hasło: </p>
                    <input type='password' placeholder='Podaj stare hasło'>
                    <input type='password' placeholder='Podaj nowe hasło'>
                    <input type='password' placeholder='Powtórz nowe hasło'>
                    <button>Zmień hasło</button>
                </form>";
            } else if ($subPage == "delAccount"){
                echo "<h1>Usuń konto</h1>
                <div class='del-account'>
                    <button>Usuń konto</button>
                    <p><em>Uwaga: </em>usunięcie konta jest nieodwracalne</p>
                </div>";
            } else if ($subPage == "editAccount"){
                echo "<h1>Twoje dane</h1>
                <form>
                    <p>Zmień dane: </p>
                    <input type='text' value='User'>
                    <input type='text' value='e-mail'>
                    <input type='password' placeholder='Podaj aktualne hasło'>
                    <button>Zmień dane</button>
                </form>
                <form>
                    <p>Zmień hasło: </p>
                    <input type='password' placeholder='Podaj stare hasło'>
                    <input type='password' placeholder='Podaj nowe hasło'>
                    <input type='password' placeholder='Powtórz nowe hasło'>
                    <button>Zmień hasło</button>
                </form>";
            }
        ?>
            
            
        </div>
    </div>
</section>