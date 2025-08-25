<?php 

include "../../Banco_Dados/conexao.php";

session_start();

if (isset($_SESSION['Validacao_Aluno']) && $_SESSION['Validacao_Aluno'] == 1) {


}
else {
    header('Location: ../login/login.php');
    mysqli_close($conexao);
    exit;
}

if ($_GET) {

    $erro = isset($_GET['erro']) ? $_GET['erro'] : null;

    if ($erro == 'cadastrado_turma') {
        echo "<script>alert('Aluno já cadastrado na turma!');</script>";
    }
    else if ($erro == 'limite_turma') {
        echo "<script>alert('Aluno já cadastrado em 2 turmas!');</script>";
    } else if ($erro == 'sucesso') {
        echo "<script>alert('Aluno adicionado a turma com sucesso!');</script>";
    } else if ($erro == 'erro_add_turma') {
        echo "<script>alert('Erro ao adicionar aluno a turma!');</script>";
    } else if ($erro == 'erro_busca_rm') {
        echo "<script>alert('Erro ao buscar RM!');</script>";
    } else if ($erro == 'turma_excluida') {
        echo "<script>alert('Turma excluída com sucesso!');</script>";
    } else if ($erro == 'erro_excluir_turma') {
        echo "<script>alert('Erro ao excluir turma!');</script>";
    } else if ($erro == 'turma_inexistente') {
        echo "<script>alert('Turma não encontrada!');</script>";
    } else if ($erro == 'curso_invalido') {
        echo "<script>alert('Curso inválido!');</script>";
    } else if ($erro == 'modulo_invalido') {
        echo "<script>alert('Módulo inválido!');</script>";
    } else if ($erro == 'turma_inexistente') {
        echo "<script>alert('Turma não encontrada!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Adicionar Turma</title>
<link rel="stylesheet" href="../Dashboard_prof/style_dashboard_materia.css">
<link rel="stylesheet" href="../Dashboard_prof/style_tela_professor.css">
<link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    #titulo {
    color: black;
    font-family: 'Poppins', Arial, Helvetica, sans-serif;
    font-weight: bold;
    margin-bottom: 20px;
    font-size: 30px;
    }
</style>
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw; overflow-y: hidden;">
<div class="barra_menu">
    <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="retorna()">
    <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
    <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2">
</div>
<div class="container_materia">
    <div class="materia">
        <div class="submenu_forms">
            <form action="add_turma.php" method="post" id="Adicionar">
                <div class="containerTitulo">
                    <h1 id="titulo" style="text-align: center;">Adicionar Turma</h1>
                </div>
                <div>
                    <label for="ID_Curso" id="tituloSelectMateria">Selecione o Curso:</label>
                    <select name="ID_Curso" id="selectTurma">
                        <option value="">Selecione</option>
                            <?php 
                                    
                                include("../../Banco_Dados/conexao.php"); 
                                //Buscar o curso na tabela

                                $nome = $_SESSION['Nome_Aluno'];
                                $senha = $_SESSION['Senha_Aluno'];

                                $sql_escola = "SELECT Cod_Escola FROM aluno WHERE Nome_Aluno = '$nome' AND Senha_Aluno = '$senha'";
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
                    <label for="Modulo" id="tituloSelectMateria">Selecione o módulo/série:</label>
                    <select name="Modulo" id="selectTurma">
                        <option value="">Selecione</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="containerBtnsForm" style="gap:20px;">
                    <input id="btnAdd" class="botoes" type="submit" value="Adicionar" style="width:100%; padding: 5px;">
                    <input id="btnExcluir" class="botoes" type="button" value="Excluir" onclick="clickexclui()" style="width:100%; padding: 5px;">
                </div>
            </form>

            <form action="exclui_turma.php" method="post" id="Excluir" style="display: none;">
                <div class="containerTitulo">
                    <h1 id="titulo" style="text-align: center;">Excluir Turma</h1>
                </div>
                <div>
                    <label for="ID_Turma" id="tituloSelectMateria">Selecione a Turma:</label>
                    <select name="ID_Turma" id="selectTurma">
                        <option value="">Selecione</option>

                        <?php 
                        
                            include "../../Banco_Dados/conexao.php";

                            $Nome_Aluno = $_SESSION['Nome_Aluno'];
                            $Senha_Aluno = $_SESSION['Senha_Aluno'];

                            $sql_select = "SELECT RM FROM aluno WHERE Nome_Aluno = '$Nome_Aluno' AND Senha_Aluno = '$Senha_Aluno'";
                            $resultado_select = mysqli_query($conexao, $sql_select);

                            if ($resultado_select) {

                                $dados_select = mysqli_fetch_array($resultado_select);
                                $RM = $dados_select['RM'];

                                $sql_select_turma = "SELECT ID_Turma_FK, turma.Nome_Turma AS Nome_Turma FROM curso_aluno INNER JOIN turma ON curso_aluno.ID_Turma_FK = turma.ID_Turma WHERE ID_Aluno_FK = $RM";
                                $resultado_select_turma = mysqli_query($conexao, $sql_select_turma);

                                if ($resultado_select_turma) {
                                    while ($dados_select_turma = mysqli_fetch_array($resultado_select_turma)) {
                                        $ID_Turma = $dados_select_turma['ID_Turma_FK'];
                                        $Nome_Turma = $dados_select_turma['Nome_Turma'];
                                        echo "<option value='$ID_Turma'>$Nome_Turma</option>";
                                    }
                                } else {
                                    echo "<option value=''>Nenhuma turma encontrada</option>";
                                }    
                            }
                        ?>
                    </select>
                </div>
                <?php 
                
                if ($_GET) {
                    $erro = isset($_GET['erro']) ? $_GET['erro'] : null;

                    if ($erro == 'turma_inexistente') {
                        echo "<script>alert('Turma não encontrada!');</script>";
                    } else if ($erro == 'limite_excedido') {
                        echo "<script>alert('Limite de turmas excedido!');</script>";
                    }
                }
                
                ?>
                <div class="containerBtnsForm">
                    <input id="btnAdd" class="botoes" type="button" value="Adicionar" onclick="clickadd()">
                    <input id="btnExcluir" class="botoes" type="submit" value="Excluir">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function clickadd() {
    document.getElementById('Adicionar').style.display = 'flex';
    document.getElementById('Excluir').style.display = 'none';
    }

    function clickexclui() {
        document.getElementById('Adicionar').style.display = 'none';
        document.getElementById('Excluir').style.display = 'flex';
    }

    function retorna() {
        window.location.href = "../Dashboard_aluno/DashBoard_Aluno.php";
    }

</script>
</body>
</html>