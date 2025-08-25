<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situação Aluno</title>

    <link rel="shortcut icon" href="../../../images/logo.png" type="image/x-icon">

    <!--CSS-->
    <link rel="stylesheet" href="../CSS/style_central.css">
    <link rel="stylesheet" href="../../../CSS/style_admin.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        
        body {
            font-family: 'poppins', Arial;
        }

        form a {
            text-decoration: none;
            color: black;
        }

        input {
            background-color:#D9D9D9;
            border:#D9D9D9;
            border-radius:5px;
            height: 25px;
        }

        form div {
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', Arial;
            font-style: normal;
            font-weight: 800;
        }


    </style>
</head>
<body>

    <form class="form_situacao" action="result_situacao.php" method="post">
        <h3 style="text-align: center;">Situação do Aluno</h3>
        <?php 

            session_start();

            if ($_SESSION['validacao_admin'] == 1) {

                include ("../../../Banco_Dados/conexao.php");

                if ($_POST) {
                    $RM = $_POST['RM'];

                    $sql = "SELECT * FROM aluno WHERE RM = $RM";
                    $query = mysqli_query($conexao, $sql);
                    $dados = mysqli_fetch_array($query);

                    if ($dados) {
                        $nome = $dados['Nome_Aluno'];
                        $situacao = $dados['Situacao_Aluno'];

                        echo "<p>Nome: $nome</p>";
                        echo "<p>Situação: $situacao</p>";
                    } else {
                        header("Location: situacao_aluno.php?erro=aluno_inexistente");
                        exit;
                    }
                }
            }
            else {
                session_destroy();
                header("Location:../Admin/index.php");
                exit;
            }
        ?>
        <label for="Situacao">Situação do Aluno:</label>
        <select class="input_text" name="Situacao" id="Situacao">
            <option value="Ativo">Ativo</option>
            <option value="Suspenso">Suspenso</option>
            <option value="Desistente">Desistente</option>
            <option value="Retido">Retido</option>
        </select>
        <input type="hidden" name="RM" value="<?php echo $RM;?>">
        <input class="btn_enviar" type="submit" value="Verificar" style="width:70px;">
        <a href="situacao_aluno.php">Voltar</a>
    </form>

    
</body>
</html>