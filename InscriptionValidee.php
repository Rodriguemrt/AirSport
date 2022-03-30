<?php

include('db_connect.php');
    $prenom = mysqli_real_escape_string($conn,htmlspecialchars($_POST['prenom'])); 
    $nom = mysqli_real_escape_string($conn,htmlspecialchars($_POST['nom']));
    $mail = mysqli_real_escape_string($conn,htmlspecialchars($_POST['mail'])); 
    $password = mysqli_real_escape_string($conn,htmlspecialchars($_POST['password']));
    $adresse = mysqli_real_escape_string($conn,htmlspecialchars($_POST['adresse'])); 
    $ville = mysqli_real_escape_string($conn,htmlspecialchars($_POST['ville'])); 
    $cp = $_POST['codepostal']; 
      
  
    $requete = "INSERT INTO utilisateur(nom,prenom,adressemail,adresse,mot_de_passe,cp, ville,role) VALUES ('$nom','$prenom','$mail','$adresse','".hash('sha256',$password)."',$cp, '$ville', 'C')";
    $exec_requete = mysqli_query($conn,$requete);
    
    var_dump($requete);
   
    header('Location: index.php');

?>