<?php
// Gestion du Panier du site  Vanille

$action = $_REQUEST['action'];
switch($action)
{
    case 'verifierConnexion':
    {
        //si l'utilisateur a rentré les variables
        if((isset($_POST['login']) && ($_POST['mdp'])))
        {
            $login = $_POST['login'];
            $mdp = $_POST['mdp'];
            $laLigne = $pdo->verifConnexion($login, $mdp);
            
            //et si la requête renvoie quelque chose
            if(count($laLigne) != 0)
            {
                //set admin à "ok"
                $_SESSION['admin']="ok";
                $lesCategories=$pdo->getLesCategories();
                include("vues/v_categories.php");
                break;
            }
            else
            {
                //sinon set admin à "!ok"
                $_SESSION['admin']="!ok";
                $message="Erreur de login ou de mot de passe. Veuillez recommencer.";
                include("vues/v_message.php");
                include("vues/v_connexion.php");
                break;
            }
        }
        //si la variable de session existe et a déjà été mise à "ok"
        if( (isset($_SESSION['admin'])) && $_SESSION['admin'] == "ok" )
        {
            $lesCategories=$pdo->getLesCategories();
            include("vues/v_categories.php");
            break;
        }
    }
        
    case 'afficherMenu':
    {
        if((isset($_SESSION['admin'])) &&($_SESSION["admin"] == "ok"))
        {
            $lesCategories = $pdo->getLesCategories();
            include("vues/v_categories.php");
        }
        else
        {
            include("vues/v_connexion.php");
        }

        break;
    }
    case 'ajouterProduit':
    {
        //recup categorie
        $categorie = $_REQUEST['categorie'];
        //recup id depuis la fonction
        $id = $pdo->getMaxIDProduit($categorie);
        $id = strtoupper($id);//minuscule
        //récupération du libelle de la catégorie concernée
        $libcateg=$pdo->getLibelleCat($categorie);
        //génération d'une image automatiquement (lib catégorie + deux derniers chiffres de l'id + png)
        $image = strtolower("images/".$libcateg['libelle']."/".substr($libcateg['libelle'],0,6).substr($id, 2, 2).".png");

        include("vues/v_ajouterProduit.php");
        break;
    }

    case 'ajouterProduitBDD':
    {
        //récupération de tous les champs + reqûete
        $id = $_REQUEST['id'];
        $categorie = $_REQUEST['categorie'];
        $img = $_REQUEST['image'];
        $des = $_REQUEST['des'];
        $prix = $_REQUEST['prix'];
        $qte = $_POST['qte'];
        $pdo->ajouterProduit($id, $des, $prix, $img, $categorie, $qte);
        $message="Produit ajouté !";
        include("vues/v_message.php");

        break;
    }

    case 'effectuerModif':
    {
        if(isset($_POST['nvdes']) && ($_POST['nvprix']))
        {
            $pdo->modifierInfosProd($_POST['nvdes'], $_POST['nvprix'], $_SESSION['prodamodif']);
        }

        $message="Modification effectuée avec succès";
        include("vues/v_message.php");

        break;
    }
    case 'faireLaModif':
    {
        $_SESSION["prodamodif"] = $_REQUEST['produit'];

        $lesInfos = $pdo->getInfosProduit($_SESSION["prodamodif"]);
        include("vues/v_modifierInfosProd.php");
        break;

    }
    case 'supprimerProduit':
    {
        $_SESSION["prodasuppr"] = $_REQUEST['produit']; //on recup le produit
        //vérification : dans table contenir ou pas ?
        $dansContenirOuPas = $pdo->checkIfInContenir($_SESSION['prodasuppr']); //on vérifie si le produit est dans la table contenir (si une commande est en cours)
        $cat=$pdo->getLaCategorieDuProduit($_SESSION['prodasuppr']);//on récupère la categ
        $categorie = $cat['idCategorie'];//on transmet aux futures pages (vues/v_categories) la catégorie
        $_SESSION['categ'] = $categorie; //on met dans une variable de session pour que ça marche sur les autres vues
        //si il y a une commande en cours
        if (count($dansContenirOuPas) != 0)
        {
            $message = "Impossible de supprimer ce produit. Une commande est en cours.";
            include("vues/v_message.php"); //msg erreur
            $lesCategories = $pdo->getLesCategories(); // on affiche le mini menu  de catégories
            include("vues/v_categories.php");
            $lesProduits = $pdo->getLesProduitsDeCategorie($cat['idCategorie']); //on charge les produits de la catégorie
            include("vues/v_produits.php");
        }
        else //si pas de commmande
        {
            $message="Êtes-vous sûr(e) de vouloir supprimer ce produit ?";//verif
            include("vues/v_message.php");
            echo"<a href='index.php?uc=admin&action=vrmtSupprimer'><input type='button' value='Confirmer'></a><br><br>";//on confirme la suppression
            echo"<a href='index.php?uc=voirProduits&categorie=$categorie&action=voirProduits'><input type='button' value='Annuler'></a><br><br>";//on annule et retour à l'affichage des produits
        }
        break;
    }
    case 'vrmtSupprimer'://on a confirmé la suppression
    {
        $categorie = $_SESSION['categ'];//on transmet à v_produit la catégorie
        //suppression
        $pdo->supprimerProduitDeLaBDD($_SESSION['prodasuppr']);//on supprime vraiment le produit
        //message
        $message="Suppression effectuée.";
        include("vues/v_message.php");
        //ré-affichage de l'étape 6 avec la catégorie du produit juste supprimé
        $lesCategories = $pdo->getLesCategories(); // on affiche le mini menu  de catégories
        include("vues/v_categories.php");
        $lesProduits = $pdo->getLesProduitsDeCategorie($_SESSION['categ']);
        include("vues/v_produits.php");
        
        break;
    }
    case 'déconnexion':
    {
        $message="Merci pour votre visite";
        include("vues/v_message.php");
        unset($_SESSION['admin']);//on unset la session
        session_destroy();//on détruit les variables
        include("vues/v_accueil.php");
        break;
    }
}

?>