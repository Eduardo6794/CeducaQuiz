<?php 

    include "../../Banco_Dados/conexao.php";

    session_start();

    if ($_SESSION['Validacao_Professor'] == 1) {

    } else {
        header ("Location: ../login/login.php");
        mysqli_close($conexao);
        exit;
    }


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Quiz</title>
    <link rel="stylesheet" href="style_tela_criar_quiz.css">
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2">
    </div>

    <div class="espacamento_pos_menu"></div>
    <p id="tituloDoQuiz">titulo do quiz</p>
    <form action="tela_final_criar_quiz.php" method="post">

        <?php 

            include "../../Banco_Dados/conexao.php";
        
            if ($_GET) {
                $ID_Quiz = $_GET['ID_Quiz'];

                $_SESSION['ID_Quiz'] = $ID_Quiz;

                $sql_pergunta = "SELECT * FROM perguntas WHERE ID_Quiz_FK = $ID_Quiz";

                $exec_pergunta = mysqli_query($conexao, $sql_pergunta);

                $contador = 1;

                while ($vetor_perguntas = mysqli_fetch_array($exec_pergunta)) {

                    $Titulo_Perg = $vetor_perguntas['Titulo_Perg'];
                    $ID_Pergunta = $vetor_perguntas['ID_Perg'];

                    $sql_consulta = "SELECT * FROM respostas WHERE ID_Perg_FK = $ID_Pergunta";

                    $result_consulta = mysqli_query($conexao, $sql_consulta);

                    while ($vetor_respostas = mysqli_fetch_array($result_consulta)) {

                        $Resposta = $vetor_respostas['Texto_Resp'];
                        $Resp_Correta = $vetor_respostas['RespCorretas_Resp'];
                        
                        if ($Resp_Correta == '1') {?>

                            <div class="containerPerguntaRespostaCorreta">
                                <span id="tituloPergunta">PERGUNTA <?php echo $contador;?></span>
                                <input type="text" id="inputPergunta" name="Titulo_Perg" value="<?php echo $Titulo_Perg?>">
                                <span id="tituloRespostaCorreta">Resposta Correta</span>
                                <input type="text" id="inputRespostaCorreta" name="Resposta" value="<?php echo $Resposta; ?>">
                                <input type="hidden" name="pergunta[]" value='<?php echo htmlspecialchars(json_encode(array(
                                        "Pergunta" => $contador,
                                        "Titulo_Perg" => $Titulo_Perg,
                                        "Resposta" => $Resposta
                                )), ENT_QUOTES, 'UTF-8'); ?>'>
                            </div>


                            
                        <?php      
                    } else {

                        }
                        
                    }  
                    $contador = $contador + 1;            
                }
            }
        ?>
        <!--<button id="btnCriarQuiz" type="button">FINALIZAR QUIZ</button>-->
    </form>
    <button id="btnCriarQuiz" type="button" onclick="redireciona_tela_professor()">FINALIZAR QUIZ</button>
</body>
<script>
    function redireciona_tela_professor() {

        window.location.href="../Dashboard_prof/tela_professor.php";

    }
</script>
</html>