<?php 

  session_start();

  if ($_SESSION['validacao_admin'] == 1) {

    include("../../../Banco_Dados/conexao.php");

    if ($_POST) {
      $RM = $_POST['RM'];
      $Situacao = $_POST['Situacao'];

      $sql = "UPDATE aluno SET Situacao_Aluno = '$Situacao' WHERE RM = '$RM'";
      $envio_consulta = mysqli_query($conexao, $sql);

      if ($envio_consulta) {
        header("Location: ../Menu_Admin.php");
      } else {
        echo "<h1>Erro ao atualizar situação do aluno</h1>";
      }

    }

  } else {
    session_destroy();
    header("../../Admin/Index.php");
    exit();
  }













?>