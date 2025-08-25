<?php   
        if ($_POST) {

            $tipo_form = $_POST['tipo_form'];

            if ($tipo_form == 1) {

                include "../../Banco_Dados/conexao.php";

                $Turma = $_POST['turma'];

                $Nome_Prof = $_SESSION['Nome_Prof'];
                $Senha_Prof = $_SESSION['Senha_Prof'];


                $sql_consulta = "SELECT * FROM professor WHERE (Nome_Prof = '$Nome_Prof') AND (Senha_Prof = '$Senha_Prof')";

                $exec_consulta = mysqli_query($conexao, $sql_consulta);

                $vetor_consulta = mysqli_fetch_array($exec_consulta);

                $ID_Prof = $vetor_consulta['ID_Prof'];


                $sql_consulta2 = "SELECT Materia_Prof, turma.Nome_Turma AS Nome_turma, ID_Turma_FK FROM prof_turma INNER JOIN turma ON turma.ID_Turma = prof_turma.ID_Turma_FK AND Nome_Turma LIKE '%$Turma%' WHERE ID_Prof_FK = $ID_Prof ";

                $exec_consulta2 = mysqli_query($conexao, $sql_consulta2);

                while ($vetor_consulta2 = mysqli_fetch_array($exec_consulta2)) {

                    $Materia_Prof = $vetor_consulta2['Materia_Prof'];
                    $Nome_Turma = $vetor_consulta2['Nome_turma'];
                    //$ID_Turma_FK = $vetor_consulta2['ID_Turma_FK']
                    
                    ?>

                    <tr>
                        <td><?php echo $Nome_Turma;?></td>
                        <td><?php echo $Materia_Prof;?></td>
                        <td>
                            <form action="../Quiz/Inicio.php" method="post">

                                <input type="hidden" name="Nome_Turma" value="<?php 
                                echo $Nome_Turma;?>">
                                <input type="hidden" name="Materia_Prof" value="<?php echo $Materia_Prof;?>">
                                <!--<input type="hidden" name="ID_Turma_FK " value="<?php echo $ID_Turma_FK;?>">-->
                                <input type="submit" value="Proximo">

                            </form>
                        </td>
                    </tr>



                <?php                        
                }
            } 
        }

        else {

            $Nome_Prof = $_SESSION['Nome_Prof'];
            $Senha_Prof = $_SESSION['Senha_Prof'];


            $sql_consulta = "SELECT * FROM professor WHERE (Nome_Prof = '$Nome_Prof') AND (Senha_Prof = '$Senha_Prof')";

            $exec_consulta = mysqli_query($conexao, $sql_consulta);

            $vetor_consulta = mysqli_fetch_array($exec_consulta);

            $ID_Prof = $vetor_consulta['ID_Prof'];

            $sql_consulta2 = "SELECT Materia_Prof, turma.Nome_Turma AS Nome_turma, ID_ProfTurma FROM prof_turma INNER JOIN turma ON turma.ID_Turma = prof_turma.ID_Turma_FK WHERE ID_Prof_FK = $ID_Prof";

            $exec_consulta2 = mysqli_query($conexao, $sql_consulta2);


            while ($vetor_consulta2 = mysqli_fetch_array($exec_consulta2)) {

                $Materia_Prof = $vetor_consulta2['Materia_Prof'];
                $Nome_Turma = $vetor_consulta2['Nome_turma'];
                $ID_ProfTurma = $vetor_consulta2['ID_ProfTurma'];
                
                
                
                ?>

                <tr>
                    <td><?php echo $Nome_Turma;?></td>
                    <td><?php echo $Materia_Prof;?></td>
                    <td>
                       <form action="../Quiz/Inicio.php" method="POST">
        
                                <input type="hidden" name="Nome_Turma" value="<?php 
                                echo $Nome_Turma;?>">
                                <input type="hidden" name="Materia_Prof" value="<?php echo $Materia_Prof;?>">
                                <input type="hidden" name="ID_ProfTurma" value="<?php echo $ID_ProfTurma;?>">
                                <input type="submit" value="Proximo">
                                
                        </form>
                    </td>
                </tr>



            <?php                        
            }
        }

                

?>





<?php 



/*$sql_consulta3 = "SELECT ID_Turma_FK FROM prof_turma WHERE (Materia_Prof = '$Materia_Prof') AND (ID_Prof_FK = $ID_Prof)";

                $exec_consulta3 = mysqli_query($conexao, $sql_consulta3);

                $vetor_consulta3 = mysqli_fetch_array($exec_consulta3);

                $ID_Turma_FK = $vetor_consulta3['ID_Turma_FK'];    */









?>