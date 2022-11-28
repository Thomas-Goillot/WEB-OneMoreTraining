/*
--------------------------------------------------------
OMT © 2022
Thomas GOILLOT
-------------------------------------------------------- 
*/
(function () {
    let lightSwitch = document.getElementById("lightSwitch");
    
    if (!lightSwitch) {
        return;
    }

    function darkMode() {
        document.querySelectorAll(".bg-light").forEach((element) => {
            element.className = element.className.replace(/-light/g, "-dark");
        });

        document.querySelectorAll(".logo-img").forEach((element) => {
            element.setAttribute("src","assets/img/logo_white.png");
        });

        document.body.classList.add("bg-dark");

        if (document.body.classList.contains("text-dark")) {
            document.body.classList.replace("text-dark", "text-light");
        } else {
            document.body.classList.add("text-light");
        }
        
        if (! lightSwitch.checked) {
            lightSwitch.checked = true;
        }
        localStorage.setItem("lightSwitch", "dark");
    }

    function lightMode() {
        document.querySelectorAll(".bg-dark").forEach((element) => {
            element.className = element.className.replace(/-dark/g, "-light");
        });

        document.querySelectorAll(".logo-img").forEach((element) => {
            element.setAttribute("src","assets/img/logo_black.png");
        });

        document.body.classList.add("bg-light");

        if (document.body.classList.contains("text-light")) {
            document.body.classList.replace("text-light", "text-dark");
        } else {
            document.body.classList.add("text-dark");
        }
        
        if (lightSwitch.checked) {
            lightSwitch.checked = false;
        }
        localStorage.setItem("lightSwitch", "light");
    }

    function onToggleMode() {
        if (lightSwitch.checked) {
            darkMode();
        } else {
            lightMode();
        }
    }

    function getSystemDefaultTheme() {
        const darkThemeMq = window.matchMedia("(prefers-color-scheme: dark)");
        if (darkThemeMq.matches) {
        return "dark";
        }
        return "light";
    }

    function setup() {
        var settings = localStorage.getItem("lightSwitch");
        if (settings == null) {
            settings = getSystemDefaultTheme();
        }
        
        if (settings == "dark") {
            lightSwitch.checked = true;
        }
        
        lightSwitch.addEventListener("change", onToggleMode);
        onToggleMode();
    }

    setup();



})();
