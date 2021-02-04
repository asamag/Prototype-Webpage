<?php
function SaveData($nme, $mail, $hash){
    $db = new SQLite3("./db/sqlite.db");
    $sql = "INSERT INTO USER (NAME, EMAIL, PASSWORD) VALUES (:nme, :mail, :hash)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':nme', $nme, SQLITE3_TEXT);
    $stmt->bindParam(':mail', $mail, SQLITE3_TEXT);
    $stmt->bindParam(':hash', $hash, SQLITE3_TEXT);
    if($stmt->execute()){
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false;
    }
}
function AddComment($headline, $txt, $user, $imgpath){
    $db = new SQLite3("./db/sqlite.db");
    $sql = "INSERT INTO POST (HEADLINE, TXT, NAME, IMG) VALUES (:headline, :txt, :user, :imgpath)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':headline', $headline, SQLITE3_TEXT);
    $stmt->bindParam(':txt', $txt, SQLITE3_TEXT);
    $stmt->bindParam(':user', $user, SQLITE3_TEXT);
    $stmt->bindParam(':imgpath', $imgpath, SQLITE3_TEXT);

    if($stmt->execute()){
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false;
    }
}
function UpdatePassword($newpassword, $user){
        $db = new SQLite3("./db/sqlite.db");    
        $sql = "UPDATE USER SET PASSWORD=:password WHERE NAME=:name";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':password', $newpassword);
        $stmt->bindParam(':name', $user);
        if($stmt->execute()){
        $db->close();
        return true;
        }
}
function UpdateUser($username, $email){
    $db = new SQLite3("./db/sqlite.db");    
    $sql = "UPDATE USER SET NAME=:name WHERE EMAIL=:email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name', $username);
    $stmt->bindParam(':email', $email);
    if($stmt->execute()){
    $db->close();
    return true;
    }
}
function ValidatePassword($oldpassword, $user){
    $db = new SQLite3("./db/sqlite.db");
    $stmt = $db->prepare("SELECT * FROM USER WHERE NAME=:name");
    $stmt -> bindParam(':name', $user, SQLITE3_TEXT);
    $result = $stmt -> execute();

    $user = $result->fetchArray();
    $hashed = $user['PASSWORD'];

    if(password_verify($oldpassword, $hashed)){
        $db->close();
        return true;
        
    }
    else{
        $db->close();
        return false;
    }
}
function ValidateUser($olduser){
    $db = new SQLite3("./db/sqlite.db");
    $stmt = $db->prepare("SELECT * FROM USER WHERE NAME=:name");
    $stmt -> bindParam(':name', $olduser, SQLITE3_TEXT);
    $result = $stmt -> execute();

    $user = $result->fetchArray();
    $name = $user['NAME'];

    if($olduser = $name){
        return true;
    }
    else{
        return false;
    }
}
function CheckEmail($email){
    $db = new SQLite3("./db/sqlite.db");
    $stmt = $db->prepare("SELECT * FROM USER WHERE EMAIL=:email");
    $stmt -> bindParam(':email', $email, SQLITE3_TEXT);
    $result = $stmt -> execute();

    $user = $result->fetchArray();
    $mail = $user['EMAIL'];

    if($email = $mail){
        return true;
    }
    else{
        return false;
    }
}
function TestUser(){
    $db = new SQLite3("./DB/sqlite.db");

    $test = $db->query("SELECT * FROM USER");
    
    while($row = $test->fetchArray()){
        echo $row['NAME']."<br>"."Lösenord: ".$row['PASSWORD']."<br>"."HASH: ".$row['HASH']."<br>"."Epost-adress: ".$row['EMAIL']."<br><br>";
    }
 }
 function TestComment(){
    $db = new SQLite3("./DB/sqlite.db");
    
    $test = $db->query("SELECT * FROM POST");
    $img = $db->query("SELECT IMG FROM POST ORDER BY ID");

    while($row = $test->fetchArray()){
        if($row['IMG'] != null){
            echo nl2br('<div class="comment">'."<img class='img' src='./img/".$row['IMG']."' alt='Post pic'>"."<br><br>".$row['HEADLINE']."<br><br>".$row['TXT']."<br><br><br>"."Användare: ".$row['NAME']."<br><br><br>"."</div>");
            echo "<br>";
        }
        else{
            echo nl2br('<div class="comment">'."<img width='100' height='100' src='img/avatar.png' alt='Default pic'>"."<br><br>".$row['HEADLINE']."<br><br>".$row['TXT']."<br><br><br>"."Användare: ".$row['NAME']."<br><br><br>"."</div>");
            echo "<br>";
        }
    }
}
 function ValidateLogIn($name, $password){
    $db = new SQLite3("./db/sqlite.db");
    $stmt = $db->prepare("SELECT * FROM USER WHERE NAME=:name");
    $stmt -> bindParam(':name', $name, SQLITE3_TEXT);
    $result = $stmt -> execute();

    $user = $result->fetchArray();
    $hashed = $user['PASSWORD'];

    $checkPSW = password_verify($password, $hashed);
    if($checkPSW){
        session_start();
        $_SESSION['id'] = $user['NAME'];
            if($user['ADMIN']!= null){
            $_SESSION['admin'] = true;
            }
        return true;
    }
    else{
        $error_login = "Inloggningen misslyckades. Försök igen.";
        header("Location: login.php?password={$error_login}");
    }
}
  function Search ($term){
     $db = new SQLite3("./DB/sqlite.db");
     $stmt = $db->prepare("SELECT * FROM 'POST' WHERE TXT LIKE :search OR HEADLINE LIKE :search OR NAME LIKE :search ORDER BY ID");
     $stmt->bindValue(':search', "%".$term."%", SQLITE3_TEXT);
     $result=$stmt->execute();
     
    while($row = $result->fetchArray()){
        if($row['IMG'] != null){
            echo nl2br('<div class="comment">'."<img class='img' src='./img/".$row['IMG']."' alt='Post pic'>"."<br><br>".$row['HEADLINE']."<br>".$row['TXT']."<br><br><br>"."Användare: ".$row['NAME']."</div>");
        }
        else{
            echo nl2br('<div class="comment">'.$row['HEADLINE']."<br>".$row['TXT']."<br><br><br>"."Användare: ".$row['NAME']."<br><br>"."</div>");
        }
    }
 }
 ?>