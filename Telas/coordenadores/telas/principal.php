<?php

    include "../../../Banco_Dados/conexao.php";

    session_start();

    if ($_SESSION['Validacao_coord'] == 1) {

    } else {
        header("Location: ../index.php");
        exit;
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <link rel="stylesheet" href="principal.css">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw; height: 100vh;">
    <div class="barra_menu">
        <img src="../../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="retorna()">
        <img src="../../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" onclick="redireciona_config()">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div class="containerNomeCoordenador">
        <span id="spanOlaCoordenador">Olá, </span><p id="paragrafoNomeCoordenador"><?php echo $_SESSION['Nome_coord'];?></p>
    </div>

    <div class="container-conteudo">
        <div class="submenu">
            <div>
                <span onclick="alunos()">Alunos</span>
            </div>
            <div>
                <span onclick="professores()">Professores</span>
            </div>
        </div>

        <div class="conteudo">

            <div id="alunos" style="display: none;">
                <div>
                    <h2 style="font-family:'Poppins',Arial; margin: auto;">Alunos</h2>
                    <label for="ID_Turma">Turmas</label>
                    <select name="ID_Turma" id="ID_Turma">
                        <option value="">Selecione</option>
                        <?php 

                        $Nome_coord = $_SESSION['Nome_coord'];
                        $Senha_coord = $_SESSION['Senha_coord'];

                        $sql_prof = "SELECT * FROM coordenacao WHERE Nome_coord = '$Nome_coord' AND Senha_coord = '$Senha_coord'";
                        $exec_prof = mysqli_query($conexao, $sql_prof);

                        if ($vetor_prof = mysqli_fetch_array($exec_prof)) {

                            $curso = $vetor_prof['ID_Curso_FK'];
                            $ce = $vetor_prof['Codigo_FK'];

                            if (!empty($curso) && !empty($ce)) {
                                $sql_select_turmas = "SELECT * FROM turma INNER JOIN curso ON turma.ID_Curso_FK = curso.ID_Curso WHERE Cod_Escola = $ce AND ID_Curso_FK = $curso";
                                $exec_select_turmas = mysqli_query($conexao, $sql_select_turmas);

                                if (!$exec_select_turmas) {
                                    echo "<option value=''>Erro ao buscar turmas</option>";
                                } else {
                                    while ($vetor_turmas = mysqli_fetch_array($exec_select_turmas)) {
                                        $ID_Turma = $vetor_turmas['ID_Turma'];
                                        $nome_turma = $vetor_turmas['Nome_Turma'];?>

                                        <option value="<?php echo $ID_Turma;?>"><?php echo $nome_turma; ?></option>

                    
                            <?php }
                                }
                            } else {
                                echo "<option value=''>Curso ou escola não definido</option>";
                            }

                        } else {
                            echo "<option value=''>Coordenador não encontrado</option>";
                        } 
                        
                        //echo "<script>console.log($curso)</script>";
                        ?>



                        
                        
                    </select>
                </div>


                <div id="chart_div"></div>
            </div>
            
            <div id="professores" style="display: none;">
                <div>
                    <h2 style="font-family:'Poppins',Arial;">Professores</h2>
                    <label for="ID_Turma">Turmas</label>
                    <select name="ID_Turma" id="ID_Turma2">
                        <option value="">Selecione</option>
                        <?php 

                        $Nome_coord = $_SESSION['Nome_coord'];
                        $Senha_coord = $_SESSION['Senha_coord'];

                        $sql_prof = "SELECT * FROM coordenacao WHERE Nome_coord = '$Nome_coord' AND Senha_coord = '$Senha_coord'";
                        $exec_prof = mysqli_query($conexao, $sql_prof);

                        if ($vetor_prof = mysqli_fetch_array($exec_prof)) {

                            $curso = $vetor_prof['ID_Curso_FK'];
                            // Corrigir para usar sempre 'Cod_Escola'
                            $ce = $vetor_prof['Codigo_FK'];

                            if (!empty($curso) && !empty($ce)) {
                                
                                $sql_select_turmas = "SELECT * FROM turma INNER JOIN curso ON turma.ID_Curso_FK = curso.ID_Curso WHERE Cod_Escola = $ce AND turma.ID_Curso_FK = $curso";
                                $exec_select_turmas = mysqli_query($conexao, $sql_select_turmas);

                                if (!$exec_select_turmas) {
                                    echo "<option value=''>Erro ao buscar turmas</option>";
                                } else {
                                    while ($vetor_turmas = mysqli_fetch_array($exec_select_turmas)) {
                                        $ID_Turma = $vetor_turmas['ID_Turma'];
                                        $nome_turma = $vetor_turmas['Nome_Turma'];?>

                                        <option value="<?php echo $ID_Turma;?>"><?php echo $nome_turma; ?></option>

                    
                            <?php }
                                }
                            } else {
                                echo "<option value=''>Curso ou escola não definido</option>";
                            }
                        } else {
                            echo "<option value=''>Coordenador não encontrado</option>";
                        }
                        ?>
                    </select>
                </div>

                <div id="chart_div_prof"></div>
            </div>
        </div>
    </div>
</body>
    <script src="principal.js"></script>
</html>