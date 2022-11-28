/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

window.onload = () => {
    setInterval(delete_training_list_msg_box,30000);
}

document.querySelectorAll(".name_training").forEach(function(node){
	node.ondblclick=function(){
		let val = this.innerHTML;
        let id_training = this.getAttribute('value');

		let input = document.createElement("input");
        input.className = "form-control";
		input.value = val;      

		input.onblur = function(){
			let val = this.value;
			this.parentNode.innerHTML=val;
            modify_name_training(id_training,val);
		}

		this.innerHTML = "";
		this.appendChild(input);
		input.focus();

	}
});

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

function refresh_training_list(){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/refresh_training_list.php?useronly=true");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("training_list");
            div.innerHTML = res;
        }
        reload_script();
    };
    
    request.send();
}

function modify_name_training(id_training,new_val){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/modify_training_name.php?id_training="+id_training+"&val="+new_val);

    request.send();
}

function delete_training(id_training) {
    if(confirm('Êtes vous sur de vouloir supprimer cette entrainement ?')){
        delete_training_list_msg_box()
        const request = new XMLHttpRequest();

        request.open("GET","/ajax/delete_training.php?id_training="+id_training);
        
        request.onreadystatechange = function(){
    
            if(request.readyState === 4){
    
                const div = document.getElementById("training_list_msg_box");
                const text = request.responseText;            
                const res = text.split(':');
    
                if(res[0] === 'err'){
    
                    div.innerHTML = "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';
    
                }else if(res[0] === 'val'){
    
                    div.innerHTML = "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
                }
                else{
                    div.innerHTML = "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';
                }
                refresh_training_list()
            }
        };
        
        request.send();
    }    
}

//FUNCTION FOR CREATION TRAINING PURPOSE

function create_training() {
    const tbody = document.getElementById('training_list');

    const request = new XMLHttpRequest();
    request.open("GET","/ajax/get_user_id.php");
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;

            let new_tr = 
            `
            <tr class="text-center align-middle" value="`+res+`">
                <td>#</td>
                <td class="name_training"><input type="text" class="form-control" name="name_training_add"></td>
                <td>
                    <select class="form-select" name="privacy_training_add">
                        <option value="1">Publique</option>
                        <option value="2">Amis seulement</option>
                        <option value="3">Privé</option>
                    </select>
                </td>
                <td><small class="text-muted"> #</small><small class="text-muted" name="id_user">`+res+`</small></td>
                <td>En attente d'enregistrement...</td>
                <td>
                    <button class="btn btn-link text-success" onclick="validate_training(this)"><i class="fa-solid fa-check"></i></button>
                    <button class="btn btn-link text-danger" onclick="delete_temp_tr(this)"><i class="fa-solid fa-xmark"></i></button>
                </td>
            </tr>
            `;    
            tbody.innerHTML = new_tr + tbody.innerHTML ;       
        }
        
    };    
    request.send();
}


function validate_training(e) {
    const parent = e.parentNode.parentNode;
    const name_training = parent.querySelector("[name='name_training_add']").value;
    const privacy_training = parent.querySelector("[name='privacy_training_add']").value;  
    const id_user = parent.querySelector("[name='id_user']").innerHTML;  

    const request = new XMLHttpRequest();

    request.open("GET","/ajax/add_training.php?name_training="+name_training+"&privacy="+privacy_training+"&id_user="+id_user);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){

            const div = document.getElementById("training_list_msg_box");
            const text = request.responseText;            
            const res = text.split(':');

            if(res[0] === 'err'){

                div.innerHTML += "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';

            }else if(res[0] === 'val'){

                div.innerHTML += "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
            }
            else{
                div.innerHTML += "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';
            }
            refresh_training_list()
        }
    };
    
    request.send();  
}

function delete_training_list_msg_box(){
    const div = document.getElementById("training_list_msg_box");
    if(div) div.innerHTML = '';
}

function delete_temp_tr(e){
    e.parentNode.parentNode.remove();
}

