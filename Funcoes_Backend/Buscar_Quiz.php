<?php 

    include("../Banco_Dados/conexao.php");

    $sql_consulta_quiz = "SELECT MAX(ID_Quiz) AS max_id FROM quiz";

    $execute_consulta_quiz = mysqli_query($conexao, $sql_consulta_quiz);

    $vetor_dado = mysqli_fetch_array($execute_consulta_quiz);

    $ID_Quiz = $vetor_dado['max_id'] + 1;

?>
