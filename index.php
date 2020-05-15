<?php
//Controleur Principal du site Vanille 2019
session_start();
require_once("util/fonctions.inc.php");
require_once("util/class.pdoVanille.inc.php");
include("vues/v_entete.php") ;
include("vues/v_bandeau.php") ;

if( (isset($_SESSION['prodamodif']) && (isset($_SESSION['prodasuppr'])) && (isset($_SESSION['categ']))))
{
$_SESSION["prodamodif"];
$_SESSION["prodasuppr"];
}

if(!isset($_REQUEST['uc']))
     $uc = 'accueil';
else
	$uc = $_REQUEST['uc'];

	
/* Cr�ation d'une instance d'acc�s � la base de donn�es */
$pdo = PdoVanille::getPdoVanille();	 
switch($uc)
{
	case 'accueil':
		{include("vues/v_accueil.php");break;}
	case 'voirProduits' :
		{include("controleurs/c_voirProduits.php");break;}
	case 'gererPanier' :
		{include("controleurs/c_gestionPanier.php");break;}
	case 'admin':
		{include("controleurs/a_gererSite.php");break;}
	
}
include("vues/v_pied.php") ;
?>

