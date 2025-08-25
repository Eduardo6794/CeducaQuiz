<?php 
    include "../../Banco_Dados/conexao.php";
    session_start();

    if ($_SESSION['Validacao_Codigo'] == 1) {

        if ($_GET) {

            $email = $_GET['email'];
            $_SESSION['email'] = $email;

        }

        if ($_POST) {

            $codigo_user = $_POST['codigo'];
            $codigo_viaemail = $_SESSION['codigo'];



            if ($codigo_user == $codigo_viaemail) {

                $email = $_SESSION['email'];

                header("Location: alterar_senha.php?email=$email");
                exit;

            } else {
                echo "<script>alert('Código inválido!')</script>";
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
    <title>Código</title>
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

            <form action="inserir_codigo.php" method="post" class="form">

                <div style="font-family: 'Poppins'; font-weight: 550; font-size: 20px; width: fit-content; margin: auto">Código de Recuperação</div>

                <div>
                    <label for="codigo">
                        Código:
                        <input type="text" name="codigo" id="codigo" required>
                    </label>
                </div>

                <button id="btnRecuperarSenha" type="submit" value="Validar" style="margin: auto;">Validação</button>

            </form>

        </div>

    </div>
    
</body>
<?php include "script.php"; ?>
</html>