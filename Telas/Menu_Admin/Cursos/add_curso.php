<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Cursos</title>

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
    <form action="add_curso.php" method="post">
        <h2>Adicione o Curso</h2>
        <label for="nome">Nome do Curso:</label>
        <input type="text" id="nome" name="nome" required>
        <Label for="periodo">Módulo</Label>
        <select name="periodo" id="periodo">
            <option value="N">Não</option>
            <option value="S">Sim</option>
        </select>
        <?php 
        
            if (isset($_GET['cadastrado'])) {
                if ($_GET['cadastrado'] == 'curso_adicionado') {
                    echo "<p style='color:green;'>Curso adicionado com sucesso!</p>";
                } elseif ($_GET['cadastrado'] == 'curso_ja_existe') {
                    echo "<p style='color:red;'>Curso já existe!</p>";
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

                $nome = $_POST['nome'];
                $periodo = $_POST['periodo'];

                $consulta = "SELECT * FROM curso where Nome_Curso = '$nome'";

                $envio_consulta = mysqli_query($conexao, $consulta);

                if (mysqli_num_rows($envio_consulta) > 0) {
                        
                    header("Location: add_curso.php?cadastrado=curso_ja_existe");

                } else {
                        
                    $inserir = "INSERT INTO curso (Nome_Curso, Meio_Periodo) values ('$nome', '$periodo')";

                    $result = mysqli_query($conexao, $inserir);
                    
                    if ($result) {
                        header("Location: add_curso.php?cadastrado=curso_adicionado");
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