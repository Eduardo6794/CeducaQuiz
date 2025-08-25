<?php
    include "../../Banco_Dados/conexao.php";

    $sql_consulta = "SELECT Link_Quiz FROM quiz WHERE ID_Quiz = '$ID_Quiz'";



    $resultado = mysqli_query($conexao, $sql_consulta);

    $dados = mysqli_fetch_array($resultado);

    $Link = $dados['Link_Quiz'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body onload="criarQuiz()">
    <div id="containerQrcode">
        <img src="" alt="" id="qrCodeImg">
    </div>

    

    <script>
        const qrCode = document.querySelector("#qrCodeImg")
        const linkBancoDados ="<?php echo $Link ?>";

        function criarQuiz(){
            qrCode.src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${linkBancoDados}`
        }
    </script>
</body>
</html>