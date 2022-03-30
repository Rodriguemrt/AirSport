<?php
 // require pour générer un fichier pdf
 require('/wamp64/www/PHP/AirSport/fpdf/fpdf.php');
 session_start();
 $username = $_SESSION['username'];
 //Connextion base de donnnées
$bdd = new PDO('mysql:host=localhost;dbname=airsport;charset=utf8','root', '');

//Requête pour récupérer les données des commandes
$id = $_GET['id'];
$reponseProduit = $bdd->query("SELECT NomProduit,quantite,prix FROM lignescommandes as l INNER JOIN produit as p ON l.idProduit=p.id WHERE idCommande = $id");
$infoClient = $bdd->query("SELECT nom, prenom , adressemail, adresse, CP, ville FROM utilisateur WHERE adressemail = '".$username."'");
$donneesClient = $infoClient->fetch();

$reponseMontant =$bdd->query("SELECT montant FROM commande WHERE IdCommande = $id");
$montant = $reponseMontant->fetch();


$data ="";
$ecrire = fopen('resultat.txt', 'w');

 
    while ($donnees = $reponseProduit->fetch())
    {
        $data = $data . $donnees['NomProduit'].';' . $donnees['prix'].';' . $donnees['quantite'];
        $ecrire = fopen('resultat.txt','a+');
        $data = $data. "\n";
    }

    fputs($ecrire,$data);


class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('../image/airsportlogo.png',10,6,30);
    // Police d'écriture
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(50);
    // Title
    $this->Cell(80,10,utf8_decode('Résumé de la commande'),1,0,'C');
    // Line break
    $this->Ln(70);
    
    

}
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}


//Table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(90, 30, 40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,utf8_decode($row[0]),'LR',0,'L',$fill);
        $this->Cell($w[1],6,utf8_decode(number_format($row[1])),'LR',0,'R',$fill);
        $this->Cell($w[2],6,utf8_decode(number_format($row[2])),'LR',0,'R',$fill);

        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica','',11);
$pdf->Text(8,38,utf8_decode('Prénom : '.$donneesClient['prenom']));
$pdf->Text(8,43,utf8_decode('Nom : '.$donneesClient['nom']));
$pdf->Text(8,48,utf8_decode($donneesClient['adresse']));
$pdf->Text(8,53,$donneesClient['ville'].' ' .$donneesClient['CP']);
define('EURO',chr(128));
$pdf->SetFont('Helvetica','',15);
$pdf->Text(8,65,'Montant total de la commande : '.$montant['montant'].' '.EURO);
$pdf->SetFont('Helvetica','',11);

// Column headings
$header = array('Nom du Produit', 'Prix', 'Quantité');
// Data loading
$data = $pdf->LoadData('resultat.txt');



$pdf->FancyTable($header,$data);
$pdf->Output('Commande'. date('d-m-y').'.pdf','I');
?>
 