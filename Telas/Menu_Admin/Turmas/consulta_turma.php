<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Turmas</title>

    <link rel="shortcut icon" href="../../../images/logo.png" type="image/x-icon">

    
    <!--CSS-->
    <link rel="stylesheet" href="../../Admin/style_geral.css">
    <link rel="stylesheet" href="../../Menu_Admin/CSS/style_admin.css">
    <link rel="stylesheet" href="../../Menu_Admin/CSS/style_consulta.css">
    <link rel="stylesheet" href="../../../CSS/style_inputs_forms_button.css">
</head>
<body>

        <form action="consulta_turma.php" method="post">
            <input type="text" name="nome" id="nome" placeholder="Pesquise Aqui">
            <select name="tipo_dado" id="tipo_dado">
                <option value="">Selecione</option>
                <option value="turma">Nome Turma</option>
                <option value="curso">Nome Curso</option>
                <option value="escola">Escola</option>
            </select>
            <input type="submit" value="Enviar" id="enviar">
            <a href="../Menu_Admin.php">voltar</a>
        </form>
        <div class="turmas">
            <table border="0">
                <tr style="background-color: #fff; color:#000;">
                    <th>Nome</th>
                    <th>Modulo</th>
                    <th>Curso</th>
                    <th>Escola</th>
                </tr>
            

            <?php 

                session_start();

                if ($_SESSION['validacao_admin'] == 1) {
            
                    include ("../../../Banco_Dados/conexao.php");

                    if ($_POST) {

                        $tipo_dado = isset($_POST['tipo_dado']) ? $_POST['tipo_dado'] : null;
                        $nome = $_POST['nome'];

                        if ($tipo_dado == 'turma') {
                            $busca_sql = "Nome_Turma";
                        } else if ($tipo_dado == 'curso') {
                            $busca_sql = "curso.Nome_Curso";
                        } else {
                            $busca_sql = "escola.Nome_Escola";
                        }

                        $sql = "SELECT Nome_Turma, Modulo_Turma, curso.Nome_Curso AS Nome_Curso, escola.Nome_Escola AS Nome_Escola FROM turma INNER JOIN curso ON turma.ID_Curso_FK = curso.ID_Curso INNER JOIN escola ON turma.Cod_Escola = escola.Codigo where lower($busca_sql) like '%$nome%' ORDER BY curso.Nome_Curso, Modulo_Turma";

                        $envio_consulta = mysqli_query($conexao, $sql);

                        while ($vetor = mysqli_fetch_array($envio_consulta)) {

                            $dado1 = $vetor['Nome_Turma'];
                            $dado2 = $vetor['Modulo_Turma'];
                            $dado3 = $vetor['Nome_Curso'];
                            $dado4 = $vetor['Nome_Escola'];?>

                            <tr>

                                <td><?php echo $dado1;?></td>
                                <td><?php echo $dado2;?></td>
                                <td><?php echo $dado3;?></td>
                                <td><?php echo $dado4;?></td>

                            </tr><?php
                        }

                    
                    } else {

                        $sql = "SELECT Nome_Turma, Modulo_Turma, curso.Nome_Curso AS Nome_Curso, escola.Nome_Escola AS Nome_Escola FROM turma INNER JOIN curso ON turma.ID_Curso_FK = curso.ID_Curso INNER JOIN escola ON turma.Cod_Escola = escola.Codigo ORDER BY curso.Nome_Curso, Modulo_Turma";

                        $envio_consulta = mysqli_query($conexao, $sql);

                        while ($vetor = mysqli_fetch_array($envio_consulta)) {

                            $dado1 = $vetor['Nome_Turma'];
                            $dado2 = $vetor['Modulo_Turma'];
                            $dado3 = $vetor['Nome_Curso'];
                            $dado4 = $vetor['Nome_Escola'];?>

                            <tr>

                                <td><?php echo $dado1;?></td>
                                <td><?php echo $dado2;?></td>
                                <td><?php echo $dado3;?></td>
                                <td><?php echo $dado4;?></td>
                            </tr><?php
                        }
                    }
                } 
                else {
                    session_destroy();
                    header("Location:../../Admin/index.php");
                    exit();
                }
            
            ?>
            </table>
        </div>
</body>
</html>