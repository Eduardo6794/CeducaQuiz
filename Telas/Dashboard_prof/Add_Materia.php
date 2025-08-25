<?php 

    include "../../Banco_Dados/conexao.php";

    session_start();

    if ($_POST) {
        $Nome_Materia = $_POST['Nome_Materia'];
        $ID_Curso = $_POST['ID_Curso'];
        $modulo = $_POST['modulo'];

        // Fix: Validate posted fields, not $ID_Turma
        if (empty($Nome_Materia) || empty($ID_Curso)) {
            header('Location: Materia.php?erro=input_vazios');
            exit;
        }

        $sql_id_turma = "SELECT ID_Turma FROM turma WHERE ID_Curso_FK = $ID_Curso AND Modulo_Turma = $modulo";
        $exec_sql_id_turma = mysqli_query($conexao, $sql_id_turma);

        if ($vetor_id_turma = mysqli_fetch_array($exec_sql_id_turma)){
            $ID_Turma = $vetor_id_turma['ID_Turma'];
        } else {
            header('Location: Materia.php?erro=ID_Turma_Nao_Encontrado');
            exit;
        }

        include "../../Funcoes_Backend/Consulta_ID_Prof.php";

        $inserir = "INSERT INTO prof_turma (ID_Prof_FK, ID_Turma_FK, Materia_Prof) VALUES ($ID_Prof, $ID_Turma, '$Nome_Materia')";

        $exec_inserir = mysqli_query($conexao, $inserir);

        if ($exec_inserir) {
            header('Location: Materia.php?erro=sucesso');
            exit;
        }
    }
?>