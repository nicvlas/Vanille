<form action="index.php?uc=admin&id=<?=$id?>&image=<?=$image?>&categorie=<?=$categorie?>&action=ajouterProduitBDD" method="post">
    <table>
        <tr>
            <td>ID : </td>
            <td><input type="text" value="<?php echo $id; ?>" disabled></td>
        </tr>
        <tr>
            <td>Description : </td>
            <td><input type="text" name="des" size="200" required></td>
        </tr>
        <tr>
            <td>Prix : </td>
            <td><input type="text" name="prix" placeholder="Veuillez saisir un nombre uniquement" required></td>
        </tr>
        <tr>
            <td>Image : </td>
            <td><input type="text" value="<?php echo $image; ?>" disabled></td>
        </tr>
        <tr>
            <td>Catégorie : </td>
            <td><input type="text" value="<?php echo $categorie; ?>" disabled></td>
        </tr>
        <tr>
            <td>Quantité en stock : </td>
            <td><input type="number" name="qte" required></td>
        </tr>
    </table>
    <input type="submit" value="Ajouter"> <input type="reset" name="Annuler">
</form>