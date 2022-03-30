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

    $produits = json_decode(file_get_contents("http://127.0.0.1/php/AirSport/API/produits.php"));

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
        <p>Bonjour <?php echo $reponse['prenom'], " ", $reponse['nom'] ?></p>
        <a href="../index.php" style="text-decoration: none;"><p>Déconnexion</p></a>
    
        <h1 style="font-size: 45px;">AirSport</h1>
    </header>
    <div class="contenu">
        <aside>
            <img src="../image/airsportlogo.PNG" width="150px">
            <p style="text-align: center; font-size:20px">AirSport</p>
        </aside>
        <div id="contenu">
            <form action="post.php" method="POST" class="formulaire" enctype="multipart/form-data">
                <h1>Ajout d'un produit</h1>
                <table>
                    <tr>
                        <td>➤ Nom du Produit :</td>
                        <td><input type="text" name="nomProduit" maxlength="30" style="width: 200px;" required /></td>
                    </tr>
                    <tr>
                        <td>➤ Description du Produit :</td>
                        <td><textarea name="description" required style="resize: none;  width: 200px; height:50px" ></textarea></td>
                    </tr>
                    <tr>
                        <td>➤ Marque du Produit :</td>
                        <td><input type="text" name="marque" required style="width: 200px;" /></td>
                    </tr>
                    <tr>
                        <td>➤ Prix du Produit :</td>
                        <td><input type="number" name="prix" required style="width: 200px;" /></td>
                    </tr>
                    <tr>
                        <td>➤ Image(s) :</td>
                        <td><input type="file" name="image[]" multiple accept=".jpg, .png, .gif" required /></td>
                    </tr>

                </table>
                <input type="submit" class="modifier" value="Ajouter"></input>
                <input type="reset" class="modifier" value="Effacer"></input>
            </form>
            <a href="indexadmin.php"><button id="ajout" class="accueil">Accueil</button></a>
        </div>
    </div>
</body>

</html>