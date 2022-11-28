
window.onload = () => {
    setInterval(delete_exercise_list_msg_box,30000);
}

function delete_temp_tr(e){
    e.parentNode.parentNode.remove();
}

function refresh_exercise_list(id_training){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/refresh_exercise_list.php?id_training="+id_training);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("exercise_list");
            div.innerHTML = res;
        }
    };
    
    request.send();
}

function create_exercise() {
    const tbody = document.getElementById('exercise_list');
    new_tr = 
    `
    <tr class="text-center align-middle">
        <td name="id_training_order" value="-1">#</td>
        <td>
        <button class="btn btn-link text-warning" onclick="get_id_training_order(this); search(this);" data-bs-toggle="modal" data-bs-target="#see_exercise"><i class="fa-solid fa-plus"></i></button>
        </td>
        <td><input type="text" class="form-control" placeholder="Ex: 15 ou 1m30" style="display: inline-block; width: 40%;"></td>
        <td>
            <button class="btn btn-link text-danger" onclick="delete_temp_tr(this)"><i class="fa-solid fa-xmark"></i></button>
        </td>
    </tr>
    `;    
    if(tbody.innerHTML === ''){
        tbody.innerHTML = new_tr;
    }
    else{
        tbody.innerHTML += new_tr;       
    }
}

function delete_exercise_training(e){
    if(confirm('Êtes vous sur de vouloir supprimer cet exercice ?')){
        const parent = e.parentNode.parentNode;
        const id_exercise = parent.querySelector("[name='id_exercise']").getAttribute('value');
        const id_training = parent.getAttribute('value');
        const id_training_order = parent.querySelector("[name='id_training_order']").getAttribute('value');
        

        const request = new XMLHttpRequest();

        request.open("GET","/ajax/delete_exercise_training.php?id_training="+id_training+"&id_exercise="+id_exercise+"&id_training_order="+id_training_order);
        
        request.onreadystatechange = function(){
            if(request.readyState === 4){
                e.parentNode.parentNode.remove();
                const div = document.getElementById("exercise_list_msg_box");
                const text = request.responseText;            
                const res = text.split(':');

                div.innerHTML = "";

                if(res[0] === 'err'){

                    div.innerHTML += "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';

                }else if(res[0] === 'val'){

                    div.innerHTML += "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
                }
                else{
                    div.innerHTML += "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';
                }
                refresh_exercise_list(id_training);
            }
        };
        
        request.send();
    }
}

function delete_training_list_msg_box(){
    const div = document.getElementById("training_list_msg_box");
    if(div) div.innerHTML = '';
}

function get_id_training_order(e) {
    const parent = e.parentNode.parentNode;
    const id_training_order = parent.querySelector("[name='id_training_order']").getAttribute('value');
    let input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "id_training_order_actual");
    input.setAttribute("value", id_training_order);
    document.getElementById("exercise_list").appendChild(input);
}

function search(){
    let x = document.getElementById("search-exercise").value;    

    const request = new XMLHttpRequest();

        request.open("GET","/ajax/search_exercise.php?q="+x);
        
        request.onreadystatechange = function(){
            if(request.readyState === 4){
                const res = request.responseText;
                const div = document.getElementById("response_exercise");
                div.innerHTML = res;
            }
        };
        
    request.send();
}

function validexercise(){
    delete_exercise_list_msg_box();
    const url = new URL(window.location.href);
    const id_training = url.searchParams.get("id");
    const exercises = document.getElementsByName('exercise');
    const id_training_order = document.getElementsByName('id_training_order_actual')[0].value;
    
    let counter = 0;


    exercises.forEach(exercise => {

        if(exercise.checked){
            counter +=1;
            if(counter == 1){
                
                const request = new XMLHttpRequest();

                request.open("GET","/ajax/add_exercise.php?id_exercise="+ exercise.value+"&id_training="+id_training+"&id_training_order="+id_training_order);
                
                request.onreadystatechange = function(){
                    if(request.readyState === 4){
                        const res = request.responseText;
                        var myModalEl = document.getElementById('see_exercise');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        refresh_exercise_list(id_training);
                        
                    }
                };
                
                request.send();

            }
            else{
                console.log("plusieurs res");
            }
        }
        
    });    
}

function setduration(e,id_training_order){
    delete_exercise_list_msg_box();
    const duration = e.parentNode.querySelector('.form-control').value;

    const request = new XMLHttpRequest();

    request.open("GET","/ajax/add_duration.php?id_training_order="+id_training_order+"&duration="+duration);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            
            const div = document.getElementById("exercise_list_msg_box");
            const text = request.responseText;            
            const res = text.split(':');

            div.innerHTML = "";

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

function delete_exercise_list_msg_box(){
    const div = document.getElementById("exercise_list_msg_box");
    if(div) div.innerHTML = '';
}