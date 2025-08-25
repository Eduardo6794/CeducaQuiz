//Variaveis Globais
//SubNavBars
let div_turma = document.getElementById('subnavbar_turmas');
let div_curso = document.getElementById('subnavbar_cursos');

//Resposividade
let div_navbar_mobile = document.getElementById('navbar_mobile');
let subdiv_mobile = document.getElementById('subnavbar_mobile');
let img_menu = document.getElementById('img_menu');
let img_close = document.getElementById('img_close');

//Funções

function clicar_geral(div_selecionada) {

    div_turma.style.display = 'none';
    div_curso.style.display = 'none';
    div_professor.style.display = 'none';
    div_aluno.style.display = 'none';

    if (div_selecionada.style.display === 'none') {
        div_selecionada.style.display = 'flex';
    } else {
        div_selecionada.style.display = 'none';
    }
}

function clicar_turma() {

    if (div_curso.style.display === "flex") {
        div_curso.style.display = "none";
    }

    if (div_turma.style.display === "none") {
        div_turma.style.display = "flex";
    }
    else {
        div_turma.style.display = "none";
    }
}

function clicar_curso(){

    if (div_turma.style.display === "flex") {
        div_turma.style.display = 'none';
    }

    if (div_curso.style.display === "none") {
        div_curso.style.display = 'flex';
    }
    else {
        div_curso.style.display = 'none';
    }
}





//Função Responsividade
function btn_mobile() {
    if (subdiv_mobile.style.display === "flex") {
        subdiv_mobile.style.display = "none";
        img_menu.style.display = "flex";
        img_close.style.display = "none";

        document.getElementById("img_close").animate(
            [
              // keyframes
              { transform: "rotate(0deg)" },
              { transform: "rotate(360deg)" },
            ],
            {
              // timing options
              duration: 2000,
              iterations: 1,
            },
          );
        
    }
    else {
        subdiv_mobile.style.display = "flex";
        img_menu.style.display = "none";
        img_close.style.display = "flex";
        document.getElementById("img_menu").animate(
            [
              // keyframes
              { transform: "rotate(360deg)" },
              { transform: "rotate(0deg)" },
            ],
            {
              // timing options
              duration: 2000,
              iterations: 1,
            },
          );

    }
}
















