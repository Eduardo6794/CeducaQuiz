<?php 

    include "../../Banco_Dados/conexao.php";

    session_start();

    // Verifica se a sessão está definida e válida
    if (!isset($_SESSION['Validacao_Professor']) || $_SESSION['Validacao_Professor'] != 1) {
        header("Location: ../login/login.php");
        mysqli_close($conexao);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Quiz'])) {
        $_SESSION['ID_Quiz'] = $_POST['ID_Quiz'];
        header("Location: tela_professor_info_quiz_feitos.php");
        exit;
    }

    if (!isset($_SESSION['ID_Quiz'])) {
        header("Location: tela_professor_quiz_feitos.php");
        exit;
    }

    $ID_Quiz = $_SESSION['ID_Quiz'];


    $sql_consulta = "SELECT Link_Quiz FROM quiz WHERE ID_Quiz = $ID_Quiz";

    $resultado = mysqli_query($conexao, $sql_consulta);

    $dados = mysqli_fetch_array($resultado);

    $Link = $dados['Link_Quiz'];

    echo "<script>console.log('$ID_Quiz')</script>";

    echo "<script>console.log('$Link')</script>";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações do Quiz</title>
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="style_tela_professor_info_quiz_feitos.css">

    <style>
        .aus_aluno {
            font-family: 'Poppins', Arial;
        }
    </style>
</head>
<body onload="criarQuiz()" style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="redireciona_anterior()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo" onclick="redirecionaDashBoardProfessor()">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" onclick="redireciona_config()">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div class="conatinerTituloTurma">
        <p>Quiz Selecionado</p>
    </div>

    <div class="conatinerTituloTurmaDoQuizSelecionado">
        <?php 
        
            include "../../Banco_Dados/conexao.php";

                $ID_Turma_FK = $_SESSION['ID_Turma_FK'];

                $sql_consulta = "SELECT curso.Nome_Curso AS Nome_Curso FROM turma INNER JOIN curso ON turma.ID_Curso_FK = curso.ID_Curso WHERE ID_Turma = $ID_Turma_FK";

                $resultado = mysqli_query($conexao, $sql_consulta);

                $dados = mysqli_fetch_array($resultado);

                $Nome_Curso = $dados['Nome_Curso'];
 
        ?>
        <p>Técnico em <?php echo $Nome_Curso;?></p>
    </div>

    <div class="conatinerQuizSelecionado">
        <?php 
        
                $ID_Quiz = $_SESSION['ID_Quiz'];

                $sql_consulta1 = "SELECT Titulo_Quiz FROM quiz WHERE ID_Quiz = $ID_Quiz";

                $resultado1 = mysqli_query($conexao, $sql_consulta1);

                $dados1 = mysqli_fetch_array($resultado1);

                $Titulo_Quiz = $dados1['Titulo_Quiz'];
   
        ?>

        <p><?php echo $Titulo_Quiz;?></p>
    </div>

    <div class="containerQrCodeDoQuiz">
        <img src="" alt="" id="qrCodeImg">
    </div>

    <div>
        <div class="container">
            <input type="text" value="Aqui está o link" id="text-to-copy" readonly>
            <button onclick="copyToClipboard()" id="copy-btn" title="Copie o link para compartilhar o quiz">Copiar</button>
        </div>
    </div>
    
    <div class="containerAlunosQueFizeramQuiz">
        <!--<div class="AlunoENotaDoQuiz">
            <p id="alunoQueFizeramQuiz">Pedro Henrique Ernesto De Souza</p>
            <div class="notaAlunoNumeroQuestoes">
                <span id="notaAluno">09 </span>|<span id="numeroQuestoes"> 10</span>
            </div>
        </div>-->
        <?php 
        
            include "../../Banco_Dados/conexao.php";

                $ID_Quiz = $_SESSION['ID_Quiz'];

                $sql_consulta2 = "SELECT aluno.Nome_Aluno AS Nome_Aluno, NotaTotal FROM quiz_aluno INNER JOIN aluno ON aluno.RM = quiz_aluno.ID_Aluno_FK WHERE ID_Quiz_FK = $ID_Quiz ORDER BY Nome_Aluno";

                $resultado2 = mysqli_query($conexao, $sql_consulta2);

                $contador = 1;

                while ($dados2 = mysqli_fetch_array($resultado2)) {
                    $Nome_Aluno = $dados2['Nome_Aluno'];
                    $NotaTotal = $dados2['NotaTotal'];?>

                    <div class="AlunoENotaDoQuiz">
                        <p id="alunoQueFizeramQuiz"><?php echo $Nome_Aluno;?></p>
                        <div class="notaAlunoNumeroQuestoes">
                            <span id="notaAluno"><?php echo $NotaTotal;?> </span><span id="numeroQuestoes"></span>
                        </div>
                    </div>
                <?php 
                $contador = $contador + 1;
                } 
                if (mysqli_num_rows($resultado2) == 0) {
                    $contador = 0;
                    echo "<p class='aus_aluno'>Nenhum aluno fez esse quiz</p>";
                }
        ?>
        <?php if ($contador >= 1) { ?>
            
        <?php }?>
    </div>
    <div style="display:flex; flex-direction:row;margin-left: 10px; margin-top: 10px; gap:10px; flex-wrap: wrap;">
        <div>
            <form action="relatorio.php" method="post">
                <input type="hidden" name="ID_Quiz" value="<?php echo $ID_Quiz;?>">
                <button id="btnEnviar" style="width: 150px;">Imprimir</button>
            </form>
        </div>
        <div>
            <form action="gabarito.php" method="post">
                <input type="hidden" name="ID_Quiz" value="<?php echo $ID_Quiz;?>">
                <button id="btnEnviar" style="width: 150px;">Gabarito</button>
            </form>
        </div>
        <div>
            <form action="placar.php" method="post">
                <input type="hidden" name="ID_Quiz" value="<?php echo $ID_Quiz;?>">
                <button id="btnEnviar" style="width: 150px;">Placar</button>
            </form>
        </div>
    </div>
