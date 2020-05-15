<div id="creationCommande">
<form method="POST" action="index.php?uc=gererPanier&action=confirmerCommande">
   <fieldset>
     <legend>Commande</legend>
     <a href="index.php?uc=gererPanier&action=annulerCommande"><img src="images\AnnulerCommande.png"></a>
		<p>
			<label for="nom">Nom Prénom*</label>
			<input id="nom" type="text" name="nom" value="<?=$nom ?>" size="30" maxlength="45" required>
		</p>
		<p>
			<label for="rue">Rue*</label>
			 <input id="rue" type="text" name="rue" value="<?=$rue ?>" size="30" maxlength="45" required>
		</p>
		<p>
         <label for="cp">Code postal* </label>
         <input id="cp" type="text" name="cp" value="<?=$cp ?>" size="5" maxlength="5" required >
      </p>


      <p>
      	<label for="ville">Ville*</label>
      	<input type="text" name="ville" id="cp" value="<?=$cp ?>" size="5" required>
      </p>

      <p>
      	<label for="mail">Email*</label>
      	<input type="text" name="mail" id="mail" value="<?=$mail ?>" size="50"  required>
      </p>
      
	  	<p>
         <input type="submit" value="Valider" name="valider">
      </p>
</form>
</div>





