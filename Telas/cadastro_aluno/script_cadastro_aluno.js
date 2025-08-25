// Seleciona os elementos do DOM necessários para manipulação do formulário e botões
let btnEnviar = document.querySelector("#btnEnviar");
let form = document.querySelector(".form");
let cadRealizado = document.querySelector(".cadastroRealizado");
let privacidade = document.querySelector("#privacidade")
let condicao = document.querySelector("#condicao")

// Adiciona evento de clique ao botão de envio do formulário
btnEnviar.addEventListener("click", enviarCad)

// Função responsável por controlar o envio do formulário e exibição da mensagem de cadastro realizado
function enviarCad(event) {
    // Verifica se os termos de privacidade e condição estão marcados
    if (!privacidade.checked || !condicao.checked){
        event.preventDefault();
        return
    }

    // Se o formulário está visível, oculta e exibe a mensagem de cadastro realizado
    if (form.style.display === "flex") {
        form.style.display = "none";
        cadRealizado.style.display = "flex";

        // Após 5 segundos, volta para o formulário
        setTimeout(() => {
            cadRealizado.style.display = "none";
            form.style.display = "flex";
        }, 5000); // 5000 milissegundos = 5 segundos
    }
    // Caso contrário, mostra o formulário novamente e esconde a mensagem
    else {
        form.style.display = "flex";
        cadRealizado.style.display = "none";
    }
}

// Função assíncrona para consultar cursos disponíveis de acordo com o C.E informado
async function consulta_cursos() {
    const ceInput = document.getElementById("inputCE");
    const selectCursos = document.getElementById("selectCursos");
    const valor_ce = ceInput.value;

    // Se o campo C.E estiver vazio, reseta as opções do select de cursos
    if (!valor_ce) {
        selectCursos.innerHTML = '<option value="">Selecione um curso</option>';
        return;
    }

    // Faz uma requisição POST para o PHP, enviando o valor do C.E para buscar os cursos correspondentes
    const resposta = await fetch('consulta_cursos.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ curso: valor_ce })
    });

    // Se a resposta for bem sucedida, popula o select com os cursos retornados
    if (resposta.ok) {
        const cursos = await resposta.json();
        selectCursos.innerHTML = '<option value="">Selecione um curso</option>';
        cursos.forEach(curso => {
            selectCursos.innerHTML += `<option value="${curso.Curso_FK}">${curso.Nome_Curso}</option>`;
        });
    } else {
        // Caso ocorra erro, exibe mensagem de erro no select
        selectCursos.innerHTML = '<option value="">Erro ao carregar cursos</option>';
    }
}




