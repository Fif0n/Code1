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
            $data = new Database;
            $stmt = $data->con->prepare("SELECT * FROM course JOIN relation ON course.courseID = relation.courseID JOIN user ON user.userID = relation.userID WHERE course.courseID = relation.courseID AND relation.userID = :userID AND relation.published = 1");
            $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_STR);
            $stmt->execute();
            
           
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
                echo "<div class='published-courses'>";
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $tags = json_decode($row['tags']);
                    echo "
                        <a href='/Code1/yourCourse/".$row['courseID']."/'>
                            <div class='course-card'>
                                <img src='/Code1/miniatures/".$row['photoSource']."' alt=''>
                                <div class='course-info'>
                                    <h3>".$row['name']."</h3>
                                    <p>średnia ocena:";
                                    $ratings = $data->con->prepare("SELECT AVG(opinion.rating) AS ratingAVG, COUNT(opinion.rating) AS ratingCOUNT FROM opinion JOIN relation ON relation.courseID = opinion.courseID WHERE opinion.courseID = :courseID");
                                    $ratings->bindParam(":courseID", $row['courseID'], PDO::PARAM_STR);
                                    $ratings->execute();
                                    while($rate = $ratings->fetch(PDO::FETCH_ASSOC)){
                                        echo " ". $rate['ratingAVG']. " (".$rate['ratingCOUNT'] . ")";
                                    }
                                    echo "</p>
                                    <p>liczba zakupień: ";
                                    $boughtCount = $data->con->prepare("SELECT COUNT(relation.bought) AS boughtCOUNT FROM relation JOIN course ON relation.courseID = course.courseID WHERE relation.bought = 1 AND relation.courseID = :courseID");
                                    $boughtCount->bindParam(":courseID", $row['courseID'], PDO::PARAM_STR);
                                    $boughtCount->execute();
                                    while($bought = $boughtCount->fetch(PDO::FETCH_ASSOC)){
                                        echo $bought['boughtCOUNT'];
                                    }
                                    echo "</p>
                                    <p>";
                                    foreach($tags as $tag){
                                        echo "<em>$tag</em>";
                                    }
                                    echo "</p>
                                </div>
                            </div>
                        </a>
                     ";
                }
                echo "</div>
                <div class='add-course'>
                        <a href='/Code1/createCourse/'><button>Opublikuj nowy kurs</button></a>
                    </div>
                </div>
                ";
            }
        ?>
            
            
    </div>   
</section>