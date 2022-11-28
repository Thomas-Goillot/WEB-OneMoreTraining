/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

//ADD DATA AJAX METHOD
const product_add = document.getElementById('product-add');

product_add.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/ajax/add_product.php',
    {
        method: 'POST',
        body: formData
    }).then(function(response){

        return response.text();

    }).then(function(text){

        const div = document.getElementById("add_product_msg_box");
        const res = text.split(':');

        if(res[0] === 'err'){

            div.innerHTML = "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';

        }else if(res[0] === 'val'){

            div.innerHTML = "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
            reset_form(product_add)
        }
        else{
            div.innerHTML = "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';
            reset_form(product_add)
        }
        refresh_product();


    })
})

function reset_form(form) {
    const input_file = document.getElementById('image_product');
    input_file.value ='';
    form.reset();
}

//REFRESH DATA AJAX METHOD//
window.onload = () => {
    setInterval(refresh_product, 5000); //each 15sec try if new product
}

function refresh_product(){
    product_list();
    product_header();
}

function product_list(){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/refresh_product_list.php");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("product_list");
            div.innerHTML = res;
        }
    };
    
    request.send();
}

function product_header() {
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/refresh_product_header.php");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("product_header");
            div.innerHTML = res;
        }
    };

    request.send();
}

function delete_product(e) {
    if(confirm('Êtes vous sur de vouloir supprimer ce produit ?')){
        const request = new XMLHttpRequest();

        request.open("GET","/ajax/delete_product.php?id="+e);
        
        request.onreadystatechange = function(){

            if(request.readyState === 4){
                const res = request.responseText;
                const div = document.getElementById("product_table_msg_box");
                div.innerHTML = "<div class='alert alert-success' role='alert'>" + res + '</div>';
                refresh_product();
            }
        };

        request.send();
    }
}

function get_id_product(e) {

    const request = new XMLHttpRequest();

    request.open("GET","/ajax/get_product_modal.php?id="+e);
        
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("modify_product-content");
            div.innerHTML = res;
        }
    };

    request.send();

    
}
