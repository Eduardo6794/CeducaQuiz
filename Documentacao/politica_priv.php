<?php 
    $redireciona = null; // Definir valor padrão para evitar warning
     if ($_GET) {

        $redireciona = isset($_GET['redir']) ? $_GET['redir'] : null ;

     }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politica de Privacidade</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="style.css">
</head>
<body>
   <div class="titulo fontpoppins centraliza">
        <h1>Política de Privacidade</h1>
   </div>
   <div class="texto">
    <span class="fontpoppins centraliza">
        Última atualização: <strong>13/05/2025</strong>
    </span>
    <span  id="LGPD">
        A privacidade e a segurança dos dados pessoais dos usuários são prioridades para o Ceduca Quiz. Essa Política de Privacidade visa informar como coletamos, utilizamos, armazenamos e protegemos as informações pessoais dos usuários, em conformidade com a <a href="https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm" style="text-decoration: none;">Lei nº 13.709/2018</a> (Lei Geral de Proteção de Dados Pessoais – LGPD).
    </span>
    <ol>
        <li>
            <strong>Dados Coletados</strong>
            <br>
            <span>Coletamos informações pessoais e não pessoais para melhorar a experiência do usuário e oferecer nossos serviços. As informações que podemos coletar incluem:</span>
            <ul>
                <li>Alunos: nome completo, e-mail, senha, ano colegial, curso, código da ETEC e RM.</li>
                <li>Professores: nome completo, e-mail, senha, código da ETEC.</li>
                <li>Além disso, registramos os acertos dos alunos em quizzes para fins de acompanhamento de desempenho.</li>
            </ul>
        </li>
        <li>
            <strong>Finalidade da Coleta</strong>
            <br>
            <span>Os dados pessoais coletados têm as seguintes finalidades:</span>
            <ul>
                <li>Criação e gestão de contas de alunos e professores.</li>
                <li>Envio de e-mails para recuperação de senha e comunicação institucional.Enviar comunicações sobre atualizações, novidades e promoções do Ceducaquiz.</li>
                <li>Registro e análise de desempenho dos alunos em quizzes.</li>
                <li>Melhoria contínua da plataforma e experiência do usuário.</li>
            </ul>
        </li>
        <li>
            <strong>Compartilhamento de Dados</strong>
            <br>
            <span>Não compartilhamos dados pessoais com terceiros, exceto quando necessário para cumprir obrigações legais ou regulatórias.</span>
        </li>
        <li>
            <strong>Segurança dos Dados</strong>
            <br>
            <span>Implementamos medidas técnicas e administrativas adequadas para proteger os dados pessoais contra acessos não autorizados, vazamentos ou qualquer forma de tratamento inadequado.</span>
        </li>
        <li>
            <strong>Direitos dos Titulares</strong>
            <br>
            <span>Os usuários têm os seguintes direitos em relação aos seus dados pessoais:</span>
            <ul>
                <li>Confirmar a existência de tratamento de dados.</li>
                <li>Acessar os dados pessoais que possuímos.</li>
                <li>Corrigir dados pessoais incompletos, inexatos ou desatualizados.</li>
                <li>Solicitar a anonimização, bloqueio ou eliminação de dados desnecessários ou tratados em desconformidade com a <a href="#LGPD" style="text-decoration: none;">LGPD</a>.</li>
            </ul>
        </li>
        <li> 
            <strong>Consentimento</strong>
            <br>
            <span>Ao criar uma conta no Ceduca Quiz, o usuário consente com a coleta e o tratamento de seus dados pessoais conforme descrito nessa Política de Privacidade.</span>
        </li>
        <li>
            <strong>Alterações na Política de Privacidade</strong>
            <br>
            <span>Reservamo-nos o direito de modificar esta Política de Privacidade a qualquer momento. Quaisquer alterações serão publicadas nesta página, com a data da última atualização.</span>
        </li>
        <li>
            <strong>Contato</strong>
            <br>
            <span>Para exercer seus direitos ou esclarecer dúvidas sobre esta Política de Privacidade, entre em contato conosco pelo e-mail: ceducaquiz.suport@outlook.com.</span>
        </li>
    </ol>
    </span>
   </div>
   <div style="width: 40%;">
        <button id="btnvoltar" onclick="redireciona_voltar()">Voltar</button>
   </div>
</body>
<script> 
    function redireciona_voltar() {

        var redireciona = <?php echo json_encode($redireciona); ?>;     

        if (redireciona == 'cadastro') {

            window.location.href = "../Telas/cadastro_aluno/cadastro_aluno.php";
        
        } else {
            window.location.href = "../Telas/principal/index.php";
        }

    }
</script>
</html>