<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Aluno</title>

    <link rel="shortcut icon" href="../../../images/logo.png" type="image/x-icon">


    <!--CSS-->
    <link rel="stylesheet" href="../../../style_geral.css">
    <link rel="stylesheet" href="../CSS/style_admin.css">
    <link rel="stylesheet" href="../CSS/style_consulta.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'poppins', Arial;
        }

        .input_text {
            background-color: var(--cor_fonte);
            border:var(--cor_fonte);
            border-radius:5px;
            height: 25px;
            padding: 5px;
        }
    </style>


</head>
<body>
    <form action="consulta_aluno.php" method="post">
        <input type="text" name="nome" id="nome" placeholder="Pesquise Aqui">
        <select class="input_text" name="tipo" id="tipo">
            <option value="">Selecione</option>
            <option value="Nome">Nome</option>
            <option value="Turma">Turma</option>
        </select>
        <input type="submit" value="Enviar" id="enviar">
        <a href="../Menu_Admin.php">voltar</a>
    </form>

    <div class="alunos">
            <table border="0">
                <tr style="background-color: #fff; color:#000;">
                    <th>RM</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Turma</th>
                    <th>2° Turma</th>
                    <th>Situação</th>
                    <th>Escola</th>
                </tr>
            

            <?php 

                session_start();

                if ($_SESSION['validacao_admin'] == 1) {
            
                    include ("../../../Banco_Dados/conexao.php");

                    if ($_POST) {
                        $nome = $_POST['nome'];
                        $tipo = $_POST['tipo'];

                        if ($tipo == 'Nome') {


                            $sql_consulta = "SELECT aluno.RM AS RM, Nome_Aluno, Email_Aluno, Situacao_Aluno, escola.Nome_Escola AS Nome_Escola FROM curso_aluno INNER JOIN aluno ON curso_aluno.ID_Aluno_FK = aluno.RM INNER JOIN escola ON aluno.Cod_Escola = escola.Codigo WHERE aluno.Nome_Aluno LIKE '%$nome%' GROUP BY aluno.RM";

                            $envio_consulta = mysqli_query($conexao, $sql_consulta);

                                while ($vetor = mysqli_fetch_array($envio_consulta)) {

                                    $dado1 = $vetor['RM'];
                                    $dado2 = $vetor['Nome_Aluno'];
                                    $dado3 = $vetor['Email_Aluno'];
                                    $dado5 = $vetor['Situacao_Aluno'];
                                    $dado6 = $vetor['Nome_Escola'];
                                    
                                    if ($dado1 != null) {

                                        $sql_turma = "SELECT turma.Nome_Turma AS Nome_turma FROM curso_aluno INNER JOIN turma ON curso_aluno.ID_Turma_FK = turma.ID_Turma WHERE ID_Aluno_FK = $dado1";

                                        $envio_turma = mysqli_query($conexao, $sql_turma);

                                        $turmas = []; // Array para armazenar todas as turmas
                                        while ($vetor_turma = mysqli_fetch_array($envio_turma)) {
                                            $turmas[] = $vetor_turma['Nome_turma']; 
                                            // Adiciona cada turma ao array

                                            if (mysqli_num_rows($envio_turma) == 1) {
                                                $turmas[] = "Nenhuma";
                                            }
                                        }

                                    }?>
    
                                    <tr>
    
                                        <td><?php echo $dado1;?></td>
                                        <td><?php echo $dado2;?></td>
                                        <td><?php echo $dado3;?></td>
                                        <?php
                                        
                                            if (!empty($turmas)) {
                                                foreach ($turmas as $turma) {
                                                    echo "<td>$turma</td>";
                                                }
                                            }
                                        ?>
                                        
                                        <td><?php echo $dado5;?></td>
                                        <td><?php echo $dado6;?></td>
    
                                    </tr><?php
                                }

                        } 
                        
                        else if ($tipo == 'Turma') {

                            $sql_consulta = "SELECT aluno.RM AS RM, Nome_Aluno, Email_Aluno, Situacao_Aluno, escola.Nome_Escola AS Nome_Escola FROM curso_aluno INNER JOIN aluno ON curso_aluno.ID_Aluno_FK = aluno.RM INNER JOIN turma ON curso_aluno.ID_Turma_FK = turma.ID_Turma INNER JOIN escola ON aluno.Cod_Escola = escola.Codigo WHERE turma.Nome_Turma LIKE '%$nome%' GROUP BY aluno.RM";

                            $envio_consulta = mysqli_query($conexao, $sql_consulta);

                            if (mysqli_num_rows($envio_consulta) == 0) {
                                exit;
                            }

                                while ($vetor = mysqli_fetch_array($envio_consulta)) {

                                    $dado1 = $vetor['RM'];
                                    $dado2 = $vetor['Nome_Aluno'];
                                    $dado3 = $vetor['Email_Aluno'];
                                    $dado5 = $vetor['Situacao_Aluno'];
                                    $dado6 = $vetor['Nome_Escola'];
                                    
                                    if ($dado1 != null) {

                                        $sql_turma = "SELECT turma.Nome_Turma AS Nome_turma FROM curso_aluno INNER JOIN turma ON curso_aluno.ID_Turma_FK = turma.ID_Turma WHERE ID_Aluno_FK = $dado1";

                                        $envio_turma = mysqli_query($conexao, $sql_turma);

                                        $turmas = []; // Array para armazenar todas as turmas
                                        while ($vetor_turma = mysqli_fetch_array($envio_turma)) {
                                            $turmas[] = $vetor_turma['Nome_turma']; 
                                            // Adiciona cada turma ao array
                                            if (mysqli_num_rows($envio_turma) == 1) {
                                                $turmas[] = "Nenhuma";
                                            }
                                        }

                                    } else {
                                        exit;
                                    }
                                }?>
    
                                    <tr>
    
                                        <td><?php echo $dado1;?></td>
                                        <td><?php echo $dado2;?></td>
                                        <td><?php echo $dado3;?></td>
                                        <?php
                                        
                                            if (!empty($turmas)) {
                                                foreach ($turmas as $turma) {
                                                    echo "<td>$turma</td>";
                                                }
                                            }
                                        ?>
                                        
                                        <td><?php echo $dado5;?></td>
                                        <td><?php echo $dado6;?></td>
    
                                    </tr><?php
                        }
                        else {
                            $sql_consulta = "SELECT aluno.RM AS RM, Nome_Aluno, Email_Aluno, Situacao_Aluno, escola.Nome_Escola AS Nome_Escola FROM curso_aluno INNER JOIN aluno ON curso_aluno.ID_Aluno_FK = aluno.RM INNER JOIN escola ON aluno.Cod_Escola = escola.Codigo WHERE ID_Aluno_FK > 0 GROUP BY aluno.RM";


                            $envio_consulta = mysqli_query($conexao, $sql_consulta);

                                while ($vetor = mysqli_fetch_array($envio_consulta)) {

                                    $dado1 = $vetor['RM'];
                                    $dado2 = $vetor['Nome_Aluno'];
                                    $dado3 = $vetor['Email_Aluno'];
                                    $dado5 = $vetor['Situacao_Aluno'];
                                    $dado6 = $vetor['Nome_Escola'];
                                    
                                    if ($dado1 != null) {

                                        $sql_turma = "SELECT turma.Nome_Turma AS Nome_turma FROM curso_aluno INNER JOIN turma ON curso_aluno.ID_Turma_FK = turma.ID_Turma WHERE ID_Aluno_FK = $dado1";

                                        $envio_turma = mysqli_query($conexao, $sql_turma);

                                        $turmas = []; // Array para armazenar todas as turmas
                                        while ($vetor_turma = mysqli_fetch_array($envio_turma)) {
                                            $turmas[] = $vetor_turma['Nome_turma']; 
                                            // Adiciona cada turma ao array

                                            if (mysqli_num_rows($envio_turma) == 1) {
                                                $turmas[] = "Nenhuma";
                                            }
                                        }

                                    }?>
    
                                    <tr>
    
                                        <td><?php echo $dado1;?></td>
                                        <td><?php echo $dado2;?></td>
                                        <td><?php echo $dado3;?></td>
                                        
                                        <?php
                                        
                                            if (!empty($turmas)) {
                                                foreach ($turmas as $turma) {
                                                    echo "<td>$turma</td>";
                                                }
                                            }
                                        ?>
                                        
                                        <td><?php echo $dado5;?></td>
                                        <td><?php echo $dado6;?></td>
    
                                    </tr><?php
                                }

                            }
                    }

                      // Fim do if tipo
                     
                    else if (!$_POST) {

                        $sql_consulta = "SELECT aluno.RM AS RM, Nome_Aluno, Email_Aluno, Situacao_Aluno, escola.Nome_Escola AS Nome_Escola FROM curso_aluno INNER JOIN aluno ON curso_aluno.ID_Aluno_FK = aluno.RM INNER JOIN escola ON aluno.Cod_Escola = escola.Codigo WHERE ID_Aluno_FK > 0 GROUP BY aluno.RM";


                            $envio_consulta = mysqli_query($conexao, $sql_consulta);

                                while ($vetor = mysqli_fetch_array($envio_consulta)) {

                                    $dado1 = $vetor['RM'];
                                    $dado2 = $vetor['Nome_Aluno'];
                                    $dado3 = $vetor['Email_Aluno'];
                                    $dado5 = $vetor['Situacao_Aluno'];
                                    $dado6 = $vetor['Nome_Escola'];
                                    
                                    if ($dado1 != null) {

                                        $sql_turma = "SELECT turma.Nome_Turma AS Nome_turma FROM curso_aluno INNER JOIN turma ON curso_aluno.ID_Turma_FK = turma.ID_Turma WHERE ID_Aluno_FK = $dado1";

                                        $envio_turma = mysqli_query($conexao, $sql_turma);

                                        $turmas = []; // Array para armazenar todas as turmas
                                        while ($vetor_turma = mysqli_fetch_array($envio_turma)) {
                                            $turmas[] = $vetor_turma['Nome_turma']; 
                                            if (mysqli_num_rows($envio_turma) == 1) {
                                                $turmas[] = "Nenhuma";
                                            }
                                
                                        }
                                        

                                    }?>
    
                                    <tr>
    
                                        <td><?php echo $dado1;?></td>
                                        <td><?php echo $dado2;?></td>
                                        <td><?php echo $dado3;?></td>
                                        <?php
                                        
                                            if (!empty($turmas)) {
                                                foreach ($turmas as $turma) {
                                                    echo "<td>$turma</td>";
                                                }
                                            }
                                        ?>
                                        
                                        <td><?php echo $dado5;?></td>
                                        <td><?php echo $dado6;?></td>
    
                                    </tr><?php
                                }

                            }           
                } else {
                    
                    session_destroy();
                    header("Location:../../Admin/index.php");
                    exit;
                }?>
            </table>
    </div>  
</body>
</html>