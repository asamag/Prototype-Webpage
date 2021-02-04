<!DOCTYPE html>
    <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta charset="UTF8"/>
            <link rel="stylesheet" href="CSS/style.css">
            <script src="JS/script.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <p>
                    <div class="icon-bar">
                        <a href="index.php" id="start">Startsida</a>
                        <a href="post-comment.php" id="post">Recept</a>
                        <a href="profile.php" id="profile">Profil</a>
                        <a href="search.php" id="search">Sök</a>
                        <a href="logout.php" id="logout">Logga ut</a>
                    </div>

                </p>
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

                     Vill du dela med dig av ett recept?</br>
                     <button onclick="document.location = 'post-comment.php'" id="startknapp">Publicera</button></br></br>
                     Söker du något speciellt?</br>
                     <button onclick="document.location = 'search.php'" id="startknapp">Sök recept</button>
                     
                </p>
            </div>
        </body>
    </html>

