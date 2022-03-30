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

    $produits = json_decode(file_get_contents("http://127.0.0.1/php/AirSport/API/produits.php/"));

    session_start();
    $username = $_SESSION['username'];
    $montant = $_SESSION['montant'];

    $requetePrenom = "SELECT * FROM utilisateur WHERE adressemail = '" . $username . "'";
    $reponsePrenom = mysqli_query($conn, $requetePrenom);
    $reponse = $reponsePrenom->fetch_assoc();

    //Requete de création de la commande
    $RequeteinsertCommande = "INSERT INTO commande(date_commande, NumClient, montant) VALUES('" . date('Y-m-d') . "'," . $reponse['idUtilisateur'] . ", $montant)";
    $exec = mysqli_query($conn, $RequeteinsertCommande);

    //Requete pour récupérer le dernier Id de la commande
    $SelectCommande = "SELECT IdCommande FROM commande ORDER BY IdCommande DESC LIMIT 1";
    $execSelect = mysqli_query($conn, $SelectCommande);
    $reponseSelect = $execSelect->fetch_array();

    $i = 0;
    foreach ($_SESSION['panier']['nomProduit'] as $id) {
        //Requete d'insertion des produits de la commande
        $requeteInsert = "INSERT INTO lignescommandes(quantite,idCommande,idProduit) VALUES (" . $_SESSION['panier']['quantite'][$i] . "," . $reponseSelect[0] . "," . $_SESSION['panier']['idProduit'][$i] . ")";
        $execInsert = mysqli_query($conn, $requeteInsert);
        $i += 1;
    }

    unset($_SESSION['panier']);
    $_SESSION['panier'] = array();
    $_SESSION['panier']['idProduit'] = array();
    $_SESSION['panier']['nomProduit'] = array();
    $_SESSION['panier']['prix'] = array();
    $_SESSION['panier']['quantite'] = array();

    $requeteCountCommande = "SELECT COUNT(*) FROM commande inner join utilisateur on commande.NumClient = utilisateur.idUtilisateur  WHERE adressemail = '" . $username . "'";
    $reponseCountCommande = mysqli_query($conn, $requeteCountCommande);
    $countCommande = $reponseCountCommande->fetch_array();

    $requeteCommande = "SELECT idCommande , date_commande FROM commande inner join utilisateur on commande.NumClient = utilisateur.idUtilisateur WHERE adressemail = '" . $username . "'";
    $reponseCommande = mysqli_query($conn, $requeteCommande);


    ?>

    <header>
        <p>Bonjour <?php echo $reponse['prenom'], " ", $reponse['nom'] ?>
        <p>
        <h1 style="font-size: 50px;">AirSport</h1>
        <a href="voirpanier.php"><img class="panier" src="../image/panier.png" width="40" /></a>
        <a href="../index.php" style="text-decoration: none;"><p>Déconnexion</p></a>
    </header>
    <div class="contenu">
        <aside>
            <img src="../image/airsportlogo.PNG" width="150px">
            <p style="text-align: center; font-size:20px">AirSport</p>
        </aside>
        <div id="contenu">

            <h1>Commande validée</h1>
            <a href="indexclient.php"><button>Accueil</button></a>

            <a href="voirpanier.php"><button>Voir les commandes passées</button></a>

        </div>

</body>

</html>