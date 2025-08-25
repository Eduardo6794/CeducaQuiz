<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Escola</title>

    <link rel="stylesheet" href="../CSS/style_central.css">
    <link rel="stylesheet" href="../../../CSS/style_admin.css">

    <link rel="shortcut icon" href="../../../../images/logo.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>

        body {
            font-family: 'Poppins', Arial;
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

    
    </style>
</head>
<body>
    <form action="add_escola.php" method="post">
        <h2>Adicione a Escola</h2>

        <label for="ce">Código da Escola:</label>
        <input type="number" id="ce" name="ce" required>

        <label for="escola">Nome da Escola:</label>
        <input type="text" id="escola" name="escola" required>

        <Label for="cidade">Cidade:</Label>
        <input type="text" name="cidade" id="cidade" required>
        <?php 
        
            if (isset($_GET['cadastrado'])) {
                if ($_GET['cadastrado'] == 'escola_adicionada') {
                    echo "<p style='color:green; text-align:center;'>Escola adicionado com sucesso!</p>";
                } elseif ($_GET['cadastrado'] == 'escola_ja_existe') {
                    echo "<p style='color:red; text-align:center;'>Escola já existe!</p>";
                }
            }
        
        
        ?>
        <input type="submit" value="Enviar" class="btn_enviar">
        <a href="../Menu_Admin.php">Voltar</a>
        
    </form>
</body>

    <?php

        session_start();

        if ($_SESSION['validacao_admin'] == 1) {

            include("../../../Banco_Dados/conexao.php");   

            if ($_POST) {

                $escola = $_POST['escola'];
                $cidade = $_POST['cidade'];
                $codigo_escola = $_POST['ce'];

                $consulta = "SELECT * FROM escola where Nome_Escola = '$escola' AND Cidade = '$cidade' AND Codigo = $codigo_escola";

                $envio_consulta = mysqli_query($conexao, $consulta);

                if (mysqli_num_rows($envio_consulta) > 0) {
                        
                    header("Location: add_escola.php?cadastrado=escola_ja_existe");

                } else {
                        
                    $inserir = "INSERT INTO escola (Codigo, Nome_Escola, Cidade) values ($codigo_escola, '$escola', '$cidade')";

                    $result = mysqli_query($conexao, $inserir);
                    
                    if ($result) {
                        header("Location: add_escola.php?cadastrado=escola_adicionada");
                    }
                }
            }
        } 
        else {
            session_destroy();
            header("Location: ../../Admin/Index.php");
            exit;
        }


    ?>
</html>