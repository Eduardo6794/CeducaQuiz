<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar curso a escola</title>

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

        form select {
            width: 100%;
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
    <form action="escola_curso.php" method="post">
        <h2 style="text-align: center;">Adicione a escola do curso</h2>

        <Label for="curso">Curso:</Label>
        <select name="curso" id="curso">
            <option value="">Selecione</option>
            
            <?php
                session_start();
                include("../../../Banco_Dados/conexao.php");

                $consulta = "SELECT * FROM curso";
                $envio_consulta = mysqli_query($conexao, $consulta);

                while ($cursos = mysqli_fetch_array($envio_consulta)) {
                    echo "<option value='" . $cursos['ID_Curso'] . "'>" . $cursos['Nome_Curso'] . "</option>";
                }
            ?>
        </select>

        <Label for="escola">Escola:</Label>
        <select name="escola" id="escola">
            <option value="">Selecione</option>            
            <?php

                $consulta_escola = "SELECT * FROM escola";
                $exec_escola = mysqli_query($conexao, $consulta_escola);

                while ($escolas = mysqli_fetch_array($exec_escola)) {
                    echo "<option value='" . $escolas['Codigo'] . "'>" . $escolas['Nome_Escola'] . "</option>";
                }
            ?>
        </select>
        <?php 
        
            if (isset($_GET['erro'])) {
                if ($_GET['erro'] == 'curso_adicionado') {
                    echo "<p style='color:green;'>Curso adicionado a escola com sucesso!</p>";
                } elseif ($_GET['erro'] == 'curso_ja_existe') {
                    echo "<p style='color:red;'>Curso já existe na escola</p>";
                }
            }
        ?>
        <input type="submit" value="Enviar" class="btn_enviar">
        <a href="../Menu_Admin.php">Voltar</a>
    </form>
</body>

    <?php
        if ($_SESSION['validacao_admin'] == 1) {

            if ($_POST) {

                $ID_curso = $_POST['curso'];
                $ID_escola = $_POST['escola'];

                $consulta = "SELECT * FROM escola_curso where Codigo_FK = '$ID_escola' AND Curso_FK = '$ID_curso'";  

                $envio_consulta = mysqli_query($conexao, $consulta);

                if (mysqli_num_rows($envio_consulta) > 0) {
                        
                    header("Location: escola_curso.php?erro=curso_ja_existe");

                } else {
                        
                    $inserir = "INSERT INTO escola_curso (Codigo_FK, Curso_FK) values ('$ID_escola', '$ID_curso')";

                    $result = mysqli_query($conexao, $inserir);
                    
                    if ($result) {
                        header("Location: escola_curso.php?cadastrado=curso_adicionado");
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