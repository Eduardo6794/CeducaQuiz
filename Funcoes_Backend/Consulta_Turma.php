<?php

                include("../../Banco_Dados/conexao.php");

                $sql_consulta = "SELECT ID_Turma, Nome_Turma, curso.Nome_Curso AS Nome_Curso FROM turma INNER JOIN curso ON turma.ID_Curso_FK = curso.ID_Curso";

                $result = mysqli_query($conexao,$sql_consulta);

                while($vetor = mysqli_fetch_array($result)){
                    
                    $id_turma = $vetor['ID_Turma'];
                    $nome_turma = $vetor['Nome_Turma'];?>

                    <option value="<?php echo $id_turma;?>"><?php echo $nome_turma;?></option>


                <?php
                }?>
            
            
            
?>