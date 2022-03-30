<?php

 // connexion à la base de données
 include('../db_connect.php');


$id = $_POST['id'];

$nom = mysqli_real_escape_string($conn, htmlspecialchars($_POST['nomProduit']));
$description = mysqli_real_escape_string($conn, htmlspecialchars($_POST['description']));
$marque = mysqli_real_escape_string($conn, htmlspecialchars($_POST['marque']));


$url = "http://127.0.0.1/php/AirSport/API/produits.php/$id"; 

$data = array('nomProduit' => $nom , 'description' => $description, 'prix' => $_POST['prix'], 'marque' => $marque);

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

$response = curl_exec($ch);
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
        <h1>Produit Modifié</h1>
		<a href="indexadmin.php"><button class="accueil">Retour à l'Accueil</button></a>
    </div>
    </div>
</body>

</html>
