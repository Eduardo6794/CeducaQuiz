<?php 
    function limpeza() {

        include "../Banco_Dados/conexao.php";

        date_default_timezone_set('America/Sao_Paulo'); // Define para o fuso horário de São Paulo
        //date("d/m/Y");
        $data = '12/06/2025'; // Puxa a data em tempo real
        $vetor_data = explode('/', $data); // Separa em vários arrays a partir da /

        $periodo = null;
        //Verifica a data
        if ($vetor_data['1'] === '06') {
            $periodo = 'modulo';
            echo 'Meio Ano';
        } else if ($vetor_data['1'] === '12') {
            $periodo = 'seriemod';
            echo 'Fim Ano';
        }  else {
            echo 'nah';
        }

        //Limpa as nota dos alunos anteriores
        $sql_limpa = "DELETE FROM quiz_aluno";
        $exec_limpa = mysqli_query($conexao, $sql_limpa);

        //Puxa os dados de todos os alunos e seus cursos
        $sql_consulta = "SELECT aluno.RM, aluno.Modulo_Aluno, aluno.Situacao_Aluno, curso.Meio_Periodo, curso.ID_Curso FROM curso_aluno ca INNER JOIN aluno ON ca.ID_Aluno_FK = aluno.RM INNER JOIN curso ON ca.ID_Curso_FK = curso.ID_Curso";
        $sql_query = mysqli_query($conexao,$sql_consulta);


        //Irá verificar cada aluno
        while($vetor = mysqli_fetch_array($sql_query)){

            $rm = $vetor['RM'];
            $ID_Curso = $vetor['ID_Curso'];

            //Todos os alunos retidos irão ficar ativos porém não irá alterar a sua turma
            if ($vetor["Situacao_Aluno"] == 'Retido') {

                $sql_update = "UPDATE aluno SET Situacao_Aluno = 'Ativo' WHERE Situacao_Aluno = 'Retido'";
                mysqli_query($conexao, $sql_update);

            } else {

                if (($vetor['Meio_Periodo'] === 'S') && ($periodo === 'modulo')) {

                    if (($vetor["Modulo_Aluno"] == 3) OR ($vetor["Situacao_Aluno"] == 'Desistente')){
                    
                        $sql_delete = "DELETE FROM aluno WHERE RM = '$rm'";
                        mysqli_query($conexao, $sql_delete);
                
                    } else if ($vetor["Modulo_Aluno"] == 2){

                        $sql_update = "UPDATE aluno SET Modulo_Aluno = 3 WHERE Modulo_Aluno = 2 AND RM = '$rm'";
                        mysqli_query($conexao, $sql_update);

                        $sql_turma = "SELECT ID_Turma FROM turma WHERE Modulo_Turma = '3' AND ID_Curso_FK = $ID_Curso";
                        $exec_select_turma = mysqli_query($conexao, $sql_turma);
                        $vetor_turma = mysqli_fetch_assoc($exec_select_turma);

                        $ID_Turma = $vetor_turma['ID_Turma'];

                        $update_turma = "UPDATE curso_aluno SET ID_Turma_FK = $ID_Turma WHERE ID_Aluno_FK = '$rm'";
                        mysqli_query($conexao, $update_turma);

                    } else if ($vetor["Modulo_Aluno"] == 1){

                        $sql_update = "UPDATE aluno SET Modulo_Aluno = 2 WHERE Modulo_Aluno = 1 AND RM = '$rm'";
                        mysqli_query($conexao, $sql_update);

                        $sql_turma = "SELECT ID_Turma FROM turma WHERE Modulo_Turma = '2' AND ID_Curso_FK = $ID_Curso";
                        $exec_select_turma = mysqli_query($conexao, $sql_turma);
                        $vetor_turma = mysqli_fetch_assoc($exec_select_turma);

                        $ID_Turma = $vetor_turma['ID_Turma'];

                        $update_turma = "UPDATE curso_aluno SET ID_Turma_FK = $ID_Turma WHERE ID_Aluno_FK = '$rm'";
                        mysqli_query($conexao, $update_turma);

                    }
                } 
                else if (($vetor['Meio_Periodo'] === 'N') && ($periodo === 'seriemod')) {

                    if (($vetor["Modulo_Aluno"] == 3) OR ($vetor["Situacao_Aluno"] == 'Desistente')){
                    
                        $sql_delete = "DELETE FROM aluno WHERE RM = '$rm'";
                        mysqli_query($conexao, $sql_delete);
                
                    } else if ($vetor["Modulo_Aluno"] == 2){

                        $sql_update = "UPDATE aluno SET Modulo_Aluno = 3 WHERE Modulo_Aluno = 2 AND RM = '$rm'";
                        mysqli_query($conexao, $sql_update);

                        $sql_turma = "SELECT ID_Turma FROM turma WHERE Modulo_Turma = '3' AND ID_Curso_FK = $ID_Curso";
                        $exec_select_turma = mysqli_query($conexao, $sql_turma);
                        $vetor_turma = mysqli_fetch_assoc($exec_select_turma);

                        $ID_Turma = $vetor_turma['ID_Turma'];

                        $update_turma = "UPDATE curso_aluno SET ID_Turma_FK = $ID_Turma WHERE ID_Aluno_FK = '$rm'";
                        mysqli_query($conexao, $update_turma);

                    } else if ($vetor["Modulo_Aluno"] == 1){

                        $sql_update = "UPDATE aluno SET Modulo_Aluno = 2 WHERE Modulo_Aluno = 1 AND RM = '$rm'";
                        mysqli_query($conexao, $sql_update);

                        $sql_turma = "SELECT ID_Turma FROM turma WHERE Modulo_Turma = '2' AND ID_Curso_FK = $ID_Curso";
                        $exec_select_turma = mysqli_query($conexao, $sql_turma);
                        $vetor_turma = mysqli_fetch_assoc($exec_select_turma);

                        $ID_Turma = $vetor_turma['ID_Turma'];

                        $update_turma = "UPDATE curso_aluno SET ID_Turma_FK = $ID_Turma WHERE ID_Aluno_FK = '$rm'";
                        mysqli_query($conexao, $update_turma);

                    }

                }
            }
              
        }
    }

    limpeza();
?>