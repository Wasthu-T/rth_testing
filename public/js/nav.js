var nav = document.querySelector("nav");
var collap = document.getElementById('navbarSupportedContent')
var btn = document.getElementById('btn-colapse')
nav.classList.remove("bg-success");
nav.classList.add("bg-transparent");

btn.addEventListener("click", function () {
    if (nav.classList.contains("bg-transparent")) {
        nav.classList.remove("bg-transparent");
        nav.classList.toggle('bg-success');
    } else if (nav.classList.contains("bg-success")) {
        if (window.scrollY < 200) {
            console.log("btn")
            nav.classList.add("bg-transparent");
            nav.classList.remove("bg-success");
        }
    } else {
        nav.classList.add("bg-transparent")
    };
});

window.addEventListener("scroll", function () {
    if ((window.scrollY > 200) && (nav.classList.contains("bg-transparent"))) {
        nav.classList.remove("bg-transparent");
        nav.classList.add("sticky");
        nav.classList.add("bg-success");
    }
    if((window.scrollY < 200) && (nav.classList.contains("bg-success"))){
        nav.classList.remove("sticky");
        nav.classList.remove("bg-success");
        nav.classList.add("bg-transparent");
    }
});