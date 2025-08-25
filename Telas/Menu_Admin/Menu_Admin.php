<?php 

    session_start();
    if ($_SESSION['validacao_admin'] != 1) {

        // Redireciona para a tela de login caso não tenha sido validado
        session_destroy();
        header('Location: ../Admin/Index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Admin</title>
    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="CSS/style_admin.css">
    <link rel="stylesheet" type="text/css" href="../../CSS/style_admin.css">
    <!--Icone-->
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
</head>
<style>

.subnavbar {
    
    width: 100%;
    height: 60px;
    padding: 5px;
    flex-wrap: nowrap;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 100px;
    background-color: var(--cor_fundo_form);
    font-family: var(--fonte_principal);
    color: var(--cor_fonteA);
    font:800;
    font-style: normal;
}


.subnavbar a {

color: var(--cor_fonteA);
text-decoration: none;

}

@media screen and (max-width: 1024px) {

    .navbar_mobile {
        display: flex;
        background-color: var(--cor_fundo_form);
        color: var(--cor_fonteA);
        font-family: var(--fonte_principal);
        font:800;
        font-style: normal;
        width: 100%;
        height: 85px;
        padding: 15px;
        display: flex;
        flex-wrap:nowrap;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 75px;
        transition: transform 5s ease-out;
        
    }

    .btn_logout {
        position: relative; 
        right: 0; 
        margin-right: 0px;
    }

    .navbar {
        display: none;
    }

    .subnavbar_mobile {
        background-color: var(--cor_fundo_form);
        color: var(--cor_fonteA);
        flex-direction: column ;
        justify-content: flex-start;
        align-items: center;
        width: 100%;
        height: fit-content;
    }

    .img_menu {
        width: 50px;
        height: 50px;
        display: flex;
        transition: transform 3s ease-in;
        animation-name: rotate;
        animation-duration: 2s;
        animation-timing-function: 1s;
    }

    .img_close {
        width: 50px;
        height: 50px;
        display: none;
        transition: transform 3s ease-in;
        animation-name: rotate;
        animation-duration: 2s;
        animation-timing-function: 1s;
    } 
}

@media screen and (min-width: 1024px) {
    .subnavbar_mobile div {
        display:none;
    }
}

.turmas:hover {

    background-color: aqua;
    transition: background-color 0.3s ease-in-out;
    padding: 7px;
    border-radius: 10px;

}

.alunos:hover {
    background-color: yellow;
    transition: background-color 0.3s ease-in-out;
    padding: 7px;
    border-radius: 10px;
}

.cursos:hover {
    background-color: greenyellow;
    transition: background-color 0.3s ease-in-out;
    padding: 7px;
    border-radius: 10px;
}

.prof:hover {
    background-color: orange;
    transition: background-color 0.3s ease-in-out;
    padding: 7px;
    border-radius: 10px;
}

.escola:hover {
    background-color: lightcoral;
    transition: background-color 0.3s ease-in-out;
    padding: 7px;
    border-radius: 10px;
}

.modelos:hover {
    background-color: lightblue;
    transition: background-color 0.3s ease-in-out;
    padding: 7px;
    border-radius: 10px;
}


</style>
<body>
    <div class="container_global">
        <!--NavBar-->
        <div class="navbar">
            <div class="turmas" onclick="clicar_turma(), clicar_geral(div_turma)">Turmas</div>
            <div class="alunos" onclick="clicar_aluno(), clicar_geral(div_aluno)">Alunos</div>
            <div class="cursos" onclick="clicar_curso(), clicar_geral(div_curso)">Cursos</div>
            <div>
                <a href="Menu_Admin.php">
                    <img src="../../images/logo.png" class="logo">
                </a>
            </div>
            <div class="prof" onclick="clicar_professor(), clicar_geral(div_professor)">Professores</div>
            <div class="escola" onclick="clicar_escola(), clicar_geral(div_escola)">Escola</div>
            <div class="modelos" onclick="clicar_modelo(), clicar_geral(div_modelos)">Modelos</div>
            <div class="btn_enviar" style="display: flex; flex-direction: row; justify-content: center; align-items: center; position: absolute; right: 0; margin-right: 20px;">
                <a href="../Menu_Admin/logout_admin.php" style="color: white; text-decoration: none;">Sair</a>
            </div>
        </div>

        <!--Navbar Mobile-->
        <div class="navbar_mobile">
            <div class="menu" id="menu" onclick="btn_mobile()">
                <img src="../../icons/icon_menu.png" class="img_menu" id="img_menu">
                <img src="../../icons/x.png" class="img_close" id="img_close" style="display: none;">
            </div>
            <div class="logo">
                <img src="../../images/logo.png" class="logo">
            </div>
            <div class="btn_enviar btn_logout">
                <a href="../../Funcoes_Backend/logout_admin.php" style="color: white; text-decoration: none;">Sair</a>
            </div>
    '   </div>

        <!--Subnavbar Mobile-->
        <div id="subnavbar_mobile" class="subnavbar_mobile">
            <div class="turmas" onclick="clicar_turma(), clicar_geral(div_turma)">Turmas</div>
            <div class="alunos" onclick="clicar_aluno(), clicar_geral(div_aluno)">Alunos</div>
            <div class="cursos" onclick="clicar_curso(), clicar_geral(div_curso)">Cursos</div>
            <div class="prof" onclick="clicar_professor(), clicar_geral(div_professor)">Professores</div>
            <div class="escola" onclick="clicar_escola(), clicar_geral(div_escola)">Escola</div>
            <div class="modelos" onclick="clicar_modelo(), clicar_geral(div_modelos)">Modelos</div>
        </div>

        <!--Subnavbar Turma-->
        <div class="subnavbar subnavbar_turmas" id="subnavbar_turmas" style="display: none;">
            <a class="turmas" href="Turmas/consulta_turma.php">Consultar</a>
            <a class="turmas" href="Turmas/add_turma2.php">Adicionar</a>
            <a class="turmas" href="Turmas/deletar_turma.php">Remover</a>
            <a class="turmas" href="Turmas/edita_turma.php">Edição</a>
        </div>

        <!--Subnavbar Cursos-->
        <div class="subnavbar subnavbar_cursos" id="subnavbar_cursos" style="display: none;">
            <a class="cursos" href="Cursos/consulta_curso.php">Consultar</a>
            <a class="cursos" href="Cursos/add_curso.php">Adicionar</a>
            <a class="cursos" href="Cursos/deletar_curso.php">Remover</a>
            <a class="cursos" href="Cursos/escola_curso.php">Escola</a>
        </div>

        <!--Subnavbar Alunos-->
        <div class="subnavbar subnavbar_alunos" id="subnavbar_alunos" style="display: none;">
            <a class="alunos" href="Alunos/consulta_aluno.php">Consultar</a>
            <a class="alunos" href="Alunos/situacao_aluno.php">Situação</a>
        </div>

        <!--Subnavbar Professores-->
        <div class="subnavbar subnavbar_profs" id="subnavbar_profs" style="display: none;">
            <a class="prof" href="Professores/consulta_prof.php">Consultar</a>
            <a class="prof" href="Professores/deletar_prof.php">Remover</a>
        </div>

        <!--Subnavbar Escola-->
        <div class="subnavbar subnavbar_escola" id="subnavbar_escola" style="display: none;">
            <a class="escola" href="Escola/consulta_escola.php">Consultar</a>
            <a class="escola" href="Escola/add_escola.php">Adicionar</a>
            <a class="escola" href="Escola/deletar_escola.php">Remover</a>
        </div>

        <!--Subnavbar Modelos-->
        <div class="subnavbar subnavbar_modelos" id="subnavbar_modelos" style="display: none;">
            <a class="modelos" href="Modelos/consulta_modelo.php">Consultar</a>
            <a class="modelos" href="Modelos/add_modelo.php">Adicionar</a>
            <a class="modelos" href="Modelos/deletar_modelo.php">Remover</a>
        </div>

        <br/>

        <!--Nome do Admin-->
        <div>
            <?php echo "<h1 style=\"color:white;\"> Bem Vindo - " . $_SESSION['nome_admin'] . "!</h1>";?>
        </div>
    </div>

    

</body>
    <!--JS-->
    <script src="../Menu_Admin/script.js" mode="text/javascript">

    </script>

    <script>
        //SubNavBars
        let div_professor = document.getElementById('subnavbar_profs');
        let div_aluno = document.getElementById('subnavbar_alunos');
        let div_escola = document.getElementById('subnavbar_escola');
        let div_modelos = document.getElementById('subnavbar_modelos');

        //Funções

        function clicar_geral(div_selecionada) {

            div_professor.style.display = 'none';
            div_aluno.style.display = 'none';
            div_turma.style.display = 'none';
            div_curso.style.display = 'none';
            div_escola.style.display = 'none';
            div_modelos.style.display = 'none';

            if (div_selecionada.style.display === 'none') {
                div_selecionada.style.display = 'flex';
            } else {
                div_selecionada.style.display = 'none';
            }
            
        }

        function clicar_aluno() {

            if (div_aluno.style.display === "none") {
                div_aluno.style.display = 'flex';
            }
            else {
                div_aluno.style.display = 'none';
            }
        }

        function clicar_professor() {

            if (div_professor.style.display === "none") {
                div_professor.style.display = 'flex';
            }
            else {
                div_professor.style.display = 'none';
            }
        }

        function clicar_escola() {

            if (div_escola.style.display === "none") {
                div_escola.style.display = 'flex';
            }
            else {
                div_escola.style.display = 'none';
            }
        }

        function clicar_modelo() {

            if (div_modelos.style.display === "none") {
                div_modelos.style.display = 'flex';
            }
            else {
                div_modelos.style.display = 'none';
            }
        }
    </script>
</html>