<?php
    if(!isset($_SESSION['username'])){
        header("Location: /Code1/home");
    }
?>
<div class="your-course-container">
    <div class="video-container">
        <?php
            $data = new Database;
            $courseID = $_GET['id'];
            $stmt = $data->con->prepare("SELECT * FROM course JOIN relation ON course.courseID = relation.courseID JOIN user ON user.userID = relation.userID WHERE course.courseID = :courseID AND relation.userID = :userID");
            $stmt->bindParam(':courseID', $courseID, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_STR);
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            
        ?>
        <video
        id="my-video"
        class="video-js"
        controls
        preload="auto"
        poster="/Code1/miniatures/<?=$row['photoSource']?>"
        data-setup='{
            "playbackRates": [0.5, 1, 1.5, 2]
        }'
        >
            <source src="/Code1/videos/<?=$row['videoSource']?>" type="video/mp4" />
            <source src="MY_VIDEO.webm" type="video/webm" />
            <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a
            web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank"
                >supports HTML5 video</a>
            </p>
        </video>
    </div>
    <div class="your-course-section">
        <div class="section-nav">
            <ul>
                <li><div class='nav-option active' id="course-decription-btn">Opis kursu</div></li>
                <li><div class='nav-option' id="course-opinions-btn">Opinie</div></li>
            </ul>
        </div>
        <div class="section-content">
            <div class='course-description'>
                <h1><?=$row['name']?></h1>
                <p><?=$row['description']?></p>
            </div>
            <div class='course-opinions'>
                <h1>Opinie</h1>
                <form>
                    <label for="opinion">Zostaw opinię</label>
                    <textarea id="opinion" cols="20" rows="10"></textarea>
                </form>
                <?php
                    $opinions = $data->con->prepare("SELECT user.username, opinion.rating, opinion.opinionContent, opinion.opinionDateTime FROM opinion JOIN user ON user.userID = opinion.userID JOIN course ON course.courseID = opinion.courseID WHERE course.courseID = :courseID");
                    $opinions->bindParam(":courseID", $_GET['id']);
                    $opinions->execute();
                    while($opinionRow = $opinions->fetch(PDO::FETCH_ASSOC)){
                ?>
                
                    <div class="opinion-card">
                        <div class="opinion-card-header">
                            <h3><?=$opinionRow['username']?></h3>
                            <p><?= $opinionRow['opinionDateTime']?></p>
                        </div>
                        <div class="opinion-card-content">
                            <p><?= $opinionRow['opinionContent']?></p>
                        </div>
                        <div class="opinion-card-rating">
                            <p>Ocena: <?= $opinionRow['rating']?>/5</p>
                        </div>
                    </div>
                <?php 
                            }
                    }
                ?>
            </div>
        </div>
    </div>
</div>