<?php
    // Sempre inicie a sessão antes de qualquer saída!
    session_start();

    //Inclusão do Banco de Dados
    include("../../Banco_Dados/conexao.php");

    // Limpa a sessão se existir
    if (!empty($_SESSION)) {
        $_SESSION = array();
        session_destroy();
        session_start(); // Reinicia a sessão para uso posterior
    }

    // Verifica cookies
    if (isset($_COOKIE['cookiesAceitos'])) {

        if (isset($_COOKIE['Validacao_Professor'])) {
            $_SESSION["Nome_Prof"] = $_COOKIE['Nome_Prof'] ?? '';
            $_SESSION["Senha_Prof"] = $_COOKIE['Senha_Prof'] ?? '';
            $_SESSION["Validacao_Professor"] = $_COOKIE['Validacao_Professor'];

            if ($_SESSION["Validacao_Professor"] == 1) {
                header("Location: ../Dashboard_prof/tela_professor.php");
                exit;
            }

        } else if (isset($_COOKIE['Validacao_Aluno'])) {
            $_SESSION["Nome_Aluno"] = $_COOKIE['Nome_Aluno'] ?? '';
            $_SESSION["Senha_Aluno"] = $_COOKIE['Senha_Aluno'] ?? '';
            $_SESSION["Validacao_Aluno"] = $_COOKIE['Validacao_Aluno'];

            if ($_SESSION["Validacao_Aluno"] == 1) {
                $ID_Quiz = isset($_GET['ID_Quiz']) ? $_GET['ID_Quiz'] : null;
                if ($ID_Quiz != null) {
                    header("Location: ../Quiz/Template/Quiz_Aluno.php?ID_Quiz=".$ID_Quiz);
                    exit;
                } else {
                    header("Location: ../Dashboard_aluno/DashBoard_Aluno.php");
                    exit;
                }
            }
        }
    }

    //Verifica se foi enviado os dados no form
    if ($_POST) {

        //Dados
        $email = $_POST["email"] ?? '';
        $senha = $_POST["senha"] ?? '';
        $tipo_user = $_POST["tipo_user"] ?? '';
        $ID_Quiz = $_POST["ID_Quiz"] ?? null;

        //verifica se o usuario é professor ou aluno
        if ($tipo_user == "professor") {

            $sql_consulta = "SELECT * FROM professor WHERE (Email_Prof = '$email') AND (Senha_Prof = '$senha')";

            $exec_consulta = mysqli_query($conexao, $sql_consulta);

            if (mysqli_num_rows($exec_consulta) > 0) {

                $vetor_prof = mysqli_fetch_array($exec_consulta);
                $nome = $vetor_prof['Nome_Prof'];

                if (isset($_COOKIE['cookiesAceitos']) && $_COOKIE['cookiesAceitos'] === 'true') {
                    setcookie('Nome_Prof', $nome, time() + (86400 * 30), "/");
                    setcookie('Senha_Prof', $senha, time() + (86400 * 30), "/");
                    setcookie('Validacao_Professor', 1, time() + (86400 * 30), "/");
                }
                $_SESSION["Nome_Prof"] = $nome;
                $_SESSION["Senha_Prof"] = $senha;
                $_SESSION["Validacao_Professor"] = 1;

                header("Location: ../Dashboard_prof/tela_professor.php");
                exit;
            }
            else {
                header("Location: login.php?erro=professor_nao_encontrado");
                exit;
            }
        }

        else if ($tipo_user == "aluno") {

            $sql_consulta = "SELECT * FROM aluno WHERE (Email_Aluno = '$email') AND (Senha_Aluno = '$senha')";

            $exec_consulta = mysqli_query($conexao, $sql_consulta);

            if (mysqli_num_rows($exec_consulta) > 0) {

                $sql_situa = "SELECT * FROM aluno WHERE (Email_Aluno = '$email') AND (Senha_Aluno = '$senha') AND (Situacao_Aluno = 'Ativo')";
                $verif_consulta  = mysqli_query($conexao, $sql_situa);

                if (mysqli_num_rows($verif_consulta) == 0) {
                    header("Location: login.php?erro=aluno_nao_ativo");
                    exit;
                } else {
                    
                    $vetor_aluno = mysqli_fetch_array($exec_consulta);
                    $nome = $vetor_aluno['Nome_Aluno'];

                    if (isset($_COOKIE['cookiesAceitos']) && $_COOKIE['cookiesAceitos'] === 'true') {
                        setcookie('Nome_Aluno', $nome, time() + (86400 * 30), "/");
                        setcookie('Senha_Aluno', $senha, time() + (86400 * 30), "/");
                        setcookie('Validacao_Aluno', 1, time() + (86400 * 30), "/");
                    }
                    $_SESSION["Nome_Aluno"] = $nome;
                    $_SESSION["Senha_Aluno"] = $senha;
                    $_SESSION["Validacao_Aluno"] = 1;

                    if ($ID_Quiz != null) {
                        header("Location: ../Quiz/Template/Quiz_Aluno.php?ID_Quiz=".$ID_Quiz);
                        exit;
                    } else {
                        header("Location: ../Dashboard_aluno/DashBoard_Aluno.php");
                        exit;
                    } 
                }  

            }
            else {
                if ($ID_Quiz != null) {
                    header("Location: login.php?ID_Quiz=".$ID_Quiz."&erro=aluno_nao_encontrado");
                } else {
                    header("Location: login.php?erro=aluno_nao_encontrado");
                    exit;
                }
            }

        } else {
            if ($ID_Quiz != null) {
                header("Location: login.php?ID_Quiz=".$ID_Quiz."&erro=aluno_nao_encontrado");
            } else {
                header("Location: login.php?erro=tipos_dados_incorretos");
                exit;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style_login.css">

    <link rel="shortcut icon" href="../../asssets/logo.png" type="image/x-icon">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw; height: 100vh;">
    
    <div class="barra_menu" style="grid-template-columns: 7fr;">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" style="display: none;">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo" onclick="volta_principal()" style="cursor: pointer;">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" style="display: none;">
    </div>
    
    <div class="espacamento_pos_menu"></div>
    
    <div class="primeira_div_centralizadora">
        <div class="primeira_div_centralizadora_forms">
            <form action="login.php" method="post" class="form">
                <div>                
                    <label for="email">
                        Email
                        <input type="text" name="email" required>
                    </label>
                    <label for="Senha">
                        Senha
                        <input type="password" name="senha" required>
                    </label>
                    <select name="tipo_user" id="tipo" class="tipo_user" style="margin-top: 10px; width: 100px;">
                        <option value="">Selecione</option>
                        <option value="professor">Professor</option>
                        <option value="aluno">Aluno</option>
                    </select>
                </div>
                <div class="botoesForm" style="column-gap: 15px;">
                    <button type="button" id="btnRecuperarSenha">Recuperar Senha</button>
                    <button type="submit" id="btnEnviar">Entrar</button>
                </div>
                <div style="width: fit-content; height: fit-content; margin: auto; font-size: 13px;">
                    <a href="../redirecionamento_de_cadastro/redirecionamento_de_cadastro.html">Não possuí conta? Cadastre-se aqui!</a>
                </div>
                <?php 
                
                    if ($_GET) {

                        $erro = isset($_GET['erro']) ? $_GET['erro'] : null;
                        $ID_Quiz = isset($_GET['ID_Quiz']) ? $_GET['ID_Quiz'] : null;

                        if ($ID_Quiz != null) { 
                            
                            ?>
                            <input type="hidden" name="ID_Quiz" value="<?php echo $ID_Quiz;?>">
                        <?php }
                        
                        if ($erro == 'professor_nao_encontrado') {
                            echo "<p style=\"color:red; text-align:center;\">Professor Não encontrado</p>";
                        } 
                        else if ($erro == 'aluno_nao_encontrado') {
                            echo "<p style=\"color:red; text-align:center;\">Aluno Não encontrado</p>";
                        } 
                        else if ($erro == 'tipos_dados_incorretos') {
                            echo "<p style=\"color:red; text-align:center;\">Tipos de Dados não inseridos corretamente</p>";
                        } else if ($erro == 'turma_quiz_imcompativel'){

                            echo "<p style=\"color:red; text-align:center;\">Turma Incompatível com o Quiz</p>";

                        } else if ($erro == 'aluno_nao_ativo') {
                            echo "<p style=\"color:red; text-align:center;\">Aluno não está mais ativo</p>";
                        } else if ($erro == 'escola_imcompativel') {
                            echo "<p style=\"color:red; text-align:center;\">Escola não compatível com o quiz</p>";
                        }
                    }
                ?>
            </form>
        </div>
        
    </div>
    
    <script src="../../script_geral.js"></script>

    <script>
        
        function volta_principal() {
            window.location.href = '../principal/index.php';
        }
    </script>
    
</body>
</html>