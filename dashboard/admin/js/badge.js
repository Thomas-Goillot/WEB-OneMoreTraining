/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
//REFRESH DATA AJAX METHOD//
window.onload = () => {
    setInterval(refresh_badge, 20000); //each 15sec try if new badge
}

function refresh_badge(){
    badge_list_user();
    badge_list();
}

function badge_list_user(){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/refresh_badge_list_user.php");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("badge_list_user");
            div.innerHTML = res;
        }
    };
    
    request.send();
}

function badge_list() {
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/refresh_badge_list.php");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("badge_list");
            div.innerHTML = res;
        }
    };

    request.send();
}

function show_user_badge(id) {

    const request = new XMLHttpRequest();

    request.open("GET","/ajax/show_badge.php?id="+id);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("modify_badge-content");
            div.innerHTML = res;
        }
    };

    request.send();   
}

const badge_modify = document.getElementById('update_badge');

badge_modify.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/ajax/update_badge.php',
    {
        method: 'POST',
        body: formData
    }).then(function(response){

        return response.text();

    }).then(function(text){

        const div = document.getElementById("update_badge_msg_box");
        const res = text.split(':');

        if(res[0] === 'err'){

            div.innerHTML = "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';

        }else if(res[0] === 'val'){

            div.innerHTML = "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
        }
        else{
            div.innerHTML = "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';
        }
        badge_list_user()

    })
})
