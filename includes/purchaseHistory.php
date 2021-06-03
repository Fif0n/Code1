<?php
    if(!isset($_SESSION['username'])){
        header("Location: /Code1/home");
    }
    

    
?>
<section>
    <h1>Historia zakupów</h1>
    <div class="purchased-history-container">
        <table>
        <col width="70%" />
        <col width="15%" />
        <col width="15%" />
            <tr>
                <th>Nazwa kursu</th>
                <th>Data zakupu</th>
                <th>Cena</th>
            </tr>
            <?php
                $data = new Database;
                $purchasedCourses = $data->con->prepare("SELECT relation.relationDate, course.prize, course.name, course.courseID FROM relation JOIN course ON relation.courseID = course.courseID WHERE relation.userId = :userID AND relation.bought = 1");
                $purchasedCourses->bindParam(":userID", $_SESSION['userID']);
                $purchasedCourses->execute();
                while($row = $purchasedCourses->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr>
                <td><a href="/Code1/yourCourse/<?=$row['courseID']?>"><?=$row['name']?></a></td>
                <td><?=$row['relationDate']?></td>
                <td><?=$row['prize']?> zł</td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>
</section>