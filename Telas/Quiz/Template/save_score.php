<?php
    include "../../../Banco_Dados/conexao.php";
    session_start();

    if ($_SESSION['Validacao_Aluno'] == 1) {
        
        if ($_POST) {
            $ID_Quiz = $_POST['ID_Quiz'];
            $score = $_POST['score'];
            $tempo_restante = isset($_POST['tempo_restante']) ? floatval($_POST['tempo_restante']) : 0;

            $sql_consulta_quiz = "SELECT Duracao_Quiz FROM quiz WHERE ID_Quiz = $ID_Quiz";
            $exec_consulta_quiz = mysqli_query($conexao, $sql_consulta_quiz);

            $vetor_dado = mysqli_fetch_array($exec_consulta_quiz);
            $Duracao_Quiz = $vetor_dado['Duracao_Quiz'];

            // Calcula o tempo gasto pelo aluno
            $duracao_aluno = $Duracao_Quiz - $tempo_restante;
            if ($duracao_aluno < 0) {$duracao_aluno = 0;}
            if ($tempo_restante < 0) {
                echo "<script>alert('Tempo excedido!')</script>";
                header('Location: ../../Dashboard_aluno/DashBoard_Aluno.php?erro=tempo_excedido');
                mysqli_close($conexao);
                exit;
            }


            $Nome_Aluno = $_SESSION['Nome_Aluno']; 
            $Senha_Aluno = $_SESSION['Senha_Aluno'];

            $sql_consulta_aluno = "SELECT RM FROM aluno WHERE (Nome_Aluno = '$Nome_Aluno') AND (Senha_Aluno = '$Senha_Aluno')";

            $exec_consulta_aluno = mysqli_query($conexao, $sql_consulta_aluno);

            $vetor_dado = mysqli_fetch_array($exec_consulta_aluno);

            $RM = $vetor_dado['RM'];

            if ($RM == null) {
                echo "<script>alert('Erro ao encontrar o RM do aluno!')</script>";
                exit;
            }

            $sql_consulta_aluno = "SELECT * FROM quiz_aluno WHERE ID_Aluno_FK = $RM AND ID_Quiz_FK = $ID_Quiz";
            $exec_consulta_aluno = mysqli_query($conexao, $sql_consulta_aluno);

            if (mysqli_num_rows($exec_consulta_aluno) > 0) {

                echo "<script>alert(Você já fez esse quiz!)</script>";
                header('Location: ../../Dashboard_aluno/DashBoard_Aluno.php?erro=quiz_feito');
                mysqli_close($conexao);
                exit;

            } else {

                $sql_insert = "INSERT INTO quiz_aluno (ID_Quiz_FK, ID_Aluno_FK, NotaTotal, Duracao_Aluno) VALUES ($ID_Quiz, $RM, '$score', '$duracao_aluno')";
                if (mysqli_query($conexao, $sql_insert)) {
                    echo "Nota salva com sucesso!";

                    header ("Location: ../../Dashboard_aluno/DashBoard_Aluno.php");
                    exit;
                } else {
                    echo "Erro ao salvar a nota: " . mysqli_error($conexao);
                }
                
            }
        }
    } else {
        header("Location:../../login/login.php");
        mysqli_close($conexao);
        exit;
    }
?>