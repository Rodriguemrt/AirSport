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
                
                $id = $_GET['id'];

                $produits = json_decode(file_get_contents("http://127.0.0.1/php/AirSport/API/produits.php/".$id),true);
                
                session_start();
                $username = $_SESSION['username'];

                $requetePrenom = "SELECT * FROM utilisateur WHERE adressemail = '".$username."'";
                $reponsePrenom = mysqli_query($conn,$requetePrenom);
                $reponse = $reponsePrenom ->fetch_assoc();

                $requetecount = "SELECT COUNT(id) as count FROM produit";
                $reponsecount = mysqli_query($conn,$requetecount);
                $count = $reponsecount ->fetch_assoc();

         
        
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
       
        <form action="put.php" method="POST" class="formulaire" enctype="multipart/form-data">
            <h1>Modifier un produit</h1>
            <table>
                <tr>
                    <td>➤ Nom du Produit :</td>
                    <td><input type="text" name="nomProduit" maxlength="30" style="width: 200px;" value="<?php echo($produits[0]['nomProduit'])?>" required/></td>    
                </tr>
                <tr>
                    <td>➤ Description du Produit :</td>
                    <td><textarea name="description" style="resize: none; width: 200px; height:50px" required><?php echo ($produits[0]['description'])?></textarea></td>
                </tr>
                <tr>
                    <td>➤ Marque du Produit :</td>
                    <td><input type="text" name="marque" style="width: 200px;" value="<?php echo $produits[0]['marque']?>" required/></td>
                </tr>
                <tr>
                    <td>➤ Prix du Produit :</td>
                    <td><input type="number" name="prix" style="width: 200px;" value="<?php echo $produits[0]['prix']?>" required/></td>
                </tr>
               
                
            </table>
            <br>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"></input>
            <input type="submit" class="modifier" value="Modifier"></input>
            <input type="reset" class="modifier" value="Réinitialiser"></input>
        </form>
        <a href="indexadmin.php"><button class="accueil" id="modif">Retour à l'Accueil</button></a>
        
    </div>
    </div>
</body>

</html>
