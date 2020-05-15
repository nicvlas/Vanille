<div id="bandeau">
<!-- Images En-t�te -->
<img src="images/Vanille.png"	alt="Boutique en ligne Vanille" title="Boutique en ligne Vanille" width="900" height="300" />
</div>
<!--  Menu haut-->

<ul id="menu">
	<li><a href="index.php?uc=accueil"> Accueil </a></li>
	<li><a href="index.php?uc=voirProduits&action=voirCategories">Voir le catalogue</a></li>
	<li><a href="index.php?uc=gererPanier&action=voirPanier">Voir votre panier</a></li>
	<li><a href="index.php?uc=admin&action=verifierConnexion">Administration</a></li>
	<?php
		if((isset($_SESSION['admin'])) && $_SESSION['admin']=="ok")
		{
			?>
			<li><a href="index.php?uc=admin&action=déconnexion">Déconnexion</a></li>
		<?php
		}
		?>
</ul>
