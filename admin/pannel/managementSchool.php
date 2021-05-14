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
            <?php foreach (selectEcoles() as $ke=>$e) { ?>
                <li id="adminEcole<?php echo $ke ?>" data-caption="<?php echo $e['intitule'] ?>" data-collapsed="true">
                    <ul>
                        <?php foreach (selectPromosByIdEcole($e['id_ecole']) as $kp=>$p) { ?>
                            <li id="adminPromo<?php echo $kp ?>" data-caption="<?php echo $p['intitule'] ?>" data-collapsed="true">
                                <ul>
                                    <?php foreach (selectClassesPromoEcoles($p['intitule'], $e['intitule']) as $kc=>$c) { ?>
                                        <li id="adminClasse<?php echo $kc ?>" data-caption="<?php echo $c['classe'] ?>" data-collapsed="true"></li>
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
<script>
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    for (let i = 0; i < 100; i++) {
        $("#adminEcole"+i).css("color", getRandomColor());    
        $("#adminPromo"+i).css("color", getRandomColor());
        $("#adminClasse"+i).css("color", getRandomColor());
    }
</script>

</html>