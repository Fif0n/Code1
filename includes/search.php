<?php
    
    if(isset($_GET['subPage'])){
        $search = $_GET['subPage'];
    } else if(isset($_POST['s'])){
        $search = $_POST['s'];
    } else if(!isset($_GET['s']) && !isset($_POST['s'])){
        header("Location: /Code1/home");
    }

    if($search == ''){
        header("Location: /Code1/home");
    }
    $data = new Database;
    $selectVar = "%$search%";
    $result = $data->con->prepare("SELECT DISTINCT course.courseID, course.name, course.prize, course.photoSource, course.tags, user.username FROM relation JOIN course ON course.courseID = relation.courseID JOIN user ON relation.userID = user.userID WHERE course.name LIKE :search OR course.tags LIKE :search OR user.username LIKE :search AND relation.published = 1 GROUP BY courseID");
    $result->bindParam(":search", $selectVar);
    $result->execute();

    
?>
<section>
    <?php
        if($result->rowCount() > 0){
            echo "<h1>".$result->rowCount()." rezultatów dla $search</h1>";
        } else {
            echo "<h1>Brak wynników dla $search</h1>
            <h4>Jeśli nie ma wynników, to jest szansa, że źle wpisałeś zapytanie</h4>";
        }
    ?>
    
    <div class="results-container">
    <?php
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $tags = json_decode($row['tags']);
    ?>
        <a href="/Code1/course/<?=$row['courseID']?>">
            <div class="course-card">
                <div class="course-img">
                    <img src="/Code1/miniatures/<?=$row['photoSource']?>">
                </div>
                <div class="course-info">
                    <h2><?=$row['name']?></h2>
                    <p><?=$row['username']?></p>
                    <p>Średnia ocen: 
                        <?php
                            $ratings = $data->con->prepare("SELECT AVG(opinion.rating) AS ratingAVG, COUNT(opinion.rating) AS ratingCOUNT FROM opinion JOIN relation ON relation.relationID = opinion.relationID WHERE relation.courseID = :courseID");
                            $ratings->bindParam(":courseID", $row['courseID'], PDO::PARAM_STR);
                            $ratings->execute();
                            while($rate = $ratings->fetch(PDO::FETCH_ASSOC)){
                                echo " ". round($rate['ratingAVG'], 2). " (".$rate['ratingCOUNT'] . ")";
                            }
                        ?>
                    </p>
                    <p>
                        <?php
                            foreach($tags as $tag){
                                echo "<em>$tag</em>";
                            }
                        ?>
                    </p>
                    <h3><?=$row['prize']?> zł</h3>
                </div>
            </div>
        </a>
        <?php
        }
        ?>
    </div>
</section>