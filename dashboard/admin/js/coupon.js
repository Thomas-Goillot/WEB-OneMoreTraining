//Copyright (c) 2022 Victor STEC

function delete_coupon(coupon_id) {

    if(confirm('Êtes vous sur de vouloir supprimer ce produit ?')){

        const request = new XMLHttpRequest();

        request.open('POST', '../../../ajax/delete_coupon.php');
        
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

 		request.send("coupon_id=" + coupon_id);

 		const row = document.getElementById("Line"+coupon_id);
        row.remove();
    }
}

function add_coupon(coupon_id) {

    const request = new XMLHttpRequest();

    request.open('POST', '../../../ajax/add_coupon.php');
    
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    request.send("coupon_id=" + coupon_id);

    
}

