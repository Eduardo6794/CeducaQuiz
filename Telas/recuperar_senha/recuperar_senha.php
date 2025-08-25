<?php 

    $red = isset($_GET['red']) ? $_GET : null;

    if ($red != null) {
        session_start();
        $_SESSION['red'] = $_GET['red'];
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>

    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
    
    <link rel="stylesheet" href="style_recuperar_senha.css">
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
            <div class="caixa_div_principal">
                <div style="font-family: 'Poppins'; font-weight: 550; font-size: 20px; width: fit-content; margin: auto">Recuperar Senha</div>
                <button class="botoes" style="width: 90%; margin: auto;" onclick="redireciona_recsen_email()">Email</button>
                <div style="width: fit-content; margin: auto; position: relative; display: flex;"><img src="../../icons/icone_escolha.png" alt="" style="height: 30px; width: 30px;"></div>
                <button class="botoes" style="width: 90%; margin: auto;" onclick="redireciona_recsen_rmch()">RM / CodChave</button>
            </div>
        </div>
    </div>

    <script src="../../script_geral.js"></script>
    <script>
        const red = <?php echo json_encode($_SESSION['red'] ?? null); ?>;
        

        function redireciona_recsen_email() {

            if (red === 'coord') { 
                window.location.href = 'recupsen_email.php?red=coord';
            } else {
                window.location.href = 'recupsen_email.php';
            }
            
            
        }

        function redireciona_recsen_rmch() {
            if (red === 'coord') { 
                window.location.href = 'recupsen_rmch.php?red=coord';
            } else {
                window.location.href = 'recupsen_rmch.php';
            }
        }

        function retorna() {

            if (red === 'coord') {
                window.location.href = "../coordenadores/index.php";
            } else {
                window.location.href = "../login/login.php";
            }
        }
    </script>

</body>
</html>