<?php 

    include "../../Banco_Dados/conexao.php";

    session_start();

    if ($_SESSION['Validacao_Aluno'] == 1) {

        $Nome_Aluno = $_SESSION['Nome_Aluno'];
        $Senha_Aluno = $_SESSION['Senha_Aluno'];

        if ($_POST) {

            $NovoNome_Aluno = $_POST['nome'];
            $NovoSenha_Aluno = $_POST['senha'];
            $Email_Aluno = $_POST['email'];
            $Nome_Social = $_POST['nome_social'];

            $sql_update = "UPDATE aluno SET Nome_Aluno = '$NovoNome_Aluno', Senha_Aluno = '$NovoSenha_Aluno', Email_Aluno = '$Email_Aluno', Nome_Social = '$Nome_Social' WHERE (Nome_Aluno = '$Nome_Aluno') AND (Senha_Aluno= '$Senha_Aluno')";

            $exec_update = mysqli_query($conexao, $sql_update);
        

            if ($exec_update) {

                $_SESSION['Nome_Aluno'] = $NovoNome_Aluno;
                $_SESSION['Senha_Aluno'] = $NovoSenha_Aluno;

                $_SESSION['msg_config'] = 'Configurações alteradas com sucesso!';
                header('Location:../Dashboard_aluno/DashBoard_Aluno.php');

                exit;
            } else {
                echo "<script>alert('Erro ao alterar as configurações!');</script>";
            }


        }

    } else {
        header("Location:../login/login.php");
        mysqli_close($conexao);
        exit;
    }







?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações</title>
    <link rel="stylesheet" href="style_config_aluno.css">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" id="barra_menu_icone_1_aluno" onclick="redirecionaDashBoardAluno()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" id="barra_menu_icone_2_aluno" onclick="redirecionaConfiguracoesAluno()">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div style="position: relative; width: 100dvw; height: fit-content; display: flex; justify-content: center;">

        <div class="primeira_div_centralizadora_forms">

            <form action="config_aluno.php" class="form" method="POST">

                <div style="font-family: 'Poppins'; font-weight: 550; font-size: 20px; width: fit-content; margin: auto">Configurações</div>

                <div>
                    <?php
                    
                        $sql_consulta = "SELECT * FROM aluno WHERE (Nome_Aluno = '$Nome_Aluno') AND (Senha_Aluno = '$Senha_Aluno')";
                        $exec_consulta = mysqli_query($conexao, $sql_consulta);

                        if ($exec_consulta) {
                            $vetor_consulta = mysqli_fetch_array($exec_consulta);
                            $Email_Aluno = $vetor_consulta['Email_Aluno'];
                            $Nome_Social = $vetor_consulta['Nome_Social'];
                        }                 
                    ?>
                    <label for="nome">
                        Nome:
                        <input type="text" name="nome" value="<?php echo $Nome_Aluno?>" required>
                    </label>
                    
                    <label for="nome_social" style="margin-bottom: 20px;">
                        Nome Social:
                        <input type="text" name="nome_social" value="<?php echo $Nome_Social;?>" required>
                    </label>

                    <label for="senha">
                        Senha:
                        <input type="password" name="senha" value="<?php echo $Senha_Aluno?>" required>
                    </label>

                    <label for="email">
                        Email:
                        <input type="email" name="email" value="<?php echo $Email_Aluno;?>" required>
                    </label>
                </div>

                <div class="botoesForm">
                    <div style="display: flex; flex-direction: row; column-gap: 15px; width: 75%; align-self: center; justify-content: space-around;">
                        <button id="btnRecuperarSenha" type="button">Recuperar Senha</button>
                        <button type="submit" id="btnEnviar" style="margin: auto;">Salvar</button>
                        <button type="button" id="btnSair" style="margin: auto; background-color: red;color: #FFFFFF;font-family: 'Poppins', Arial, Helvetica, sans-serif;border: none;height: 45px;width: 40%;border-radius: 10px;font-weight: 700;font-size: 16px;transition: background-color ease 0.2s;" 
                        onclick="redirecionaSair()">Sair</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

    <script src="../../script_geral.js"></script>
    <script>
        let btnSair = document.querySelector("#btnSair")

        function redirecionaSair(){
            window.location.href="../../Funcoes_Backend/apaga_cookie.php"
        }
    </script>

</body>