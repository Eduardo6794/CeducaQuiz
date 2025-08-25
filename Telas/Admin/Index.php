<?php 
    //Conexão Banco de Dados
    include("../../Banco_Dados/conexao.php");

    //Abre a Sessão (Vetor Associativo na Memória)
    session_start();

    //Ao user entrar na página zerar a validação
    $_SESSION['validacao_admin'] = 0;

    //Dados Verdadeiros como padrão
    $dados_incorretos = false;

    //Verifica se o user enviou os dados
    if($_POST) {
        //Dados enviados do user
        $nome_admin = trim($_POST['nome']);
        $senha_admin = trim($_POST['senha']);

        //Procura o user
        $code_sql = "SELECT * FROM admin WHERE (Nome_Admin = '$nome_admin') and (Senha_Admin = '$senha_admin')";
        //Executa o comando SQL
        $consulta = mysqli_query($conexao, $code_sql);

        //Caso o admin já esteja cadastrado
        if(mysqli_num_rows($consulta) > 0) {

                $_SESSION['nome_admin'] = $nome_admin;
                $_SESSION['senha_admin'] = $senha_admin;
                $_SESSION['validacao_admin'] = 1;
                header("Location: ../Menu_Admin/Menu_Admin.php");
        }
        else {
            $dados_incorretos = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <!--Icone-->
    <link rel="shortcut icon" href="../../asssets/logo.png" type="image/x-icon">
    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="../../CSS/style_admin.css">
    <link rel="stylesheet" type="text/css" href="../Admin/style.css">
</head>
<body>
    <!--Formulário-->
    <form class="formulario" method="post" action="Index.php">
        <h2>Administrador</h2>
        <!--Nome-->
        <div class="subform">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" class="input_text">
        </div>
        <div class="subform">
            <!--Senha-->
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" class="input_text">
        </div>
        <!--Botão Logar-->
        <input class="btn_enviar" id="btn_enviar" type="submit" value="Logar" onclick="btn_enviar()">
        <div class="btn_enviar_actived"></div>

        <?php if($dados_incorretos === true) {?>
            <p style="color: red; margin-top: 10px;" class="validacao">Dados Incorretos!</p>
        <?php } ?>
        
    </form>
    <!--JS-->
    <script src="interact.js" type="text/javascript"></script>
</html>
</body>
</html>
