function init(idtraining) {
    if(localStorage.getItem('training_order') == null) {
        localStorage.setItem('training_order', JSON.stringify([]));
        localStorage.setItem('training_order', 0);
    }
    console.log(localStorage.getItem('training_order'));

    get_info(idtraining);

}

function get_info(id_training) { 
    localStorage.setItem('training_order',parseInt(localStorage.getItem('training_order'))+1);
    console.log(localStorage.getItem('training_order'));
    let exercise_order = localStorage.getItem('training_order');

    const request = new XMLHttpRequest();

        request.open("GET","/ajax/get_training_exercise.php?id_training="+id_training+"&exercise_order="+exercise_order);
        
        request.onreadystatechange = function(){
            if(request.readyState === 4){
                const res = request.responseText;
                const div = document.getElementById("content");
                div.innerHTML = res;
                
            }
        };
        
    request.send();
}

function stop(id_training) {
    localStorage.setItem('training_order',0);
    
    const request = new XMLHttpRequest();

        request.open("GET","/ajax/add_training_historical.php?id_training="+id_training);
        
        request.onreadystatechange = function(){
            if(request.readyState === 4){
                document.location.href="https://onemoretraining.ddns.net/main.php"; 
            }
        };
        
    request.send();
}

