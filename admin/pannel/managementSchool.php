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
        <ul data-role="treeview">
            <?php foreach (selectEcoles() as $e) { ?>
                <li data-icon="<span class='mif-library'></span>" data-caption="<?php echo $e['intitule'] ?>">
                    <ul>
                        <?php foreach (selectPromosByIdEcole($e['id_ecole']) as $p) { ?>
                            <li data-icon="<span class='mif-library'></span>" data-caption="<?php echo $p['intitule'] ?>">
                                <ul>
                                    <?php foreach (selectClassesPromoEcoles($p['intitule'], $e['intitule']) as $c) { ?>
                                        <li data-icon="<span class='mif-library'></span>" data-caption="<?php echo $c['classe'] ?>"></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </div>
</body>
<script src="../../js/activeMenu.js"></script>

</html>