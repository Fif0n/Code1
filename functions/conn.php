<?php

class Database {
    public $con;
    public $error = array();
    public $ok = true;

    public function __construct(){
        try {
            $this->con = new PDO("mysql:host=localhost;dbname=shop", "root", "");
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo 'Coś poszło nie tak' . $e->getMessage();
        }
    }

    public function requiredValidation($field){
        $count = 0;
        foreach($field as $k => $v){
            if(empty($v)){
                $count++;
                $this->error[] = "Wszystkie pola muszą być wypełnione!";
                $this->ok = false;
                break;
            }
        }

        if($count == 0){
            return true;
        } else {
            $this->ok = false;
            echo json_encode(
                array(
                    'ok' => $this->ok,
                    'error' => $this->error
                )
            );
        }
        
    }

    public function canRegister($tableName, $fields){
        $email = $fields['email'];
        $userName = $fields['username'];
        $password = $fields['password'];
        $password_repeat = $fields['passwordRepeat'];   
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->con->prepare("INSERT INTO $tableName (username, email, password) VALUES (:username, :email, :password)");
            
            $stmt->bindParam(':username', $userName, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password_hashed, PDO::PARAM_STR);    
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            if(strlen($userName) > 4){
                if(strlen($password) > 4){
                    if($password === $password_repeat){
                        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                            $stmt_e = $this->con->prepare("SELECT email FROM $tableName WHERE email = :email");
                            $stmt_e->bindParam(':email', $email, PDO::PARAM_STR);
                            $stmt_e->execute();
                            if($stmt_e->rowCount() > 0){
                                $this->error[] = "Ten E-mail jest już użyty";
                                $this->ok =false;
                            } else {
                                $stmt_u = $this->con->prepare("SELECT username FROM $tableName WHERE username = :username");
                                $stmt_u->bindParam(':username', $userName, PDO::PARAM_STR);
                                $stmt_u->execute();
                                if($stmt_u->rowCount() > 0){
                                    $this->error[] = "Ta nazwa użytkownika jest już zajęta";
                                    $this->ok =false;
                                } else {
                                    $stmt->execute();
                                    $this->error[] = "Rejestracja powiodła się";
                                }
                            }
                        } else {
                            $this->error[] = "E-mail jest nie poprawny";
                            $this->ok =false;
                        }
                    } else {
                        $this->error[] = "Hasła różnią się";
                        $this->ok =false;
                    }
                } else {
                    $this->error[] = "Hasło użytkownika musi być dłuższa niż 4 znaków";
                    $this->ok =false;
                }
            } else {
                $this->error[] = "Nazwa użytkownika musi być dłuższa niż 4 znaków";
                $this->ok =false;
            }
            
