<?php
    $data = new Database;
    if(!isset($_SESSION['username'])){
        header("Location: /Code1/home");
    }
        $isThereRelation = $data->con->prepare("SELECT bought, published FROM relation WHERE userID = :userID AND courseID = :courseID");
        $isThereRelation->bindParam(":userID", $_SESSION['userID']);
        $isThereRelation->bindParam(":courseID", $_GET['id']);
        $isThereRelation->execute();
        if($isThereRelation->rowCount() <= 0){
            header("Location: /Code1/yourCourses");
        }
?>
<div class="your-course-container">
    <div class="video-container">
        <?php
            
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
                <?php
                $owner = false;
                while($relationRow = $isThereRelation->fetch(PDO::FETCH_ASSOC)){
                    if($relationRow['published'] == 1){
                        echo "<li><div class='nav-option' id='course-edit-btn'>Edytuj Dane</div></li>
                        <li><div class='nav-option' id='course-delete-btn'>Usuń kurs</div></li>
                        ";
                        $owner = true;
                    }
                }
                   
                ?>
            </ul>
        </div>
        <div class="section-content">
            <div class='course-description'>
                <h1><?=$row['name']?></h1>
                <p><?=$row['description']?></p>
            </div>
            
        </div>
    </div>
</div>
<?php
    if($owner){
        echo "<div class='edit-popup'>
            <div class='edit-content'>
                <span class='close-edit'>&times;</span>
                <h1>Edytuj dane</h1>
                <form>
                    <input type='text' id='edit-course-name' placeholder='Nazwa kursu' value='".$row['name']."'>
                    <textarea placeholder='Opis kursu' id='edit-course-description'>".$row['description']."</textarea>
                    <input type='number' placeholder='Cena' id='edit-course-prize' value='".$row['prize']."'>
                    <button type='submit' id='edit-course-submit'>Edytuj</button>
                    <ul id='edit-course-error-message'>

                    </ul>
                </form>
            </div>
        </div>
        <div class='delete-course-popup'>
            <div class='delete-course-content'>
                <span class='close-delete'>&times;</span>
                <h1>Usuń kurs</h1>
                <form>
                <h2>Podaj hasło aby usunąć kurs</h2>
                    <input type='password' id='delete-course-password' placeholder='Hasło'> 
                    <button id='delete-course-submit'>Usuń</button>
                    <ul id='delete-course-error-message'>

                    </ul>
                </form>
                <p><em>Uwaga: </em>usunięcie jest nieodwracalne</p>
            </div>
        </div>";
    }
}
?>