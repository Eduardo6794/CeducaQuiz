<?php 

    session_start();


    if ($_SESSION['validacao_admin'] == 1) {


    } else {
        session_destroy();
        header("Location:../Admin/index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição Alunos</title>
    <link rel="shortcut icon" href="../../../images/logo.png" type="image/x-icon">

    <!--CSS-->
    <link rel="stylesheet" href="../CSS/style_central.css">
    <link rel="stylesheet" href="../../../CSS/style_admin.css">
    <link rel="stylesheet" href="../../../css/style_inputs_forms_button.css">

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

        form div {
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', Arial;
            font-style: normal;
            font-weight: 800;
            width: 100%;
        }
    </style>
</head>
<body>
    <form action="resultedit_turma.php" method="post">
        <h1 style="text-align: center;">Edição de Turmas</h1>
            <div>
                <label for="curso">Nome do Curso:</label>
                    <?php 

                        include "../../../Banco_Dados/conexao.php";
                    
                        include "../../../Funcoes_Backend/Consulta_Curso.php";

                    ?>
            </div>
            <div>
                <label for="modulo">Modulo:</label>
                <select name="modulo" id="modulo">
                    <option value="">Selecione</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div>
                <label for="escola">Escola:</label>
                <select name="escola" id="escola">
                    <option value="">Selecione</option>
                    <?php 
                    
                        $sql_escola = "SELECT Codigo, Nome_Escola FROM escola";
                        $exec_escola = mysqli_query($conexao, $sql_escola);

                        while ($vetor_escola = mysqli_fetch_array($exec_escola)) {

                            $dado1 = $vetor_escola['Codigo'];
                            $dado2 = $vetor_escola['Nome_Escola']; ?>

                            <option value="<?php echo $dado1; ?>"><?php echo $dado2; ?></option>




                        <?php }      
                    ?>
                </select>
            </div>
            <div>
                <?php 
        
                if ($_GET) {

                    $erro = $_GET['erro'];

                    if ($erro == "turma_inexistente") {
                        echo "<p style='color: red; text-align:center;'>Turma não encontrada!</p>";
                    }
                }
                ?>
            </div>
            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 10px;">
                <input class="btn_enviar" type="submit" value="Editar"></input>
                <a href="../Menu_Admin.php">Voltar</a>
            </div>       
    </form>
    
</body>
</html>