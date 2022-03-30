<?php
session_start();

//Création du panier
$_SESSION['panier'] = array();

$_SESSION['panier']['idProduit'] = array();
$_SESSION['panier']['nomProduit'] = array();
$_SESSION['panier']['prix'] = array();
$_SESSION['panier']['quantite'] = array();


if (isset($_POST['username']) && isset($_POST['password'])) {
    // connexion à la base de données
    $db_username = 'root';
    $db_password = '';
    $db_name     = 'airsport';
    $db_host     = 'localhost';
    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name)
        or die('could not connect to database');


    $username = mysqli_real_escape_string($conn, htmlspecialchars($_POST['username']));
    $password = mysqli_real_escape_string($conn, htmlspecialchars($_POST['password']));
    $password = hash('sha256', $password);

    if ($username !== "" && $password !== "") {
        $requete = "SELECT count(*), role  FROM utilisateur where 
              adressemail = '" . $username . "' and mot_de_passe = '" . $password . "' ";
        $exec_requete = mysqli_query($conn, $requete);
        $reponse = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        if ($count != 0) // nom d'utilisateur et mot de passe correctes
        {
            $_SESSION['username'] = $username;
            if ($reponse['role'] == 'A')
            {
                header('Location: admin/indexadmin.php');
            } 
            else 
            {
                header('Location: client/indexclient.php');
            }
        } 
        else 
        {
            header('Location: index.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
        header('Location: index.php?erreur=2'); // utilisateur ou mot de passe vide
    }
} 
else
{
    header('Location: index.php');
}
mysqli_close($db); // fermer la connexion
