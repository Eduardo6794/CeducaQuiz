<!DOCTYPE html>
<html lang="Pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../../../images/logo.png" type="image/x-icon">

    <!--CSS-->
    <link rel="stylesheet" href="../CSS/style_central.css">
    <link rel="stylesheet" href="../../../CSS/style_admin.css">
    <link rel="stylesheet" href="../../../CSS/style_inputs_forms_button.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <title>Deletar Escola</title>
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
<body><?php 
        
        include ("../../../Banco_Dados/conexao.php");

        session_start();

        if ($_SESSION['validacao_admin'] == 1) {

            if ($_POST) {
                $nome = $_POST['nome'];

                $sql_consulta = "SELECT * FROM escola WHERE Nome_Escola = '$nome'";
                $envio_consulta = mysqli_query($conexao, $sql_consulta);

                if (mysqli_num_rows($envio_consulta) == 0) {
                    header("Location: deletar_escola.php?erro=escola_nao_encontrada");
                    exit;
                }

                $sql = "DELETE FROM escola WHERE Nome_Escola = '$nome'";

                $envio_consulta = mysqli_query($conexao, $sql);

                if ($envio_consulta) {
                    header("Location: deletar_escola.php?erro=false");
                }
            }

        } else {
            session_destroy();
            header("Location:../Admin/index.php");
            exit;
        }   
    ?>
    

        <form action="deletar_escola.php" method="post">
            <h1>Deletar Escola</h1>
            <div>
                <label for="nome">Nome:</label>
                <select name="nome" id="nome">
                    <option value="">Selecione</option>
                    <?php 
                    
                        $sql_consulta = "SELECT Codigo, Nome_Escola FROM escola";
                        $envio_consulta = mysqli_query($conexao, $sql_consulta);

                        while ($linha = mysqli_fetch_array($envio_consulta)) {
                            $Codigo = $linha['Codigo'];
                            $nome_escola = $linha['Nome_Escola'];
                            
                            echo "<option value='$nome_escola'>$nome_escola</option>";
                        }
                    
                    
                    
                    ?>
                </select>
            </div>
            <?php 
                if (isset($_GET['erro'])) {
                    if ($_GET['erro'] == 'escola_nao_encontrada') {
                        echo "<p style='color:red;'>Escola não encontrada!</p>";
                    } elseif ($_GET['erro'] == 'false') {
                        echo "<p style='color:green;'>Escola deletada com sucesso!</p>";
                    }
                }
            ?>
            <input type="submit" value="Enviar" class="btn_enviar">
            <a href="../Menu_Admin.php">voltar</a>
        </form>  
</body>
</html>