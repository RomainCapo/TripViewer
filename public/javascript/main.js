
//evenenement de scroll
window.onscroll = function() {scrollFunction()};

/**
 * Permet d'afficher le bouton lorsqu'il est en bas de page
 * @return {[type]} [description]
 */
function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("btnToTop").style.display = "block";
    } else {
        document.getElementById("btnToTop").style.display = "none";
    }
}

/**
 * Permet de remettre la page tout en haut
 */
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

/**
 * Ajoute la classe active sur le menu de la navbar
 * @param  {string} menu id du menu du string
 */
function updateNavMenu(menu){
  let element = document.getElementById(menu);
  element.classList.add("active");
}
