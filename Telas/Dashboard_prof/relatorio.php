<?php
session_start(); // Deve ser a primeira linha, sem espaços antes

include "../../Banco_Dados/conexao.php";

if (isset($_SESSION['Validacao_Professor']) && $_SESSION['Validacao_Professor'] == 1) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Quiz'])) {
        $_SESSION['ID_Quiz'] = $_POST['ID_Quiz'];
        header("Location: relatorio.php");
        exit;
    }

    if (!isset($_SESSION['ID_Quiz'])) {
        header("Location: tela_professor_info_quiz_feitos.php");
        exit;
    }

    $ID_Quiz = $_SESSION['ID_Quiz'];


    $select = "SELECT Titulo_Quiz FROM quiz WHERE ID_Quiz = $ID_Quiz";
    $resultado = mysqli_query($conexao, $select);
    $dados = mysqli_fetch_array($resultado);

    $Titulo_Quiz = $dados['Titulo_Quiz'];  
    

} else {
    header("Location: ../login/login.php");
    mysqli_close($conexao);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="relatorio.css">
    <title>Imprimir</title>
        <style>
            * {
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }

            body {
                overflow: hidden;
            }

            .container {
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;

            }

            
        </style>
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw; height: 100vh;">
      <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="redireciona_sair()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2" onclick="redireciona_config()">
    </div>
    <div class="container">
        <form class="form" action="modelo.php" method="post" style="width: 50%;">
            <h1 style="text-align:center; font-family: 'poppins';">Modelo Prova</h1>
            <input type="hidden" name="ID_Quiz" value="<?php echo $ID_Quiz; ?>">
            <select name="modelo" id="modelo">
                <option value="">Selecione o Modelo</option>
                <option value="1">Modelo 1</option>
            </select>
            <input type="submit" value="Previsualizar">
        </form>
    </div>
</body>
<script>
    function redireciona_sair() {
        window.location.href = "tela_professor_info_quiz_feitos.php";
    }
</script>
</html>