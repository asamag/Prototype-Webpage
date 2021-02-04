<?php include "db/db.php";
session_start();
if(ValidateComment($_POST['comment'])){
AddComment($_POST['comment'], $_SESSION['Username'], $_SESSION['Id']);
$array = GetComments();
    while ($row = $array->fetchArray()){
        PrintDiv($row);
    }
}
else {
    header('HTTP/1.1 400 Bad Request');
}
