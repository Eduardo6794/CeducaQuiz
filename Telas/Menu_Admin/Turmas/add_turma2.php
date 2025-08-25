<?php

session_start();

if ($_SESSION['validacao_admin'] == 1) {

    include("../../../Banco_Dados/conexao.php");  
    
    $js_cadastrado = false;

    if ($_POST) {

        $nome = $_POST['nome'];
        $modulo = $_POST['modulo'];
        $curso = $_POST['curso'];
        $ID_Escola = $_POST['escola'];

        $consulta = "SELECT * FROM turma WHERE (Modulo_Turma = $modulo) AND (ID_Curso_FK = $curso) AND (Cod_Escola = $ID_Escola)";
        $result_consulta = mysqli_query($conexao, $consulta);

        if (mysqli_num_rows($result_consulta) > 0) {
            $js_cadastrado = "true";
        } else {

            $inserir = "INSERT INTO turma (Nome_Turma, Modulo_Turma, ID_Curso_FK, Cod_Escola) values ('$nome', '$modulo',  '$curso', '$ID_Escola')";

            $envio_inserir = mysqli_query($conexao, $inserir);

        }
    }

} else {
    session_destroy();
    header("Location:../../Admin/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Turmas</title>

    <link rel="shortcut icon" href="../../../images/logo.png" type="image/x-icon">

    <!--CSS-->
    <link rel="stylesheet" href="../CSS/style_central.css">
    <link rel="stylesheet" href="../../../CSS/style_admin.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>

        form a {
            text-decoration: none;
            color: black;
        }

        input, select {
            background-color:#D9D9D9;
            border:#D9D9D9;
            border-radius:5px;
            height: 25px;
        }

        form div {
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', Arial;
            font-style: normal;
            font-weight: 800;
            width: 100%;
        }

    
    </style>
</head>
<body>
    <form action="add_turma2.php" method="post">
        <h2>Adicione Turma</h2>
        <div>
            <label for="nome">Nome da Turma:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div>
            <label for="modulo">Módulo:</label>
            <input type="number" id="modulo" name="modulo" required>
        </div>
        <div>
            <label for="selectCursos">Curso:</label>
            <?php 
                include("../../../Funcoes_Backend/Consulta_Curso.php");
            ?> 
        </div>
       <div>
        <label for="escola">Escola:</label>
        <select name="escola" id="escola">
            <option value="">Selecione</option>
            <?php 
            
                $consulta_escola = "SELECT Nome_Escola, Codigo FROM escola";
                $exec_escola = mysqli_query($conexao, $consulta_escola);

                while ($vetor_escola = mysqli_fetch_array($exec_escola)) {

                    $dado1 = $vetor_escola['Codigo'];
                    $dado2 = $vetor_escola['Nome_Escola']; ?>

                    <option value="<?php echo $dado1; ?>"><?php echo $dado2; ?></option>

                <?php }
            
          
            ?>
        </select>
       </div>


        <input type="submit" value="Enviar" class="btn_enviar">
        <a href="../Menu_Admin.php">Voltar</a>
    </form>
</body>
    <script>

        settimeout()

        let cadastrado = <?php echo $js_cadastrado?>;

        if (cadastrado == true) {
            alert("Curso não cadastrado");
        } else {
            alert("Turma adicionada com sucesso!");
        }

    </script>
</html>