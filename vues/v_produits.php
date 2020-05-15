<div id="produits">
<?php 								//récupération & envoie de la catégorie à ajouterProduit si connecté
if(isset($_SESSION['admin']) && ($_SESSION['admin'] == "ok")){
echo"<a href='index.php?uc=admin&categorie=$categorie&action=ajouterProduit'><img src='images/AjoutProduit.png' alt=''></a><br>";}
echo 'ClIQUEZ A DROITE DU PRODUIT POUR AJOUTER AU PANIER  ';

foreach( $lesProduits as $unProduit) 
{
	$id = $unProduit['PDT_id'];
	$description = $unProduit['description'];
	$prix=$unProduit['prix'];
	$image = $unProduit['image'];
  ?>
<table  cellpadding=10 cellspacing=10>  
	<tr> 
			<td><img src="<?=$image ?>" alt=image /></td>
			<td><?=$description ?></td>
			 <td><?=$prix." Euros" ?></td>
			 <td><a href=index.php?uc=voirProduits&categorie=<?=$categorie ?>&produit=<?=$id ?>&action=ajouterAuPanier> 
			 <img src="images/AjoutPanier.png" TITLE="Ajouter au panier" </td></a>
			 <?php 
			 if( (isset($_SESSION['admin'])) && ($_SESSION['admin'] == "ok") )//admin quand la connexion sera effectuée
			 {
				echo"<td><a href=index.php?uc=admin&produit=$id&action=faireLaModif><img src='images/Update.png' TITLE='Modifier'</a></td>";
				echo"<td><a href=index.php?uc=admin&produit=$id&action=supprimerProduit ><img src='images/Suppr.png' TITLE='Supprimer'</a></td>";
			 }
			?>
	</tr>
			
<?php			
}
?>
</table>
</div>
