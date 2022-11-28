/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
//ADD DATA AJAX METHOD
const captcha_img_add = document.getElementById('captcha-img-add');

captcha_img_add.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    
    fetch('/ajax/add_captcha_img.php',
    {
        method: 'POST',
        body: formData
    }).then(function(response){
        
        return response.text();

    }).then(function(text){

        const div = document.getElementById("add_captcha_msg_box");
        const res = text.split(':');

        if(res[0] === 'err'){

            div.innerHTML = "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';

        }else if(res[0] === 'val'){

            div.innerHTML = "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
            reset_form(captcha_img_add);
        }
        else{
            div.innerHTML = "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';
            reset_form(captcha_img_add);
        }

    })
})

function reset_form(form) {
    const input_file = document.getElementById('image_captcha');
    input_file.value ='';
    form.reset();
}