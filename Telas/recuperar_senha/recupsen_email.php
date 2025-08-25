<?php 

    include('../../Banco_Dados/conexao.php');

    session_start();

    $_SESSION['Validacao_Codigo'] = 0;

    if ($_POST) {

        $email = $_POST['email'];

            $sql = "SELECT * FROM professor WHERE Email_Prof = '$email'";
            $resultado = mysqli_query($conexao, $sql);

            if ($resultado && mysqli_num_rows($resultado) > 0) {

                $dados = mysqli_fetch_array($resultado);
                $nome = $dados['Nome_Prof'];

                $_SESSION['Validacao_Codigo'] = 1;

        
                header("Location: codigo_recupsen.php?nome=$nome&email=$email");

                exit;

            } else if ($resultado && mysqli_num_rows($resultado) == 0) {

                $sql = "SELECT * FROM aluno WHERE Email_Aluno = '$email'";
                $resultado = mysqli_query($conexao, $sql);

                if ($resultado && mysqli_num_rows($resultado) > 0) {

                    $dados = mysqli_fetch_array($resultado);
                    $nome = $dados['Nome_Aluno'];

                    $_SESSION['Validacao_Codigo'] = 1;

                    header("Location: codigo_recupsen.php?nome=$nome&email=$email");

                    exit;

                } else if ($resultado && mysqli_num_rows($resultado) == 0) {

                    $sql = "SELECT * FROM coordenacao WHERE Email_coord = '$email'";
                    $resultado = mysqli_query($conexao, $sql);

                    if ($resultado && mysqli_num_rows($resultado) > 0) {

                        $dados = mysqli_fetch_array($resultado);
                        $nome = $dados['Nome_coord'];

                        $_SESSION['Validacao_Codigo'] = 1;

                        header("Location: codigo_recupsen.php?nome=$nome&email=$email");

                        exit;

                    } else {
                        echo "<script>alert('Email não encontrado!');</script>";
                    }
                }

            }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recupera Senha por Email</title>
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

            <form action="recupsen_email.php" method="post" class="form">

                <div style="font-family: 'Poppins'; font-weight: 550; font-size: 20px; width: fit-content; margin: auto">Recuperação De Senha</div>

                <div>
                    <label for="email">
                        Email:
                        <input type="email" name="email" id="email" placeholder="Digite seu email">
                    </label>
                </div>

                <button id="btnRecuperarSenha" type="submit" value="Enviar" style="margin: auto;">Recuperar Senha</button>

            </form>

        </div>

    </div>
    
</body>
<script>
    if (!sessionStorage.getItem('pageReloaded')) {
        sessionStorage.setItem('pageReloaded', 'true');
        window.location.reload();
    }
</script>
<?php include "script.php"; ?>
</html>