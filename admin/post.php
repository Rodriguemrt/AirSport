<?php
$url = 'http://127.0.0.1/php/AirSport/API/produits.php/';

  // connexion à la base de données
  include ('../db_connect.php');
$nom = mysqli_real_escape_string($conn, htmlspecialchars($_POST['nomProduit']));
$description = mysqli_real_escape_string($conn, htmlspecialchars($_POST['description']));
$marque = mysqli_real_escape_string($conn, htmlspecialchars($_POST['marque']));

$data = array('nomProduit' => $nom, 'description' => $description, 'prix' => $_POST['prix'], 'marque' => $marque);


$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

include('../db_connect.php');

$requeteSelect = "SELECT id FROM produit ORDER BY ID DESC LIMIT 1";
$reponseSelect = mysqli_query($conn, $requeteSelect);
$reponse = $reponseSelect->fetch_assoc();


if (count($_FILES['image']['name']) != null) 
    {
        $fichier = count($_FILES['image']['name']);
    } 
    else
    {
    $fichier = 1;
    }

    for ($i = 0; $i < $fichier; $i++) 
    {
        $insertimage = "INSERT INTO image(url,IdProduit) VALUES('image/produit/" . $_FILES['image']['name'][$i] . "','" . $reponse['id'] . "')";
        $exec_requete = mysqli_query($conn, $insertimage);
        move_uploaded_file($_FILES["image"]["tmp_name"][$i], '../image/produit/' . $_FILES['image']['name'][$i]);
    }

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

    $requetePrenom = "SELECT * FROM utilisateur WHERE adressemail = '" . $username . "'";
    $reponsePrenom = mysqli_query($conn, $requetePrenom);
    $reponse = $reponsePrenom->fetch_assoc();

    ?>

    <header>
        <p>Bonjour <?php echo $reponse['prenom'], " ", $reponse['nom'] ?> </p>
        <a href="../index.php" style="text-decoration: none;">
            <p>Déconnexion</p>
        </a>
        <h1 style="font-size: 45px;">AirSport</h1>
    </header>
    <div class="contenu">
        <aside>
            <img src="../image/airsportlogo.PNG" width="150px">
            <p style="text-align: center; font-size:20px">AirSport</p>
        </aside>
        <div id="contenu">
            <h1>Produit Ajouté</h1>
            <a href="indexadmin.php"><button class="accueil">Retour à l'Accueil</button></a>
        </div>
    </div>
</body>

</html>