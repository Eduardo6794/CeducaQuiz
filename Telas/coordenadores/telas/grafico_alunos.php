<?php
include "../../../Banco_Dados/conexao.php";
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$ativos = 0;
$desistentes = 0;
$retidos = 0;

if (isset($data['ID_Turma'])) {
    $ID_Turma = intval($data['ID_Turma']);
    $ce = $_SESSION['Codigo_Escola'];

    $sql = "SELECT Situacao_Aluno FROM curso_aluno 
            INNER JOIN aluno ON curso_aluno.ID_Aluno_FK = aluno.RM 
            WHERE ID_Turma_FK = $ID_Turma AND aluno.Cod_Escola = $ce";
    $res = mysqli_query($conexao, $sql);

    while ($row = mysqli_fetch_assoc($res)) {
        if ($row['Situacao_Aluno'] == 'Ativo') $ativos++;
        elseif ($row['Situacao_Aluno'] == 'Desistente') $desistentes++;
        elseif ($row['Situacao_Aluno'] == 'Retido') $retidos++;
    }
}

echo json_encode([
    'ativos' => $ativos,
    'desistentes' => $desistentes,
    'retidos' => $retidos
]);

?>