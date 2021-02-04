<?php
function PrintComments(){
    $array = GetComments();
    while ($row = $array->fetchArray()){
        PrintDiv($row);
    }
}
function PrintDiv($row){
    echo '<div class = "printDiv"> ';
    EchoImage($row);
    echo'<p Id = h2Username>';
    echo $row['Username'];
    echo ":";
    echo'</p>'; 
    echo $row['Text'];
    echo'</div>';  
}
function EchoImage($row){
    if($row['UserImage'] == ""){ 
        echo '<img width ="100" height = "100" src = "pictures/default.jpg" alt "Default Profile Pic">';
    }
    else{
        echo "<img width ='100' height ='100' src ='pictures/".$row['UserImage']."' alt ='Profile Pic'>";
    }
}
function GetComments(){
    $db = new SQLite3("./db/Labb2.db");
    $stmt = $db->prepare("SELECT * FROM Comments");
    $result = $stmt->execute();
    while($data = $result->fetchArray())
    {
        $array[] = $data;
    }
        return $result;
        $db->close();
}
function ValidateComment($comment){
    if($comment == ""){
        return false;
    }
    else return true;
}
function GetUserImage($userID){
    $db = new SQLite3("./db/Labb2.db");
    $imageSQL = "SELECT Image FROM Users WHERE Id = :userID";
    $imageSTMT = $db->prepare($imageSQL);
    $imageSTMT->bindParam( ':userID', $userID, SQLITE3_TEXT);
    $imageResult = $imageSTMT->execute();
    $imageBool = $imageResult->fetchArray();
    if($imageBool == false){
        return "";
    }
    else {
        return $imageBool['Image'];
    }
}
function AddComment($text,$username, $userID){
    $db = new SQLite3("./db/Labb2.db");
    $image = GetUserImage($userID);
    $sql = "INSERT INTO Comments (Username, Text, UserID, UserImage) VALUES (:username, :text, :userID, :image)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam( ':username', $username, SQLITE3_TEXT);
    $stmt->bindParam( ':text', $text, SQLITE3_TEXT);
    $stmt->bindParam( ':userID', $userID, SQLITE3_TEXT);
    $stmt->bindParam( ':image', $image, SQLITE3_TEXT);
    if($stmt->execute()){
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false;
    }
}
function StopSession(){
    unset($_SESSION['Id']);
    unset($_SESSION['Username']);
    unset($_SESSION['Email']);
    session_destroy();
}
function StartSession($userID, $username, $email){
    session_start();
    $_SESSION['Id'] = $userID;
    $_SESSION['Username'] = $username;
    $_SESSION['Email'] = $email;
}
function VerifyLogin($username, $password){
if (!empty($_POST)){
    if (isset($username) && isset($password)){
        $db = new SQLite3("./db/Labb2.db");
        $stmt = $db->prepare("SELECT * FROM Users WHERE Username = :username");
        $stmt->bindParam( ':username', $username, SQLITE3_TEXT);
        $result = $stmt->execute();
        $user = $result->fetchArray();
        if($user != Null){
    	if (password_verify($password, $user['Salt'])) {
            return $user;
        }
        else {
            return false;
        }
    } else return false;
    }
    else return false; 
}
else return false;
}
function RegisterUser($username,$password,$email){
    $salt = GetHash($password);
    $db = new SQLite3("./db/Labb2.db");
    $sql = "INSERT INTO Users (Username, Email, Salt) VALUES (:username, :email, :salt)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam( ':username', $username, SQLITE3_TEXT);
    $stmt->bindParam( ':email', $email, SQLITE3_TEXT);
    $stmt->bindParam( ':salt', $salt, SQLITE3_TEXT);
    
    if(!UniqueUsername($username) || !UniqueEmail($email)){
        $db->close();
        return false;
    }
    else{
    if(!ValidateInput($username,$email,$password)){
    $db->close();
    return false;
    }
    else{
    if($stmt->execute()){
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false;
    }
}
}
}
function UniqueUsername($username){
    $db = new SQLite3("./db/Labb2.db");
    $stmt = $db->prepare("SELECT * FROM Users WHERE Username = :username");
    $stmt->bindParam( ':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute();
    $userArray = $result->fetchArray();
    if($userArray != false){
        $db->close();
        return false;
    }
    else{
        $db->close();
        return true;
    }
}
function UniqueEmail($email){
    $db = new SQLite3("./db/Labb2.db");
    $stmt = $db->prepare("SELECT * FROM Users WHERE Email = :email");
    $stmt->bindParam( ':email', $email, SQLITE3_TEXT);
    $result = $stmt->execute();
    $emailArray = $result->fetchArray();
    if($emailArray != false){
        $db->close();
        return false;
    }
    else{
        $db->close();
        return true;
    }
}
function ValidateInput($username,$email,$password){
    if($email == "" || $username == "" || $password == ""){
        return false;
    }
    else if(strrpos($email,"@") == false || strrpos($email,"@")>strrpos($email,'.') || (strrpos($email,"@")+2)>strlen($email)){
        return false;
    }
    else return true;
}
function GetHash($password){
    return password_hash($password, PASSWORD_DEFAULT);
}
function UpdateProfile($oldName, $newPass,$newName, $newMail, $oldMail,$userID){
    $db = new SQLite3("./db/Labb2.db");
    if($oldName != $newName && !UniqueUsername($newName)){
        return false;
    }
    if($oldMail != $newMail && !UniqueEmail($newMail)){
        return false;
    }
    if($newMail == ""){
        $newMail = $oldMail;
    }
    if($newName == ""){
        $newName = $oldName;
    }
    if($newPass = ""){
        $newPass = $oldPass;
    }
    $hashedPass = GetHash($newPass);
    $stmt = $db->prepare("UPDATE Users SET Username = :newUser, Email = :email, Password = :password WHERE Id = $userID;");
    $stmt2 = $db->prepare("UPDATE Comments SET Username = :newUser WHERE UserID = $userID;");
    $stmt->bindParam( ':newUser', $newName, SQLITE3_TEXT);
    $stmt->bindParam( ':oldUser', $oldName, SQLITE3_TEXT);
    $stmt2->bindParam( ':newUser', $newName, SQLITE3_TEXT);
    $stmt2->bindParam( ':oldUser', $oldName, SQLITE3_TEXT);
    $stmt->bindParam( ':email', $newMail, SQLITE3_TEXT);
    $stmt->bindParam( ':password', $hashedPass, SQLITE3_TEXT);
    if($stmt->execute()){
        unset($_SESSION['Username']);
        unset($_SESSION['Email']);
        $_SESSION['Email'] = $newMail;
        $_SESSION['Username'] = $newName;
        $stmt2->execute();
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false;
    }
}
