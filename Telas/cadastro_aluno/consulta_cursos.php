<?php
// Define o tipo de conteúdo da resposta como JSON
header('Content-Type: application/json');

// Recebe os dados enviados via POST em formato JSON
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se o campo 'curso' foi enviado
if (isset($data['curso'])) {
    // Converte o valor recebido para inteiro (evita SQL Injection)
    $dado = intval($data['curso']);

    // Inclui o arquivo de conexão com o banco de dados
    include "../../Banco_Dados/conexao.php";

    // Consulta SQL para buscar os cursos vinculados ao código da escola informado
    $consulta_cursos = "SELECT Curso_FK, curso.Nome_Curso FROM escola_curso INNER JOIN curso ON escola_curso.Curso_FK = curso.ID_Curso WHERE Codigo_FK = $dado";
    $exec_consulta_cursos = mysqli_query($conexao, $consulta_cursos);

    // Monta um array com os cursos encontrados
    $cursos = [];
    while ($curso = mysqli_fetch_assoc($exec_consulta_cursos)) {
        $cursos[] = $curso;
    }
    // Retorna os cursos encontrados em formato JSON
    echo json_encode($cursos);
    exit;
}
// Caso não haja parâmetro 'curso', retorna um array vazio
echo json_encode([]);
?>