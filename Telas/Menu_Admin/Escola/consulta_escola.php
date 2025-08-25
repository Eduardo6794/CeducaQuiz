<!DOCTYPE html>
<html lang="Pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Escolas</title>

    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">


    <!--CSS-->
    <link rel="stylesheet" href="../../Admin/style_geral.css">
    <link rel="stylesheet" href="../CSS/style_admin.css">
    <link rel="stylesheet" href="../CSS/style_consulta.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<style>
    body {
        font-family: 'poppins', Arial;
    }
</style>
<body>

        <form action="consulta_escola.php" method="post">
            <input type="text" name="nome" id="nome" placeholder="Pesquise Aqui">
            <input type="submit" value="Enviar" id="enviar" class="btn_enviar">
            <a href="../Menu_Admin.php">voltar</a>
        </form>

        <div class="cursos">
            <table border="0">
                <tr style="background-color: #fff; color:#000;">
                    <th style="font-size:25px;">Nome</th>
                    <th style="font-size:25px;">Cidade</th>
                </tr>
                
        
        <?php 

            session_start();

            if ($_SESSION['validacao_admin'] == 1) {

                // Conexão com o banco de dados
                include ("../../../Banco_Dados/conexao.php");

                if ($_POST) {
                    $nome = $_POST['nome'];

                    $sql = "SELECT * FROM escola where  lower(Nome_Escola) like '%$nome%' ORDER BY Nome_Escola ASC";

                    $envio_consulta = mysqli_query($conexao, $sql);

                    while ($vetor = mysqli_fetch_array($envio_consulta)) {

                        $dado1 = $vetor['Nome_Escola'];
                        $dado2 = $vetor['Cidade'];?>

                        <tr>

                            <td><?php echo $dado1;?></td>
                            <td><?php echo $dado2;?></td>

                        </tr><?php
                    }

                
                } else {

                    $sql = "SELECT * FROM escola ORDER BY Nome_Escola ASC";

                    $envio_consulta = mysqli_query($conexao, $sql);

                    while ($vetor = mysqli_fetch_array($envio_consulta)) {

                        $dado1 = $vetor['Nome_Escola'];
                        $dado2 = $vetor['Cidade'];?>

                        <tr>

                            <td><?php echo $dado1;?></td>
                            <td><?php echo $dado2;?></td>

                        </tr><?php
                    }
                }
            } else {
                session_destroy();
                header("Location:../Admin/index.php");
                exit;
            }
        
        ?>
            </table>
        </div>  
</body>
</html>