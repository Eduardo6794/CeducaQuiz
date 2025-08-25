let btnRecuperarSenha = document.querySelector("#btnRecuperarSenha")

btnRecuperarSenha.addEventListener("click", redireciona_recuperar_senha)

function redireciona_recuperar_senha(){
    window.location.href="../recuperar_senha/recuperar_senha.php"
}


let barraMenuIcone2Aluno = document.querySelector("#barra_menu_icone_2_aluno")

barraMenuIcone2Aluno.addEventListener("click", redirecionaConfiguracoesAluno)

function redirecionaConfiguracoesAluno(){
    window.location.href="../config_aluno/config_aluno.php"
}


let barraMenuIcone2Professor = document.querySelector("#barra_menu_icone_2_professor")

barraMenuIcone2Professor.addEventListener("click", redirecionaConfiguracoesProfessor)

function redirecionaConfiguracoesProfessor(){
    window.location.href="../config_professor/config_professor.php"
}


let barraMenuIcone1Aluno = document.querySelector("#barra_menu_icone_1_aluno")

barraMenuIcone1Aluno.addEventListener("click", redirecionaDashBoardAluno)

function redirecionaDashBoardAluno(){
    window.location.href="../Dashboard_aluno/DashBoard_Aluno.php"
}


let barraMenuIcone1Professor = document.querySelector("#barra_menu_icone_1_professor")

barraMenuIcone1Professor.addEventListener("click", redirecionaDashBoardProfessor)

function redirecionaDashBoardProfessor(){
    window.location.href="../Dashboard_prof/tela_professor.php"
}