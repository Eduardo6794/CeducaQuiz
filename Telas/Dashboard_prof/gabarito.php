<?php 

    include "../../Banco_Dados/conexao.php";
    session_start();

    if ($_SESSION['Validacao_Professor'] == 1) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Quiz'])) {
                $_SESSION['ID_Quiz'] = $_POST['ID_Quiz'];
                header("Location: gabarito.php");
                exit;
            }

            if (!isset($_SESSION['ID_Quiz'])) {
                header("Location: tela_professor_info_quiz_feitos.php");
                exit;
            }

            $ID_Quiz = $_SESSION['ID_Quiz'];

            $sql_select_perg = "SELECT Titulo_Quiz FROM quiz WHERE ID_Quiz = $ID_Quiz";

            $exec_select_perg = mysqli_query($conexao, $sql_select_perg);

            $vetor = mysqli_fetch_assoc($exec_select_perg);

            $Titulo_Quiz = $vetor['Titulo_Quiz'];

    } else {
        header ("Location: ../login/login.php");
        mysqli_close($conexao);
        exit;
    }?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gabarito</title>
    <link rel="stylesheet" href="style_tela_criar_quiz.css">
    <link rel="stylesheet" href="../tela_final_criar_quiz/style_tela_criar_quiz.css">
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="retorna()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2">
    </div>

    <div class="espacamento_pos_menu"></div>
    <p id="tituloDoQuiz"><?php echo $Titulo_Quiz;?></p>
    <form action="tela_final_criar_quiz.php" method="post">

        <?php 

            include "../../Banco_Dados/conexao.php";
        
                $ID_Quiz = $_SESSION['ID_Quiz'];

                echo "<script>console.log('$ID_Quiz')</script>";

                $sql_pergunta = "SELECT * FROM perguntas WHERE ID_Quiz_FK = $ID_Quiz";

                $exec_pergunta = mysqli_query($conexao, $sql_pergunta);

                $contador = 1;

                while ($vetor_perguntas = mysqli_fetch_array($exec_pergunta)) {

                    $Titulo_Perg = $vetor_perguntas['Titulo_Perg'];
                    $ID_Pergunta = $vetor_perguntas['ID_Perg'];

                    $sql_consulta = "SELECT * FROM respostas WHERE ID_Perg_FK = $ID_Pergunta";

                    $result_consulta = mysqli_query($conexao, $sql_consulta);?>

                    <div class="containerPerguntaRespostaCorreta">
                                <span id="tituloPergunta">PERGUNTA <?php echo $contador;?></span>
                                <input type="text" id="inputPergunta" name="Titulo_Perg" value="<?php echo $Titulo_Perg?>">
                                <span style="font-family: 'Poppins',Arial;">Respostas</span>
                    </div>
                    <?php
                    while ($vetor_respostas = mysqli_fetch_array($result_consulta)) {

                        $Resposta = $vetor_respostas['Texto_Resp'];
                        $Resp_Correta = $vetor_respostas['RespCorretas_Resp'];?>
                        
            

                            <div class="containerPerguntaRespostaCorreta">
                                <!--<?php if ($Resp_Correta == 1) {
                                    echo '<span id="tituloRespostaCorreta">Resposta Correta</span>';
                                } else {
                                    echo '<span id="tituloRespostaCorreta">Resposta</span>';
                                }?>-->
                                <input type="text" id="inputRespostaCorreta" name="Resposta" value="<?php echo $Resposta;?>" style="<?php if ($Resp_Correta == 1) { echo "background-color:green; color:white;"; } ?>">
                            </div>


                            
                        <?php 
                        
                    }  
                    $contador = $contador + 1;            
                }
        ?>
        <!--<button id="btnCriarQuiz" type="button">FINALIZAR QUIZ</button>-->
    </form>
</body>
<script>
    function retorna() {
        window.location.href = "tela_professor_info_quiz_feitos.php"
    }
</script>
</html>