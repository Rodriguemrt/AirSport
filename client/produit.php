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


    $produits = json_decode(file_get_contents("http://127.0.0.1/php/AirSport/API/produits.php/" . $_GET['id']));

    session_start();
    $username = $_SESSION['username'];


    $requetePrenom = "SELECT * FROM utilisateur WHERE adressemail = '" . $username . "'";
    $reponsePrenom = mysqli_query($conn, $requetePrenom);
    $reponse = $reponsePrenom->fetch_assoc();

    $requetecount = "SELECT COUNT(id) as count FROM produit";
    $reponsecount = mysqli_query($conn, $requetecount);
    $count = $reponsecount->fetch_assoc();
    ?>

    <header>
        <p>Bonjour <?php echo $reponse['prenom'], " ", $reponse['nom'] ?>
        <p>
        <h1 style="font-size: 50px;">AirSport</h1>
        <a href="voirpanier.php"><img class="panier" src="../image/panier.png" width="40" /></a>
        <a href="../index.php" style="text-decoration: none;">
            <p>Déconnexion</p>
        </a>

    </header>
    <div class="contenu">
        <aside>
            <img src="../image/airsportlogo.PNG" width="150px">
            <p style="text-align: center; font-size:20px">AirSport</p>
        </aside>
        <div id="contenu">
            <div class="infoproduit">
                <table>
                    <?php foreach ($produits as $produit) : ?>
                        <?php
                        echo ("<p style='font-size:20px'>Nom produit : "), $produit->nomProduit, "</br></p>";
                        echo ("<p style='font-size:20px'>Description : "), $produit->description, "</br></p>";
                        echo ("<p style='font-size:20px'>Marque : "), $produit->marque, "</br></p>";
                        echo ("<p style='font-size:20px'>Prix : "), $produit->prix, "€ </br></p>";
                     endforeach; 
                     ?>

                </table>
                <form action="panier.php" method="POST">
                    <input type="hidden" name="nomProduit" value="<?php echo $produit->nomProduit ?>">
                    <input type="hidden" name="prix" value="<?php echo $produit->prix ?>">
                    <input type="hidden" name="idProduit" value="<?php echo $produit->id ?>">
                    <label style="font-size: 20px;">Quantité :</label>
                    <input type="number" name="quantite" required>
                    <br>

                    <br>

                    <input type="submit" class="ajout" value="Ajouter au panier"></input>
                </form>
            </div>
            <div class="image">
                <?php
                $requeteImage = mysqli_query($conn, "SELECT url FROM image WHERE idProduit = " . $_GET['id']);

                while ($row = mysqli_fetch_array($requeteImage)) 
                {
                    $image = $row[0];
                    echo '<img src=../' . $image . ' class="imageproduit">';
                }

                ?>
            </div>
        </div>
        <a href="indexclient.php"><button class="indexacceuil">Accueil</button></a>
    </div>
</body>

</html>