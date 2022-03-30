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

    ?>

    <header>
        <p>Bonjour <?php echo $reponse['prenom'], " ", $reponse['nom'] ?></p>
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


            <?php foreach ($produits as $produit) : ?>
                <div style="display: inline-block;">
                    <a href="produit.php?id=<?php echo $produit->id ?>" class="lienProduit">
                        <div class="produit">
                            <table>
                                <tr>
                                    <td class="produit"> <?php echo ("Nom : "), $produit->nomProduit; ?></td>
                                </tr>
                                <tr>
                                    <td class="produit"> <?php echo ("Marque : "), $produit->marque ?></td>
                                </tr>
                                <tr>
                                    <td class="produit"> <?php echo ("Prix : "), $produit->prix, " €"; ?></td>
                                </tr>
                                <tr>
                                    <td class="produit">
                                        <?php
                                        $requeteImage = mysqli_query($conn, "SELECT url FROM image WHERE idProduit = " . $produit->id);

                                        $row = mysqli_fetch_array($requeteImage);

                                        $image = $row[0];
                                        echo '<img src=../' . $image . ' class="image" width="180px" height="130px">';
                                        ?>

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
</body>
</html>