            echo json_encode(
                array(
                    'ok' => $this->ok,
                    'error' => $this->error
                )
            );
    }

    public function canLogin($tableName, $fields){
        $login = $fields['username'];
        $password = $fields['password'];
            $stmt = $this->con->prepare("SELECT * FROM $tableName WHERE username = :username");
            $stmt->bindParam(':username', $login, PDO::PARAM_STR);
            $stmt->execute();
                       
                if($stmt->rowCount() <= 0){
                    $this->error[] = "Zły login lub hasło";
                    $this->ok =false;
                } else {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        if(password_verify($fields['password'], $row['password'])){
                            session_start();
                            $_SESSION['userID'] = $row['userID'];
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['email'] = $row['email'];
                            $this->error[] ='sukces';
                        } else {
                            $this->error[] = "Zły login lub hasło";
                            $this->ok =false;
                        }
                    }
                    
                }

                echo json_encode(
                    array(
                        'ok' => $this->ok,
                        'error' => $this->error
                    )
                );
    }

    public function logout(){
        session_start();
        session_unset();
        session_destroy();
        header("Location: /Code1/");
    }

    public function editSoftData($tableName, $fields, $orginalUsername, $userID){
        $username = $fields['username'];
        $email = $fields['email'];
        $password = $fields['password'];
        $stmt = $this->con->prepare("SELECT password FROM $tableName WHERE username = :orginalUsername AND userID = :userID");
        $stmt->bindParam(':orginalUsername', $orginalUsername, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmt->execute();

        if(strlen($username) > 4){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    if(password_verify($password, $row['password'])){
                        $stmt_e = $this->con->prepare("SELECT email FROM $tableName WHERE email = :email AND NOT userID = :userID");
                        $stmt_e->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt_e->bindParam(':userID', $userID, PDO::PARAM_STR);
                        $stmt_e->execute();
                        if($stmt_e->rowCount() > 0){
                            $this->ok = false;
                            $this->error[] = 'Istnieje już taki e-mail';
                        } else {
                            $stmt_u = $this->con->prepare("SELECT username FROM $tableName WHERE username = :username AND NOT userID = :userID");
                            $stmt_u->bindParam(':username', $username, PDO::PARAM_STR);
                            $stmt_u->bindParam(':userID', $userID, PDO::PARAM_STR);
                            $stmt_u->execute();
                            if($stmt_u->rowCount() > 0){
                                $this->ok = false;
                                $this->error[] = 'Ta nazwa już jest zajęta';
                            } else {
                                $stmtU = $this->con->prepare("UPDATE $tableName SET username = :username, email = :email WHERE username = :orginalUsername");
                                $stmtU->bindParam(':username', $username, PDO::PARAM_STR);
                                $stmtU->bindParam(':email', $email, PDO::PARAM_STR);
                                $stmtU->bindParam(':orginalUsername', $orginalUsername, PDO::PARAM_STR);
                                $stmtU->execute();
                                
                                $stmtN = $this->con->prepare("SELECT username, email FROM $tableName WHERE userID = :userID");
                                $stmtN->bindParam(':userID', $userID, PDO::PARAM_STR);
                                $stmtN->execute();

                                while($rowN = $stmtN->fetch(PDO::FETCH_ASSOC)){
                                    $_SESSION['username'] = $rowN['username'];
                                    $_SESSION['email'] = $rowN['email'];
                                    
                                }
                            }
                        }
                    } else {
                        $this->ok = false;
                        $this->error[] = 'Niepoprawne hasło';
                    }
                } 
            } else {
                $this->ok = false;
                $this->error[] ="Niepoprawny E-mail";
            }
        } else {
            $this->ok = false;
            $this->error[] ="Nazwa użytkownika musi mieć więcej niż 4 znaki";
        }
        
        echo json_encode(
            array(
                'ok' => $this->ok,
                'error' => $this->error
            )
        );
    }

    public function editPassword($tableName, $fields){
        $oldPassword = $fields['oldPassword'];
        $newPassword = $fields['newPassword'];
        $repeatPassword = $fields['repeatPassword'];
        $stmt = $this->con->prepare("SELECT password FROM $tableName WHERE userID = :userID");
        $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_STR);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            if(password_verify($oldPassword, $row['password'])){
                if(strlen($newPassword) > 4){
                    if($newPassword === $repeatPassword){
                        $passwordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
                        $stmtIns = $this->con->prepare("UPDATE $tableName SET password = :newPassword WHERE userID = :userID");
                        $stmtIns->bindParam(':newPassword', $passwordHashed, PDO::PARAM_STR);
                        $stmtIns->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_STR);
                        $stmtIns->execute();
                    } else {
                        $this->ok = false;
                        $this->error[] = 'Nowe hasła różnią się';
                    }
                } else {
                    $this->ok = false;
                    $this->error[] = 'Nowe hasło musi mieć więcej niż 4 znaki';
                }
            } else {
                $this->ok = false;
                $this->error[] = 'Niepoprawne hasło';
            }
        }
        echo json_encode(
            array(
                'ok' => $this->ok,
                'error' => $this->error
            )
        );
    }

    public function deleteAccount($tableName, $field){
        $password = $field['password'];
        $stmt = $this->con->prepare("SELECT password FROM $tableName WHERE userID = :userID");
        $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_STR);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(password_verify($password, $row['password'])){
                $stmtDel = $this->con->prepare("DELETE FROM $tableName WHERE userID = :userID");
                $stmtDel->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_STR);
                $stmtDel->execute();
                session_unset();
                session_destroy();
            } else {
                $this->ok = false;
                $this->error[] = 'Złe hasło';
            }
        }
        echo json_encode(
            array(
                'ok' => $this->ok,
                'error' => $this->error
            )
        );
    }

    public function createCourse(){
        if(!empty($_POST['courseName']) && !empty($_POST['courseDescription']) && !empty($_FILES['courseMiniature']) && !empty($_FILES['courseVideo']) && !empty($_POST['courseTags']) && !empty($_POST['coursePrize'])){
            $courseName = $_POST['courseName'];
            $courseDescription = $_POST['courseDescription'];
            $courseMiniature = $_FILES['courseMiniature'];
            $courseVideo = $_FILES['courseVideo'];
            $courseTags = $_POST['courseTags'];
            $coursePrize = $_POST['coursePrize'];

            $tags = explode(',', $courseTags);
                    
            $trimedTags = array();
            foreach($tags as $tag){
                $trimedTags[] = trim($tag);
            }

            $miniatureExt = explode('/', $courseMiniature['type']);
            $videoExt = explode('/', $courseVideo['type']);

            $allowedMiniatureExt = array('jpg', 'png', 'jpeg');
            $allowedVideoExt = array('mp4');
            if($courseMiniature['error'] === 0){
                if($courseVideo['error'] === 0){
                    if(in_array($miniatureExt[1], $allowedMiniatureExt)){
                        if(in_array($videoExt[1], $allowedVideoExt)){
                            $stmt = $this->con->prepare("SELECT * FROM course WHERE name = :name");
                            $stmt->bindParam(":name", $courseName, PDO::PARAM_STR);
                            $stmt->execute();
                            if($stmt->rowCount() == 0){

                                $fileUniqid = uniqid("" ,true);
                                $newPhotoName = "$fileUniqid." . $miniatureExt[1];
                                $newVideoName = "$fileUniqid." . $videoExt[1];
                                $jsonTags = json_encode($trimedTags);
                                    $courseIns = $this->con->prepare("INSERT INTO course (name, prize, description, photoSource, videoSource, tags) VALUES (:name, :prize, :description, :photoSource, :videoSource, :tags)");
                                    $courseIns->bindParam(':name', $courseName, PDO::PARAM_STR);
                                    $courseIns->bindParam(':prize', $coursePrize, PDO::PARAM_STR);
                                    $courseIns->bindParam(':description', $courseDescription, PDO::PARAM_STR);
                                    $courseIns->bindParam(':photoSource', $newPhotoName, PDO::PARAM_STR);
                                    $courseIns->bindParam(':videoSource', $newVideoName, PDO::PARAM_STR);
                                    $courseIns->bindParam(':tags', $jsonTags, PDO::PARAM_STR);
                                    $courseIns->execute();

                                    $relationDate = date("Y-m-d");

                                    $courseID = $this->con->prepare("SELECT courseID FROM course WHERE name = :name");
                                    $courseID->bindParam(":name", $courseName, PDO::PARAM_STR);
                                    $courseID->execute();
                                    move_uploaded_file($courseMiniature['tmp_name'], "../miniatures/$newPhotoName");
                                    move_uploaded_file($courseVideo['tmp_name'], "../videos/$newVideoName");
                                    while($row = $courseID->fetch(PDO::FETCH_ASSOC)){
                                        $relationIns = $this->con->prepare("INSERT INTO relation (bought, published, currentTime, relationDate, courseID, userID) VALUES (0, 1, 0, :relationDate, :courseID, :userID)");
                                        $relationIns->bindParam(':relationDate', $relationDate, PDO::PARAM_STR);
                                        $relationIns->bindParam(':courseID', $row['courseID'], PDO::PARAM_STR);
                                        $relationIns->bindParam(':userID', $_SESSION['userID']);
                                        $relationIns->execute();
                                    }
                                    $this->error[] = 'Kurs został opublikowany';
                            } else {
                                $this->error[] = 'Istnieje już taka nazwa kursu';
                                $this->ok = false;
                            }
                        } else {
                            $this->error[] = 'Niepoprawyne rozszerzenie video. Dozwolone to mp4';
                            $this->ok = false;
                        }
                    } else {
                        $this->error[] = 'Niepoprawyne rozszerzenie zdjęcia. Dozwolone to png, jpg i jpeg';
                        $this->ok = false;
                    }
                } else {
                    $this->error[] = 'Plik video jest zepsuty';
                    $this->ok = false;
                }
            } else {
                $this->error[] = 'Plik miniatury jest zepsuty';
                $this->ok = false;
            }
            

        } else {
            $this->error[] = 'Wszystkie pola muszą być uzupełnione!';
            $this->ok = false;
        }
      
        
        echo json_encode(
            array(
                'ok' => $this->ok,
                'error' => $this->error
            )
        );
    }
    public function getCurrentTime($userId, $courseId){
        $stmt = $this->con->prepare("SELECT currentTime FROM relation WHERE courseID = :courseID AND userID = :userID");
        $stmt->bindParam(":courseID", $courseId, PDO::PARAM_STR);
        $stmt->bindParam(":userID", $userId, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(
            array(
                'currentTime' => $row['currentTime']
            )
        );
    }
    public function setCurrentTime($currentTime, $courseId, $userId){
        $stmt = $this->con->prepare("UPDATE relation SET currentTime = :currentTime WHERE userID = :userID AND courseID = :courseID");
        $stmt->bindParam(":currentTime", $currentTime, PDO::PARAM_STR);
        $stmt->bindParam(":userID", $userId, PDO::PARAM_STR);
        $stmt->bindParam(":courseID", $courseId, PDO::PARAM_STR);
        $stmt->execute();
    }
    public function getOpinions($id){
        $stmt = $this->con->prepare("SELECT user.username, opinion.rating, opinion.opinionContent, opinion.opinionDateTime FROM opinion JOIN relation ON relation.relationID = opinion.relationID JOIN user ON relation.userID = user.userID WHERE relation.courseID = :courseID GROUP BY opinion.opinionDateTime DESC");
        $stmt->bindParam(":courseID", $id, PDO::PARAM_STR);
        $stmt->execute();
        $owner = $this->con->prepare("SELECT published FROM relation WHERE userID = :userID AND courseID = :courseID");
        $owner->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_STR);
        $owner->bindParam(":courseID", $id, PDO::PARAM_STR);
        $owner->execute();
        if($stmt->rowCount() <= 0){
            $opinionsJSON[] = array();
            while ($row = $owner->fetch(PDO::FETCH_ASSOC)) {
                if($row['published'] == 1){
                    $opinionsJSON[] = ["owner" => true];
                } else {
                    $opinionsJSON[] = ["owner" => false];
                }
            }
            echo json_encode($opinionsJSON);
        } else {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $opinionsJSON[] = array(
                    "username" => $row['username'],
                    "opinionDateTime" => $row['opinionDateTime'],
                    "opinionContent" => $row['opinionContent'],
                    "rating" => $row['rating']
                );
            }
            
            while ($row = $owner->fetch(PDO::FETCH_ASSOC)) {
                if($row['published'] == 1){
                    $opinionsJSON[] = ["owner" => true];
                } else {
                    $opinionsJSON[] = ["owner" => false];
                }
            }
            echo json_encode($opinionsJSON);
            
        }
        
    }

    public function addOpinion($fields){
        $opinionContent = $fields['opinionContent'];
        $opinionRating = $fields['opinionRating'];
        $courseId = $fields['courseId'];
        $dateTime = date('Y-m-d H:i:s');
        $userID = $_SESSION['userID'];
        $relationID = $this->con->prepare("SELECT relationID FROM relation WHERE userID = :userID AND courseID = :courseID");
        $relationID->bindParam(":courseID",$courseId);
        $relationID->bindParam(":userID",$userID);
        $relationID->execute();
        while($id = $relationID->fetch(PDO::FETCH_ASSOC)){
            $stmt = $this->con->prepare("INSERT INTO opinion (rating, opinionContent, opinionDateTime, relationID) VALUES (:rating, :opinionContent, :opinionDateTime, :relationID)");
            $stmt->execute(
                array(
                    ":rating" => $opinionRating,
                    ":opinionContent" => $opinionContent,
                    ":opinionDateTime" => $dateTime,
                    ":relationID" => $id['relationID']
                )
            );
        }
    }

    public function editCourse($fields){
        $name = $fields['name'];
        $description = $fields['description'];
        $prize = $fields['prize'];
        $courseId = $fields['id'];
        $isName = $this->con->prepare("SELECT name FROM course WHERE name = :name AND NOT courseID = :courseID");
        $isName->bindParam(":name", $name);
        $isName->bindParam(":courseID", $courseId);
        $isName->execute();
        if($isName->rowCount() <= 0){
            $updateCourse = $this->con->prepare("UPDATE course SET name = :name, description = :description, prize = :prize WHERE courseID = :courseID");
            $updateCourse->bindParam(":name", $name);
            $updateCourse->bindParam(":description", $description);
            $updateCourse->bindParam(":prize", $prize);
            $updateCourse->bindParam(":courseID", $courseId);
            $updateCourse->execute();
        } else {
            $this->ok = false;
            $this->error[] = "Istnieje już taka nazwa kursu";
        }
        echo json_encode(
            array(
                'ok' => $this->ok,
                'error' => $this->error
            )
        );
    }

    public function deleteCourse($fields){
        $password = $fields['password'];
        $courseId = $fields['id'];
        $hashedPassword = $this->con->prepare("SELECT password FROM user WHERE userID = :userID");
        $hashedPassword->bindParam(":userID", $_SESSION['userID']);
        $hashedPassword->execute();
        $correctPassword = $hashedPassword->fetch(PDO::FETCH_ASSOC);
        if(password_verify($password, $correctPassword['password'])){
            $relationID = $this->con->prepare("SELECT relationID FROM relation WHERE courseID = :courseID");
            $relationID->bindParam(":courseID", $courseId);
            $relationID->execute();
            while($relationIDRow = $relationID->fetch(PDO::FETCH_ASSOC)){
                $deleteOpinions = $this->con->prepare("DELETE FROM opinion WHERE relationID = :relationID");
                $deleteOpinions->bindParam(":relationID", $relationIDRow['relationID']);
                $deleteOpinions->execute();
            }
            
            $deleteRelation = $this->con->prepare("DELETE FROM relation WHERE courseID = :courseID");
            $deleteRelation->bindParam(":courseID", $courseId);
            $deleteRelation->execute();

            $fileNames = $this->con->prepare("SELECT photoSource, videoSource FROM course WHERE courseID = :courseID");
            $fileNames->bindParam(":courseID", $courseId);
            $fileNames->execute();

            while($row = $fileNames->fetch(PDO::FETCH_ASSOC)){
                unlink("../miniatures/".$row['photoSource']."");
                unlink("../videos/".$row['videoSource']."");
            }

            $deleteCourse = $this->con->prepare("DELETE FROM course WHERE courseID = :courseID");
            $deleteCourse->bindParam(":courseID", $courseId);
            $deleteCourse->execute();

        } else {
            $this->ok = false;
            $this->error[] = "Nieprawidłowe hasło";
        }

        echo json_encode(
            array(
                'ok' => $this->ok,
                'error' => $this->error
            )
        );

    }
    public function buyCourse($courseId, $userId){
        $date = date("Y-m-d");
        $stmt = $this->con->prepare("INSERT INTO relation (bought, published, currentTime, relationDate, courseID, userID) VALUES (1, 0, 0, :date, :courseID, :userID)");
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":courseID", $courseId);
        $stmt->bindParam(":userID", $userId);
        $stmt->execute();
    }
}