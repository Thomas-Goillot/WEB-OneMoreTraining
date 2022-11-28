function refresh_objective_list(){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/refresh_objective_list.php");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("objective_list");
            div.innerHTML = res;
        }
    };
    
    request.send();
}

function add_objective(){
    const name = document.getElementById('name_objective').value;
    const description = document.getElementById('description_objective').value;

    const request = new XMLHttpRequest();

    request.open("GET","/ajax/add_objective.php?name="+name+"&description="+description);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const myModalEl = document.getElementById('add_objective');
            const modal = bootstrap.Modal.getInstance(myModalEl)
            modal.hide();
            refresh_objective_list();
        }
    };
    
    request.send();

}

function delete_objective(id_objective) {
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/delete_objective.php?id_objective="+id_objective);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            refresh_objective_list();
        }
        
    };
    
    request.send();

}