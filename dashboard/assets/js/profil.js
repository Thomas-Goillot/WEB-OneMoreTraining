window.onload = () => {
    setInterval(delete_mail_check_msg_box,60000);
}

function delete_mail_check_msg_box(){
    const div = document.getElementById("mail_check_msg_box");
    if(div) div.innerHTML = '';
}


function sendmail(id_user,mailfile){
    const div = document.getElementById("mail_check_msg_box");
    if(div) div.innerHTML = '';
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