let menuMobile = document.querySelector("#menuMobile")

let hamburguerMenu = document.querySelector("#menuHamburguerMobile")

let menuHumburguer2 = document.querySelector("#menuHumburguer2")

function showMenuMobile() {
    if (menuMobile.style.display === "none" || menuMobile.style.display === "") {
        menuMobile.style.display = "flex"
        menuHumburguer2.style.width = "45px"
    }
    else {
        menuMobile.style.display = "none"
        menuHumburguer2.style.width = "55px"
    }
}

function verificarTamanhoTela() {
    let larguraTela = window.innerWidth;
    if (larguraTela > 768) {
        menuMobile.style.display = "none";
        menuHumburguer2.style.width = "55px"
    }
}

window.addEventListener("resize", verificarTamanhoTela);

verificarTamanhoTela();

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("a[href^='#']").forEach(anchor => {
      anchor.addEventListener("click", function (e) {
        e.preventDefault();
  
        const targetId = this.getAttribute("href").substring(1);
        const targetElement = document.getElementById(targetId);
  
        if (targetElement) {
          targetElement.scrollIntoView({ behavior: "smooth" });
        }
      });
    });
  });


  let btnEntrar = document.querySelector("#btnEntrar")

  btnEntrar.addEventListener("click", redirecionalogin)
  
  function redirecionalogin(){
      window.location.href="../login/login.php";
  }