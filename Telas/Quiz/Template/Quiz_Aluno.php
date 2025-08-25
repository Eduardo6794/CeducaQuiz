<?php 

    include "../../../Banco_Dados/conexao.php";
    session_start();

    // Prevent output before header() calls
    ob_start();

    // Check if session variable is set before accessing
    if (isset($_SESSION['Validacao_Aluno']) && $_SESSION['Validacao_Aluno'] == 1) {
        if ($_GET) {

            //Irá pegar o ID_Quiz presente na URL
            $ID_Quiz = $_GET['ID_Quiz'];

            $nome = $_SESSION['Nome_Aluno'];
            $senha = $_SESSION['Senha_Aluno'];

            $sql_situa = "SELECT * FROM aluno WHERE (Nome_Aluno = '$nome') AND (Senha_Aluno = '$senha') AND (Situacao_Aluno = 'Ativo')";

            $verif_consulta  = mysqli_query($conexao, $sql_situa);

            if (mysqli_num_rows($verif_consulta) == 0) {
                header("Location: ../login/login.php?erro=aluno_nao_ativo");
                exit;
            } 

            $sql_aluno = "SELECT RM, Cod_Escola FROM aluno WHERE (Nome_Aluno = '$nome') AND (Senha_Aluno = '$senha')";

            $exec_aluno = mysqli_query($conexao, $sql_aluno);

            $vetor_aluno = mysqli_fetch_array($exec_aluno);

            $RM = $vetor_aluno['RM'];
            $Cod_Escola_Aluno = $vetor_aluno['Cod_Escola'];

            //codigo novo
            $sql_verif_escola = "SELECT prof_turma.ID_ProfTurma FROM quiz INNER JOIN prof_turma ON quiz.ID_ProfTurma_FK = prof_turma.ID_ProfTurma WHERE ID_Quiz = $ID_Quiz";
            $exec_verif_escola = mysqli_query($conexao, $sql_verif_escola);

            if (mysqli_num_rows($exec_verif_escola) > 0) {

                $sql_verif_professor = "SELECT * FROM prof_turma INNER JOIN professor ON prof_turma.ID_Prof_FK = professor_ID_Prof WHERE professor.Cod_Escola = $Cod_Escola_Aluno";
                $exec_verif_professor = mysqli_query($conexao, $sql_verif_escola);

                if (mysqli_num_rows($exec_verif_professor) == 0) {

                    header("Location: ../login/login.php?erro=escola_imcompativel");
                    exit;


                }




            }
            
            //---------

            $sql_select = "SELECT prof_turma.ID_Turma_FK AS ID_Turma_FK FROM quiz INNER JOIN prof_turma ON quiz.ID_ProfTurma_FK = prof_turma.ID_ProfTurma WHERE ID_Quiz = $ID_Quiz";

            $exec_select = mysqli_query($conexao, $sql_select);

            if (mysqli_num_rows($exec_select) > 0) {

                $vetor_turma = mysqli_fetch_array($exec_select);

                $ID_Turma_FK = $vetor_turma['ID_Turma_FK'];

                $sql_validacao = "SELECT * FROM curso_aluno WHERE (ID_Aluno_FK = $RM) AND (ID_Turma_FK = $ID_Turma_FK)";

                $exec_validacao = mysqli_query($conexao, $sql_validacao);

                if (mysqli_num_rows($exec_validacao) == 0) {
                    header("Location:../../login/login.php?erro=turma_quiz_imcompativel");
                    mysqli_close($conexao);
                    exit;
                }

                $sql_consulta_aluno = "SELECT * FROM quiz_aluno WHERE ID_Aluno_FK = $RM AND ID_Quiz_FK = $ID_Quiz";
                $exec_consulta_aluno = mysqli_query($conexao, $sql_consulta_aluno);

                if (mysqli_num_rows($exec_consulta_aluno) > 0) {

                    echo "<script>alert(Você já fez esse quiz!)</script>";
                    header('Location: ../../Dashboard_aluno/DashBoard_Aluno.php?erro=quiz_feito');
                    mysqli_close($conexao);
                    exit;

                }


            } else {
                header('Location: ../Dashboard_aluno/DashBoard_Aluno.php');
                mysqli_close($conexao);
                exit;
            }

            //Buscar a Duração do Quiz
            $sql_duracao = "SELECT Duracao_Quiz FROM quiz WHERE ID_Quiz = $ID_Quiz";
            $exec_duracao = mysqli_query($conexao, $sql_duracao);
            $vetor_duracao = mysqli_fetch_array($exec_duracao);
            $Duracao = $vetor_duracao['Duracao_Quiz'];

            //Buscar as Perguntas do Quiz
            $sql_consulta = "SELECT ID_Perg, Titulo_Perg, linkimg FROM perguntas WHERE ID_Quiz_FK = $ID_Quiz";
            $resultado = mysqli_query($conexao, $sql_consulta);

            //Abrir um array
            $perguntas = [];

            //Irá buscar as informações da perguntas e respostas e colocar dentro de um array
            while ($dados = mysqli_fetch_array($resultado)) {

                $ID_Perg = $dados['ID_Perg'];

                $Titulo_Perg = $dados['Titulo_Perg'];

                $linkimg = $dados['linkimg'];

                $sql_consulta1 = "SELECT ID_Resp, Texto_Resp, RespCorretas_Resp FROM respostas WHERE ID_Perg_FK = $ID_Perg";
                $resultado1 = mysqli_query($conexao, $sql_consulta1);
                $respostas = [];

                //Irá colocar as informações das respostas dentro do array respostas
                while ($dados1 = mysqli_fetch_array($resultado1)) {
                    $respostas[] = [
                        'ID_Resp' => $dados1['ID_Resp'],
                        'Texto_Resp' => $dados1['Texto_Resp'],
                        'RespCorretas_Resp' => $dados1['RespCorretas_Resp']
                    ];
                }
                //Está colocando o array respostas dentro do array perguntas
                $perguntas[] = [
                    'ID_Perg' => $ID_Perg,
                    'Titulo_Perg' => $Titulo_Perg,
                    'linkimg' => $linkimg,
                    'Respostas' => $respostas
                ];
            }
        }
    } else {
        if (isset($_GET['ID_Quiz'])) {
            $ID_Quiz = $_GET['ID_Quiz'];
        } else {
            $ID_Quiz = null;
        }
        if ($ID_Quiz != null) {
            header("Location:../../login/login.php?ID_Quiz=$ID_Quiz");
            mysqli_close($conexao);
            exit;

        } else {
            header("Location:../../login/login.php");
            mysqli_close($conexao);
            exit;
        }
        
    }

    // Flush output buffer before any HTML output
    ob_end_flush();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #243A69;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        #quiz-container {
            background: #D9D9D9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        #timer {
            font-size: 1.5em;
            text-align: center;
            margin-bottom: 20px;
        }
        #question-title {
            font-size: 1.2em;
            margin-bottom: 10px;
            width: 100%;
            height: 150px;
            overflow-y: auto; /* ou 'scroll' se quiser que a barra apareça sempre */
            word-wrap: break-word; /* CORRETO */
            
        }
        #respostas label {
            display: block;
            margin-bottom: 10px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!--Corpo da Página-->
    <div id="quiz-container">
        <div id="timer">
            <span id="minutos">00</span>:<span id="segundos">00</span>
        </div>
        <img id="imagem" src="" style="display: none;">
        <h1 id="question-title"></h1>
        <div id="respostas"></div>
        <button onclick="nextQuestion()">Próxima</button>
    </div>
    <script>
    //Irá convertar o array do php para array js
    let perguntas = <?php 
        if (isset($perguntas) && !empty($perguntas)) {
            
           echo json_encode($perguntas);

        } else {
            echo '[]'; // Retorna um array vazio se $perguntas não estiver definido ou estiver vazio
        }
    ?>;

    let currentQuestionIndex = 0;
    let respostasAluno = [];

    // Duracao do Quiz
    let minutos = <?php echo $Duracao; ?> - 1;
    let segundos = 60;

    const imagem = document.getElementById('imagem');

    // Restaura o tempo do cronômetro do localStorage, se disponível
    if (localStorage.getItem('tempoRestante')) {
        const tempoRestante = JSON.parse(localStorage.getItem('tempoRestante'));
        minutos = tempoRestante.minutos;
        segundos = tempoRestante.segundos;
    }

    function showQuestion(index) {
        if (index >= perguntas.length) {
            calculateScore();
            return;
        }

        let pergunta = perguntas[index];
        document.getElementById('question-title').innerText = pergunta.Titulo_Perg;

        if (pergunta.linkimg != null && pergunta.linkimg != "") {
            imagem.src = pergunta.linkimg;
            imagem.style.display = 'flex'; // Esconde a imagem se não houver
        } else {
            imagem.style.display = 'none'; // Esconde a imagem se não houver
        }

        let respostasContainer = document.getElementById('respostas');
        respostasContainer.innerHTML = '';

        pergunta.Respostas.forEach((resposta) => {
            let label = document.createElement('label');
            label.innerHTML = `<input type="radio" name="resposta" value="${resposta.ID_Resp}"> ${resposta.Texto_Resp}`;
            respostasContainer.appendChild(label);
        });
    }

    // Salva o índice da pergunta atual no localStorage
    function nextQuestion() {
        let selected = document.querySelector('input[name="resposta"]:checked');
        if (selected) {
            respostasAluno.push(selected.value);
            currentQuestionIndex++;
            localStorage.setItem('indiceAtual', currentQuestionIndex); // Salva o índice
            showQuestion(currentQuestionIndex);
        } else {
            alert('Por favor, selecione uma resposta.');
        }
    }

      // Restaura o índice da pergunta atual ao carregar a página
      if (localStorage.getItem('indiceAtual')) {
        currentQuestionIndex = parseInt(localStorage.getItem('indiceAtual'), 10);
        // Reinicia o índice se for inválido
        if (currentQuestionIndex >= perguntas.length) {
            currentQuestionIndex = 0;
            localStorage.removeItem('indiceAtual'); // Remove o índice inválido
        }
    }

    function calculateScore() {
        let correctAnswers = 0;

        perguntas.forEach((pergunta, index) => {
            let respostaCorreta = pergunta.Respostas.find(r => r.RespCorretas_Resp == 1).ID_Resp;
            let respostaAluno = respostasAluno[index] || null;
            if (respostaAluno == respostaCorreta) {
                correctAnswers++;
            }
        });

        let scoreString = `${correctAnswers} | ${perguntas.length}`;
        document.getElementById('quiz-container').innerHTML = `Sua nota: ${scoreString}`;
    
        // Limpa o localStorage ao finalizar o quiz
        localStorage.removeItem('tempoRestante');

        saveScore(scoreString);

        // Exibe a nota por 5 segundos e redireciona para a dashboard
        setTimeout(() => {
            window.location.href = "../../Dashboard_aluno/DashBoard_Aluno.php";
        }, 5000); // 5000ms = 5 segundos
    }

    function saveScore(scoreString) {
    // Calcula o tempo restante em minutos (pode ajustar para segundos se preferir)
    let tempoRestante = minutos + (segundos / 60);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "save_score.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert('Nota salva com sucesso!');
        }
    };
    xhr.send(
        "ID_Quiz=" + <?php echo $ID_Quiz; ?> +
        "&score=" + encodeURIComponent(scoreString) +
        "&tempo_restante=" + encodeURIComponent(tempoRestante)
    );
}

    let cronometroAtivo = false;

function carregarRelogio() {
    if (cronometroAtivo) return; // Evita múltiplas execuções
    cronometroAtivo = true;

    function atualizarRelogio() {
            if (minutos === 0 && segundos === 0) {
                alert("Tempo esgotado! Sua nota será calculada com base nas respostas fornecidas.");
                calculateScore();
                return;
            }

            if (segundos > 0) {
                segundos--;
            } else {
                minutos--;
                segundos = 59;
            }

            document.getElementById("minutos").innerText = minutos.toString().padStart(2, '0');
            document.getElementById("segundos").innerText = segundos.toString().padStart(2, '0');

            // Salva o tempo restante no localStorage
            localStorage.setItem('tempoRestante', JSON.stringify({ minutos, segundos }));

            setTimeout(atualizarRelogio, 1000);
        }

        atualizarRelogio();
    }

    window.onload = function() {
        carregarRelogio();
        showQuestion(currentQuestionIndex);
    };

    // Limpa o localStorage ao finalizar o quiz
    window.onbeforeunload = function() {
        if (minutos === 0 && segundos === 0) {
            localStorage.removeItem('tempoRestante');
        }
    };
</script>
</body>
</html>