<?php 

include "../../Banco_Dados/conexao.php";

session_start();

if ($_SESSION['Validacao_Professor'] == 1) {

    if ($_SESSION['Validacao_Quiz'] == 0) {
        header("Location: add_quiz.php");
        exit;
    }
        
    $ID_ProfTurma = $_SESSION['ID_ProfTurma'];

    $sql_consulta = "SELECT MAX(ID_Quiz) AS ID_Quiz FROM quiz WHERE ID_ProfTurma_FK = ?";
    $stmt = $conexao->prepare($sql_consulta);
    $stmt->bind_param("i", $ID_ProfTurma);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $dados = $resultado->fetch_assoc();

    $ID_Quiz = $dados['ID_Quiz'];

    if ($ID_Quiz === null) {
        header ("Location: ../Quiz/add_quiz.php");
        exit;
    }
    
    } else {
    header("Location:../login/login.php");
    $conexao->close();
    exit;
}

if ($_POST) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header("Location: criador_quiz.php");
        exit;
    }
    //Recebe o título da pergunta
    $Titulo_Pergunta = $_POST['titulo_pergunta'];

    $uploadOk = 1;
    $alvo_dir = "../Quiz/img_quiz/";
    $alvo_file = $alvo_dir . basename($_FILES["imagem"]["name"]);

    $file_banco = "../".$alvo_file;
    $imageFileType = strtolower(pathinfo($alvo_file,PATHINFO_EXTENSION));

    // Check if file already exists
      if (file_exists($alvo_file)) {
          $uploadOk = 0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {

      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $alvo_file)) {
              echo "<script>console.log('The file ". basename( $_FILES["imagem"]["name"]). " has been uploaded.')</script>";
          } else {
              echo "<script>console.log('Sorry, there was an error uploading your file.')</script>";
          }
      }

    $Resp_Corretas = [];
    $Resp_Corretas = $_POST['opcao'];

    //Pega o texto das respostas
    $Respostas = []; 
    $Respostas = $_POST['respostas'];

    $sql_insere_pergunta = "INSERT INTO perguntas (Titulo_Perg, linkimg, ID_Quiz_FK) VALUES ('$Titulo_Pergunta', '$file_banco' , $ID_Quiz)";
    $exec_insere_pergunta = mysqli_query($conexao, $sql_insere_pergunta);
    
    $ID_Pergunta = mysqli_insert_id($conexao);

    // Inserção das respostas
    for ($i = 0; $i < count($Respostas); $i++) {

        $Texto_Resp = $Respostas[$i];
        
        $Resp_Correta = isset($Resp_Corretas[$i]) && $Resp_Corretas[$i] == '1' ? 1 : 0;

        $sql_insere_resposta = "INSERT INTO respostas (Texto_Resp, RespCorretas_Resp, ID_Perg_FK) VALUES ('$Texto_Resp', $Resp_Correta, $ID_Pergunta)";
        $exec_insere_resposta = mysqli_query($conexao, $sql_insere_resposta);

    }
}

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

//ALTER TABLE perguntas AUTO_INCREMENT = 1;
//ALTER TABLE respostas AUTO_INCREMENT = 1;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz</title>
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style_criador_quiz.css">
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2">
    </div>

    <div class="espacamento_pos_menu"></div>

    
    <h1 id="titulo_pg">NOVO QUIZ</h1>
    <form action="criador_quiz.php" method="post"  enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <label for="inputPergunta" id="titulo_pergunta">PERGUNTA 
            <?php $sql_consulta_perg = "SELECT count(ID_Perg) FROM perguntas WHERE ID_Quiz_FK = $ID_Quiz";
                  $exec_consulta_perg = mysqli_query($conexao, $sql_consulta_perg);
                    $vetor_perg = mysqli_fetch_assoc($exec_consulta_perg);

                    $quantidade_perg = $vetor_perg['count(ID_Perg)'];
                  echo $quantidade_perg + 1;?>
        </label>
        <input type="file" name="imagem" id="file" class="file-input">
        <label for="file" class="file-label">Selecionar Imagem</label>
        <span id="file-name">Nenhum arquivo selecionado</span>
        <input type="text" name="titulo_pergunta" required class="inputPergunta" placeholder="Digite a pergunta"
        id="inputPergunta">
        </div>
                <!-- SUBSTITUA PELO NOVO CONTAINER -->
            <div id="resposta" class="resposta-container">
                <!-- As respostas serão adicionadas dinamicamente aqui -->
            </div>

        <input type="button" value="Adicionar Resposta" id="buttonAdiconarResposta">
        <input type="submit" value="Proxima Pergunta" id="buttonAdiconarPerguntas">
        <button id="buttonCriarQuiz" type="button" onclick="redireciona_fim_quiz()">Finalizar Quiz</button>
    </form>
    <script src="script_criador_quiz.js"></script>
    <script>
    let form = document.querySelector("form");

    function redireciona_fim_quiz() {
        document.getElementById("buttonCriarQuiz").addEventListener("click", function(event) {
            event.preventDefault(); // Impede o comportamento padrão do botão
            let formData = new FormData(form);

            // Envia o formulário via fetch
            fetch(form.action, {
                method: "POST",
                body: formData
            }).then(response => {
                if (response.ok) {
                    // Redireciona para a página de finalização do quiz após o envio bem-sucedido
                    window.location.href = "../tela_final_criar_quiz/tela_final_criar_quiz.php?ID_Quiz=<?php echo $ID_Quiz ?>";
                } else {
                    alert("Erro ao enviar os dados. Tente novamente.");
                }
            }).catch(error => {
                console.error("Erro:", error);
                alert("Erro ao enviar os dados. Tente novamente.");
            });
        });
    }
</script>
</body>
</html>