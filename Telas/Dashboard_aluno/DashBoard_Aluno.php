<?php

    include "../../Banco_Dados/conexao.php";

    session_start();

    if (!isset($_SESSION['Validacao_Aluno']) || $_SESSION['Validacao_Aluno'] != 1) {
        header("Location: ../login/login.php");
        mysqli_close($conexao);
        exit;
    }


    if (isset($_GET)) {
        $erro = isset($_GET['erro']) ? $_GET['erro'] : null;

        if ($erro == "quiz_feito") {
            echo "<script>alert('Quiz Já Feito')</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Aluno</title>

    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="../Dashboard_prof/style_tela_professor.css">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="redireciona_sair()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" onclick="redireciona_config()">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div class="containerNomeProfessor">
        <span id="spanOlaProfessor">Olá, </span><p id="paragrafoNomeProfessor"><?php echo $_SESSION['Nome_Aluno'];?></p>
    </div>

    <div class="containerInputSearchTurmas">
        <form action="DashBoard_Aluno.php" method="post">
            <input name="busca_turma" type="text" id="inputSearchTurmas" placeholder="Pesquise a Turma">
            <div id="containerImgSearch">
                <input type="image" style="border:0;" src="../../icons/pesquisa.png" alt="" id="imgSearch">
            </div>
        </form>
    </div>

    <div class="conatinerTituloTurma">
        <p>Turmas</p>
    </div>

    <div class="containerTurmas">
        <?php 
        
            include "../../Banco_Dados/conexao.php";

            $Nome_Aluno = $_SESSION['Nome_Aluno'];
            $Senha_Aluno = $_SESSION['Senha_Aluno'];

            $sql_consulta = "SELECT RM FROM aluno WHERE Nome_Aluno = '$Nome_Aluno' AND Senha_Aluno = '$Senha_Aluno'";

            $resultado = mysqli_query($conexao, $sql_consulta);

            $dados = mysqli_fetch_array($resultado);

            $rm = $dados['RM'];

            if ($rm === null) {
                header('Location: tela_professor.php');
                exit;
            }

            $_SESSION['rm'] = $rm;

            if (!$_POST) {

                $sql_consulta2 = "SELECT ID_Turma_FK, turma.Nome_Turma AS Nome_Turma FROM curso_aluno INNER JOIN turma ON curso_aluno.ID_Turma_FK = turma.ID_turma
                WHERE curso_aluno.ID_Aluno_FK = $rm";

                $resultado2 = mysqli_query($conexao, $sql_consulta2);

                while ($dados2 = mysqli_fetch_array($resultado2)) {

                    $ID_Turma_FK = $dados2['ID_Turma_FK'];
                    $Nome_Turma = $dados2['Nome_Turma'];?>

                
                    <div id="turmas" style="width: auto;">
                            <div class="nome_turma">
                                <?php echo $Nome_Turma;?>
                            </div>
                            <div>
                                <form action="../Dashboard_aluno/Curso.php" method="post">
                                    <input type="hidden" name="ID_Turma_FK" value="<?php echo $ID_Turma_FK;?>">
                                    <input class="seta" type="image" src="../../icons/arrow_right.png" alt="próxima" style="width:15px; height: 15px; border: none; box-shadow: none;">
                                </form>
                            </div>

                    </div>
            <?php 
            
            } }
            else {
                $Busca_Turma = $_POST['busca_turma'];

                $sql_consulta2 = "SELECT ID_Turma_FK, turma.Nome_Turma AS Nome_Turma FROM curso_aluno INNER JOIN turma ON curso_aluno.ID_Turma_FK = turma.ID_turma
                WHERE curso_aluno.ID_Aluno_FK = $rm AND turma.Nome_Turma LIKE '%$Busca_Turma%'";

                $resultado2 = mysqli_query($conexao, $sql_consulta2);

                while ($dados2 = mysqli_fetch_array($resultado2)) {

                    $ID_Turma_FK = $dados2['ID_Turma_FK'];
                    $Nome_Turma = $dados2['Nome_Turma'];?>

                
                    <div id="turmas" style="width: auto;">
                            <div class="nome_turma">
                                <?php echo $Nome_Turma;?>
                            </div>
                            <div>
                                <form action="../Dashboard_aluno/Curso.php" method="post">
                                    <input type="hidden" name="ID_Turma_FK" value="<?php echo $ID_Turma_FK;?>">
                                    <input class="seta" type="image" src="../../icons/arrow_right.png" alt="próxima" style="width:15px; height: 15px; border: none; box-shadow: none;">
                                </form>
                            </div>

                    </div><?php 


            } }  
        ?>
    </div>

    <div class="contanierButtonCriarNovaTurma">
        <button id="ButtonCriarNoveTurma" onclick="redireciona_entrar_turma()">ADD / DEL TURMA</button>
    </div>
    
    <script src="../../script_geral.js"></script>
    <script>
        function redireciona_config() {
            window.location.href = '../config_aluno/config_aluno.php';
        }
        function redireciona_sair() {
            window.location.href = '../Dashboard_aluno/Logout_Aluno.php';
        }
        function redireciona_entrar_turma() {
            window.location.href = '../Dashboard_aluno/entrar_curso.php';
        }

        const inputEle = document.getElementById('inputSearchTurmas');
        
        inputEle.addEventListener('keyup', function(e, event) {
            var key = e.which || e.keyCode;
            if (key == 13) { // codigo da tecla enter
                // colocas aqui a tua função a rodar
                event.preventDefault(); // Impede o comportamento padrão do botão

                let formData = new FormData(form);

                // Envia o formulário via fetch
                fetch(form.action, {
                    method: "POST",
                    body: formData
                }).then(response => {
                    if (response.ok) {
                    } else {
                        alert("Erro ao enviar os dados. Tente novamente.");
                    }
                }).catch(error => {
                    console.error("Erro:", error);
                    alert("Erro ao enviar os dados. Tente novamente.");
                });
            }
        });
    </script>
</body>
</html>