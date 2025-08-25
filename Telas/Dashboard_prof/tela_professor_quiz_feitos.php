<?php 

    include "../../Banco_Dados/conexao.php";

    session_start();

    // Verifica se a sessão está definida e válida
    if (!isset($_SESSION['Validacao_Professor']) || $_SESSION['Validacao_Professor'] != 1) {
        header("Location: ../login/login.php");
        mysqli_close($conexao);
        exit;
    }

    // Se veio por POST, salva na sessão e redireciona para GET
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Materia_Prof']) && isset($_POST['ID_Turma_FK'])) {
        $_SESSION['Materia_Prof'] = $_POST['Materia_Prof'];
        $_SESSION['ID_Turma_FK'] = $_POST['ID_Turma_FK'];
        header("Location: tela_professor_quiz_feitos.php");
        exit;
    }

    if (!isset($_SESSION['Materia_Prof']) || !isset($_SESSION['ID_Turma_FK'])) {
        header("Location: tela_professor.php");
        exit;
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Já Feitos</title>
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="style_tela_professor_quiz_feitos.css">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="redirecionaDashBoardProfessor()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" onclick="redirecionaConfiguracoes()">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div style="display: flex; flex-direction: column; align-items: center;">
        <div class="texto" style="text-align: center;">
            <div class="conatinerTituloTurma">
                <?php
            
                    include "../../Banco_Dados/conexao.php";
                        $ID_Turma_FK = $_SESSION['ID_Turma_FK'];
                        if ($ID_Turma_FK === null) {
                            header('Location: tela_professor.php');
                            exit;
                        }
                        $sql_consulta = "SELECT Nome_Turma FROM turma WHERE ID_Turma = $ID_Turma_FK";
                        $resultado = mysqli_query($conexao, $sql_consulta);
                        $dados = mysqli_fetch_array($resultado);
                        $Nome_Turma = $dados['Nome_Turma'];
                        echo "<p>Turma: ".$Nome_Turma."</p>";
            
                ?>
            </div>
            <div class="conatinerTituloTurmaDoQuizSelecionado">
                <p>
                <?php
            
                    include "../../Banco_Dados/conexao.php";
                        $ID_Turma_FK = $_SESSION['ID_Turma_FK'];
                        if ($ID_Turma_FK === null) {
                            header('Location: tela_professor.php');
                            exit;
                        }
                        $sql_consulta = "SELECT curso.Nome_Curso AS Nome_Curso FROM turma INNER JOIN curso ON turma.ID_Curso_FK = curso.ID_Curso WHERE ID_Turma = $ID_Turma_FK";
                        $resultado = mysqli_query($conexao, $sql_consulta);
                        $dados = mysqli_fetch_array($resultado);
                        $Nome_Curso = $dados['Nome_Curso'];
            
            
                ?><?php echo $Nome_Curso;?></p>
            </div>
        </div>
        <div class="containerQuizFeitos" style="flex-direction: column;">
            <?php
        
            include "../../Banco_Dados/conexao.php";

            $select_perg_incorrect = "DELETE FROM perguntas WHERE Titulo_Perg = ''";
            $exec_perg_incorrect = mysqli_query($conexao, $select_perg_incorrect);

            // Corrigido: Use subquery aninhada para evitar erro de referência à tabela alvo
            $select_quiz_incorrect = "DELETE FROM quiz WHERE ID_Quiz IN (
                SELECT * FROM (
                    SELECT q.ID_Quiz
                    FROM quiz q
                    LEFT JOIN perguntas p ON q.ID_Quiz = p.ID_Quiz_FK
                    WHERE p.ID_Quiz_FK IS NULL
                ) AS temp_ids
            )";
            $exec_quiz_incorrect = mysqli_query($conexao, $select_quiz_incorrect);
        
                $ID_Turma_FK = $_SESSION['ID_Turma_FK'];
                $Materia_Prof = $_SESSION['Materia_Prof'];
                $ID_Prof = $_SESSION['ID_Prof'];
                $sql_consulta2 = "SELECT ID_ProfTurma FROM prof_turma WHERE (ID_Prof_FK = $ID_Prof) AND (ID_Turma_FK = $ID_Turma_FK) AND (Materia_Prof = '$Materia_Prof')";
                $resultado2 = mysqli_query($conexao, $sql_consulta2);
                $dados2 = mysqli_fetch_array($resultado2);
                if ($dados2['ID_ProfTurma'] === null) {
                    header("Location: tela_professor.php");
                    exit;
                }
                $ID_ProfTurma = $dados2['ID_ProfTurma'];
                $_SESSION['ID_ProfTurma'] = $ID_ProfTurma;
                $sql_consulta3 = "SELECT ID_Quiz, Titulo_Quiz, Data_Quiz FROM quiz WHERE ID_ProfTurma_FK = $ID_ProfTurma GROUP BY Titulo_Quiz ORDER BY Data_Quiz DESC";
                $resultado3 = mysqli_query($conexao, $sql_consulta3);
                
                while ($dados3 = mysqli_fetch_array($resultado3)) {
        
                    $ID_Quiz = $dados3['ID_Quiz'];
                    $Titulo_Quiz = $dados3['Titulo_Quiz'];
                    $data = $dados3['Data_Quiz'];
        
                    // Formata a data para o formato desejado (dd/mm/aaaa)
                    //Include_once garante que o arquivo será incluído apenas uma vez
                    include_once "../../Funcoes_Backend/formata_data.php";
                    $Data_Quiz = formata_data($data);
        
                    ?>
                    <div id="quizFeitos" style="width: auto; display: flex; flex-direction: row; align-items: center; justify-content: space-between;">
                        <div>
                            <?php echo $Titulo_Quiz . " " . $Data_Quiz;?>
                        </div>
                        <div>
                            <form action="tela_professor_info_quiz_feitos.php" method="post">
                                <input type="hidden" name="ID_Quiz" value="<?php echo $ID_Quiz;?>">
                                <input type="image" src="../../icons/arrow_right.png" alt="próxima" style="width:20px; height: 20px; border: none; box-shadow: none;">
                            </form>
                        </div>
                    </div>
    



            <?php
            
            }
        ?>
        </div>
    </div>

    <div class="contanierButtonCriarNovoQuiz">
        <button id="ButtonCriarNovoQuiz" onclick="rednovoquiz()">CRIAR NOVO QUIZ</button>
    </div>
</body>
<script>  
    function rednovoquiz() {
       window.location.href = "../criador_quiz/add_quiz.php"; 
    }

    function redirecionaConfiguracoes() {
        window.location.href = "../config_professor/config_professor.php";
    }
</script>
<script src="../../script_geral.js"></script>
</html>