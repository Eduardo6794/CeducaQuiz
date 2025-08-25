<?php 

    include '../../Banco_Dados/conexao.php';

    session_start();

    $email = $_SESSION['email'];

    $dados_incorretos = false;

    if ($_SESSION['Validacao_Codigo'] == 1) {

        if ($_POST) {

            $senha = $_POST['senha'];
            $confirmar_senha = $_POST['confirmar_senha'];

            if ($senha == $confirmar_senha) {

                $sql = "SELECT * FROM professor WHERE Email_Prof = '$email'";
                $resultado = mysqli_query($conexao, $sql);

                if ($resultado && mysqli_num_rows($resultado) > 0) {

                    $dados = mysqli_fetch_array($resultado);

                    $sql = "UPDATE professor SET Senha_Prof = '$senha' WHERE Email_Prof = '$email'";

                    $result_sql = mysqli_query($conexao, $sql);

                    if ($result_sql) {
                        $_SESSION['Validacao_Codigo'] = 0;
                        mysqli_close($conexao);
                        header('Location: ../login/login.php');
                        exit;

                    } else {
                        echo "Erro ao alterar a senha: " . $conexao->error;

                        $dados_incorretos = true;
                    }

                } else if ($resultado && mysqli_num_rows($resultado) == 0) {

                    $sql = "SELECT * FROM aluno WHERE Email_Aluno = '$email'";
                    $resultado = mysqli_query($conexao, $sql);

                    if ($resultado && mysqli_num_rows($resultado) > 0) {

                        $sql = "UPDATE aluno SET Senha_Aluno = '$senha' WHERE Email_Aluno = '$email'";

                        $result_sql = mysqli_query($conexao, $sql);
        
                        if ($result_sql) {
                            $_SESSION['Validacao_Codigo'] = 0;
                            mysqli_close($conexao);
                            header('Location: ../login/login.php');
                            exit;
    
                        } else {
                            echo "Erro ao alterar a senha: " . $conexao->error;
    
                            $dados_incorretos = true;
                        }

                    } else {
                        echo "<script>alert('Email não encontrado!');</script>";
                    }

                }

            } else {
                $dados_incorretos = true;
            }
        }

    } else {
        header('Location: ../recuperar_senha/recuperar_senha.php');
        exit;
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Altera Senha</title>
    <link rel="stylesheet" href="style_recuperar_senha.css">
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">
    
    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" id="barra_menu_icone_1_professor" onclick="retorna()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" id="barra_menu_icone_2_professor">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div style="position: relative; width: 100dvw; height: fit-content; display: flex; justify-content: center;">

        <div class="primeira_div_centralizadora_forms">

            <form action="alterar_senha.php" method="post" class="form">

                <div style="font-family: 'Poppins'; font-weight: 550; font-size: 20px; width: fit-content; margin: auto">Alterar Senha</div>

                <div>
                    <label for="senha">
                        Nova senha:
                        <input type="password" name="senha" id="senha" required>
                    </label>
                    <label for="confirmar_senha">
                        Confirme a nova senha:
                        <input type="password" name="confirmar_senha" id="confirmar_senha" required>
                    </label>
                </div>

                <button id="btnRecuperarSenha" type="submit" value="Validar" style="margin: auto;">Alterar</button>

                <?php if ($dados_incorretos) { ?>
                    <p style="color: red;">As senhas não coincidem ou houve um erro ao alterar a senha.</p>
                <?php } ?>
            </form>

        </div>

    </div>
    
</body>
<?php include "script.php"; ?>
</html>


