<?php 
    include ("../../Funcoes_Backend/Add_CodChave.php");
    include("../../Funcoes_Backend/Cadastro_Prof.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Professor</title>
    <link rel="stylesheet" href="style_cadastro_professor.css">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="retorna()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div style="display: block; width: 100%; position: relative; height: fit-content; z-index: 1;">
        <div class="primeira_div_centralizadora_forms">
            <form action="../cadastro_professor/cadastro_professor.php" method="post" class="form">
                <div>
                    <label for="nome_aluno">
                        Nome Completo
                        <input type="text" id="nome_aluno" name="nome" required>
                    </label>
                    <label for="Senha">
                        Senha
                        <input type="password" id="Senha" name="senha" required>
                    </label>
                    <label for="codigo_chave" style="margin-top: 20px;">
                        <div style="display: flex; column-gap: 8px;">
                            Código Chave
                            <img src="../../icons/icone_info.png" alt="" style=" height: 15px; align-self: center;" required>
                        </div>
                        <div style="display: grid; grid-template-columns: 80% 1fr;">
                            <input type="number" style="height: 27px;" value="<?php echo $chave_pronta;?>" id="codigo_chave" name="cod_chave" required>
                            <img src="../../icons/icone_aleatorio.png" alt="" style="object-fit: contain; margin: auto;">
                        </div>
                    </label>
                    <div style="display:flex; flex-direction: row; justify-content:space-between;">
                        <label for="email" >
                            Email
                            <input type="email" id="email" name="email" required>
                        </label>
                        <label for="ce">
                            C.E.
                            <input type="number" id="ce" name="chave_escola" style="width:60px;" required>
                        </label>
                    </div>
                </div>

                <div class="botoesForm">
                    <div style="display: flex; flex-direction: row; column-gap: 15px; width: 75%; align-self: center; justify-content: space-around;">
                        <button id="btnRecuperarSenha" type="button">Recuperar Senha</button>
                        <button id="btnEnviar" type="submit">ENVIAR</button>
                    </div>
                </div>

                <p style="margin: auto; color: red;">
                    <?php 
                        if($_GET) {

                            $erro = $_GET['erro'];
                            //Mensagens de erro podem ser exibidas aqui
                            if ($erro == 'chave_professor_existente') {
                                echo "Já existe um professor cadastrado com essa chave!";
                            }
                            else if ($erro == 'chave_invalida') {
                                echo "A chave deve ser um número inteiro!";
                            }
                            else if ($erro == 'escola_inexistente') {
                                echo "Escola não foi encontrada";
                            }
                        }   
                    ?>
                </p>

            </form>

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
    
    <script src="../../script_geral.js"></script>
    <script>
        function retorna() {
            window.location.href = "../redirecionamento_de_cadastro/redirecionamento_de_cadastro.html";
        }
    </script>
    
</body>
</html>