</body>
<script>
        const qrCode = document.querySelector("#qrCodeImg");
        const linkBancoDados ="<?php echo $Link;?>"

        console.log(linkBancoDados);


        window.onload = function() {
            criarQuiz();
            const textElement = document.querySelector("#text-to-copy")
            textElement.value = linkBancoDados
        };

        function criarQuiz(){
            if (linkBancoDados) {
                qrCode.src = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${linkBancoDados}`;
            }
        }

        function redireciona_placar() {
            window.location.href = "placar.php";
        }

        function redireciona_config() {
            window.location.href = '../config_professor/config_professor.php';
        }

        function redireciona_anterior() {
            window.location.href = '../Dashboard_prof/tela_professor_quiz_feitos.php';
        }

       // Função para copiar o link para a área de transferência
// Função para copiar o link para a área de transferência
function copyToClipboard() {
    const textElement = document.querySelector("#text-to-copy")
    textElement.value = linkBancoDados

    if (textElement) {
        // Selecionar o conteúdo do campo de input
        textElement.select();
        textElement.setSelectionRange(0, 99999);  // Para dispositivos móveis

        try {
            // Tentar copiar o texto para a área de transferência
            const successful = document.execCommand("copy");

            if (successful) {
                changeButtonText("Copiado!");
                changeButtonColor("green"); // Alterar a cor do botão para verde
            } else {
                changeButtonText("Falha ao copiar");
                changeButtonColor("red"); // Alterar a cor do botão para vermelho
            }
        } catch (err) {
            // Caso o comando de cópia falhe
            console.error("Erro ao tentar copiar", err);
            changeButtonText("Falha ao copiar");
            changeButtonColor("red");
        }
    }
}

// Função para alterar o texto e cor do botão
function changeButtonText(text) {
    const button = document.getElementById("copy-btn");
    button.textContent = text; // Mudar o texto do botão para "Copiado!" ou erro

    // Restaurar o texto original do botão após 2 segundos
    setTimeout(() => {
        button.textContent = "Copiar";
        button.style.backgroundColor = ""; // Restaura a cor original
    }, 2000);
}

// Função para alterar a cor do botão (feedback visual)
function changeButtonColor(color) {
    const button = document.getElementById("copy-btn");
    button.style.backgroundColor = color; // Muda a cor do botão para verde ou vermelho
}

            

</script>
<script src="../../script_geral.js"></script>
</html>