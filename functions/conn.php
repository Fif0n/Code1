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
        // $user = 3;    
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->con->prepare("INSERT INTO $tableName (username, email, password) VALUES (:username, :email, :password)");
            
            $stmt->bindParam(':username', $userName, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password_hashed, PDO::PARAM_STR);    
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            // $stmt->bindParam(':roleid', $user, PDO::PARAM_INT);
            if(strlen($userName) > 4){
                if(strlen($password) > 4){
                    if($password === $password_repeat){
                        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                            $stmt_e = $this->con->prepare("SELECT email FROM $tableName WHERE email = :email");
                            $stmt_e->bindParam(':email', $email, PDO::PARAM_STR);
                            $stmt_e->execute();
                            if($stmt_e->rowCount() > 0){
                                $this->error[] = "Istnieje już taki użytkownik";
                                $this->ok =false;
                            } else {
                                $stmt->execute();
                                $this->error[] = "Rejestracja powiodła się";
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
            // $stmt->bindParam(':password', $password, PDO::PARAM_STR); + "AND password = :password" <- problem, bo nie możemy porównać hasła podanego z zahashowanym w bazie danych w zapytaniu
            $stmt->execute();
                       
                if($stmt->rowCount() <= 0){
                    $this->error[] = "Zły login lub hasło";
                    $this->ok =false;
                } else {
                    // przy dwóch takich samych loginach nie można się na drugiego użytkownika zalogować
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        if(password_verify($fields['password'], $row['password'])){
                            session_start();
                            $_SESSION['username'] = $login;
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

    public function editSoftData($tableName, $fields, $orginalUsername){
        $username = $fields['username'];
        $email = $fields['email'];
        $password = $fields['password'];
        $stmt = $this->con->prepare("SELECT password, userID FROM $tableName WHERE username = :orginalUsername");
        $stmt->bindParam(':orginalUsername', $orginalUsername, PDO::PARAM_STR);
        $stmt->execute();

        if(strlen($username) > 4){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    if(password_verify($password, $row['password'])){
                        $stmtU = $this->con->prepare("UPDATE $tableName SET username = :username, email = :email WHERE username = :orginalUsername");
                        $stmtU->bindParam(':username', $username, PDO::PARAM_STR);
                        $stmtU->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmtU->bindParam(':orginalUsername', $orginalUsername, PDO::PARAM_STR);
                        $stmtU->execute();
                        
                        $stmtN = $this->con->prepare("SELECT username, email FROM $tableName WHERE userID = :userID");
                        $stmtN->bindParam(':userID', $row['userID'], PDO::PARAM_STR);
                        $stmtN->execute();

                        while($rowN = $stmtN->fetch(PDO::FETCH_ASSOC)){
                            $_SESSION['username'] = $rowN['username'];
                            $_SESSION['email'] = $rowN['email'];
                            
                        }
        
                    } else {
                        $this->ok = false;
                        $this->error[] = 'Niepoprawne hasło';
                    }
                } 
            } else {
                $this->ok = false;
                $this->eror[] ="Niepoprawny E-mail";
            }
        } else {
            $this->ok = false;
            $this->eror[] ="Nazwa użytkownika musi mieć więcej niż 4 znaki";
        }
        
        echo json_encode(
            array(
                'ok' => $this->ok,
                'error' => $this->error
            )
        );
    }
}