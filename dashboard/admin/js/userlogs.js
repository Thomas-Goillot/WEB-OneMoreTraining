/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

//REFRESH DATA AJAX METHOD//
window.onload = () => {
    setInterval(userlog_header, 15000);
    setInterval(delete_userlog_list_msg_box, 15000);
}

/* function refresh_userlog(){
    userlog_list();
    userlog_header();
}

function userlog_list(){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/refresh_userlog_list.php");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("userlog_list");
            div.innerHTML = res;
        }
    };
    
    request.send();
} */

function userlog_header() {
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/refresh_userlog_header.php");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("userlog_header");
            div.innerHTML = res;
        }
    };

    request.send();
}

function search_user(){
    let x = document.getElementById("search-user").value;    

    const request = new XMLHttpRequest();

        request.open("GET","/ajax/search_user.php?q="+x);
        
        request.onreadystatechange = function(){
            if(request.readyState === 4){
                const res = request.responseText;
                const div = document.getElementById("userlog_list");
                div.innerHTML = res;
            }
        };
        
    request.send();
}

function userstatus(e,id_user) {
    const banned_user = `<i class="fa-solid fa-user-times"></i>`;
    const active_user = `<i class="fa-solid fa-user-check"></i>`; 

    const request = new XMLHttpRequest();

    if(e.innerHTML === banned_user){
        request.open("GET","/ajax/modify_user_banned.php?value=0&id_user="+id_user);
    }
    else{
        request.open("GET","/ajax/modify_user_banned.php?value=1&id_user="+id_user);
    }

    request.onreadystatechange = function(){
        if(request.readyState === 4){
            const res = request.responseText;
            console.log(res);

            if(res == 0){
                e.innerHTML = active_user;
                e.className = "btn btn-link text-success";
            }
            else{
                e.innerHTML = banned_user;
                e.className = "btn btn-link text-danger";
            }

        }
    };

    request.send();
}

function change_permissions(e,id_user,type_permissions) {

    const permission = e.options[e.selectedIndex].value;

    delete_userlog_list_msg_box();

    const request = new XMLHttpRequest();
    request.open("GET","/ajax/get_user_id.php");
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;

            if(res != id_user){

                const request = new XMLHttpRequest();
        
                request.open("GET","/ajax/modify_user_permission.php?value="+permission+"&id_user="+id_user+"&type_permissions="+type_permissions);
                
                request.onreadystatechange = function(){
                    if(request.readyState === 4){
                        const div = document.getElementById("userlog_list_msg_box");
                        const text = request.responseText;            
                        const res = text.split(':');
                        console.log(text)
                        if(res[0] === 'err'){
        
                            div.innerHTML += "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';
        
                        }else if(res[0] === 'val'){
        
                            div.innerHTML += "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
                        }
                        else{
                            div.innerHTML += "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';
                        }
                    }
                };
                
                request.send();
            }
            else{
                alert("Vous ne pouvez pas changer vos propres permissions");
                e.selectedIndex = 0;
            }
        }
        
    };    
    request.send();
}

function delete_userlog_list_msg_box(){
    const div = document.getElementById("userlog_list_msg_box");
    if(div) div.innerHTML = '';
}

function set_id_modal(id_user){
    const hidden = document.getElementById("hidden");
    hidden.innerHTML = "";

    const elem = document.createElement("input");
    elem.setAttribute("type","hidden");
    elem.setAttribute("id","id_user");
    elem.setAttribute("value",id_user);
    hidden.appendChild(elem);
}

function sendmail(){
    const div = document.getElementById("mail_msg_box");
    if(div) div.innerHTML = '';

    const id_user = document.getElementById("id_user").value;
    const select = document.getElementById("mail_file");
    const mailfile = select.options[select.selectedIndex].value;
    console.log(mailfile);
    console.log(id_user);
    console.log(select)
    const request = new XMLHttpRequest();

    request.open("GET", "/ajax/sendmail.php?id_user="+id_user+"&mail_file="+mailfile);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const text = request.responseText;
            const res = text.split(':');
            if(res[0] === 'err'){
    
                div.innerHTML = "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>'+ div.innerHTML;;
    
            }else if(res[0] === 'val'){
    
                div.innerHTML = "<div class='alert alert-success' role='alert'>" + res[1] + '</div>'+ div.innerHTML;;
                
            }
            else{
                div.innerHTML = "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>'+ div.innerHTML;;
            }
            
        }
    };

    request.send();

}