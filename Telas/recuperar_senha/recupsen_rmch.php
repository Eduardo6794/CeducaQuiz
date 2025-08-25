<?php

session_start();

if (isset($_SESSION['red'])) {
        $red = $_SESSION['red'];
}

include('../../Banco_Dados/conexao.php');

if ($_POST) {

    $dado = $_POST['dado'];
    $tipo_dado = $_POST['tipo_dado'];

    if ($tipo_dado == 'aluno') {

        $sql = "SELECT Email_Aluno, Nome_Aluno FROM aluno WHERE RM = $dado";
        $resultado = mysqli_query($conexao, $sql);

        if ($resultado) {

            $dados = mysqli_fetch_array($resultado);

            $nome = $dados['Nome_Aluno'];
            $email = $dados['Email_Aluno'];

            if ($nome === null && $email === null) {
                header('Location: recupsen_rmch.php?erro=aluno_nao_encontrado');
                exit;
            }

            $_SESSION['Validacao_Codigo'] = 1;

            header("Location: codigo_recupsen.php?nome=$nome&email=$email");

            exit;

        }

    } else if ($tipo_dado == 'professor') {

        $sql = "SELECT Email_Prof, Nome_Prof FROM professor WHERE CodChave_Prof = $dado";
        $resultado = mysqli_query($conexao, $sql);


        if ($resultado) {

            $dados = mysqli_fetch_array($resultado);

            $nome = $dados['Nome_Prof'];
            $email = $dados['Email_Prof'];

            if ($nome === null && $email === null) {
                header('Location: recupsen_rmch.php?erro=professor_nao_encontrado');
                exit;
            }

            $_SESSION['Validacao_Codigo'] = 1;

            header("Location: codigo_recupsen.php?nome=$nome&email=$email");

            exit;


        }
    } else {
        header('Location: recupsen_rmch.php?erro=tipo_nao_encontrado');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recupera Senha por RM/CodChave</title>
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

            <form action="recupsen_rmch.php" method="post" class="form">

                <div style="font-family: 'Poppins'; font-weight: 550; font-size: 20px; width: fit-content; margin: auto">Recuperação De Senha</div>

                <div>
                    <label for="dado">
                        RM / Código Chave:
                        <input class="dado" type="text" name="dado" id="dado" placeholder="Digite ">
                    </label>
                </div>

                <div>
                    <label for="tipo_dado">
                        Tipo de Usuário
                        <select class="tipo_dado" name="tipo_dado" id="tipo_dado">
                            <option value="">Selecione</option>
                            <option value="professor">Professor</option>
                            <option value="aluno">Aluno</option>
                        </select>
                    </label>
                </div>

                <button id="btnRecuperarSenha" type="submit" value="Enviar" style="margin: auto;">Recuperar Senha</button>
                <div style="display: flex; flex-direction: row; justify-content: center; align-items: center;">
                <?php 
                    if ($_GET) {
                        $erro = $_GET['erro'];

                        if ($erro == "professor_nao_encontrado") {
                            echo "<p style='color:red; '>Professor não encontrado</p>";
                        
                        } else if ($erro == "aluno_nao_encontrado") {
                            echo "<p style='color:red'>Aluno não encontrado</p>";
                        
                        } else if ($erro == "tipo_nao_encontrado") {
                            echo "<p style='color:red'>Tipo não encontrado</p>";
                        
                        }
                    }?>
                </div>
            </form>

            

        </div>

    </div>
    
</body>
<script>
    const red = <?php echo json_encode($red ?? null); ?>;

    function retorna() {

            if (red === 'coord') {
                window.location.href = "recuperar_senha.php?red=coord";
            } else {
                window.location.href = "recuperar_senha.php"
            }
    }
</script>
</html>