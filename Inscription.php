<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>
        <div id="container">
            <!-- zone de connexion -->
            
            <form action="InscriptionValidee.php" method="POST" class="inscription">
                <h1>Inscription</h1>

                <label><b>Votre Prénom :</b></label>
                <input type="text" placeholder="Entrer votre prénom" name="prenom" class="connexion" required>

                <label><b>Votre Nom :</b></label>
                <input type="text" placeholder="Entrer votre nom de famille" name="nom" class="connexion" required>

                <label><b>Votre Adresse :</b></label>
                <input type="text" placeholder="Entrer votre adresse complète" name="adresse" class="connexion" required>

                <label><b>Votre Ville :</b></label>
                <input type="text" name="ville" class="connexion" required/>

                <label><b>Votre Code Postal :</b></label>
                <input type="text" name="codepostal" class="connexion" required/>
                
                <label><b>Adresse mail :</b></label>
                <input type="email" placeholder="Entrer votre adresse mail" name="mail" class="connexion" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="password" class="connexion" required>

                <input type="submit" id='submit' value='INSCRIPTION' class="connexion" >
                <?php
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1)
                        echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
                }
                ?>
            </form>
            <div><a href='index.php'><button>Se connecter</button></a></div>
        </div>
    </body>
</html>