<?php
/** 
 * Classe d'accès aux données. 
 * Utilise les services de la classe PDO
 * pour l'application Vanille
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoVanille qui contiendra l'unique instance de la classe
 *
 * @package default
 * @author slam5
 * @version    1.0

 */

class PdoVanille
{   		
      	private static $monPdo;
		private static $monPdoVanille = null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct()
	{
    		PdoVanille::$monPdo = new PDO('mysql:host=127.0.0.1;dbname=vanille', 'root', ''); 
			PdoVanille::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoVanille::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 *
 * Appel : $instancePdoVanille = PdoVanille::getPdoVanille();
 * @return l'unique objet de la classe PdoVanille
 */
	public  static function getPdoVanille()
	{
		if(PdoVanille::$monPdoVanille == null)
		{
			PdoVanille::$monPdoVanille= new PdoVanille();
		}
		return PdoVanille::$monPdoVanille;  
	}
/**
 * Retourne toutes les catégories sous forme d'un tableau associatif
 *
 * @return le tableau associatif des catégories 
*/
	public function getLesCategories()
	{
		$req = "select * from categorie";
		$res = PdoVanille::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

/**
 * Retourne sous forme d'un tableau associatif tous les produits de la
 * catégorie passée en argument
 * 
 * @param $idCategorie 
 * @return un tableau associatif  
*/

	public function getLesProduitsDeCategorie($idCategorie)
	{
	    $req="select * from produit where idCategorie = '$idCategorie'";
		$res = PdoVanille::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
/**
 * Retourne les produits concernés par le tableau des idProduits passés en argument
 *
 * @param $desIdProduit tableau d'idProduits
 * @return un tableau associatif 
*/
	public function getLesProduitsDuTableau($desIdProduit)
	{
		$nbProduits = count($desIdProduit);
		$lesProduits=array();
		if($nbProduits != 0)
		{
			foreach($desIdProduit as $unIdProduit)
			{
				$req = "select * from produit where PDT_id = '$unIdProduit'";
				$res = PdoVanille::$monPdo->query($req);
				$unProduit = $res->fetch();
				$lesProduits[] = $unProduit;
			}
		}
		return $lesProduits;
	}
/**
 * Création d'une commande 
 *
 * Crée une commande à partir des arguments validés passés en paramètre, l'identifiant est
 * construit à partir du maximum existant ; crée les lignes de commandes dans la table contenir à partir du
 * tableau d'idProduit passé en paramètre
 * @param $nom 
 * @param $rue
 * @param $cp
 * @param $ville
 * @param $mail
 * @param $lesIdProduit
 
*/
	public function creerCommande($nom,$rue,$cp,$ville,$mail, $lesIdProduit )
	{
		$req = "select max(CDE_id) as maxi from commande";
		$res = PdoVanille::$monPdo->query($req);
		$laLigne = $res->fetch();
		$maxi = $laLigne['maxi'] ;
		$maxi++;
		$idCommande = $maxi;

		$date = date('Y/m/d');
		$req = "insert into commande values ('$idCommande','$date','$nom','$rue','$cp','$mail','$ville')";
		$res = PdoVanille::$monPdo->exec($req);

		//on récupère les produits du panier dans un tableau
		$desIdProduit = getLesIdProduitsDuPanier();
		//on parcourt le tableau et on insere une ligne par produit de commande dans la table contenir
		//et on enleve 1 au stock
		foreach($desIdProduit as $unProduit)
		{
			$reqinsert = "insert into contenir values ($idCommande, '$unProduit');";
			$res = PdoVanille::$monPdo->exec($reqinsert) or die ("Erreur");
			$reqenlever = "UPDATE produit
							SET qte_stock=qte_stock-1
							WHERE PDT_id = '$unProduit';";
			$res = PdoVanille::$monPdo->exec($reqenlever) or die ('erreur');
			
		}
		supprimerPanier();
	}

	public function getInfosProduit($id)
	{
		$req = "select description, prix
				from produit
				where PDT_id='$id'";
		$res = PdoVanille::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function modifierInfosProd($description, $prix, $id)
	{
		$req = "UPDATE produit
				SET description='$description', prix='$prix'
				WHERE PDT_id='$id';";
		$res = PdoVanille::$monPdo->exec($req) or die ('Erreur de requête');
	}

	public function checkIfInContenir($id)
	{
		$req = "SELECT *
				FROM contenir
				WHERE idProduit = '$id';";
		$res = PdoVanille::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function supprimerProduitDeLaBDD($id)
	{
		$req = "DELETE from produit
				WHERE PDT_id = '$id';";
		$res = PdoVanille::$monPdo->exec($req);
	}

	public function verifConnexion($login, $mdp)
	{
		$req = "SELECT Login, Mdp
				FROM administrateur
				WHERE Login='$login'
				AND Mdp='$mdp';";
		$res = PdoVanille::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	public function getLaCategorieDuProduit($id)
	{
		$req = "SELECT idCategorie
				FROM produit
				WHERE PDT_id ='$id';";
		$res = PdoVanille::$monPdo->query($req);
		$lesLignes=$res->fetch();
		return $lesLignes;
	}

	public function ajouterProduit($id, $des, $prix, $image, $categorie, $qte)
	{
		if(estEntier($prix) || estEntier($qte))
		{
			$req = "INSERT INTO produit
				VALUES ('$id', '$des', $prix, '$image', '$categorie', $qte);";
			$res = PdoVanille::$monPdo->exec($req) or die ($message="Erreur. Recommencez.");
		}
		else
		{
			die("Erreur. Veuillez rentrer seulement un chiffre pour le prix et la quantité !");
		}
	}

	public function getMaxIDProduit($categorie)
	{
		$req = "SELECT max(PDT_id) as max
				FROM produit
				WHERE idCategorie = '$categorie';";
		$res = PdoVanille::$monPdo->query($req);
		$laLigne = $res->fetch();//récupération de l'id produit le plus elevé de la catégorie
		$maxi = $laLigne['max'] ;
		$maxi++;
		return $maxi;//on le retourne +1
	}

	public function getLibelleCat($cat)
	{
		$req = "SELECT libelle
				FROM categorie
				WHERE CAT_id = '$cat'";
		$res = PdoVanille::$monPdo->query($req);
		$laLigne = $res ->fetch();
		return $laLigne;
	}
	
}
?>