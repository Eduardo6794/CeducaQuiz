<?php 

// Prevent PHP from outputting warnings/notices before headers
error_reporting(0);
ini_set('display_errors', 0);

session_start();

include "../../Banco_Dados/conexao.php";

if (isset($_SESSION['Validacao_Aluno']) && $_SESSION['Validacao_Aluno'] == 1) {

    if ($_POST) {

        $ID_Turma = $_POST['ID_Turma'];

        if ($ID_Turma == null || $ID_Turma == "") {
            header('Location:../Dashboard_aluno/entrar_curso.php?erro=turma_inexistente');
            exit;
        }

    }

    $Nome_Aluno = $_SESSION['Nome_Aluno'];
    $Senha_Aluno = $_SESSION['Senha_Aluno'];

    if ($ID_Turma != null || $ID_Turma != "") {

        $sql_select = "SELECT RM FROM aluno WHERE Nome_Aluno = '$Nome_Aluno' AND Senha_Aluno = '$Senha_Aluno'";
        $resultado_select = mysqli_query($conexao, $sql_select);

        if ($resultado_select) {

            $dados_select = mysqli_fetch_array($resultado_select);
            $RM = $dados_select['RM'];

            $sql_select_curso = "SELECT ID_Curso_FK FROM turma WHERE ID_Turma = $ID_Turma";
            $resultado_select_curso = mysqli_query($conexao, $sql_select_curso);

            $dados_select_curso = mysqli_fetch_array($resultado_select_curso);
            $ID_Curso_FK = $dados_select_curso['ID_Curso_FK'];

            $sql_select_aluno = "SELECT * FROM curso_aluno WHERE ID_Aluno_FK = $RM";
            $resultado_select_aluno = mysqli_query($conexao, $sql_select_aluno);
            if (mysqli_num_rows($resultado_select_aluno) == 1) {
                header('Location:../Dashboard_aluno/entrar_curso.php?erro=limite_excedido');
                exit;
            }

            $sql_delete = "DELETE FROM curso_aluno WHERE ID_Aluno_FK = $RM AND ID_Turma_FK = $ID_Turma AND ID_Curso_FK = $ID_Curso_FK";
            $exec_delete = mysqli_query($conexao, $sql_delete);



            if ($exec_delete) {
                header('Location:../Dashboard_aluno/entrar_curso.php?erro=turma_excluida');
                exit;
            } else {
                header('Location:../Dashboard_aluno/entrar_curso.php?erro=erro_excluir_turma');
                exit;
            }

        } else {
            header('Location:../Dashboard_aluno/entrar_curso.php?erro=erro_busca_rm');
            exit;
        }

    } else {
        header('Location:../Dashboard_aluno/Dashboard_Aluno.php?msg=config_sucesso');
        exit;
    }

} else {
    header("Location: ../login/login.php");
    mysqli_close($conexao);
    exit;
}

?>