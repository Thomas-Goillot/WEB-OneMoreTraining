localStorage.setItem('clicks', 0);

function incrementClick() {
    var clicks = localStorage.getItem('clicks');
    if (clicks === null) {
        clicks = 0;
    }
    clicks++;
    localStorage.setItem('clicks', clicks);
    if (localStorage.getItem('clicks') == 10) {
        exec();
    }
}

function exec(){
    const body = document.body;
    body.innerHTML += "<div class='content'><h1 class='text-center nodelete'>Bravo !</h1></div>";


    let audio = new Audio('assets/media/zelda.mp3');
    audio.play();
    
    setInterval(bounce, 50);
}

function bounce() {
    const nav = document.getElementById('navbar-bg-light');
    const body = document.body;
    const img = document.createElement('img');
    const list = ["p","h1:not(.nodelete)","h2","h3","h4","h5","h6","hr","button","input","i","a","span","li","footer",".card",".banner"];
    const erase = Math.floor(Math.random() * 5);

    scroll(0,0);
    nav.classList.remove('bg-light');

    if(erase == 0) {

        let element =  document.querySelector(list[Math.floor(Math.random() * list.length)])

        if (typeof(element) != 'undefined' && element != null) element.remove();
    }

    img.src = 'assets/media/Cocotte.png';
    img.classList.add('bounce');
    img.style.left = Math.random() * window.innerWidth + 'px';
    img.style.top = (Math.random() * window.innerHeight) + 'px';

    body.appendChild(img);

    setTimeout(() => {
        img.remove();
    }
    , 1000);

}