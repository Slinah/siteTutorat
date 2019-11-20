<?php
session_start();
include_once '../../requests/select.php';
?>
<!DOCTYPE html>
<html>

<?php
include_once '../../bases/head.php';
?>

<body>
    <?php include_once '../../bases/menu.php'; ?>
    <div class="container">

        <h3>Modification de cours : </h3>
        <?php
        echo '<form action="updateMattersMdfAdmin.php?mat=' . $_GET['mat'] . '" method="post">
            <input data-role="input" name="matiere" placeholder="' . selectMatiereById($_GET['mat']) . '" data-prepend="Matière">
            <br><button class="button" onclick="location.href = `updateMattersMdfAdmin.php?mat=' .  $_GET['mat']  . '`;"><span class="mif-checkmark"></span> Modifier le nom de la matiere</button>
        </form>';
    ?>
    </div>
</body>
<script src="../../js/activeMenu.js"></script>

</html>