<?php 
   // Inclui o arquivo responsável pelo backend do cadastro do aluno
   include "../../Funcoes_Backend/Cadastro_Aluno.php";
?>
<!--
Página HTML para cadastro de aluno.
Contém formulário com campos para nome, senha, email, série/módulo, curso, RM e C.E.
Inclui também exibição de mensagens de erro e confirmação de cadastro.
-->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Aluno</title>
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style_cadastro_aluno.css">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <!-- Barra superior com ícones e logo -->
    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="retorna()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div style="display: block; width: 100%; position: relative; height: fit-content; z-index: 1;">
        <div class="primeira_div_centralizadora_forms">
            <!-- Formulário de cadastro de aluno -->
            <form action="../cadastro_aluno/cadastro_aluno.php"  method="post" class="form">
                <div>
                    <!-- Campos de entrada de dados do aluno -->
                    <label for="nome_aluno">
                        Nome Completo
                        <input type="text" id="nome_aluno" name="nome" required>
                    </label>
                    <label for="Senha">
                        Senha
                        <input type="password" id="Senha" name="senha" required>
                    </label>
                    <label for="email">
                        Email
                        <input type="text" id="email" name="email" required>
                    </label>
                    <div class="inputsAnoECurso">
                        <!-- Seleção de série/módulo e curso (curso é carregado dinamicamente via JS) -->
                        <label for="inputAno" style="width: 50%; align-items: center;">
                                <div style="display: flex; flex-direction: column; width: 75%;">
                                    Série/Módulo
                                    <select type="number" id="inputAno" name="modulo" required>
                                        <option value="1">1º Série</option>
                                        <option value="2">2º Série</option>
                                        <option value="3">3º Série</option>
                                        <option value="4">4º Série</option>
                                    </select>
                                </div>
                        </label>
                        <label for="inputC.E" style="width: 50%; align-items: center;">
                            <div style="display: flex; flex-direction: column; width: 75%;">
                                C.E
                                <input type="number" id="inputCE" name="ce" required oninput="consulta_cursos()">
                            </div>
                        </label>
                    </div>
                    <div class="inputsRmECe">
                        <!-- Campos para RM e C.E (C.E aciona consulta de cursos via JS) -->
                        <label for="inputRm" style="width: 50%; align-items: center;">
                            <div style="display: flex; flex-direction: column; width: 75%;">
                                RM
                                <input type="number" id="inputRm" name="rm" required>
                            </div>
                        </label>
                        <label for="selectCursos" style="width: 50%; align-items: center;">
                            <div style="display: flex; flex-direction: column; width: 75%;">
                            Cursos
                                <select id="selectCursos" name="curso" required>
                                    <option value="">Selecione um curso</option>
                                </select>
                            </div>
                        </label>
                    </div>
                </div>
                <p style="margin: auto; color: red;">
                    <?php
                        // Exibe mensagens de erro conforme o parâmetro recebido via GET
                        if ($_GET) {

                            $dados_incorretos = $_GET['dados_incorretos'];

                            if ($dados_incorretos == 'numeros_invalidos') {
                                echo "Os campos RM, C.E e Módulo devem conter apenas números inteiros.";
                            } else if ($dados_incorretos == 'sem_turma') {
                                echo "Não há turma cadastrada para o curso selecionado";
                            } else if ($dados_incorretos == 'aluno_existente') {
                                echo "Já existe um aluno cadastrado com esse RM ou C.E.";
                            } else if ($dados_incorretos == 'erro_cadastro') {
                                echo "Erro ao cadastrar o aluno. Tente novamente mais tarde.";
                            } else if ($dados_incorretos == 'rm_cadastrado') {
                                echo "RM já cadastrado";
                            }
                        }         
                    ?>
                </p>
                <div class="containerTermsCondicional">
                    <!-- Checkboxes para aceitar termos de privacidade e uso -->
                    <div id="containerPrivacidade">
                    <input type="checkbox" name="termoPrivacidade" id="privacidade" style="width: 20px; height: 20px;"><label onclick="redireciona_priv()">Termos de Privacidade</label></div>
                    <div id="containerCondicao">
                    <input type="checkbox" name="termoCondicaoUso" id="condicao" style="width: 20px; height: 20px;"><label onclick="redireciona_uso()">Termos de Condição e Uso</label></div>
                </div>
                <div class="botoesForm">
                    <!-- Botões para recuperar senha e enviar cadastro -->
                    <div style="display: flex; flex-direction: row; column-gap: 15px; width: 75%; align-self: center; justify-content: space-around;">
                        <button id="btnRecuperarSenha" type="button">Recuperar Senha</button>
                        <button id="btnEnviar" type="submit" >ENVIAR</button>
                    </div>     
                </div>

            </form>
                <!-- Mensagem de cadastro realizado com sucesso (exibida via JS) -->
                <div class="cadastroRealizado">
                    <div class="containerImgCadRealizado">
                        <img src="../../asssets/cadRealizado.png" alt="" id="imgCadRealizado">
                    </div>
                    <div class="textoCadRealizado">
                        <p>Cadastro foi realizado com Sucesso!</p>
                    </div>
                </div>
        </div>
    </div>
    
    <!-- Inclusão dos scripts JS -->
    <script src="script_cadastro_aluno.js"></script>
    <script src="../../script_geral.js"></script>

    <script>
        function redireciona_priv() {

            window.location.href = "../../Documentacao/politica_priv.php?redir=cadastro";

        }

        function redireciona_uso() {

            window.location.href = "../../Documentacao/politica_uso.php?redir=cadastro";

        }

        function retorna() {
            window.location.href = "../redirecionamento_de_cadastro/redirecionamento_de_cadastro.html";
        }
    </script>
    <script>
        // Salva e recupera os dados do formulário de cadastro de aluno
        document.addEventListener('DOMContentLoaded', function() {
            // Recupera os dados ao carregar a página
            const dados = JSON.parse(localStorage.getItem('cadastro_aluno'));
            if (dados) {
                if (document.getElementById('nome_aluno')) document.getElementById('nome_aluno').value = dados.nome || '';
                if (document.getElementById('Senha')) document.getElementById('Senha').value = dados.senha || '';
                if (document.getElementById('email')) document.getElementById('email').value = dados.email || '';
                if (document.getElementById('inputAno')) document.getElementById('inputAno').value = dados.modulo || '';
                if (document.getElementById('inputCE')) document.getElementById('inputCE').value = dados.ce || '';
                if (document.getElementById('inputRm')) document.getElementById('inputRm').value = dados.rm || '';
                if (document.getElementById('selectCursos')) document.getElementById('selectCursos').value = dados.curso || '';
                if (document.getElementById('privacidade')) document.getElementById('privacidade').checked = !!dados.privacidade;
                if (document.getElementById('condicao')) document.getElementById('condicao').checked = !!dados.condicao;
            }

            // Salva os dados ao digitar
            var form = document.querySelector('.form');
            if (form) {
                form.addEventListener('input', function() {
                    localStorage.setItem('cadastro_aluno', JSON.stringify({
                        nome: document.getElementById('nome_aluno') ? document.getElementById('nome_aluno').value : '',
                        senha: document.getElementById('Senha') ? document.getElementById('Senha').value : '',
                        email: document.getElementById('email') ? document.getElementById('email').value : '',
                        modulo: document.getElementById('inputAno') ? document.getElementById('inputAno').value : '',
                        ce: document.getElementById('inputCE') ? document.getElementById('inputCE').value : '',
                        rm: document.getElementById('inputRm') ? document.getElementById('inputRm').value : '',
                        curso: document.getElementById('selectCursos') ? document.getElementById('selectCursos').value : '',
                        privacidade: document.getElementById('privacidade') ? document.getElementById('privacidade').checked : false,
                        condicao: document.getElementById('condicao') ? document.getElementById('condicao').checked : false
                    }));
                });

                // Limpa os dados ao enviar o formulário
                form.addEventListener('submit', function() {
                    localStorage.removeItem('cadastro_aluno');
                });
            }
        });
    </script>
    
</body>
</html>