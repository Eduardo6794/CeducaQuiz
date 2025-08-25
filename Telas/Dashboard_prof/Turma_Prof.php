<?php 
    include "../../Banco_Dados/conexao.php";
    session_start();

    if ($_SESSION['Validacao_Professor'] == 1) {


    } else {
        header("Location: ../login/login.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Turma</title>

    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
</head>
<body>
    <a href="../Dashboard_prof/Dashboard_Prof.php">Voltar</a>
<div>
    <a href="../Dashboard_prof/Add_Materia.php">Criar</a>
    <a href="../Dashboard_prof/Edita_Materia.php">Editar</a>
    <a href="../Dashboard_prof/Remover_Materia.php">Remover</a>
</div>
<table>
    <tr>
        <th>Turma</th>
        <th></th>
    </tr>
    <?php 
    
        include "../../Banco_Dados/conexao.php";

        if($_POST) {
            $ID_Turma_FK = $_POST['ID_Turma_FK'];

            $_SESSION['ID_Turma_FK'] = $ID_Turma_FK;

            $ID_Prof = $_SESSION['ID_Prof'];

            $sql_consulta2 = "SELECT Materia_Prof FROM prof_turma WHERE (ID_Prof_FK = $ID_Prof) AND (ID_Turma_FK = $ID_Turma_FK)";

            $resultado2 = mysqli_query($conexao, $sql_consulta2);

            while ($dados2 = mysqli_fetch_array($resultado2)) {
                
                $dado1 = $dados2['Materia_Prof'];?>

                <tr>
                    <td><?php echo $dado1;?></td>
                    <td>
                        <form action="../Dashboard_prof/Materia_Prof.php" method="post">
                            <input type="hidden" name="Materia_Prof" value="<?php echo $dado1;?>">
                            <input type="submit" value="Proximo">
                        </form>
                    </td>
                </tr>



            <?php
            
            }
        }

        
    ?>
</table>
</body>
</html>