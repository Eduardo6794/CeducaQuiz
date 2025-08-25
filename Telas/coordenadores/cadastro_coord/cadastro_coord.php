<?php 

function cadastro($nome, $senha, $email, $chave_escola, $tipo_user) {

    include("../../../Banco_Dados/conexao.php");

    // Convertendo as chaves para string
    $chave_escola = (int)$chave_escola;

    // Consulta para verificar se a chave do professor já existe
    $sql_consulta1 = "SELECT * FROM coordenacao WHERE Nome_coord = '$nome' AND Senha_coord = '$senha'";
    // Preparando a consulta
    $exec_consulta1 = mysqli_query($conexao, $sql_consulta1);

    // Verificando se a chave já existe
    if (mysqli_num_rows($exec_consulta1) > 0) {
        header ('Location: cadastro_coord.php?erro=coord_existente');
        exit;
    }

    $sql_consulta2 = "SELECT * FROM escola WHERE Codigo = $chave_escola";
    $exec_consulta2 = mysqli_query($conexao, $sql_consulta2);

    // Verificando se a escola não existe
    if (mysqli_num_rows($exec_consulta2) == 0) {
        // echo "Escola não encontrada"; // Removido para evitar saída antes do header
        header ('Location: cadastro_coord.php?erro=escola_inexistente');
        exit;
    }

    // Inserção no banco de dados
    $sql_insert = "INSERT INTO coordenacao (Nome_coord, Email_coord, Senha_coord, Grau, Codigo_FK) VALUES ('$nome', '$email', '$senha', '$tipo_user', '$chave_escola')";
    // Preparando a consulta de inserção
    $sql_insert = mysqli_query($conexao, $sql_insert);

    // Executando a inserção
    if ($sql_insert) {
        // Cadastro realizado com sucesso, iniciando a sessão
        session_start();
        $_SESSION['Nome_coord'] = $nome;
        $_SESSION['Senha_coord'] = $senha;
        $_SESSION['Cod_Escola'] = $chave_escola;
        $_SESSION["Validacao_coord"] = 1;

        // Redirecionando para o dashboard do professor
        header('Location: ../telas/principal.php');
        exit;
    } else {
        // echo "Erro ao cadastrar: " . mysqli_error($conexao); // Removido para evitar saída antes do header
        header('Location: cadastro_coord.php?erro=erro_cadastro');
        exit;
    }

    mysqli_close($conexao);
}

// Verificando se o formulário foi enviado
if ($_POST) {
    // Dados recebidos do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $chave_escola = $_POST['chave_escola'];
    $tipo_user = $_POST['tipo_user'];

    $chave_escola = (int)$chave_escola;

    if (!is_integer($chave_escola)) {
        // Verificando se a chave da escola são números inteiros
        header ('Location: cadastro_coord.php?erro=chave_invalida');
        exit;
    } 

    // Chamando a função de cadastro
    cadastro($nome, $senha, $email, $chave_escola, $tipo_user);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Coordenadores</title>
    <link rel="stylesheet" href="style_cadastro_coord.css">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw;">

    <div class="barra_menu" style="grid-template-columns: 1fr;">
        <img src="../../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
    </div>

    <div class="espacamento_pos_menu"></div>

    <div style="display: block; width: 100%; position: relative; height: fit-content; z-index: 1;">
        <div class="primeira_div_centralizadora_forms">
            <form action="cadastro_coord.php" method="post" class="form">
                <div>
                    <label for="nome_aluno">
                        Nome Completo
                        <input type="text" id="nome_aluno" name="nome" required>
                    </label>
                    <label for="Senha">
                        Senha
                        <input type="password" id="Senha" name="senha" required>
                    </label>
                    <div style="display:flex; flex-direction: row; justify-content:space-between;">
                        <label for="email" >
                            Email
                            <input type="email" id="email" name="email" required>
                        </label>
                        <label for="ce">
                            C.E.
                            <input type="number" id="ce" name="chave_escola" style="width:60px;" required>
                        </label>
                    </div>
                    <label for="tipo_user">
                        Grau
                        <select name="tipo_user" id="tipo_user">
                            <option value="">Selecione</option>
                            <option value="Curso">Coordenação de Curso</option>
                            <option value="Pedag">Coordenação Pedagógica</option>
                        </select>
                    </label>
                </div>

                <div class="botoesForm">
                    <div style="display: flex; flex-direction: row; column-gap: 15px; width: 75%; align-self: center; justify-content: space-around;">
                        <button id="btnRecuperarSenha" type="button">Recuperar Senha</button>
                        <button id="btnEnviar" type="submit">ENVIAR</button>
                    </div>
                </div>


                <p style="margin: auto; color: red;">
                    <?php 
                        if($_GET) {

                            $erro = $_GET['erro'];
                            //Mensagens de erro podem ser exibidas aqui
                            if ($erro == 'chave_coord_existente') {
                                echo "Já existe um coordenador cadastrado!";
                            }
                            else if ($erro == 'escola_inexistente') {
                                echo "Escola não foi encontrada";
                            }
                        }   
                    ?>
                </p>

            </form>

            <div class="cadastroRealizado">
                    <div class="containerImgCadRealizado">
                        <img src="../../../asssets/cadRealizado.png" alt="" id="imgCadRealizado">
                    </div>
                    <div class="textoCadRealizado">
                        <p>Cadastro foi realizado com Sucesso!</p>
                    </div>
            </div>
            
        </div>
    </div>
    
    <script src="../../../script_geral.js"></script>
    
</body>
</html>