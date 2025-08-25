<?php
    session_start();
    include "../../Banco_Dados/conexao.php";

    if (!isset($_SESSION['Validacao_Professor']) || $_SESSION['Validacao_Professor'] != 1) {
        header('Location: ../Login/login.php');
        mysqli_close($conexao);
        exit;
    }
    if ($_GET) {
        $erro = $_GET['erro'];

        if ($erro == 'input_vazios') {

            echo "<script>alert('Por favor, preencha todos os campos!');</script>";

        } else if ($erro == 'sucesso') {

            echo "<script>alert('Materia adicionada com sucesso!');</script>";

        } else if ($erro == 'ID_Turma_Nao_Encontrado') {

            echo "<script>alert('ID da Turma não encontrado!');</script>";

        } else if ($erro == 'materia_nao_encontrada') {

            echo "<script>alert('Matéria não encontrada!');</script>";

        } else if ($erro == 'materia_excluida') {

            echo "<script>alert('Matéria excluída com sucesso!');</script>";

        } else if ($erro == 'materia_editada') {

            echo "<script>alert('Matéria editada com sucesso!');</script>";

        } else {

            echo "<script>alert('Erro ao adicionar matéria!');</script>";

        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Matéria</title>
    <link rel="stylesheet" href="style_dashboard_materia.css">
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="style_tela_professor.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        #titulo {
            font-family: 'Poppins', Arial;
            font-size: 30px;
            font-weight: bold;
            color: black;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw; overflow-y: hidden;">
    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="retorna()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" onclick="configura()">
    </div>
    <div class="container_materia">
        <div class="materia">
            <div class="submenu_forms">
                <form action="Add_Materia.php" method="post" id="Adicionar">
                    <p id="titulo">Adicionar Matéria</p>
                    <div>
                        <label for="Nome_Materia" id="tituloNomeMateria">Nome da Matéria:</label>
                        <input type="text" name="Nome_Materia" id="inputNomeMateria">
                    </div>
                    <div>
                        <label for="ID_Curso" id="tituloSelectMateria">Selecione o Curso:</label>
                        <select name="ID_Curso" id="selectTurma">
                            <option value="">Selecione</option>

                            <?php 
                                    
                                include("../../Banco_Dados/conexao.php"); 
                                //Buscar o curso na tabela

                                $nome = $_SESSION['Nome_Prof'];
                                $senha = $_SESSION['Senha_Prof'];

                                $sql_escola = "SELECT Cod_Escola FROM professor WHERE Nome_Prof = '$nome' AND Senha_Prof = '$senha'";
                                $exec_escola = mysqli_query($conexao, $sql_escola);

                                if ($vetor_prof = mysqli_fetch_array($exec_escola)) {
                                    $Cod_Escola = $vetor_prof['Cod_Escola'];
                                }


                                $consulta = "SELECT curso.ID_Curso AS ID_Curso, curso.Nome_Curso AS Nome_Curso FROM escola_curso INNER JOIN curso ON escola_curso.Curso_FK = curso.ID_Curso WHERE Codigo_FK = $Cod_Escola ORDER BY Nome_Curso";
                                $envio_consulta = mysqli_query($conexao, $consulta);

                                while ($vetor = mysqli_fetch_array($envio_consulta)){

                                    $dado1 = $vetor['ID_Curso'];
                                    $dado2 = $vetor['Nome_Curso'];?>

                                    <option value="<?php echo $dado1;?>"> <?php echo $dado2;?></option>;

                                <?php
                            }?>
                        </select>
                    </div>
                    <div>
                        <label for="ID_Turma" id="tituloSelectMateria">Série/Módulo</label>
                        <select name="modulo" id="">
                            <option value="">Selecione o Módulo/Série</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="containerBtnsForm">
                        <input id="btnAdd" class="botoes" type="submit" value="Adicionar">
                        <input id="btnEdit" class="botoes" type="button" value="Editar" onclick="clickedit()">
                        <input id="btnExcluir" class="botoes" type="button" value="Excluir" onclick="clickexclui()">
                    </div>
                </form>

                <form action="Edita_Materia.php" method="post" id="Editar" style="display: none; width: 100%;">
                <p id="titulo">Editar Matéria</p>
                    <div>
                        <label for="Nova_Materia" id="tituloNomeMateria">Nova Matéria:</label>
                        <input type="text" name="Nova_Materia" id="inputNomeMateria">
                    </div>
                    <div>
                        <label for="Nome_Materia" id="tituloSelectMateria">Selecione a Matéria:</label>
                        <select name="Nome_Materia" id="selectMateria">
                            <option value="">Selecione</option>
                            <?php 
                            
                                include "../../Funcoes_Backend/Consulta_ID_Prof.php";

                                $sql_consulta = "SELECT Materia_Prof, turma.Nome_Turma AS Nome_Turma, turma.ID_Turma AS ID_Turma FROM prof_turma INNER JOIN turma ON prof_turma.ID_Turma_FK = turma.ID_Turma WHERE prof_turma.ID_Prof_FK = $ID_Prof";
            
                                $result = mysqli_query($conexao,$sql_consulta);
            
                                while($vetor = mysqli_fetch_array($result)){
                                
                                    $Nome_Materia = $vetor['Materia_Prof'];
                                    $nome_turma = $vetor['Nome_Turma'];
                                    $ID_Turma = $vetor['ID_Turma'];?>
                    
                                <option value="<?php echo $Nome_Materia;?>"><?php echo $Nome_Materia . ' - ' . $nome_turma;?></option>
                                
            
            
                            <?php
                            }?>
                        </select>
                    </div>
                    <div>
                        <label for="ID_Turma" id="tituloSelectMateria">Selecione a Turma:</label>
                        <select name="ID_Turma" id="selectTurma">
                            <option value="">Selecione</option>

                            <?php 
                                include "../../Funcoes_Backend/Consulta_Turma.php";
                            ?>
                        </select>
                    </div>
                    <div class="containerBtnsForm">
                        <input id="btnAdd" class="botoes" type="button" value="Adicionar" onclick="clickadd()">
                        <input id="btnEdit" class="botoes" type="submit" value="Editar">
                        <input id="btnExcluir" class="botoes" type="button" value="Excluir" onclick="clickexclui()">
                    </div>
                </form>

                <form action="Deleta_Materia.php" method="post" id="Excluir" style="display: none;">
                    <p id="titulo">Excluir Matéria</p>
                    <div>
                        <label for="Nome_Materia" id="tituloSelectMateria">Selecione a Matéria:</label>
                        <select name="Nome_Materia" id="selectMateria">
                            <option value="">Selecione</option>
                            <?php 
                            
                            include "../../Funcoes_Backend/Consulta_ID_Prof.php";

                            $sql_consulta = "SELECT Materia_Prof, turma.Nome_Turma AS Nome_Turma, turma.ID_Turma AS ID_Turma FROM prof_turma INNER JOIN turma ON prof_turma.ID_Turma_FK = turma.ID_Turma WHERE prof_turma.ID_Prof_FK = $ID_Prof";
        
                            $result = mysqli_query($conexao,$sql_consulta);
        
                            while($vetor = mysqli_fetch_array($result)){
                            
                                $Nome_Materia = $vetor['Materia_Prof'];
                                $nome_turma = $vetor['Nome_Turma'];
                                $ID_Turma = $vetor['ID_Turma'];?>
                
                            <option value="<?php echo $Nome_Materia;?>"><?php echo $Nome_Materia . ' - ' . $nome_turma;?></option>
                            
        
        
                        <?php
                        }?>
                        </select>
                    </div>
                    <div>
                        <label for="ID_Turma" id="tituloSelectMateria">Selecione a Turma:</label>
                        <select name="ID_Turma" id="selectTurma">
                            <option value="">Selecione</option>

                            <?php 
                                include "../../Funcoes_Backend/Consulta_Turma.php";
                            ?>
                        </select>
                    </div>
                    <div class="containerBtnsForm">
                        <input id="btnAdd" class="botoes" type="button" value="Adicionar" onclick="clickadd()">
                        <input id="btnEdit" class="botoes" type="button" value="Editar" onclick="clickedit()">
                        <input id="btnExcluir" class="botoes" type="submit" value="Excluir" >
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="script_dashboard_materia.js"></script>
    <script>
        function retorna() {
            window.location.href = "tela_professor.php";
        }

        function configura() {
            window.location.href = "../config_professor/config_professor.php";
        }
    </script>
</body>
</html>