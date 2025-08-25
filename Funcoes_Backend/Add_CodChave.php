<?php       
            //Inclui a conexão do Banco de Dados
            include("../../Banco_Dados/conexao.php");

            $return = false;

            while ($return == false) {

                $Cod_Chave = rand(11111, 99999);

                $sql_consulta = "SELECT * from professor where CodChave_Prof = '$Cod_Chave'";

                $execute_consulta = mysqli_query($conexao,$sql_consulta);

                if ($execute_consulta == false) {
                    echo "Erro de consulta" . mysqli_error($conexao);
                } else {
                    $verifica_chave = mysqli_fetch_assoc($execute_consulta);

                    if ($verifica_chave !== null) {
                        $return = false;
                    } else {
                        $chave_pronta = $Cod_Chave;
                        $return = true;
                    }
                }
            }    
?>
