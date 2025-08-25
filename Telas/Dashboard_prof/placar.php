<?php 

    include "../../Banco_Dados/conexao.php";

    session_start();

    if ($_SESSION['Validacao_Professor'] == 1) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Quiz'])) {
                $_SESSION['ID_Quiz'] = $_POST['ID_Quiz'];
                header("Location: placar.php");
                exit;
        }

        if (!isset($_SESSION['ID_Quiz'])) {
                header("Location: tela_professor_info_quiz_feitos.php");
                exit;
        }

        $ID_Quiz = $_SESSION['ID_Quiz'];


    } else {
        header("Location: ../login/login.php");
        mysqli_close($conexao);
        exit;
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placar</title>

    <link rel="stylesheet" href="placar.css">

    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

<div class="barra_menu">
    <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="redireciona_volta()">
    <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
    <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2">
</div>

<div class="classificados">
    <div>
        <h1>Classificados</h1>
    </div>
    <div class="containeralunosclassif">
        <?php 

                $ID_Quiz = $_SESSION['ID_Quiz'];

                $sql_consulta = "SELECT aluno.Nome_Aluno AS Nome_Aluno, NotaTotal, Duracao_Aluno, aluno.Nome_Social AS Nome_Social FROM quiz_aluno INNER JOIN aluno ON quiz_aluno.ID_Aluno_FK = aluno.RM WHERE ID_Quiz_FK = $ID_Quiz ORDER BY CAST(SUBSTRING_INDEX(NotaTotal, ' ',1) AS UNSIGNED) DESC, Duracao_Aluno ASC LIMIT 3";

                $exec_consulta = mysqli_query($conexao, $sql_consulta);
                $contador = 1;

                while ($vetor_aluno = mysqli_fetch_array($exec_consulta)) {

                    if ($vetor_aluno['Nome_Social'] != null) {
                        $nome = $vetor_aluno['Nome_Social'];
                    } else {
                        $nome = $vetor_aluno['Nome_Aluno'];
                    }

                    $nota = $vetor_aluno['NotaTotal'];
                    $duracao = $vetor_aluno['Duracao_Aluno'];


                    $duracao = floatval($duracao);
                    $minutos = floor($duracao);
                    $segundos = round(($duracao - $minutos) * 60);

                    if ($segundos >= 60) {
                        $minutos += floor($segundos / 60);
                        $segundos = $segundos % 60;
                    }

                    // Formata segundos para sempre ter dois dígitos
                    $segundos = str_pad($segundos, 2, '0', STR_PAD_LEFT);

                    $tempo_restante = $minutos . ':' . $segundos;

                    if ($contador == 1) {
                        $primeiro_lugar = true;
                    } else if ($contador == 2) {
                        $segundo_lugar = true;
                    } else if ($contador == 3) {
                        $terceiro_lugar = true;
                    }

                    if ($contador == 2) {
                        echo "<div class='alunoclassif' style='display:none;' data-pos='2'>";
                        echo "<h1>2º Lugar</h1>";
                        echo "<h2 style='margin:0;'>$nome - $nota</h2>";
                        echo "<h3 style='margin:0;'>$tempo_restante</h3>";
                        echo "<div class='top2'></div>";
                        echo "<img src='../../icons/top2.png' style='width:60px; height:60px;'></img>";
                        echo "</div>";

                    }
                    else if ($contador == 1) {
                        echo "<div class='alunoclassif' style='display:none;' data-pos='1'>";
                        echo "<h1>1º Lugar</h1>";
                        echo "<h2 style='margin:0;'>$nome - $nota</h2>";
                        echo "<h3 style='margin:0;'>$tempo_restante</h3>";
                        echo "<div class='top1'></div>";
                        echo "<img src='../../icons/top1.png' style='width:60px; height:60px;'></img>";
                        echo "</div>";
                    } 
                    else if ($contador == 3) {
                        echo "<div class='alunoclassif' style='display:none;' data-pos='3'>";
                        echo "<h1>3º Lugar</h1>";
                        echo "<h2>$nome - $nota</h2>";
                        echo "<h3 style='margin:0;'>$tempo_restante</h3>";
                        echo "<div class='top3'></div>";
                        echo "<img src='../../icons/top3.png' style='width:60px; height:60px;'></img>";
                        echo "</div>";
                    } else {
                        break;
                    }

                    $contador = $contador + 1;
                }   
        ?>
    </div>
</div>
<div class="restantealunos">
    <?php
            $ID_Quiz = $_SESSION['ID_Quiz'];

            //Função CAST() converte a string NotaTotal para um número inteiro, permitindo a ordenação correta.
            //Função SUBSTRING_INDEX() é usada para extrair a parte numérica da string NotaTotal, que é separada por um espaço.
            //A consulta agora ordena os alunos primeiro pela nota (em ordem decrescente) e, em caso de empate, pela duração (em ordem crescente).

            $sql_consulta = "SELECT aluno.Nome_Aluno AS Nome_ALuno, NotaTotal, Duracao_Aluno, aluno.Nome_Social AS Nome_Social FROM quiz_aluno INNER JOIN aluno ON quiz_aluno.ID_Aluno_FK = aluno.RM WHERE ID_Quiz_FK = $ID_Quiz ORDER BY CAST(SUBSTRING_INDEX(NotaTotal, ' ',1) AS UNSIGNED) DESC, Duracao_Aluno ASC LIMIT 3, 1000";

            $exec_consulta = mysqli_query($conexao, $sql_consulta);

            if (mysqli_num_rows($exec_consulta) == 0) {
                echo "<p id='alunoQueFizeramQuiz'>Nenhum aluno encontrado</p>";
            } else {

                $contador = 4;

                while ($vetor_aluno = mysqli_fetch_array($exec_consulta)) {

                    $nome = $vetor_aluno['Nome_ALuno'];
                    $nota = $vetor_aluno['NotaTotal'];
                    $duracao = $vetor_aluno['Duracao_Aluno'];



                    $duracao = floatval($duracao);
                    $minutos = floor($duracao);
                    $segundos = round(($duracao - $minutos) * 60);

                    if ($segundos >= 60) {
                        $minutos += floor($segundos / 60);
                        $segundos = $segundos % 60;
                    }

                    // Formata segundos para sempre ter dois dígitos
                    $segundos = str_pad($segundos, 2, '0', STR_PAD_LEFT);

                    $tempo_restante = $minutos . ':' . $segundos;
     
                    echo "<div style='color:white;'>";
                    echo "<p id='alunoQueFizeramQuiz'>$contador"."° $nome - $nota</p>";
                    echo "<p id='alunoQueFizeramQuiz'>$tempo_restante</p>";
                    echo "</div>";


                    $contador = $contador + 1;
                } 
            }  
    ?>
    <button id="btnEnviar" onclick="redireciona_volta()">Voltar</button>
</div>
</body>
<script>
    function redireciona_volta() {
        window.location.href = "../Dashboard_prof/tela_professor_info_quiz_feitos.php";
    }

    document.addEventListener("DOMContentLoaded", () => {
        const container = document.querySelector(".containeralunosclassif");

        // Seleciona as divs de acordo com a posição
        const top1 = document.querySelector(".alunoclassif[data-pos='1']");
        const top2 = document.querySelector(".alunoclassif[data-pos='2']");
        const top3 = document.querySelector(".alunoclassif[data-pos='3']");

        // Remove as divs do DOM para reordenar
        if (top1) container.removeChild(top1);
        if (top2) container.removeChild(top2);
        if (top3) container.removeChild(top3);

        // Adiciona as divs na ordem desejada
        if (top2) container.appendChild(top2);
        if (top1) container.appendChild(top1);
        if (top3) container.appendChild(top3);

        // Exibe as divs com animação
        document.querySelectorAll('.alunoclassif').forEach((element, index) => {
            setTimeout(() => {
                element.style.display = 'flex';
            }, index * 2000); // 1000ms = 1 segundo
        });
    });
</script>
</html>