<?php 

    if (isset($_SESSION['red'])) {
        $red = $_SESSION['red'];
    }

?>
<script>
    const red = <?php echo json_encode($red ?? null); ?>; 

    function retorna() {

            if (red === 'coord') {
                window.location.href = "recuperar_senha.php?red=coord";
            } else {
                window.location.href = "recuperar_senha.php"
            }
    }
</script>