<?php 

    session_start();

    include "../../Funcoes_Backend/Consulta_ID_Prof.php";

    if ($_POST) {
        $Nome_Materia = $_POST['Nome_Materia'];
        $ID_Turma = $_POST['ID_Turma'];

        $sql_delete = "DELETE FROM prof_turma WHERE (Materia_Prof = '$Nome_Materia') AND (ID_Turma_FK = $ID_Turma) AND (ID_Prof_FK = $ID_Prof)";
        $exec_delete = mysqli_query($conexao, $sql_delete);

        if ($exec_delete) {
            header('Location: Materia.php');
            exit;
        }
    }










?>