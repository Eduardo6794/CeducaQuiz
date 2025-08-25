<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Professor</title>

    <link rel="shortcut icon" href="../../../images/logo.png" type="image/x-icon">


    <!--CSS-->
    <link rel="stylesheet" href="../Admin/style_geral.css">
    <link rel="stylesheet" href="../CSS/style_admin.css">
    <link rel="stylesheet" href="../CSS/style_consulta.css">
</head>
<body>
    <form action="consulta_prof.php" method="post">
        <input type="text" name="nome" id="nome" placeholder="Pesquise Aqui">
        <input type="submit" value="Enviar" id="enviar">
        <a href="../Menu_Admin.php">voltar</a>
    </form>

    <div class="professores">
            <table border="0">
                <tr style="background-color: #fff; color:#000;">
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Cod_Chave</th>
                    <th>Escola</th>
                </tr>
            

            <?php 

                session_start();

                if ($_SESSION['validacao_admin'] == 1) {
            
                    include ("../../../Banco_Dados/conexao.php");

                    if ($_POST) {
                        $nome = $_POST['nome'];

                        $sql = "SELECT Nome_Prof, Email_Prof, CodChave_Prof, escola.Nome_Escola AS Nome_Escola FROM professor INNER JOIN escola ON professor.Cod_Escola = escola.Codigo where lower(Nome_Prof) like '%$nome%'";

                        $envio_consulta = mysqli_query($conexao, $sql);

                        while ($vetor = mysqli_fetch_array($envio_consulta)) {

                            $dado1 = $vetor['Nome_Prof'];
                            $dado2 = $vetor['Email_Prof'];
                            $dado3 = $vetor['CodChave_Prof'];
                            $dado4 = $vetor['Nome_Escola'];?>

                            <tr>

                                <td><?php echo $dado1;?></td>
                                <td><?php echo $dado2;?></td>
                                <td><?php echo $dado3;?></td>
                                <td><?php echo $dado4;?></td>

                            </tr><?php
                        }

                    
                    } else {

                        $sql = "SELECT Nome_Prof, Email_Prof, CodChave_Prof, escola.Nome_Escola AS Nome_Escola FROM professor INNER JOIN escola ON professor.Cod_Escola = escola.Codigo";

                        $envio_consulta = mysqli_query($conexao, $sql);

                        while ($vetor = mysqli_fetch_array($envio_consulta)) {

                            $dado1 = $vetor['Nome_Prof'];
                            $dado2 = $vetor['Email_Prof'];
                            $dado3 = $vetor['CodChave_Prof'];
                            $dado4 = $vetor['Nome_Escola'];?>

                            <tr>

                                <td><?php echo $dado1;?></td>
                                <td><?php echo $dado2;?></td>
                                <td><?php echo $dado3;?></td>
                                <td><?php echo $dado4; ?></td>

                            </tr><?php
                        }
                    }
                } 
                else {
                    session_destroy();
                    header("Location:../Admin/index.php");
                    exit();
                }
            
            ?>
            </table>
    </div>
        
</body>
</html>