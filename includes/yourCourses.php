<?php
    if(!isset($_SESSION['username'])){
        header("Location: /Code1/home");
    }
?>
<section>
    <div class="your-courses-container">
        <div class="your-courses-header">
            <h1>Twoje kursy</h1>
            <ul>
                <a href="/Code1/yourCourses/boughtCourses/"><li><div class="your-courses-option active"><p>Kupione kursy</p></div></li></a>
                <a href="/Code1/yourCourses/publishedCourses/"><li><div class="your-courses-option"><p>Opublikowane kursy</p></div></li></a>
            </ul>
        </div>
        <div class="your-courses-list">
        <?php
            if(isset($_GET['subPage'])){
                $subPage = $_GET['subPage'];
            } else {
                $subPage = "";
            }

            if($subPage == ""){
                echo "<div class='bought-courses'>
                    <a href='/Code1/yourCourse/1/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <h5>Autor</h5>
                            </div>
                        </div>
                    </a>
                    <a href='/Code1/yourCourse/2/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <h5>Autor</h5>
                            </div>
                        </div>
                    </a>
                    <a href='/Code1/yourCourse/3/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <h5>Autor</h5>
                            </div>
                        </div>
                    </a>
                    <a href='/Code1/yourCourse/5/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <h5>Autor</h5>
                            </div>
                        </div>
                    </a>
                    <a href='/Code1/yourCourse/7/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <h5>Autor</h5>
                            </div>
                        </div>
                    </a>
                </div>";
            }

            else if ($subPage == "boughtCourses"){
                echo "<div class='bought-courses'>
                    <a href='/Code1/yourCourse/1/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <h5>Autor</h5>
                            </div>
                        </div>
                    </a>
                    <a href='/Code1/yourCourse/2/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <h5>Autor</h5>
                            </div>
                        </div>
                    </a>
                    <a href='/Code1/yourCourse/3/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <h5>Autor</h5>
                            </div>
                        </div>
                    </a>
                    <a href='/Code1/yourCourse/5/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <h5>Autor</h5>
                            </div>
                        </div>
                    </a>
                    <a href='/Code1/yourCourse/7/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <h5>Autor</h5>
                            </div>
                        </div>
                    </a>
                </div>";
            } else if($subPage == "publishedCourses"){
                echo "<div class='published-courses'>
                    <a href='/Code1/yourCourse/12/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <p>ocena</p>
                                <p>liczba zakupień: 2</p>
                                <p>liczba opinii</p>
                            </div>
                        </div>
                    </a>
                    <a href='/Code1/yourCourse/16/'>
                        <div class='course-card'>
                            <img src='/Code1/photos/course-miniature.jpg' alt=''>
                            <div class='course-info'>
                                <h3>Tytuł</h3>
                                <p>ocena</p>
                                <p>liczba zakupień: 2</p>
                                <p>liczba opinii</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class='add-course'>
                    <button>Opublikuj nowy kurs</button>
                </div>
            </div>";
            }
        ?>
            
            
    </div>   
</section>