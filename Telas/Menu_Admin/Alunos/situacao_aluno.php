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
        }


    </style>
</head>
<body>

    <form class="form_situacao" action="verifsit_aluno.php" method="post">
        <h2>Situação Aluno</h2>
        <label for="RM">RM do Aluno:</label>
        <input class="input_text" type="text" id="RM" name="RM">
        <?php 
        
            if ($_GET) {
                $erro = $_GET['erro'];
                if ($erro == 'aluno_inexistente') {
                    echo "<p style='color: red; text-align:center;'>Aluno não encontrado.</p>";
                }
            }
        
        ?>
        <input class="btn_enviar" type="submit" value="Verificar" style="width:70px;">
        <a href="../Menu_Admin.php">Voltar</a>
    </form>

    
</body>
</html>