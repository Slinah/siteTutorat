<?php
session_start();
include_once '../../requests/select.php';
include_once '../../commons/date.php';


?>
<!DOCTYPE html>
<html>

<?php

include_once '../../bases/head.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] != 1) {

    header("location: ../../connexion/co.php?co=newco");
}
?>

<body>
    <?php include_once '../../bases/menu.php'; ?>
    <div class="container">
    </div>
</body>
<script src="../../js/activeMenu.js"></script>

</html>