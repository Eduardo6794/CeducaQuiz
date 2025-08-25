<?php 
    
    $select = "SELECT * FROM quiz WHERE ID_Quiz = $ID_Quiz";
    $resultado = mysqli_query($conexao, $select);
    $dados = mysqli_fetch_array($resultado);

    $Titulo_Quiz = $dados['Titulo_Quiz'];  
    $ID_ProfTurma_FK = $dados['ID_ProfTurma_FK'];

    $Nome_Prof = $_SESSION['Nome_Prof'];
    $Senha_Prof = $_SESSION['Senha_Prof'];

    $select = "SELECT Materia_Prof, prof.Nome_Prof AS Nome_Prof, turma.Nome_Turma AS Nome_Turma 
        FROM prof_turma 
        INNER JOIN professor prof ON prof_turma.ID_Prof_FK = prof.ID_Prof 
        INNER JOIN turma ON prof_turma.ID_Turma_FK = turma.ID_Turma 
        WHERE Nome_Prof = '$Nome_Prof' 
        AND Senha_Prof = '$Senha_Prof' 
        AND ID_ProfTurma = $ID_ProfTurma_FK";

    $resultado = mysqli_query($conexao, $select);
    $dados = mysqli_fetch_array($resultado);
    $Materia_Prof = $dados['Materia_Prof'];
    $Nome_Prof = $dados['Nome_Prof'];
    $Nome_Turma = $dados['Nome_Turma'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo1</title>

    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }
        .cabecalho {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: black 3px solid;
            width: 100%;
        }
        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px;
            border-bottom: black 1px solid;
            width: 100%;
        }
        .info {
            width: 100%;
            padding: 1px;
            display: flex;
            flex-direction: row;
            justify-content: start;
            align-items: center;
            height: 80px;
            border-bottom: black 1px solid;
        }
        .a {
            width: 50%;
            height: 100%;
            padding-left: 6px;
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
            align-items: start;
            border-right: black 1px solid;
        }
        .b {
            width: 25%;
            height: 100%;
            padding-left: 6px;
            border-right: black 1px solid; 
        }
        .c {
            width: 25%;
            height: 100%;
            padding-left: 6px;
        }
        .aluno {
            height: 50px;
            width: 100%;
            display: flex;
            justify-content: start;
            align-items: center;
            padding: 3px;
            padding-left: 6px;
        }
        .perguntas {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: start;
            align-items: start;
            gap: 10px;
        }
        .pergunta {
            width: 100%;
            margin-bottom: 10px;
        }
        .text_perg {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="cabecalho">
        <div class="logo">
            <img src="../../images/logo2.png" alt="">
        </div>
        <div class="info">
            <div class="a">
                <span>Componente Curricular: <?php echo $Materia_Prof; ?></span>
                <span>Professor: <?php echo $Nome_Prof; ?></span>
            </div>
            <div class="b">
                <span>Data:</span>
            </div>
            <div class="c">
                <span>Nota:</span>
            </div>
        </div>
        <div class="aluno">
            <span>Nome:___________________________________________________________________________<?php echo $Nome_Turma ?></span>
        </div>
    </div>


    <div>
        <h1><?php echo $Titulo_Quiz; ?></h1>
    </div>

    <div class="perguntas">
        <?php 
        $select_perg = "SELECT * FROM perguntas WHERE ID_Quiz_FK = $ID_Quiz";
        $resultado = mysqli_query($conexao, $select_perg);

        $contador = 1;

        while($pergunta = mysqli_fetch_array($resultado)) {

            $contador2 = 1;
            $Titulo_Perg = $pergunta['Titulo_Perg'];
            $linkimg = $pergunta['linkimg'];
            $linkimg = str_replace("../", "", $linkimg);
            $linkimg = "../" . $linkimg;
            $ID_Pergunta = $pergunta['ID_Perg'];

            echo "<div class='pergunta'>";
            if (!empty($pergunta['linkimg'])) {

                if ($linkimg != "../Quiz/img_quiz/") {
                    echo "<img src='$linkimg' alt='Imagem da pergunta' style='width:100px; height:100px;'>";
                }   
            }
            echo "<div class='text_perg'>";
            echo "<span>$contador) $Titulo_Perg</span>";
            echo "</div>";

            $select_resposta = "SELECT * FROM respostas WHERE ID_Perg_FK = $ID_Pergunta";
            $resultado_resposta = mysqli_query($conexao, $select_resposta);

            while ($resposta = mysqli_fetch_array($resultado_resposta)) {
                $Texto_Resp = $resposta['Texto_Resp'];
                $ID_Resposta = $resposta['ID_Resp'];

                if ($contador2 == 1) {
                    $alternativa = "a";
                } 
                else if ($contador2 == 2) {
                    $alternativa = "b";
                } 
                else if ($contador2 == 3) {
                    $alternativa = "c";
                } 
                else if ($contador2 == 4) {
                    $alternativa = "d";
                } 
                else if ($contador2 == 5) {
                    $alternativa = "e";
                }

                echo "<div>";
                echo "<span>$alternativa) $Texto_Resp</span>";
                echo "</div>";

                $contador2++;
            }

            echo "</div>"; // fecha .pergunta
            $contador++;
        }
        ?>
    </div>

</body>
</html>