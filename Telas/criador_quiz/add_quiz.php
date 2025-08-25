<?php 
    include "../../Banco_Dados/conexao.php";

    session_start();

    $_SESSION['Validacao_Quiz'] = 0;

    if ($_SESSION['Validacao_Professor'] == 1) {


    }
    else {
        header('Location: ../Login/login.php');
        mysqli_close($conexao);
        exit;
    }

    if ($_GET) {

        $erro = isset($_GET['erro']) ? $_GET['erro'] : null;

        if ($_GET['erro'] == 'input_vazios') {
            echo "<script>alert('Preencha todos os campos!');</script>";
        }
    }

    if ($_SESSION['Validacao_Quiz'] == 1) {
        $_SESSION['Validacao_Quiz'] = 0;
        header('Location: add_quiz.php');
    }

    if ($_POST) {

        $ID_ProfTurma = $_SESSION['ID_ProfTurma'];
        $Duracao = $_POST['duracao'];
        $Titulo = $_POST['titulo'];

        if (empty($Duracao) || empty($Titulo)) {
            header('Location: add_quiz.php?erro=input_vazios');
            exit;
        }

        date_default_timezone_set('America/Sao_Paulo');

        $data = date('Y-m-d');

        // Initialize $link before using it in the insert
        $link = '';

        $sql_quiz = "INSERT INTO quiz (Titulo_Quiz, Duracao_Quiz, Link_Quiz, Data_Quiz, ID_ProfTurma_FK) VALUES ('$Titulo', '$Duracao', '$link', '$data', $ID_ProfTurma)";

        $execute_quiz = mysqli_query($conexao, $sql_quiz);

        if ($execute_quiz) {

            $ID_Quiz = mysqli_insert_id($conexao);

            $link = 'lampada7.com.br/ceduca/Telas/Quiz/Template/Quiz_Aluno.php?ID_Quiz='.$ID_Quiz;

             // Atualizar o link no banco de dados
            $sql_update_link = "UPDATE quiz SET Link_Quiz = '$link' WHERE ID_Quiz = $ID_Quiz";
            mysqli_query($conexao, $sql_update_link);

            $_SESSION['Validacao_Quiz'] = 1;
            header ('Location: criador_quiz.php');
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz</title>
    <link rel="stylesheet" href="style_add_quiz.css">
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="redireciona_voltar()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" onclick="redireciona_config()">
    </div>

    <div class="espacamento_pos_menu"></div>
    <div class="containerCentralizanteForm">
        <h1>novo quiz</h1>
            <form action="add_quiz.php" method="post">
                <label for="tituloQuiz" id="labelTituloQuiz">Título do Quiz:</label>
                <input type="text" name="titulo" id="tituloQuiz">

                <label for="duracaoQuiz" id="labelDuracaoQuiz">Duração do Quiz:</label>
                <input type="number" name="duracao" id="duracaoQuiz" placeholder="Ex: 60" min="0" max="480">

                <input type="submit" value="Avançar" id="btnCriarQuiz" onclick="verificar()">
            </form>
    </div>
</body>
<script>
    let inputDuracao = document.querySelector("#duracaoQuiz")
    let inputTituloQuiz = document.querySelector("#tituloQuiz")

    function verificar(){
        if(inputDuracao.value == ""){
            inputDuracao.style.border ="2px solid red"
        }
        else {
            inputDuracao.style.border =""
        }
        if(inputTituloQuiz.value == ""){
            inputTituloQuiz.style.border ="2px solid red"
        }
        else {
            inputTituloQuiz.style.border =""
        }
    }

    function redireciona_voltar() {
        window.location.href = "../Dashboard_prof/tela_professor.php";
    }
    function redireciona_config() {
        window.location.href = "../config_professor/config_professor.php";
    }

</script>
</html>