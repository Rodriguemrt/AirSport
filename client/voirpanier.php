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


    $requetePrenom = "SELECT * FROM utilisateur WHERE adressemail = '" . $username . "'";
    $reponsePrenom = mysqli_query($conn, $requetePrenom);
    $reponse = $reponsePrenom->fetch_assoc();

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

            <a href="indexclient.php"><button class="accueil">Accueil</button></a>
         
                <a href="validercommande.php"><button class="validercommande">Valider la commande</button></a>
           

            <table class="panier">
                <tr>
                    <td>
                        Nom du Produit
                    </td>
                    <td>
                        Prix
                    </td>
                    <td>
                        Quantité
                    </td>
                    <td>
                        Supprimer
                    </td>
                </tr>

                <?php

                $i = 0;
                $montant = 0;
                foreach ($_SESSION['panier']['nomProduit']  as $nom) 
                {
                ?>
                    <tr>
                        <td>
                            <?php echo $nom ?>
                        </td>
                        <td>
                            <?php echo $_SESSION['panier']['prix'][$i], ' €' ?>
                        </td>
                        <td>
                            <?php echo $_SESSION['panier']['quantite'][$i] ?>
                        </td>
                        <td>
                            <form action="supprimerarticle.php" method="POST">
                                <input type="hidden" name="nom" value="<?php echo $_SESSION['panier']['nomProduit'][$i]  ?>">
                                <input type="image" width=40px src="../image/poubelle.png">
                            </form>
                        </td>
                        <?php
                        $montant +=  $_SESSION['panier']['prix'][$i] *  $_SESSION['panier']['quantite'][$i];
                        ?>
                    <?php
                    $i += 1;
                }
                $_SESSION['montant'] = $montant;
                    ?>

            </table>
            <p class="montant">Montant total : <?php echo $montant, ' €'  ?></p>

            <div class="commande">
                <p>Voir les anciennes commandes :</p>
                <?php for ($i = 0; $i < $countCommande[0]; $i++) {
                    $dataCommande = $reponseCommande->fetch_array();
                    $date = $dataCommande['date_commande'];
                    $newdate = date("d/m/Y", strtotime($date));
                ?>
                    <form action="pdf.php?id=<?php echo $dataCommande['idCommande'] ?>" method="POST">
                        <input type="submit" value="Voir la commande du <?php echo $newdate ?> ">
                    </form>
                <?php
                    echo ('<br/>');
                }
                ?>
            </div>
        </div>
</body>

</html>