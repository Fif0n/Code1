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
        data-setup="{}"
        >
            <source src="/Code1/videos/<?=$row['videoSource']?>" type="video/mp4" />
            <source src="MY_VIDEO.webm" type="video/webm" />
            <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a
            web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank"
                >supports HTML5 video</a
            >
            </p>
        </video>
    </div>
    <div class="your-course-section">
        <div class="section-nav">
            <ul>
            <?php
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                } else {
                    $id = "";
                }
                echo "<a href='/Code1/yourCourse/$id/courseDescription'><li><div class='nav-option active'>Opis kursu</div></li></a>
                <a href='/Code1/yourCourse/$id/courseOpinions'><li><div class='nav-option'>Opinie</div></li></a>";
                
            ?>
            </ul>
        </div>
        <div class="section-content">
        <?php
            if(isset($_GET['subPage'])){
                $subPage = $_GET['subPage'];
            } else {
                $subPage = "";
            }

            

            if($subPage == ""){
                echo "<div class='course-description'>
                    <h1>O kursie nr ".$row['name']."</h1>
                    <p>".$row['description']."</p>
                </div>";
            } else if ($subPage == "courseDescription"){
                echo "<div class='course-description'>
                    <h1>O kursie nr ".$row['name']."</h1>
                    <p>".$row['description']."</p>
                </div>";
            } else if ($subPage == "courseOpinions"){
                echo "<div class='course-opinions'>
                        opinions
                    </div>";
            }
        }
        ?>
            
            
        </div>
    </div>
</div>