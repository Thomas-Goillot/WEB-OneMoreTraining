<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');
$id = $_GET['id'];

if(is_numeric($id)){
    $req_product = $bdd->prepare("SELECT * FROM PRODUCT where id_product = ?");
    $req_product->execute(array($id));
    $product_info = $req_product->fetchAll();

echo '<form id="product-modify" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id_product" id="id_product_selected" value="'.$id.'">
<div class="row">
    <div class="col-lg-6">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="name_product" placeholder="Nom du produit" value='.$product_info[0]['name'].'
                id="name_product" required>
            <label for="name_product">Nom</label>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-floating mb-3">
            <input type="number" class="form-control" name="price_product" placeholder="Prix du produit" value='.$product_info[0]['price'].'
                id="price_product" required>
            <label for="price_product">Prix</label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="form-floating mb-3">
            <input type="number" class="form-control" name="quantity_product" placeholder="Quantiter" value='.$product_info[0]['quantity'].'
                id="quantity_product" required>
            <label for="quantity_product">Quantité</label>
        </div>
    </div>
    <div class="col-lg-8">
        <input type="file" class="form-control form-control-lg mb-3" id="image_product" name="image_product"
            accept="image/jpeg,image/png" required>
    </div>

</div>

<div class="form-floating mb-3">
    <textarea class="form-control" placeholder="Description du profil" id="description_product"
        style="height: 100px" name="description_product">'.$product_info[0]['description'].'</textarea>
    <label for="description_product">Description du produit</label>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Ajouter</button>
</div>
</form>
';

}
else{
    echo "Merci de ne pas toucher au code de la page !";
}

?>

