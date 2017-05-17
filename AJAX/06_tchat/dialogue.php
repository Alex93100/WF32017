<?php
require_once('inc/init.inc.php')

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div id=conteneur>
            <h2 id="moi">Bonjour <?php echo $_SESSION['pseudo'];?></h2>
            <div id="message_tchat"></div>
            <div id="liste_membre_connecte"></div>
            <div class="clear"></div>
            <div id="smiley">
                <img src="smil/smiley1.gif" alt=":)">
            </div>
            <!-- FORMULAIRE -->
            <div id="formulaire_tchat">
                <form id="form">
                    <textarea name="message" id="message" maxlength="300" rows="5"></textarea><br>
                    <input type="submit" name="envoi" value="envoi" class="submit">
                </form>
            </div>
            <div id="postMessage"></div>
        </div>
        <script>
            // pour récupérer la liste des membres connectés
            setInterval("ajax(liste_membre_connecte)", 11000);

            // déclaration de la fonction ajax
            function ajax(mode, arg = '') {
                if(typeof(mode) == 'object'){
                    mode = mode.id;
                    // l'argument mode recevra les id des différents elements de notre page.
                    // Sachant que l'on peut sélectionner des éléments html directement par leir id (sans getElementBy...)
                    // il y a un risque de récuprérer un objet représentant l'élément html. dans ce cas nous récupérons juste l'id de l'élément (mode = mode.id)
                }
                console.log("mode actuel: "+mode); // nous afiche la tache en cours dans la console

                var file = "ajax_dialogue.php";
                var parametres = "mode="+mode+"&arg="+arg;

                if(window.XMLHttpRequest){
                    var xhttp = new XMLHttpRequest();
                }
                else{
                    var xhttp = new ActiveXObject("Microsoft.XMLHTTP"); // IE < v7
                }

                xhttp.open("POST", file, true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhttp.onreadystatechange = function(){
                    if(xhttp.readyState == 4 && xhttp.status == 200){
                        console.log(xhttp.responseText);
                    var obj = JSON.parse(xhttp.responseText);

                    document.getElementById(mode).innerHTML = obj.resultat;
                    var boiteMessage = document.getElementById("message_tchat");
                    document.getElementById(mode).scrollTop = boiteMessage.scrollHeight;
                    // permet de descendre l'ascenceur de ce div et de voir les derniers messages.
                    }
                }
                xhttp.send(parametres);
            }

        </script>
    </body>
</html>