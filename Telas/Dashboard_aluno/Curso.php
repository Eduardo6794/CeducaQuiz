<?php
session_start(); // Start session before any output

if ($_POST) {
    $ID_Turma_FK = $_POST['ID_Turma_FK'];
} else {
    $ID_Turma_FK = "";
}

include "../../Banco_Dados/conexao.php";

$Nome_Aluno = isset($_SESSION['Nome_Aluno']) ? $_SESSION['Nome_Aluno'] : null;
$Senha_Aluno = isset($_SESSION['Senha_Aluno']) ? $_SESSION['Senha_Aluno'] : null;

if (!$Nome_Aluno || !$Senha_Aluno) {
    header('Location: ../../login.php');
    exit();
}

$sql_consulta = "SELECT RM FROM aluno WHERE (Nome_Aluno = '$Nome_Aluno') AND (Senha_Aluno = '$Senha_Aluno')";
$resultado_consulta = mysqli_query($conexao, $sql_consulta);
$vetor_aluno = mysqli_fetch_array($resultado_consulta);
$RM = isset($vetor_aluno['RM']) ? $vetor_aluno['RM'] : null;

if (!$RM) {
    header('Location: ../../login.php');
    exit();
}

if ($ID_Turma_FK == "") {
    header('Location: DashBoard_Aluno.php');
    exit();
}

$sql_consulta2 = "SELECT Materia_Prof, ID_ProfTurma FROM prof_turma WHERE ID_Turma_FK = $ID_Turma_FK";
$resultado_consulta2 = mysqli_query($conexao, $sql_consulta2);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style_painel.css">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw; height: 100vh;">
    
    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="retorna()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" onclick="redireciona_config()">
    </div>
    
    <div class="espacamento_pos_menu"></div>

    <div class="primeira_div_centralizadora">
        <div class="primeira_div_centralizadora_forms">
            <div class="form">
                <div class="texto_saudacao">Olá <?php echo $Nome_Aluno ?></div>
                <?php
                while ($vetor1 = mysqli_fetch_array($resultado_consulta2)) {
                    $Materia_Prof = $vetor1['Materia_Prof'];
                    $ID_ProfTurma = $vetor1['ID_ProfTurma'];
                    ?>
                    <div class="quiz-container" style="box-shadow: 0 2px 5px -1px #00000059; background-color: transparent; border-radius: 5px;">
                        <div class="div_extende toggle-quiz">
                            <div class="nome_materia"><?php echo $Materia_Prof; ?></div>
                            <img src="../../icons/arrow_right.png" alt="" class="formata_seta">
                        </div>
                        <div class="quiz-list div_pos_extende">
                            <div class="formatador_grid">
                            <?php 
                                $sql_consulta3 = "SELECT quiz.Data_Quiz, quiz.Titulo_Quiz AS Titulo_Quiz, NotaTotal FROM quiz_aluno JOIN quiz ON quiz_aluno.ID_Quiz_FK = quiz.ID_Quiz WHERE (quiz.ID_ProfTurma_FK = $ID_ProfTurma) AND (ID_Aluno_FK = $RM) ORDER BY quiz.Data_Quiz";
                                $resultado_consulta3 = mysqli_query($conexao, $sql_consulta3);

                                if (mysqli_num_rows($resultado_consulta3) == 0) {
                                    echo "<div class='no-quizzes'>Nenhum quiz encontrado para esta matéria.</div>";
                                } else {
                                     while ($vetor2 = mysqli_fetch_array($resultado_consulta3)) {
                                        $data = $vetor2['Data_Quiz'];
                                        include_once "../../Funcoes_Backend/formata_data.php";
                                        $data = formata_data($data);
                                        $titulo_quiz = $vetor2['Titulo_Quiz'];

                                        $notatotal = $vetor2['NotaTotal']; ?>
                                        <div><?php echo $data . ' - ' . $titulo_quiz?></div>
                                        <div></div>
                                        <div><?php echo $notatotal ?></div>
                                <?php } 
                                }?>

                                


                               
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script>

        // Seleciona todos os botões de alternância
        let buttons = document.querySelectorAll('.toggle-quiz');

        // Adiciona um evento de clique para cada botão
        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                // Encontra o contêiner pai do botão
                let container = button.closest('.quiz-container');
                // Seleciona a lista de quizzes dentro do contêiner
                let quizList = container.querySelector('.quiz-list');

                let formata_seta = button.querySelector('.formata_seta');
                let formata_seta_gira = button.querySelector('.formata_seta_gira');

                // Alterna a exibição da lista de quizzes
                if (quizList.style.display === '' || quizList.style.display === 'none') {
                    quizList.style.display = 'flex'; // Define o display como flex
                    formata_seta.classList.replace('formata_seta', 'formata_seta_gira');
                    console.log("abriu");
                } else {
                    quizList.style.display = 'none'; // Oculta novamente
                    formata_seta_gira.classList.replace('formata_seta_gira', 'formata_seta');
                    console.log("fechou");
                }

                // Seleciona todas as divs com a classe 'quiz' dentro da lista
                let quizzes = quizList.querySelectorAll('.quiz');
                quizzes.forEach((quiz) => {
                    quiz.style.display = 'flex'; // Define o display como flex para cada quiz
                });
            });
        });

        function retorna() {
            window.location.href = "../Dashboard_aluno/DashBoard_Aluno.php";
        }

        function redireciona_config() {
            window.location.href = '../config_aluno/config_aluno.php';
        }

    </script>

</body>
</html>