<?php 

    setcookie("cookiesAceitos", "", time() - 3600, "/");

    setcookie("Nome_Prof", "", time() - 3600, "/");
    setcookie("Senha_Prof", "", time() - 3600, "/");
    setcookie("Validacao_Professor", "", time() - 3600, "/");

    session_destroy();

    header('Location: ../Telas/login/login.php');

?>