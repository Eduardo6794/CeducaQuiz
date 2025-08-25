<?php 

function cadastro($nome, $senha, $email, $chave_prof, $chave_escola) {

    include("../../Banco_Dados/conexao.php");

    // Convertendo as chaves para string
    $chave_prof = (string)$chave_prof;
    $chave_escola = (int)$chave_escola;

    // Consulta para verificar se a chave do professor já existe
    $sql_consulta1 = "SELECT * FROM professor WHERE CodChave_Prof = '$chave_prof'";
    // Preparando a consulta
    $exec_consulta1 = mysqli_query($conexao, $sql_consulta1);

    // Verificando se a chave já existe
    if (mysqli_num_rows($exec_consulta1) > 0) {
        header ('Location: ../cadastro_professor/cadastro_professor.php?erro=chave_professor_existente');
        //echo "Professor com esta chave já está cadastrado.";
        exit;
    }

    $sql_consulta2 = "SELECT * FROM escola WHERE Codigo = $chave_escola";
    $exec_consulta2 = mysqli_query($conexao, $sql_consulta2);

    // Verificando se a escola não existe
    if (mysqli_num_rows($exec_consulta2) == 0) {
        header ('Location: ../cadastro_professor/cadastro_professor.php?erro=escola_inexistente');
        //echo "Escola não encontrada";
        exit;
    }

    // Inserção no banco de dados
    $sql_insert = "INSERT INTO professor (Nome_Prof, Email_Prof, Senha_Prof, CodChave_Prof, Cod_Escola) VALUES ('$nome', '$email', '$senha', '$chave_prof', '$chave_escola')";
    // Preparando a consulta de inserção
    $sql_insert = mysqli_query($conexao, $sql_insert);

    // Executando a inserção
    if ($sql_insert) {
        // Cadastro realizado com sucesso, iniciando a sessão
        session_start();
        $_SESSION['Nome_Prof'] = $nome;
        $_SESSION['Senha_Prof'] = $senha;
        $_SESSION["Validacao_Professor"] = 1;

        // Redirecionando para o dashboard do professor
        header('Location: ../Dashboard_prof/tela_professor.php');
        exit;
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);

    }

    mysqli_close($conexao);
}

// Verificando se o formulário foi enviado
if ($_POST) {
    // Dados recebidos do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $chave_prof = $_POST['cod_chave'];
    $chave_escola = $_POST['chave_escola'];

    $chave_prof = (int)$chave_prof;
    $chave_escola = (int)$chave_escola;

    if (!is_integer($chave_prof) && !is_integer($chave_escola)) {
        // Verificando se a chave do professor e a chave da escola são números inteiros
        header ('Location: ../cadastro_professor/cadastro_professor.php?erro=chave_invalida');
        exit;
    } 

    // Chamando a função de cadastro
    cadastro($nome, $senha, $email, $chave_prof, $chave_escola);
}
?>