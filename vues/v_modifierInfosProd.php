<?php
foreach($lesInfos as $info){
$des = $info['description'];
$prix = $info['prix'];
}
?>
<form action="index.php?uc=admin&action=effectuerModif" method="post">
    <table>
        Sélectionnez les nouvelles informations du produit <?php echo $_SESSION['prodamodif']; ?> :
        <tr>
            <td>Description :</td>
            <td><input type="text" name="nvdes" value="<?php echo $des; ?>" size="100"></td>
        </tr>
        <tr>
            <td>Prix :</td>
            <td><input type="number" name="nvprix" value="<?php echo $prix; ?>"></td>
        </tr>
    </table>
    <input type="submit" value="Valider">
</form>