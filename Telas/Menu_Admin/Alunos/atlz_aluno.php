<?php 

    session_start();

    if ($_SESSION['validacao_admin'] == 1) {

        include("../../Banco_Dados/conexao.php");

        if ($_POST) {

            $dado_editar = $_POST['dado_editar'];
            $valor_editar = $_POST['valor_editar'];
            $ID_Turma = $_POST['ID_Turma'];

            if ($valor_editar == '1') {

                $sql_update = "UPDATE turma SET Nome_Turma = '$dado_editar' WHERE ID_Turma = $ID_Turma";
                $result_update = mysqli_query($conexao,$sql_update);

                if ($result_update) {

                    header("Location: ../Menu_Admin/edita_turma.php");

                } else {

                    $erro_atlz = True;

                }

            } elseif ($valor_editar == '2') {

                $sql_update = "UPDATE turma SET Modulo_Turma = '$dado_editar' WHERE ID_Turma = $ID_Turma";

                $result_update = mysqli_query($conexao,$sql_update);

                if ($result_update) {

                    header("Location: ../Menu_Admin/edita_turma.php");

                } else {

                    $erro_atlz = True;

                }

            } elseif ($valor_editar == '3') {

                $sql_consulta  = "SELECT ID_Curso FROM curso where lower(Nome_Curso) LIKE '%$dado_editar%'";
                $result_consulta = mysqli_query($conexao,$sql_consulta);
                $vetor = mysqli_fetch_array($result_consulta);
                $id_curso = $vetor['ID_Curso'];

                echo $ID_Turma;

                $sql_update = "UPDATE turma SET ID_Curso_FK = $id_curso WHERE ID_Turma = $ID_Turma";
                $result_update = mysqli_query($conexao,$sql_update);

                if ($result_update) {
                    
                    header("Location: ../Menu_Admin/edita_turma.php");
        
                } else {
        
                    $erro_atlz = True;
        
                }
            }

        } else {
            $erro_envio = True;
        }
    } else {
        session_destroy();
        header("Location:../Admin/Index.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação</title>

    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">

    <!--CSS-->
    <link rel="stylesheet" href="../Menu_Admin/style_central.css">
    <link rel="stylesheet" href="../../CSS/style_admin.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        .alert {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color:var (--cor_fundo_form);
            color: red;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php 
    
        if($erro_envio){
            echo "<div class=\"alert\">";
            echo "<strong>Erro!</strong> Formulário não enviado.";
            echo mysqli_error($conexao);
            echo "</div>";
        }
        if($erro_atlz){
            echo "<div class=\"alert\">";
            echo "<strong>Erro!</strong> Atualização não realizada.";
            echo mysqli_error($conexao);
            echo "</div>";
        }
    
    ?>
    
</body>
</html>