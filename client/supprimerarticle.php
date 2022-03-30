<?php

session_start();

/**
 * Supprimer un article du panier
 *
 * @param String    $ref_article numéro de référence de l'article à supprimer
 * @return Boolean  Retourn TRUE si la suppression a bien été effectuée, FALSE sinon
 */
function supprim_article($ref_article)
{
    $suppression = false;
    /* création d'un tableau temporaire de stockage des articles */
    $panier_tmp = array("nomProduit"=>array(),"idProduit"=>array(),"prix"=>array(),"quantite"=>array());
    /* Comptage des articles du panier */
    $nb_articles = count($_SESSION['panier']['idProduit']);
    /* Transfert du panier dans le panier temporaire */
    for($i = 0; $i < $nb_articles; $i++)
    {
        /* On transfère tout sauf l'article à supprimer */
        if($_SESSION['panier']['nomProduit'][$i] != $ref_article)
        {
            array_push($panier_tmp['nomProduit'],$_SESSION['panier']['nomProduit'][$i]);
            array_push($panier_tmp['idProduit'],$_SESSION['panier']['idProduit'][$i]);
            array_push($panier_tmp['quantite'],$_SESSION['panier']['quantite'][$i]);
            array_push($panier_tmp['prix'],$_SESSION['panier']['prix'][$i]);
        }
    }
    /* Le transfert est terminé, on ré-initialise le panier */
    $_SESSION['panier'] = $panier_tmp;
    /* Option : on peut maintenant supprimer notre panier temporaire: */
    unset($panier_tmp);
    $suppression = true;
    return $suppression;
}


supprim_article($_POST['nom']);

header('Location: voirpanier.php');



?>