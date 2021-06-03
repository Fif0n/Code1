<section>
    <div class="home-page">
        <img src="photos/home-photo.jpg">
        <div class="recomended-courses">
            <h1>Najpopularniejsze kursy</h1>
            <div class="home-courses-grid">
            <?php
                $data = new Database;
                $highestRate = $data->con->prepare("
                SELECT AVG(rating) AS rating_avg, COUNT(opinionID) AS rating_count, relationID FROM opinion GROUP BY opinion.relationID having max(rating) AND COUNT(opinionID) > 1 ORDER BY avg(rating) DESC LIMIT 4");
                $highestRate->execute();
                while($row = $highestRate->fetch(PDO::FETCH_ASSOC)){
                    $popularCourses = $data->con->prepare("SELECT course.courseID, course.name, course.prize, course.photoSource, course.tags, user.username, relation.relationID FROM course JOIN relation ON course.courseID = relation.courseID JOIN user ON relation.userID = user.userID WHERE relation.relationID = :relationID");
                    $popularCourses->bindParam(':relationID', $row['relationID']);
                    $popularCourses->execute();
                    while($popularRow = $popularCourses->fetch(PDO::FETCH_ASSOC)){
                        $tags = json_decode($popularRow['tags']);
            ?>
                <a href="/Code1/includes/course/<?=$popularRow['courseID']?>">
                    <div class="course-card">
                        <img src="miniatures/<?= $popularRow['photoSource']?>">
                        <div class="course-info">
                            <h3><?= $popularRow['name']?></h3>
                            <h4><?= $popularRow['username']?></h4>
                            <p><?= "Ocena: ".round($row['rating_avg'], 2) . " (".$row['rating_count'].")"?></p>
                            <p>Cena: <?= $popularRow['prize']. " zł"?></p>
                            <p><?php
                             foreach($tags as $tag){
                                echo "<em>$tag</em>";
                            }
                            ?></p>
                        </div>
                    </div>
                </a>
            <?php
                    }
                }
            ?>
            </div>
            <h1>Najnowsze kursy</h1>
            <div class="home-courses-grid">
                <?php
                    $newCourses = $data->con->prepare("SELECT course.courseID, course.photoSource, course.name, course.tags, user.username, course.prize FROM relation JOIN course ON course.courseID = relation.courseID JOIN user ON user.userID = relation.userID WHERE relation.published = 1 ORDER by relation.relationDate DESC LIMIT 4");
                    $newCourses->execute();
                    while($row = $newCourses->fetch(PDO::FETCH_ASSOC)){
                        $ratings = $data->con->prepare("SELECT AVG(opinion.rating) AS ratingAVG, COUNT(opinion.rating) AS ratingCOUNT FROM opinion JOIN relation ON relation.relationID = opinion.relationID WHERE relation.courseID = :courseID");
                        $ratings->bindParam(":courseID", $row['courseID'], PDO::PARAM_STR);
                        $ratings->execute();
                        while($ratingRow = $ratings->fetch(PDO::FETCH_ASSOC)){
                            $tags = json_decode($row['tags']);      
                ?>
                <a href="/Code1/includes/course/<?=$row['courseID']?>">
                    <div class="course-card">
                        <img src="miniatures/<?=$row['photoSource']?>">
                        <div class="course-info">
                            <h3><?=$row['name']?></h3>
                            <h4><?=$row['username']?></h4>
                            <?php
                                echo "Ocena: ". round($ratingRow['ratingAVG'], 2). " (".$ratingRow['ratingCOUNT'] . ")<p>";
                            ?>
                            <p>Cena: <?=$row['prize']. " zł"?></p>
                            <p><?php
                             foreach($tags as $tag){
                                echo "<em>$tag</em>";
                            }
                            ?></p>
                        </div>
                    </div>
                </a>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</section>