<?php

$id = $_GET['id'];
$url = "http://127.0.0.1/php/AirSport/API/produits.php/$id"; 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    
   
    <title>AirSport - Accueil</title>
  
    <link rel="stylesheet" href="../style.css">

</head>

<body>
            <?php
            // connexion à la base de données
                include('../db_connect.php');

                session_start();
                $username = $_SESSION['username'];

                $requetePrenom = "SELECT * FROM utilisateur WHERE adressemail = '".$username."'";
                $reponsePrenom = mysqli_query($conn,$requetePrenom);
                $reponse = $reponsePrenom ->fetch_assoc();

    ?> 

    <header>
        <p>Bonjour <?php echo $reponse['prenom']," " , $reponse['nom']?> </p>
        <a href="../index.php" style="text-decoration: none;"><p>Déconnexion</p></a>
        <h1 style="font-size: 45px;">AirSport</h1>
    </header>
    
    <div class="contenu">
    <aside>
        <img src="../image/airsportlogo.PNG" width="150px">
        <p style="text-align: center; font-size:20px">AirSport</p>
    </aside>
    <div id="contenu">
        <h1>Produit Supprimé</h1>
		<a href="indexadmin.php"><button class="accueil">Retour à l'Accueil</button></a>
    </div>
    </div>
    
</body>

</html>
