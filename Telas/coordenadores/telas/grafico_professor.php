<?php
include "../../../Banco_Dados/conexao.php";
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$total = 0;

if (isset($data['ID_Turma'])) {
    $ID_Turma = intval($data['ID_Turma']);
    $ce = $_SESSION['Codigo_Escola'];

    $sql = "SELECT Materia_Prof FROM prof_turma 
            INNER JOIN professor ON prof_turma.ID_Prof_FK = professor.ID_Prof 
            WHERE ID_Turma_FK = $ID_Turma AND professor.Cod_Escola = $ce";
    $res = mysqli_query($conexao, $sql);

    while (mysqli_fetch_array($res)) {
        $total++;
    }
}

echo json_encode([
    'total' => $total
]);

?>