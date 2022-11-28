/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

window.onload = () => {
    setInterval(delete_group_detail_msg_box,30000);
}

function reload_script(){
    document.querySelectorAll(`script:not([class*="noreload"]`).forEach(function(e){

    let oldScript = e.getAttribute("src");
    e.remove();

    let newScript;
    newScript = document.createElement('script');
    newScript.type = 'text/javascript';
    newScript.src = oldScript;

    document.getElementById("scripttoreload").appendChild(newScript);
    });
}


function refresh_group_list() {

    const request = new XMLHttpRequest();

    request.open("GET","/ajax/refresh_group_list.php");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("group_list");
            div.innerHTML = res;
            reload_script()
        }
    };

    request.send();
}

function get_group_detail(id_group) {

    const request = new XMLHttpRequest();

    request.open("GET","/ajax/get_group_detail.php?id_group="+id_group);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("see_group-content");
            div.innerHTML = res;
        }
    };

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
                get_group_detail(id_group);
            }
        };

        request.send();
    }
}

function delete_group_detail_msg_box(){
    const div = document.getElementById("group_detail_msg_box");
    if(div) div.innerHTML = '';
}


function delete_group(id_group){
    if(confirm('Êtes vous sur de vouloir supprimer ce groupe ?')){
        const request = new XMLHttpRequest();

        request.open("GET","/ajax/delete_group.php?id_group="+id_group);
        
        request.onreadystatechange = function(){

            if(request.readyState === 4){

                const text = request.responseText;
                const div = document.getElementById("group_list_msg_box");
                const res = text.split(':');
        
                if(res[0] === 'err'){
        
                    div.innerHTML = "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';
        
                }else if(res[0] === 'val'){
        
                    div.innerHTML = "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
                }
                else{
                    div.innerHTML = "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';
                }
                refresh_group_list()
            }
        };

        request.send();
    }
}

document.getElementById('group-add').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/ajax/add_group.php',
    {
        method: 'POST',
        body: formData
    }).then(function(response){

        return response.text();

    }).then(function(text){

        const div = document.getElementById("add_group_msg_box");
        const res = text.split(':');

        if(res[0] === 'err'){

            div.innerHTML = "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';

        }else if(res[0] === 'val'){

            div.innerHTML = "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
        }
        else{
            div.innerHTML = "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';
        }
        refresh_group_list()

    })
})

document.querySelectorAll("tbody td").forEach(function(node){
	node.ondblclick=function(){
		let val = this.innerHTML;
        let column = this.getAttribute('name');
        let id_group = this.getAttribute('value');


		let input = document.createElement("input");
        input.className = "form-control";
		input.value = val;      

		input.onblur = function(){
			let val = this.value;
			this.parentNode.innerHTML=val;
            modify_group_content(id_group,column,val);
		}

		this.innerHTML = "";
		this.appendChild(input);
		input.focus();

	}
});

function modify_group_content(id_group,column_name,new_val){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/modify_group_content.php?id_group="+id_group+"&column_name="+column_name+"&val="+new_val);

    request.send();
}

