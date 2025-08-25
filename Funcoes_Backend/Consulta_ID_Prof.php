<?php 
                
        include "../../Banco_Dados/conexao.php";

        $Nome_Prof = $_SESSION['Nome_Prof'];
        $Senha_Prof = $_SESSION['Senha_Prof'];

        $sql_consulta = "SELECT ID_Prof FROM professor WHERE (Nome_Prof = '$Nome_Prof') AND (Senha_Prof = '$Senha_Prof')";

        $exec_consulta = mysqli_query($conexao, $sql_consulta);

        $vetor_prof = mysqli_fetch_array($exec_consulta);

        $ID_Prof = $vetor_prof['ID_Prof'];
?>