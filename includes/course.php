<?php
$courseId = $_GET['id'];
if(!isset($_GET['subPage'])){
    $subPage = "";
} else {
    $subPage = $_GET['subPage'];
}

$data = new Database;
$stmt = $data->con->prepare("SELECT user.username, course.name, course.tags, course.description, course.prize, course.photoSource, relation.relationID FROM course JOIN relation ON course.courseID = relation.courseID JOIN user ON user.userID = relation.userID WHERE course.courseID = :courseID and relation.published = 1");
$stmt->bindParam(":courseID", $courseId);
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $tags = json_decode($row['tags']);
    $rating = $data->con->prepare("SELECT AVG(opinion.rating) AS ratingAVG, COUNT(opinion.rating) AS ratingCOUNT FROM opinion JOIN relation ON relation.relationID = opinion.relationID WHERE relation.courseID = :courseID");
    $rating->bindParam(":courseID", $courseId);
    $rating->execute();
    while($ratingRow = $rating->fetch(PDO::FETCH_ASSOC)){   

?>
<div class="course-container">
    <div class="course-header">
        <div class="header-info">
            <p><?php
                foreach($tags as $tag){
                    echo "<em>$tag</em>";
                }
            ?></p>
            <h1><?= $row['name']?></h1>
            <p><?= "Ocena: ".round($ratingRow['ratingAVG'], 2) . " (".$ratingRow['ratingCOUNT'].")"?></p>
            <?php
                }
            ?>
            <p>Autor: <?= $row['username']?></p>
        </div>
        <div class="header-card">
            <img src="/Code1/miniatures/<?=$row['photoSource']?>">
            <?php
                if(!isset($_SESSION['username'])){
                    echo '<p>Zaloguj się aby kupić</p>';
                } else {
                    $owner = $data->con->prepare("SELECT published from relation where relation.courseID = :courseID AND published = 1 AND relation.userID = :userID");
                    $owner->bindParam(":courseID", $courseId);
                    $owner->bindParam(":userID", $_SESSION['userID']);
                    $owner->execute();
                    $bought = $data->con->prepare("SELECT published from relation where relation.courseID = :courseID AND bought = 1 AND relation.userID = :userID");
                    $bought->bindParam(":courseID", $courseId);
                    $bought->bindParam(":userID", $_SESSION['userID']);
                    $bought->execute();
                    if(!$owner->rowCount() <= 0){
                        echo "<p>Jesteś właścicielem tego kurs</p>";
                    } else if (!$bought->rowCount() <= 0){
                        echo "<p>Posiadasz już ten kurs</p>";
                    } else {
                        echo "<button id='buy-course-btn'>Kup teraz</button>";
                    } 
                }
            ?>
            <p>Cena: <?= $row['prize']?> zł</p>
        </div>
    </div>
    <div class="course-info">
        <?php
            if($subPage == "" || $subPage == "description"){
                echo "
                <div class='course-info-nav'>
                    <ul>
                        <a href='/Code1/course/$courseId/description'><li class='active'><div class='course-option'><p>Opis kursu</p></div></li></a>
                        <a href='/Code1/course/$courseId/opinions'><li><div class='course-option'><p>Opinie</p></div></li></a>
                    </ul>
                </div>
                <div class='course-info-text'>
                    <p>".$row['description']."</p>
                </div>";
            } else if($subPage == "opinions" ){
                echo "
                <div class='course-info-nav'>
                    <ul>
                        <a href='/Code1/course/$courseId/description'><li><div class='course-option'><p>Opis kursu</p></div></li></a>
                        <a href='/Code1/course/$courseId/opinions'><li class='active'><div class='course-option active'><p>Opinie</p></div></li></a>
                    </ul>
                </div>
                <div class='course-info-opinions'>";
                $opinions = $data->con->prepare("SELECT user.username, opinion.rating, opinion.opinionContent, opinion.opinionDateTime FROM opinion JOIN relation ON relation.relationID = opinion.relationID JOIN user ON relation.userID = user.userID WHERE relation.courseID = :courseID GROUP BY opinion.opinionDateTime DESC");
                $opinions->bindParam(":courseID", $courseId, PDO::PARAM_STR);
                $opinions->execute();
                if($opinions->rowCount() <= 0){
                    echo "<h3>Brak opinii</h3>";
                } else {
                    while($opinionRow = $opinions->fetch(PDO::FETCH_ASSOC)){
                        echo "<div class='opinion-card'>
                            <div class='opinion-card-header'>
                                <h3>".$opinionRow['username']."</h3>
                                <p>".$opinionRow['opinionDateTime']."</p>
                            </div>
                            <div class='opinion-card-content'>
                                <p>".$opinionRow['opinionContent']."</p>
                            </div>
                            <div class='opinion-card-rating'>
                                <p>Ocena: ".$opinionRow['rating']."/5</p>
                            </div>                  
                        </div>";
                    }
                }      
            echo "</div>";
            }
        ?>
    </div>
</div>


<?php
if($owner->rowCount() <= 0 && $bought->rowCount() <= 0){
    echo "<div class='buy-popup'>
    <div class='buy-content'>
        <span class='close-buy'>&times;</span>
        <h1>Kup kurs ".$row['name']."</h1>
        <form action='/Code1/functions/buyCourse.php' method='POST'>
            <input type='hidden' value='".$courseId."' name='courseID'>
            <button name='submit'>Kup kurs za ".$row['prize']."</button>
        </form>
    </div>
</div>";
}
    }
?>