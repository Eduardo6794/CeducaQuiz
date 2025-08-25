let redirecionar_aluno = document.querySelector("#redirecionar_aluno")

redirecionar_aluno.addEventListener("click", redirecionar_aluno1)

function redirecionar_aluno1() {
    window.location.href="../cadastro_aluno/cadastro_aluno.php"
}


let redirecionar_professor = document.querySelector("#redirecionar_prof")

redirecionar_professor.addEventListener("click", redirecionar_professor1)

function redirecionar_professor1() {
    window.location.href="../cadastro_professor/cadastro_professor.php"
}

function retorna() {
    window.location.href="../login/login.php"
}