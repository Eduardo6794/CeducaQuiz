<?php 



    $conexao = mysqli_connect("localhost", "olhona42_bdceduca", "C3duc@2025InfoNet", "olhona42_ceduca");

    if (!$conexao) {
        echo "Falha na conexão com o banco de dados: " . mysqli_connect_error();
        exit;
    }

    mysqli_set_charset($conexao, "utf8mb4"); // Define a codificação para UTF-8

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);




?>