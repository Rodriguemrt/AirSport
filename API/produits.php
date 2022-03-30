<?php
	
	include("../db_connect.php");


	$request_method = $_SERVER["REQUEST_METHOD"];

	//Afficher tous les produits
	function getProducts()
	{
		global $conn;
		$query = "SELECT * FROM produit";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json; charset=UTF-8');
		$data = json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		echo($data); 
	
	}

	
	//Afficher un produit
	function getProduct($id=0)
	{
		global $conn;
		$query = "SELECT * FROM produit";
		if($id != 0)
		{
			$query .= " WHERE id=".$id." LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json; charset=UTF-8');
		$data = json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		echo $data;
	}
	
	//Ajouter un produit
	function AddProduct()
	{
		global $conn;
		$name = $_POST["nomProduit"];
		$description = $_POST["description"];
		$price = $_POST["prix"];
		$marque = $_POST["marque"];
		
		echo $query="INSERT INTO produit(nomProduit, description, prix, marque) VALUES('".$name."', '".$description."', '".$price."', '".$marque."')";
		$result= mysqli_prepare($conn,$query);
		if($result->execute())
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Produit ajouté avec succès.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'ERREUR!.'. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	

	//Mettre a jour un produit
	function updateProduct($id)
	{
		global $conn;
		$_PUT = array();
		parse_str(file_get_contents('php://input'), $_PUT);
		$nomProduit = $_PUT["nomProduit"];
		$description = $_PUT["description"];
		$prix = $_PUT["prix"];
		$marque = $_PUT["marque"];
		$query="UPDATE produit SET nomProduit='".$nomProduit."', description='".$description."', prix='".$prix."' , marque='".$marque."' WHERE id=".$id;
		
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Produit mis a jour avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Echec de la mise a jour de produit. '. mysqli_error($conn)
			);
			
		}
		
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	//Supprimer un produit
	function deleteProduct($id)
	{
		global $conn;
		$delete = "DELETE FROM image WHERE idProduit=$id";
		mysqli_query($conn,$delete);
		$query = "DELETE FROM produit WHERE id=".$id;
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Produit supprime avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'La suppression du produit a echoue. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	switch($request_method)
	{
		
		case 'GET':
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				getProduct($id);
			}
			else
			{
				getProducts();
			}
			break;
		default:
			// Erreur 404
			header("HTTP/1.0 405 Method Not Allowed");
			break;
			
		case 'POST':
			// Ajouter un produit
			AddProduct();
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			updateProduct($id);
			break;

		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteProduct($id);
			break;

	}
?>