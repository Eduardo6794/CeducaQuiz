<?php 

    session_start();

    // Verifica se a chave está definida antes de acessar
    if (!isset($_SESSION['Validacao_Professor']) || $_SESSION['Validacao_Professor'] != 1) {
        header("Location: ../login/login.php");
        exit;
    }

    include "../../Banco_Dados/conexao.php";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Professor</title>

    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="style_tela_professor.css">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="redireciona_sair()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" onclick="redireciona_config()">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div class="containerNomeProfessor">
        <span id="spanOlaProfessor">Olá, </span><p id="paragrafoNomeProfessor"><?php echo $_SESSION['Nome_Prof'];?></p>
    </div>

    <div class="containerInputSearchTurmas">
        <form action="tela_professor.php" method="post">
            <input type="text" id="inputSearchTurmas" placeholder="Pesquise a Turma" name="busca_turma">
            <div id="containerImgSearch">
                <input type="image" src="../../icons/pesquisa.png" alt="" id="imgSearch">
            </div>
        </form>
    </div>

    <div class="conatinerTituloTurma">
        <p>Turmas</p>
    </div>

    <div class="containerTurmas">
        <?php 

            //Ver Turmas
        
            include "../../Banco_Dados/conexao.php";

            $Nome_Prof = $_SESSION['Nome_Prof'];
            $Senha_Prof = $_SESSION['Senha_Prof'];

            $sql_consulta = "SELECT ID_Prof FROM professor WHERE Nome_Prof = '$Nome_Prof' AND Senha_Prof = '$Senha_Prof'";

            $resultado = mysqli_query($conexao, $sql_consulta);

            $dados = mysqli_fetch_array($resultado);

            $ID_Prof = $dados['ID_Prof'];

            if ($ID_Prof === null) {
                header('Location: tela_professor.php');
                exit;
            }

            $_SESSION['ID_Prof'] = $ID_Prof; 

            if ($_POST) {

                $busca_turma = $_POST['busca_turma'];

                $sql_consulta2 = "SELECT Materia_Prof, ID_Turma_FK, turma.Nome_Turma AS Nome_Turma FROM prof_turma INNER JOIN turma ON prof_turma.ID_Turma_FK = turma.ID_Turma  WHERE ID_Prof_FK = $ID_Prof AND Nome_Turma LIKE '%$busca_turma%' ORDER BY Nome_Turma";

                $resultado2 = mysqli_query($conexao, $sql_consulta2);

                while ($dados2 = mysqli_fetch_array($resultado2)) {

                    $Materia_Prof = $dados2['Materia_Prof'];
                    $ID_Turma_FK = $dados2['ID_Turma_FK'];
                    $Nome_Turma = $dados2['Nome_Turma'];?>

                    <div id="turmas" style="width: auto;">
                            <div class="nome_turma">
                                <?php echo $Nome_Turma . " - " . $Materia_Prof;?>
                            </div>
                            <div>
                                <form action="../Dashboard_prof/tela_professor_quiz_feitos.php" method="post">
                                    <input type="hidden" name="Materia_Prof" value="<?php echo $Materia_Prof;?>">
                                    <input type="hidden" name="ID_Turma_FK" value="<?php echo $ID_Turma_FK;?>">
                                    <input class="seta" type="image" src="../../icons/arrow_right.png" alt="próxima" style="width:15px; height: 15px; border: none; box-shadow: none;">
                                </form>
                            </div>

                    </div>
                <?php 
            
                } 
            } else {

                $sql_consulta2 = "SELECT Materia_Prof, ID_Turma_FK, turma.Nome_Turma AS Nome_Turma FROM prof_turma INNER JOIN turma ON prof_turma.ID_Turma_FK = turma.ID_Turma  WHERE ID_Prof_FK = $ID_Prof ORDER BY Nome_Turma";

                $resultado2 = mysqli_query($conexao, $sql_consulta2);

                while ($dados2 = mysqli_fetch_array($resultado2)) {

                    $Materia_Prof = $dados2['Materia_Prof'];
                    $ID_Turma_FK = $dados2['ID_Turma_FK'];
                    $Nome_Turma = $dados2['Nome_Turma'];?>

                
                    <div id="turmas" style="width: auto;">
                            <div class="nome_turma">
                                <?php echo $Nome_Turma . " - " . $Materia_Prof;?>
                            </div>
                            <div>
                                <form action="../Dashboard_prof/tela_professor_quiz_feitos.php" method="post">
                                    <input type="hidden" name="Materia_Prof" value="<?php echo $Materia_Prof;?>">
                                    <input type="hidden" name="ID_Turma_FK" value="<?php echo $ID_Turma_FK;?>">
                                    <input class="seta" type="image" src="../../icons/arrow_right.png" alt="próxima" style="width:15px; height: 15px; border: none; box-shadow: none;">
                                </form>
                            </div>

                    </div>
                <?php 
            
                }}
                 
 
            ?>
    </div>

    <div class="contanierButtonCriarNovaTurma">
        <button id="ButtonCriarNoveTurma" onclick="redireciona_criar_materia()">ADICIONAR MATÉRIA A UMA TURMA</button>
    </div>
    
    <script src="../cadastro_aluno/script_cadastro_aluno.js"></script>
    <script src="../../script_geral.js"></script>
    <script>
        function redireciona_criar_materia() {
            window.location.href = '../Dashboard_prof/Materia.php';
        }
        function redireciona_config() {
            window.location.href = '../config_professor/config_professor.php';
        }
        function redireciona_sair() {
            window.location.href = '../Dashboard_prof/Logout_prof.php';
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
</body>
</html>
    