<?php

        include "../../Banco_Dados/conexao.php";

        session_start();

        if ($_SESSION['Validacao_Professor'] == 1) {

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Quiz']) && isset($_POST['modelo'])) {

                if (empty($_POST['ID_Quiz']) || empty($_POST['modelo'])) {
                    header("Location: modelo.php?erro=input_vazios");
                    exit;
                } else {
                    $_SESSION['ID_Quiz'] = $_POST['ID_Quiz'];
                    $_SESSION['modelo'] = $_POST['modelo'];
                    header("Location: modelo.php");
                    exit;

                }         
            }

            if (!isset($_SESSION['ID_Quiz']) && !isset($_SESSION['modelo'])) {
                header("Location: modelo.php");
                exit;
            }

                $ID_Quiz = $_SESSION['ID_Quiz'];
                $Modelo = $_SESSION['modelo'];

                $select = "SELECT * FROM quiz WHERE ID_Quiz = $ID_Quiz";
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo</title>

    <style>
        #contanierButtonCriarNovaTurma {
    button {
        position: fixed; /* Fixa o botão na tela */
        top: 95%; /* Posiciona o botão no meio da tela (50% da altura) */
        left: 50%; /* Posiciona o botão no meio da tela (50% da largura) */
        transform: translate(-50%, -50%); /* Ajusta o botão para que o centro dele esteja exatamente no meio */
        z-index: 1000; /* Garante que o botão fique por cima de outros elementos */
        background-color: #2B47F8;
        color: ghostwhite;
        border: none;
        font-family: 'Poppins', Arial, Helvetica,   sans-serif;
        font-weight: bold;
        width: 30%;
        height: 50px;
        border-radius: 10px;
        font-size: 18px;
        transition: background-color 0.15s ease;
    }
    
    button:hover {
        background-color: #4CAF50;
        transition: background-color 0.15s ease;
    }
}

@media print {
    
}
    </style>
</head>
<body>
    <?php 
    
        include "../modelos/modelo" . $Modelo . ".php"; // Include the selected model file
    ?>

    <div id="contanierButtonCriarNovaTurma">
        <button id="ButtonCriarNoveTurma" onclick="imprimir()">Imprimir</button>
    </div>
    
</body>
    <script>
        function imprimir() {
            let btn_impressao = document.getElementById("contanierButtonCriarNovaTurma");
            
            if (btn_impressao.style.display === 'flex') {

                btn_impressao.style.display = 'none'
                print()

            } else {
                btn_impressao.style.display = 'flex';
            }
        }

        window.onafterprint = function() {
            imprimir();
        };
    </script>
</html>