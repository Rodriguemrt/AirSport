<html>

<head>
    <meta charset="utf-8">
    <!-- importer le fichier de style -->
    <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
</head>

<body>
    <div id="container">
        <!-- zone de connexion -->

        <form action="verification.php" method="POST" class="connexion">
            <h1>Connexion</h1>

            <label><b>Adresse mail</b></label>
            <input type="email" placeholder="Entrer votre adresse mail" name="username" class="connexion" required>

            <label><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer le mot de passe" name="password" class="connexion" required>

            <input type="submit" id='submit' value='Connexion' class="connexion">
            <?php
            if (isset($_GET['erreur'])) {
                $err = $_GET['erreur'];
                if ($err == 1)
                    echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
            }
            ?>

        </form>
        <div><a href='Inscription.php'><button>S'inscrire ici</button></a></div>
    </div>
</body>

</html>