function get_user_group_info(id_group,id_user){

    document.getElementById("get_user_group_info_content").innerHTML = "<h3>Chargement des informations utilisateurs...</h3>";

    const request = new XMLHttpRequest();

    request.open("GET","/ajax/get_user_firstname.php?id_user=" + id_user);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){

            const text = request.responseText;
            document.getElementById('get_user_group_info_title').innerText = "Détails de l'utilisateur " + text;
        }
    };

    request.send();

    const request2 = new XMLHttpRequest();

    request2.open("GET","/ajax/get_user_group_info.php?id_group="+id_group + "&id_user=" + id_user);
    
    request2.onreadystatechange = function(){

        if(request2.readyState === 4){

            const text = request2.responseText;
            const div = document.getElementById("get_user_group_info_content");
            div.innerHTML = text;
        }
    };

    request2.send();
}

function ban_user_group(e,id_group,id_user) {
    const banned_user = `<i class="fa-solid fa-user-times"></i>`;
    const active_user = `<i class="fa-solid fa-user-check"></i>`; 

    const request = new XMLHttpRequest();

    console.log(id_user);

    if(e.innerHTML === banned_user){
        request.open("GET","/ajax/modify_user_group_banned.php?value=1&id_user="+id_user+"&id_group="+id_group);
    }
    else{
        request.open("GET","/ajax/modify_user_group_banned.php?value=3&id_user="+id_user+"&id_group="+id_group);
    }

    request.onreadystatechange = function(){
        if(request.readyState === 4){
            const res = request.responseText;
            if(res == 1){
                e.innerHTML = active_user;
                e.className = "btn btn-link text-success";
            }
            else{
                e.innerHTML = banned_user;
                e.className = "btn btn-link text-danger";
            }
            get_user_group_info(id_group,id_user);
            refresh_user_group_info(id_group);
        }
    };

    request.send();
}

function change_permissions(e,id_group,id_user){
    const permission = e.options[e.selectedIndex].value;

    if(permission >= 0 && permission <= 1){

        const request = new XMLHttpRequest();

        request.open("GET","/ajax/modify_user_group_permission.php?id_group="+id_group+"&id_user="+id_user+"&permission="+permission);
        
        request.onreadystatechange = function(){
            if(request.readyState === 4){
                const res = request.responseText;
                get_user_group_info(id_group,id_user);
                refresh_user_group_info(id_group);
            }
        };
        
        request.send();
        
    }
    
}

function refresh_user_group_info(id_group){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/get_group_detail_list.php?id_group="+id_group);

    request.onreadystatechange = function(){
        if(request.readyState === 4){
            const res = request.responseText;
            document.getElementById('group_detail_list').innerHTML = res;
        }
    }

    request.send();
}

function search_user_group(id_group){
    let x = document.getElementById("search-user_group").value;    

    const request = new XMLHttpRequest();

        request.open("GET","/ajax/search_user_group.php?q="+x+"&id_group="+id_group);
        
        request.onreadystatechange = function(){
            if(request.readyState === 4){
                const res = request.responseText;
                const div = document.getElementById("add_user_content");
                div.innerHTML = res;
            }
        };
        
    request.send();
}

function add_user_to_group(id_group,id_user){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/add_user_to_group.php?id_group="+id_group+"&id_user="+id_user);

    request.onreadystatechange = function(){
        if(request.readyState === 4){
            const res = request.responseText;
            console.log(res);
            refresh_user_group_info(id_group);
        }
    }

    request.send();
}

function delete_user_group(id_group,id_user){
    if(confirm('Êtes vous sur de vouloir supprimer cet utilisateurs de son groupe ?')){
        const request = new XMLHttpRequest();

        request.open("GET","/ajax/delete_user_group.php?id_group="+id_group + "&id_user=" + id_user);
        
        request.onreadystatechange = function(){

            if(request.readyState === 4){

                const text = request.responseText;
                const div = document.getElementById("group_detail_msg_box");
                const res = text.split(':');
        
                if(res[0] === 'err'){
        
                    div.innerHTML = "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';
        
                }else if(res[0] === 'val'){
        
                    div.innerHTML = "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
                    
                }
                else{
                    div.innerHTML = "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';
                }
                refresh_user_group_info(id_group);
            }
        };

        request.send();
    }
}