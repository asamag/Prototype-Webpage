<?php 
    session_start();
    if(isset($_SESSION['id'])){
        header("Location: index1.php");
    }
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta charset="UTF8"/>
            <link rel="stylesheet" href="CSS/style.css">
            <script src="JS/script.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>
        <body class="start">
            <div class= subm-form>
                <h1 id="rubrik">THE BREAKFAST CLUB</h1>
                 <br/>
                 <br/>
                 <p>
                     Är du en av Sveriges största frukostälskare?</br>
                     Då har du hittat rätt!</br></br>

                     Här kan du inspirera och inspireras</br>
                     genom att ta del av eller dela med dig av</br>
                     dina allra bästa frukosttips.</br></br>

                     Medlem?</br>
                     <button onclick="document.location = 'login.php'" id="startknapp">Logga in</button></br></br>
                     Inte medlem än?</br>
                     <button onclick="document.location = 'register.php'" id="startknapp">Registrera dig</button>
                     
                </p>
            </div>
        </body>
    </html>

