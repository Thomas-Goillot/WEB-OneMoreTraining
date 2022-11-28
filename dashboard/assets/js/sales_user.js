/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

//REFRESH DATA AJAX METHOD//
window.onload = () => {
    setInterval(refresh_sales, 15000); //each 15sec try if new sales
}

function refresh_sales(){
    sales_list();
}

function sales_list(){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/refresh_sales_list.php?info=useronly");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("sales_list");
            div.innerHTML = res;
        }
    };
    
    request.send();
}


function get_command_detail(id) {

    const request = new XMLHttpRequest();

    request.open("GET","/ajax/get_command_detail.php?id="+id);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("command-detail-content");
            div.innerHTML = res;
        }
    };

    request.send();

    
}