<?php 

    include "../../Banco_Dados/conexao.php";

    session_start();

    if ($_SESSION['Validacao_Aluno'] == 1) {

        if ($_POST) {

            $ID_Curso = $_POST['ID_Curso'];

            if (is_numeric($ID_Curso)) {
                $ID_Curso = intval($ID_Curso);
            } else {
                header('Location:../Dashboard_aluno/entrar_curso.php?erro=curso_invalido');
                exit;
            }

            $Modulo = $_POST['Modulo'];

            if (empty($Modulo) || !is_numeric($Modulo)) {
                header('Location:../Dashboard_aluno/entrar_curso.php?erro=modulo_invalido');
                exit;
            }

        }

        $Nome_Aluno = $_SESSION['Nome_Aluno'];
        $Senha_Aluno = $_SESSION['Senha_Aluno'];

        if ($ID_Curso != null || $ID_Curso != "") {

            $sql_select = "SELECT RM FROM aluno WHERE Nome_Aluno = '$Nome_Aluno' AND Senha_Aluno = '$Senha_Aluno'";
            $resultado_select = mysqli_query($conexao, $sql_select);

            if ($resultado_select) {

                $dados_select = mysqli_fetch_array($resultado_select);
                $RM = $dados_select['RM'];

                //Verifica se a turma existe
                $sql_verif_turma = "SELECT ID_Turma FROM turma WHERE Modulo_Turma = $Modulo AND ID_Curso_FK = $ID_Curso";
                $result_verif_turma = mysqli_query($conexao, $sql_verif_turma);

                if (mysqli_num_rows($result_verif_turma) == 0) {
                    header('Location:../Dashboard_aluno/entrar_curso.php?erro=turma_inexistente');
                    exit;
                } else {
                    $vetor_turma = mysqli_fetch_array($result_verif_turma);
                    $ID_Turma = $vetor_turma['ID_Turma'];
                }

                // Verifica se o aluno já está cadastrado na turma
                $sql_verifica_turma = "SELECT * FROM curso_aluno WHERE ID_Aluno_FK = $RM AND ID_Turma_FK = $ID_Turma";
                $resultado_verifica_turma = mysqli_query($conexao, $sql_verifica_turma);

                if (mysqli_num_rows($resultado_verifica_turma) > 0) {
                    header('Location:../Dashboard_aluno/entrar_curso.php?erro=cadastrado_turma');
                    exit;
                }

                //Verifica se o aluno já está cadastrado em 2 turmas
                $sql_verifica_aluno = "SELECT ID_Turma_FK FROM curso_aluno WHERE ID_Aluno_FK = $RM";
                $resultado_verifica_aluno = mysqli_query($conexao, $sql_verifica_aluno);

                if (mysqli_num_rows($resultado_verifica_aluno) >= 2) {
                    header('Location:../Dashboard_aluno/entrar_curso.php?erro=limite_turma');
                    exit;
                }


                $sql_select_curso = "SELECT ID_Curso_FK FROM turma WHERE ID_Turma = $ID_Turma";
                $resultado_select_curso = mysqli_query($conexao, $sql_select_curso);

                $dados_select_curso = mysqli_fetch_array($resultado_select_curso);

                $ID_Curso_FK = $dados_select_curso['ID_Curso_FK'];

                $sql_insert = "INSERT INTO curso_aluno (ID_Aluno_FK, ID_Curso_FK, ID_Turma_FK) VALUES ($RM, $ID_Curso_FK, $ID_Turma)";
                $exec_insert = mysqli_query($conexao, $sql_insert);

                if ($exec_insert) {
                    header('Location:../Dashboard_aluno/entrar_curso.php?erro=sucesso');
                    exit;
                } else {
                    header('Location:../Dashboard_aluno/entrar_curso.php?erro=erro_add_turma');
                }

            } else {
                header('Location:../Dashboard_aluno/entrar_curso.php?erro=erro_busca_rm');
                exit;
            }

        } else {
            header('Location:../Dashboard_aluno/DashBoard_Aluno.php');
            exit;
        }

    } else {
        header("Location: ../login/login.php");
        mysqli_close($conexao);
        exit;
    }
?>