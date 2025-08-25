<?php 

    include "../../Banco_Dados/conexao.php";

    session_start();

    if ($_POST) {

        $Nome_Materia = $_POST['Nome_Materia'];
        $Nova_Materia = $_POST['Nova_Materia'];
        $ID_Turma_FK = $_POST['ID_Turma'];

        if (empty($Nome_Materia) OR empty($Nova_Materia) OR empty($ID_Turma_FK)) {
            header('Location: Materia.php?erro=input_vazios');
            exit;
        }

        $sql_select = "SELECT * FROM prof_turma WHERE ID_Turma_FK = $ID_Turma_FK AND Materia_Prof = '$Nome_Materia'";
        $exec_sql_select = mysqli_query($conexao, $sql_select);

        if (mysqli_num_rows($exec_sql_select) == 0) {

            header('Location: Materia.php?erro=materia_nao_encontrada');
            exit;

        } else {

            include "../../Funcoes_Backend/Consulta_ID_Prof.php";

            $update = "UPDATE prof_turma SET Materia_Prof = '$Nova_Materia' WHERE (ID_Turma_FK = $ID_Turma_FK) AND (ID_Prof_FK = $ID_Prof) AND (Materia_Prof = '$Nome_Materia')";
            $exec_update = mysqli_query($conexao, $update);

            if ($exec_update) {
                header('Location: Materia.php?erro=materia_editada');
                exit;
            }

        }
    }













?>