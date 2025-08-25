<?php 

    include "../../Banco_Dados/conexao.php";

    session_start();

    if (isset($_SESSION)) {
        $_SESSION = array();
        session_destroy();
    }

    if ($_POST) {

        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $tipo_user = $_POST['tipo_user'];

        $sql_coord = "SELECT * FROM coordenacao WHERE Email_coord = '$email' AND Senha_coord = '$senha' AND Grau = '$tipo_user'";
        $exec_coord = mysqli_query($conexao, $sql_coord);

        if (mysqli_num_rows($exec_coord) === 0) {
            header("Location: index.php?erro=nao_cadastrado");
            exit;
        } else {

            $vetor_coord = mysqli_fetch_array($exec_coord);

            $Nome_coord = $vetor_coord['Nome_coord'];
            $Codigo_Escola = $vetor_coord['Codigo_FK'];

            session_start();
            
            $_SESSION['Nome_coord'] = $Nome_coord;
            $_SESSION['Senha_coord'] = $senha;
            $_SESSION['Codigo_Escola'] = $Codigo_Escola;
            $_SESSION['Validacao_coord'] = 1;


            header("Location: telas/principal.php");
            exit;
        }

    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenadores</title>

    <link rel="stylesheet" href="style.css">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw; height: 100vh; display: flex; align-items: center;">

     <div class="primeira_div_centralizadora">
        <div class="primeira_div_centralizadora_forms">
            <form action="index.php" method="post" class="form">
                <img src="../../images/logo.png" alt="" width="100px" height="100px" style="margin: auto;">
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
                        <option value="Curso">Coordenação de Curso</option>
                        <option value="Pedag">Coordenação Pedagógica</option>
                    </select>
                </div>
                <div class="botoesForm" style="column-gap: 15px;">
                    <button type="button" id="btnRecuperarSenha" onclick="redireciona_rcpsen()">Recuperar Senha</button>
                    <button type="submit" id="btnEnviar">Entrar</button>
                </div>
                <div class="cadastro" style="width: fit-content; height: fit-content; margin: auto; font-size: 13px;">
                    <a href="cadastro_coord/cadastro_coord.php">Não possuí conta? Cadastre-se aqui!</a>
                </div>
                <?php 
                
                    if ($_GET) {

                        $erro = isset($_GET['erro']) ? $_GET['erro'] : null;
                        
                        if ($erro == 'nao_cadastrado') {
                            echo "<p style=\"color:red; text-align:center;\">Coordenador não encontrado</p>";
                        }
                    }
                ?>
            </form>
        </div>
    </div>


</body>
    <script src="interact.js"></script>
</html>