<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Edição</title>

    <link rel="shortcut icon" href="../../../images/logo.png" type="image/x-icon">

    <!--CSS-->
    <link rel="stylesheet" href="../CSS/style_central.css">
    <link rel="stylesheet" href="../../../CSS/style_admin.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>

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

    <form action="atlz_aluno.php" method="post">
        <h1>Resultado</h1>
        <div style="text-align:center; font-weight: 400;">
        <?php 

            session_start();

            if ($_SESSION['validacao_admin'] == 1) {
            
                include("../../../Banco_Dados/conexao.php");
                
                if ($_POST) {

                    $ID_curso= $_POST["curso"];
                    $Modulo = $_POST["modulo"];
                    $ID_escola = $_POST["escola"];

                    $sql_consulta = "SELECT Nome_Turma, Modulo_Turma, ID_Curso_FK, curso.Nome_Curso AS Nome_Curso FROM turma INNER JOIN curso ON turma.ID_Curso_FK = curso.ID_Curso WHERE Modulo_Turma = $Modulo AND ID_Curso_FK = '$ID_curso' AND Cod_Escola = '$ID_escola'";

                    $result_consulta = mysqli_query($conexao,$sql_consulta);

                    if ($vetor = mysqli_fetch_array($result_consulta)) {

                        $nome_turma = $vetor['Nome_Turma'];
                        $modulo_turma = $vetor['Modulo_Turma'];
                        $id_curso = $vetor['ID_Curso_FK'];
                        $nome_curso = $vetor['Nome_Curso'];?>

                        <p><?php echo "Nome da Turma: " . $nome_turma;?></p>
                        <p><?php echo "Módulo: " . $modulo_turma . "° módulo";?></p>
                        <p><?php echo "Curso: " . $nome_curso . " Chave: " . $id_curso;?></p>

                    <?php 
                    } else {
                        header("Location: edita_turma.php?erro=turma_inexistente");
                        exit;
                    }
                }
            } else {
                session_destroy();
                header("Location: ../Admin/Index.php");
                exit;
            }
         ?>
        </div>
        <br>
        
        <label for="dado_editar">Editar:</label>

        <div style="display: flex; flex-direction: row; justify-content: center; align-items: center; gap: 10px;">
            <input class="input_text" type="text" name="dado_editar">
            <select class="input_text" name="valor_editar" id="valor_editar" style="width: 40px;">
                <option value="" disabled>Selecione o dado</option>
                <option value="1">Nome da Turma</option>
                <option value="2">Módulo</option>
                <option value="3">Curso</option>
            </select>
        </div>

        <input type="hidden" name="ID_Turma" value="<?php echo $ID_Turma;?>">

        <input class="btn_enviar" type="submit" value="Enviar">
        <a href="edita_turma.php">Voltar</a>
    </form>
    
</body>
</html>