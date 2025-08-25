<?php

    function cadastro($nome_aluno, $email, $senha_aluno, $modulo, $curso, $rm, $ce){

        $ce = (int)$ce;
        $rm = trim((string)$rm); // Garante que RM é string e sem espaços

        include("../../Banco_Dados/conexao.php");

        $sql_validacao = "SELECT ID_Turma FROM turma WHERE Modulo_Turma = $modulo AND ID_Curso_FK = $curso AND Cod_Escola = $ce";
        $execute_validacao = mysqli_query($conexao, $sql_validacao);

        if (mysqli_num_rows($execute_validacao) == 0) {
            header("Location: ../cadastro_aluno/cadastro_aluno.php?dados_incorretos=sem_turma");
            mysqli_close($conexao);
            exit;
        }

        // Usando prepared statement para evitar problemas de comparação e SQL injection
        $stmt_rm = mysqli_prepare($conexao, "SELECT RM FROM aluno WHERE RM = ?");
        mysqli_stmt_bind_param($stmt_rm, "s", $rm);
        mysqli_stmt_execute($stmt_rm);
        mysqli_stmt_store_result($stmt_rm);

        if (mysqli_stmt_num_rows($stmt_rm) > 0) {
            mysqli_stmt_close($stmt_rm);
            header("Location: ../cadastro_aluno/cadastro_aluno.php?dados_incorretos=rm_cadastrado");
            exit;
        }
        mysqli_stmt_close($stmt_rm);

        if ($execute_validacao) {

            $vetor_turma = mysqli_fetch_assoc($execute_validacao);

            $ID_Turma = $vetor_turma['ID_Turma'];

            $sql_consulta_aluno = "SELECT * FROM aluno WHERE (Nome_Aluno = '$nome_aluno') AND (Senha_Aluno = '$senha_aluno')";

            $execute_consulta_aluno = mysqli_query($conexao, $sql_consulta_aluno);

            if (mysqli_num_rows($execute_consulta_aluno) == 0) {

                $sql_inserir = "INSERT INTO aluno (RM, Nome_Aluno, Email_Aluno, Senha_Aluno, Modulo_Aluno, Cod_Escola, Situacao_Aluno) VALUES ($rm, '$nome_aluno', '$email', '$senha_aluno', $modulo, '$ce', 'Ativo')";

                $execute_inserir = mysqli_query($conexao, $sql_inserir);

                if ($execute_inserir) {
                    
                    $sql_inserir_turma = "INSERT INTO curso_aluno (ID_Aluno_FK, ID_Curso_FK, ID_Turma_FK) VALUES ($rm, $curso ,$ID_Turma)";
                    $execute_inserir_turma = mysqli_query($conexao, $sql_inserir_turma);

                    if (!$execute_inserir_turma) {
                        mysqli_close($conexao);
                        header("Location: ../cadastro_aluno/cadastro_aluno.php?dados_incorretos=erro_turma");
                        exit;
                    }

                        session_start();
                        $_SESSION['Nome_Aluno'] = $nome_aluno;
                        $_SESSION['Email_Aluno'] = $email;
                        $_SESSION['Senha_Aluno'] = $senha_aluno;
                        $_SESSION['Validacao_Aluno'] = 1;

                        header("Location:../Dashboard_aluno/DashBoard_Aluno.php");
                        mysqli_close($conexao);
                        exit;

                } else {
                    mysqli_close($conexao);
                    header("Location: ../cadastro_aluno/cadastro_aluno.php?dados_incorretos=erro_cadastro");
                    exit;

                }

            } else {
                mysqli_close($conexao);
                header("Location: ../cadastro_aluno/cadastro_aluno.php?dados_incorretos=aluno_existente");
                exit;
            }
        }
        
    }



    if ($_POST) {
        $nome_aluno = $_POST['nome'];
        $senha_aluno = $_POST['senha'];
        $email = $_POST['email'];
        $modulo = $_POST['modulo'];
        $curso = $_POST['curso'];
        $rm = trim($_POST['rm']); // Remove espaços
        $ce = $_POST['ce'];

        $rm = (string)$rm;
        $ce = (int)$ce;

        if (!ctype_digit($rm) || !is_int($ce)) {
            header("Location: cadastro_aluno.php?dados_incorretos=numeros_invalidos");
            if (isset($conexao)) mysqli_close($conexao);
            exit;
        }

        if ($modulo >= 5) {
            header("Location: cadastro_aluno.php?dados_incorretos=numeros_invalidos");
            if (isset($conexao)) mysqli_close($conexao);
            exit;
        }

        try {
            cadastro(nome_aluno: $nome_aluno, email: $email, senha_aluno: $senha_aluno, modulo: $modulo, curso: $curso, rm: $rm, ce: $ce);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
?>