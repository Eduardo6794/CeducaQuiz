<?php 
    function formata_data($data) {

        $data = implode("/", array_reverse(explode("-",$data)));

        return ($data);

    }
?>