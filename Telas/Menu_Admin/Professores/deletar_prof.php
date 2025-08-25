<?php 

        session_start();

        if ($_SESSION['validacao_admin'] == 1) {

            // Conexão com o Banco de Dados
            include ("../../../Banco_Dados/conexao.php");

            if ($_POST) {

                $nome = $_POST['nome'];
                $cod_chave = $_POST['cod_chave'];

                        $sql_delete = "DELETE FROM professor WHERE (ID_Prof = $nome)";

                        $envio_delete = mysqli_query($conexao, $sql_delete);

                        header("Location: deletar_prof.php?erro=false");
                        exit;
                    //}
                //}
                //else {
                    //header("Location: deletar_prof.php?erro=professor_nao_encontrado");
                    //exit; 
                //}

            }
        }
        else {
            session_destroy();
            header("Location:../Admin/index.php");
            exit;
        }
    
    ?>
<!DOCTYPE html>
<html lang="Pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Professor</title>

    <link rel="shortcut icon" href="../../../images/logo.png" type="image/x-icon">

    <!--CSS-->
    <link rel="stylesheet" href="../CSS/style_central.css">
    <link rel="stylesheet" href="../../../CSS/style_admin.css">
    <link rel="stylesheet" href="../../../CSS/style_inputs_forms_button.css">

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
            width: 100%;
        }

        
    </style>
</head>
<body>

        <form action="deletar_prof.php" method="post">
            <h2>Deletar Professor</h2>
            <div>
                <label for="nome">Nome:</label>
                <select name="nome" id="nome">
                    <option value="">Selecione</option>
                    <?php 
                    
                        $sql_professor = "SELECT ID_Prof, Nome_Prof FROM professor";
                        $envio_professor = mysqli_query($conexao, $sql_professor);

                        $contador = 0;

                        while ($vetor_professor = mysqli_fetch_array($envio_professor)) {

                            $nome_prof = $vetor_professor['Nome_Prof'];
                            $ID_Prof = $vetor_professor['ID_Prof'];
                            echo "<option value='$ID_Prof'>$nome_prof</option>";
                            $contador = $contador + 1;
                        }

                        if ($contador == 0) {
                            echo "<option value=''>Sem Professor</option>";
                        }          
                    ?>
                </select>
            </div>
            <div>
                <label for="cod_chave">Código Chave:</label>
                <input type="number" name="cod_chave" id="cod_chave" placeholder="">
            </div>
            <input type="submit" value="Enviar" class="btn_enviar">
            <a href="../Menu_Admin.php">voltar</a>

            <?php 
            
                if ($_GET) {

                    $erro = $_GET['erro'];

                    if ($erro == false) {
                        echo "<p style=\"color:green;\">Professor deletado com sucesso</p>";
                    } else if ($erro == "professor_nao_encontrado") {
                        echo "<p style=\"color:red\">Professor não encontrado";
                    }
                }
            
            ?>

        </form>

        



    
</body>
</html>