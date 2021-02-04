<?php
session_start();
if (!isset($_SESSION['Id'])) {
  header("Location: LogOut.php");
}
?>
<!DOCTYPE html>
<html lang="sv">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/lab2_css.css">
  <script src="js/script.js"></script>
</head>
<div class=navbar>

  <body>
    <header>
      <nav>

        <div class="navheader navheader-left">
          <a href="Startpage.php">Startsida</a>
          <a href="Profile.php">Min profil</a>
          <a href="Contact.php">Contact</a>
        </div>
        <div class="navheader navheader-right">
          <a href="LogOut.php">Logout</a>
        </div>
</div>
</div>
</nav>
<div class=wrapper>
  <div class="breakDiv"></div>
  <div class="breakDiv"></div>
  Pls dont contact me
  </body>

</html>