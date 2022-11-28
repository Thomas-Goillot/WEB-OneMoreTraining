/*
 * Created on Mon Apr 21 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
function avatar_items_list(e,id){
    const nav_list = document.querySelectorAll('.nav-list');
    const items_list = document.querySelectorAll('.items');

    nav_list.forEach(item => item.classList.remove('active'));
    e.classList.add('active');

    items_list.forEach(item => item.classList.add('hide'));
    document.getElementById(id).classList.remove('hide');
    document.getElementById(id).classList.add('show');
}

function change_item(e){
    const parent = e.parentNode;
    const img = parent.querySelector('img');
    const id = img.dataset.id;
    const src = img.src;

    switch (id) {
        case 'head':
            document.getElementById('head').src = src;
            break;
        case 'eyes':
            document.getElementById('eyes').src = src;
            break;
        case 'mouth':
            document.getElementById('mouth').src = src;
            break;
        case 'nose':
            document.getElementById('nose').src = src;
            break;
        case 'brows':
            document.getElementById('brows').src = src;
            break;    
        default:
            break;
    }
}

function random_avatar(){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/load_avatar_preview.php");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            console.log(request.responseText);
            document.getElementById("avatar_preview").innerHTML = request.responseText;
        }
    };
    
    request.send();

}

function save_avatar(){
    const head = document.getElementById('head').src;
    const eyes = document.getElementById('eyes').src;
    const mouth = document.getElementById('mouth').src;
    const nose = document.getElementById('nose').src;
    const brows = document.getElementById('brows').src;
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/save_avatar.php?head="+head+"&eyes="+eyes+"&mouth="+mouth+"&nose="+nose+"&brows="+brows);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const text = request.responseText;
            const res = text.split(':');
            const div = document.getElementById("avatar_msg_box");

            if(res[0] === 'err'){

                div.innerHTML = "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';

            }else if(res[0] === 'val'){

                div.innerHTML = "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
            }
            else{
                div.innerHTML = "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';

            }
        }
    };
    
    request.send();

}