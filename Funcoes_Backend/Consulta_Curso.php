<select name="curso" id="selectCursos">

    <option value="">Selecione o curso</option>
    <?php 
                                    
        include("../../Banco_Dados/conexao.php"); 
        //Buscar o curso na tabela
        $consulta = "SELECT * FROM curso ORDER BY Nome_Curso";

        $envio_consulta = mysqli_query($conexao, $consulta);

        while ($vetor = mysqli_fetch_array($envio_consulta)){

            $dado1 = $vetor['ID_Curso'];
            $dado2 = $vetor['Nome_Curso'];?>

                                        

            <option value="<?php echo $dado1;?>"> <?php echo $dado2;?></option>;

    <?php
    }?>

</select>