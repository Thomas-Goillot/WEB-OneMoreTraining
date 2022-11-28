/* 
--------------------------------------------------------
OMT © 2022
Thomas GOILLOT
--------------------------------------------------------
*/
window.onload = () => {
    load_captcha();
}

function load_captcha(){
    const request = new XMLHttpRequest();

    request.open("GET","/ajax/load_captcha.php");
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const res = request.responseText;
            const div = document.getElementById("captcha");
            div.innerHTML = res;
        }


        //For drag and drop start after loading image
        const draggables = document.querySelectorAll('.draggable');
        const containers = document.querySelectorAll('.captcha-div');

        draggables.forEach(draggable => {

            draggable.addEventListener('dragstart', () =>{
                
                draggable.classList.add('dragging');
            })

            draggable.addEventListener('dragend', () => {
                draggable.classList.remove('dragging');
            })

        })

        containers.forEach(container => {
            container.addEventListener('dragover', e =>{

                e.preventDefault();

                const draggable = document.querySelector('.dragging'); //img en cours de drag
                const parentcontainer = draggable.parentNode //ancien container

                const draggableElement = [...container.querySelectorAll('.draggable')][0] //element dans le container de destination
                
                parentcontainer.appendChild(draggableElement);
            
                container.appendChild(draggable);

            })
        })
        //End drag and drop
    };
    
    request.send();
}

function check_captcha() {

    const containers = document.querySelectorAll('.draggable');

    let req = '';
    let myModalEl = document.getElementById('captcha-modal');
    let modal = bootstrap.Modal.getInstance(myModalEl)
    let counter = 0;

    containers.forEach(container => {
        if(counter === 0){
            req += 'val'+counter+'='+container.getAttribute('value');  
        }
        else{
            req += '&val'+counter+'='+container.getAttribute('value');  
        }
        counter++;
    })

    const request = new XMLHttpRequest();

    request.open("GET","/ajax/check_captcha.php?"+req);
    
    request.onreadystatechange = function(){

        if(request.readyState === 4){
            const text = request.responseText;
            const res = text.split(':');
            const div = document.getElementById("res");
            const input = document.getElementById("captcha_validation");

            if(res[0] === 'err'){

                div.innerHTML = "<div class='alert alert-danger' role='alert'>" + res[1] + '</div>';

            }else if(res[0] === 'val'){

                div.innerHTML = "<div class='alert alert-success' role='alert'>" + res[1] + '</div>';
                input.value = "true";

                setTimeout(() => { modal.hide(); }, 750);
            }
            else{
                div.innerHTML = "<div class='alert alert-warning' role='alert'>Erreur: " + text + '</div>';

            }
        }
    };
    
    request.send();
}

//function avec dragstart et dragend pour captcha
function dragstart_captcha(event) {
    event.dataTransfer.setData("text", event.target.id);
}











   
