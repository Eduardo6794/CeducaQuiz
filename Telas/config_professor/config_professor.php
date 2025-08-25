<?php 

    include "../../Banco_Dados/conexao.php";

    session_start();

    if ($_SESSION['Validacao_Professor'] == 1) {

        $Nome_Prof = $_SESSION['Nome_Prof'];
        $Senha_Prof = $_SESSION['Senha_Prof'];

        if ($_POST) {

            $NovoNome_Prof = $_POST['nome'];
            $NovoSenha_Prof = $_POST['senha'];
            $Email_Prof = $_POST['email'];

            $sql_update = "UPDATE professor SET Nome_Prof = '$NovoNome_Prof', Senha_Prof = '$NovoSenha_Prof', Email_Prof = '$Email_Prof' WHERE (Nome_Prof = '$Nome_Prof') AND (Senha_Prof = '$Senha_Prof')";

            $exec_update = mysqli_query($conexao, $sql_update);

            if ($exec_update) {

                $_SESSION['Nome_Prof'] = $NovoNome_Prof;
                $_SESSION['Senha_Prof'] = $NovoSenha_Prof;

        
                header('Location:../Dashboard_prof/tela_professor.php');
                echo "<script>alert('Configurações alteradas com sucesso!');</script>";

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
    <link rel="stylesheet" href="style_config_professor.css">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" id="barra_menu_icone_1_professor" onclick="redirecionaDashBoardProfessor()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" id="barra_menu_icone_2_professor" onclick="redirecionaConfiguracoesProfessor()">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div style="position: relative; width: 100dvw; height: fit-content; display: flex; justify-content: center;">

        <div class="primeira_div_centralizadora_forms">

            <form action="config_professor.php" class="form" method="POST">
                
                <div style="font-family: 'Poppins'; font-weight: 550; font-size: 20px; width: fit-content; margin: auto">Configurações</div>

                <div>
                    <?php
                    
                        $sql_consulta = "SELECT * FROM professor WHERE (Nome_Prof = '$Nome_Prof') AND (Senha_Prof = '$Senha_Prof')";
                        $exec_consulta = mysqli_query($conexao, $sql_consulta);

                        if ($exec_consulta) {
                            $vetor_consulta = mysqli_fetch_array($exec_consulta);
                            $Email_Prof = $vetor_consulta['Email_Prof'];
                        }                 
                    ?>
                    <label for="nome" style="margin-bottom: 20px;">
                        Nome:
                        <input type="text" name="nome" value="<?php echo $Nome_Prof?>" required>
                    </label>

                    <label for="senha">
                        Senha:
                        <input type="password" name="senha" value="<?php echo $Senha_Prof?>" required>
                    </label>

                    <label for="email">
                        Email:
                        <input type="text" name="email" value="<?php echo $Email_Prof?>" required>
                    </label>
                </div>

                <div class="botoesForm">
                    <div style="display: flex; flex-direction: row; column-gap: 15px; width: 100%; align-self: center; justify-content: space-around;">
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