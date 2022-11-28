/*
--------------------------------------------------------
OMT © 2022
Thomas GOILLOT
-------------------------------------------------------- 
*/
function scrolldetection() {
    const header = document.getElementsByClassName("navbar-color")[0];
    const lightSwitch = document.getElementById("lightSwitch");
    let sticky = header.offsetTop;
    if (window.pageYOffset > sticky) { //on scroll
        if (! lightSwitch.checked) {
            header.classList.add("bg-light");      
        }
        else{
            header.classList.add("bg-dark");
        }
        
    } else { //on top
        if (! lightSwitch.checked) {
            header.classList.remove("bg-light");
        }
        else{
            header.classList.remove("bg-dark");
        }
        
    }
} 