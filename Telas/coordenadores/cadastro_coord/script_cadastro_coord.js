let btnEnviar = document.querySelector("#btnEnviar");
let form = document.querySelector(".form");
let cadRealizado = document.querySelector(".cadastroRealizado");

btnEnviar.addEventListener("click", enviarCad);

function enviarCad() {
    //Se o formulário está visível, oculta e exibe a mensagem de cadastro
    if (form.style.display === "flex") {
        form.style.display = "none";
        cadRealizado.style.display = "flex";

        // Após 10 segundos, volta para o formulário
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