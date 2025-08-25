<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../vendor/autoload.php';

include('../../Banco_Dados/conexao.php');
session_start();

$_SESSION['codigo'] = null;

if ($_SESSION['Validacao_Codigo'] == 1) {

    if ($_GET) {
        $nome = $_GET['nome'];
        $email = $_GET['email'];
    
        $codigo = rand(111111, 999999);

        //echo "<script>console.log('$email');</script>";
        //echo "<script>console.log('$codigo');</script>";

        $_SESSION['codigo'] = $codigo;

        try {

            $mail = new PHPMailer(true);

             //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF; //DEBUG_SERVER para depurar                  //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                   //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'educouto98@gmail.com';                     //SMTP username
            $mail->Password   = 'djys vbqn dedt ezta';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );   
            
            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('educouto98@gmail.com', 'CeducaQuiz-Suporte');
            $mail->addAddress($email, $nome);     //Add a recipient
            $mail->addReplyTo('educouto98@gmail.com', 'CeducaQuiz-Suporte');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Codigo Enviado pelo CeducaQuiz';

            //$body = '<span>Código <strong>'.$codigo.'</strong></span>';

            $body = '
            <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            padding: 20px;
                        }
                        .container {
                            background-color: #fff;
                            padding: 20px;
                            border-radius: 5px;
                            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                        }
                        h1 {
                            color: #333;
                        }
                        p {
                            font-size: 16px;
                            color: #555;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h1>Código de Recuperação</h1>
                        <p>Olá '.$nome.',</p>
                        <p>Seu código de recuperação é: <strong>'.$codigo.'</strong></p>
                    </div>
                </body>';

            $mail->Body = $body;

            $mail->send();
            echo "<script>alert('Email enviado com sucesso');</script>";


        } catch (Exception $e) {
            echo "<script>console.log('Erro ao gerar o código: " . $e->getMessage() . "');</script>";
        }
    }

} else {
    header('Location: ../recuperar_senha/recuperar_senha.php');
    mysqli_close($conexao);
    exit;
}?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código</title>
    <link rel="stylesheet" href="style_recuperar_senha.css">

    <link rel="shortcut icon" href="../../asssets/logo.png" type="image/x-icon">
</head>
<body style="margin: 0; background-color: #243A69; width: 100vw; height: 100vh;">
    
    <div class="barra_menu">
        <img src="../../icons/icone_menu.png" alt="Menu" class="barra_menu_icone_1" onclick="retorna()">
        <img src="../../images/logo.png" alt="Ceduca Quiz" class="barra_menu_logo">
        <img src="../../icons/icone_engrenagem.png" alt="Configurações" class="barra_menu_icone_2">
    </div>
    
    <div class="espacamento_pos_menu"></div>
    
    <div class="primeira_div_centralizadora">
        <div class="primeira_div_centralizadora_forms">
            <div class="form">

                <div style="font-family: 'Poppins'; font-weight: 550; font-size: 20px; width: fit-content; margin: auto">Código Enviado</div>

                <button type="button" id="btnEnviar" style="margin: auto;" onclick="redireciona_inserecode()">Progredir</button>

            </div>
        </div>
    </div>

</body>
<script>
    function redireciona_inserecode() {
        window.location.href = "inserir_codigo.php?email=<?php echo $email; ?>";
    }
</script>
<?php include "script.php"; ?>
</html>
