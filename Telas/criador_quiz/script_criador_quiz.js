let quantidadeDeClicadas = 0;
const LIMITE_RESPOSTAS = 5;
let numeroInputs = 1

// Garante que o botão só é adicionado UMA vez
document.getElementById("buttonAdiconarResposta").addEventListener("click", function() {
    quantidadeDeClicadas++;
    console.log(quantidadeDeClicadas)
    if (quantidadeDeClicadas == 5) {
        this.disabled = true;
        this.style.backgroundColor = "#ffd885"
    }

    const respostaId = "resposta_" + Date.now();

    // Criação da resposta (MANTENDO SEUS IDs/CLASSES)
    const respostaHTML = `
        <div class="resposta-item" data-id="${respostaId}">
            <div class="containerRecebeInputs">
                <div class="input-options">
                    <input type="text" name="respostas[]" id="inputRespostas${numeroInputs}" placeholder="Digite a resposta" class="inputRespostas">
                </div>
            </div>
            <div class="containerRecebeRadios">
                <div class="input-options">
                    <label title="Clique aqui para escolher o verdadeiro ou falso">
                    <input type="radio" class="radio-estilizado" name="opcao[]" value="1" id="radio_${respostaId}">
                    <input type="hidden" name="opcao[]" value="0" id="hidden_${respostaId}">
                    </label>
                </div>
            </div>
            <div class="containerRecebeBotoesExcluir">
                <div class="input-options">
                    <label title="Clique aqui para excluir a resposta">
                    <button id="excluirPergunta" onclick="removerResposta('${respostaId}')">Excluir</button>
                </div>
            </div>
        </div>
    `;

    document.getElementById("resposta").insertAdjacentHTML("beforeend", respostaHTML);

    numeroInputs++
});

function atualizarValorOculto(respostaId, isChecked) {
    // Define todos os campos ocultos como "0"
    document.querySelectorAll('input[type="hidden"][name="opcao[]"]').forEach(hiddenInput => {
        hiddenInput.value = "0";
    });

    // Atualiza o campo oculto correspondente ao botão de rádio selecionado
    if (isChecked) {
        const hiddenInput = document.getElementById(`hidden_${respostaId}`);
        if (hiddenInput) {
            hiddenInput.value = "1";
        }
    }
}




// Função de exclusão
function removerResposta(id) {
    const resposta = document.querySelector(`[data-id="${id}"]`);
    if (resposta) {
        resposta.remove();
        quantidadeDeClicadas--;
        numeroInputs--;
        
        const btnAdd = document.getElementById("buttonAdiconarResposta");
        if (quantidadeDeClicadas < LIMITE_RESPOSTAS) {
            btnAdd.disabled = false;
            btnAdd.style.backgroundColor = "#ffae00";
        }
    }
}



// Estilização dos radios (seu código original)
function alterarCores() {
    document.querySelectorAll(".radio-estilizado").forEach(radio => {
        radio.style.backgroundColor = radio.checked ? "#4CAF50" : "red";
        radio.style.borderColor = radio.checked ? "#4CAF50" : "red";
    });
}

// Aplica o evento de clique aos radios (DELEGAÇÃO)
document.getElementById("resposta").addEventListener("click", function(e) {
    if (e.target.classList.contains("radio-estilizado")) {
        alterarCores();
    }
});

// Função para verificar os inputs
function verificarResposta() {
    const inputPergunta = document.getElementById("inputPergunta");
    const perguntaVazia = inputPergunta.value.trim() === "";
    inputPergunta.classList.toggle("inputErro", perguntaVazia);

    const inputsResposta = document.querySelectorAll(".inputRespostas");
    let formularioValido = true;

    inputsResposta.forEach(input => {
        input.classList.remove("inputErro");
    });

    inputsResposta.forEach(input => {
        if (input.value.trim() === "") {
            input.classList.add("inputErro");
            formularioValido = false;
        }
    });

    const valoresPreenchidos = Array.from(inputsResposta)
        .filter(input => input.value.trim() !== "")
        .map(input => input.value.trim());

    const valoresUnicos = [...new Set(valoresPreenchidos)];
    
    if (valoresPreenchidos.length !== valoresUnicos.length) {
        formularioValido = false;

        const contador = {};
        valoresPreenchidos.forEach(valor => {
            contador[valor] = (contador[valor] || 0) + 1;
        });

        inputsResposta.forEach(input => {
            const valor = input.value.trim();
            if (valor !== "" && contador[valor] > 1) {
                input.classList.add("inputErro");
            }
        });
    }

    return formularioValido;
}


// Captura o envio do formulário e faz a validação
document.querySelector("form").addEventListener("submit", function(event) {
    const formularioValido = verificarResposta();

    // Checa se um radio está selecionado
    const algumaOpcaoSelecionada = document.querySelector('input[type="radio"][name="opcao[]"]:checked');

    if (!formularioValido || !algumaOpcaoSelecionada) {
        event.preventDefault(); // impede o envio do form

        if (!algumaOpcaoSelecionada) {
            alert("Selecione uma resposta correta antes de continuar.");
        }

        // Você pode usar estilos visuais também se quiser
    }
});

function criar_quiz() {
    window.location.href="../Dashboard_prof/tela_professor.php";
}

  const fileInput = document.getElementById("file");
  const fileNameDisplay = document.getElementById("file-name");

  fileInput.addEventListener("change", () => {
    const file = fileInput.files[0];
    fileNameDisplay.textContent = file ? file.name : "Nenhum arquivo selecionado";
  });