<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Dados</title>
</head>
<body>
<?php 

    if (!$conexao) {
        header("../Funcoes_Backend/Erro_DB.php");
        echo"[ERROR] Não foi possível conectar com o Banco de Dados!";
        exit();
    }
    else if (mysqli_error($conexao)) {
        header("../Funcoes_Backend/Erro_DB.php");
        echo "[ERROR]" . mysqli_error( $conexao );
        exit();
    }
?>
    
</body>
</html>