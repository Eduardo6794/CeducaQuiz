<?php 

    include "../../../Banco_Dados/conexao.php";

    session_start();

    if ($_SESSION['Validacao_coord'] == 1) {

        $Nome_coord = $_SESSION['Nome_coord'];
        $Senha_coord = $_SESSION['Senha_coord'];

        $sql_prof = "SELECT * FROM coordenacao WHERE Nome_coord = '$Nome_coord' AND Senha_coord = '$Senha_coord'";
        $exec_prof = mysqli_query($conexao, $sql_prof);

        if ($vetor_prof = mysqli_fetch_array($exec_prof)) {
            $Grau = $vetor_prof['Grau'];
            $Curso = null;

            if ($vetor_prof['ID_Curso_FK'] != null) {
                $Curso = $vetor_prof['ID_Curso_FK'];
            }
            
        } else {
            $Grau = null;
        }

        if ($_POST) {

            $NovoNome_coord = $_POST['nome'];
            $NovoSenha_coord = $_POST['senha'];
            $Email_coord = $_POST['email'];
            $Curso = $_POST['Curso'];

            $sql_update = "UPDATE coordenacao SET Nome_coord = '$NovoNome_coord', Senha_coord = '$NovoSenha_coord', Email_coord = '$Email_coord', ID_Curso_FK = $Curso WHERE (Nome_coord = '$Nome_coord') AND (Senha_coord = '$Senha_coord')";

            $exec_update = mysqli_query($conexao, $sql_update);

            if ($exec_update) {

                $_SESSION['Nome_coord'] = $NovoNome_coord;
                $_SESSION['Senha_coord'] = $NovoSenha_coord;

                header('Location:principal.php');

                exit;
            } else {
                echo "<script>alert('Erro ao alterar as configurações!');</script>";
            }

        }
    } else {
        header("Location:../index.php");
        mysqli_close($conexao);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações</title>
    <link rel="stylesheet" href="style_config_professor.css">

    <style>
        @import url('../../../style_geral.css');
        @import url('../../../CSS/style_inputs_forms_button.css');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    </style>
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu">
        <img src="../../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" id="barra_menu_icone_1_professor" onclick="retorna()">
        <img src="../../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" id="barra_menu_icone_2_professor">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div style="position: relative; width: 100dvw; height: fit-content; display: flex; justify-content: center;">

        <div class="primeira_div_centralizadora_forms">

            <form action="config_coord.php" class="form" method="POST">
                
                <div style="font-family: 'Poppins'; font-weight: 550; font-size: 20px; width: fit-content; margin: auto">Configurações</div>

                <div>
                    <?php
                    
                        $sql_consulta = "SELECT * FROM coordenacao WHERE (Nome_coord = '$Nome_coord') AND (Senha_coord = '$Senha_coord')";
                        $exec_consulta = mysqli_query($conexao, $sql_consulta);

                        if ($exec_consulta) {
                            $vetor_consulta = mysqli_fetch_array($exec_consulta);
                            $Email_coord = $vetor_consulta['Email_coord'];
                            $ce = $vetor_consulta['Codigo_FK'];
                        }                 
                    ?>
                    <label for="nome" style="margin-bottom: 20px;">
                        Nome:
                        <input type="text" name="nome" value="<?php echo $Nome_coord?>" required>
                    </label>

                    <label for="senha">
                        Senha:
                        <input type="password" name="senha" value="<?php echo $Senha_coord?>" required>
                    </label>

                    <label for="email">
                        Email:
                        <input type="text" name="email" value="<?php echo $Email_coord?>" required>
                    </label>
                    <?php 
                    
                    if ($Grau != null and $Grau == 'Curso') { ?>

                        <label for="curso">
                            Curso:
                            <select name="Curso" id="Curso">
                                <?php 

                                    if ($Curso != null or $Curso != '') {
                                        $sql_exclusive = "SELECT ID_Curso, Nome_Curso FROM curso WHERE ID_Curso = $Curso";
                                        $exec_exclusive = mysqli_query($conexao, $sql_exclusive);

                                        if ($vetor_Curso = mysqli_fetch_array($exec_exclusive)) {

                                            $ID_Curso = $vetor_Curso['ID_Curso'];
                                            $Nome_Curso = $vetor_Curso['Nome_Curso']; ?>

                                            <option value="<?php echo $ID_Curso; ?>"><?php echo $Nome_Curso; ?></option>

                                        <?php } else {

                                        }
                                    } else { ?>
                                        <option value="">Selecione</option>
                                    <?php }

                                    if ($Curso != null) {

                                        $consulta_curso = "SELECT curso.ID_Curso, curso.Nome_Curso FROM escola_curso INNER JOIN curso ON escola_curso.Curso_FK = curso.ID_Curso WHERE Codigo_FK = $ce AND Curso_FK != $ID_Curso";

                                    } else {
                                        $consulta_curso = "SELECT curso.ID_Curso, curso.Nome_Curso FROM escola_curso INNER JOIN curso ON escola_curso.Curso_FK = curso.ID_Curso WHERE Codigo_FK = $ce";
                                    }

                                
                                    $exec_curso = mysqli_query($conexao, $consulta_curso);

                                    while ($vetor_curso = mysqli_fetch_array($exec_curso)) {

                                        $ID_Curso = $vetor_curso['ID_Curso'];
                                        $Nome_Curso = $vetor_curso['Nome_Curso']; ?>

                                        <option value="<?php echo $ID_Curso ?>"><?php echo $Nome_Curso; ?></option>

                                    <?php } 

                                
                                
                                
                                ?>
                            </select>
                        </label>


                    <?php }
                    
                    ?>
                </div>

                <div class="botoesForm">
                    <div style="display: flex; flex-direction: row; column-gap: 15px; width: 100%; align-self: center; justify-content: space-around;">
                        <button id="btnRecuperarSenha" type="button">Recuperar Senha</button>
                        <button type="submit" id="btnEnviar" style="margin: auto;">Salvar</button>
                        <button type="button" id="btnSair" style="margin: auto; background-color: red;color: #FFFFFF;font-family: 'Poppins', Arial, Helvetica, sans-serif;border: none;height: 45px;width: 40%;border-radius: 10px;font-weight: 700;font-size: 16px;transition: background-color ease 0.2s;" 
                        onclick="redirecionaSair()">Sair</button>
                    </div>
                </div>

            </form>

        </div>

    </div>

    <script src="../../script_geral.js"></script>
    <script>
        let btnSair = document.querySelector("#btnSair")

        function redirecionaSair(){
            window.location.href="../index.php"
        }

        function retorna() {
            window.location.href = "principal.php"
        }
    </script>
</body>
</html>