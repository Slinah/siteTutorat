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
        <h3>Apperçu et ajout de promos</h3>
        <ul data-role="treeview">
            <?php foreach (selectEcoles() as $ke => $e) { ?>
                <li id="adminEcole<?php echo $e['intitule'] . $ke ?>" data-caption="<?php echo $e['intitule'] ?>" data-collapsed="true"><button class="button" onclick="location.href = `addPromoToSchool.php?school=<?php echo $e['id_ecole'] ?>`"><span class="mif-add"></span></button>
                    <ul>
                        <?php foreach (selectPromosByIdEcole($e['id_ecole']) as $kp => $p) { ?>
                            <li id="adminPromo<?php echo $e['intitule'] . $kp ?>" data-caption="<?php echo $p['intitule'] ?>" data-collapsed="true">
                                <ul>
                                    <?php foreach (selectClassesPromoEcoles($p['intitule'], $e['intitule']) as $kc => $c) { ?>
                                        <li id="adminClasse<?php echo $e['intitule'] . $p['intitule'] . $kc ?>" data-caption="<?php echo $c['classe'] ?>" data-collapsed="true"></li>
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

    let arraySchool = ['EPSI', 'WIS', 'IFAG'];
    let arrayPromo = ['PSN1', 'B2', 'B3', 'I1', 'I2', 'Wis1', 'Wis2', 'Wis3']
    arraySchool.forEach(elementS => {
        arrayPromo.forEach(elementP => {
            for (let i = 0; i < 100; i++) {
                $("#adminEcole" + elementS + i).css("color", getRandomColor());
                $("#adminPromo" + elementS + i).css("color", getRandomColor());
                $("#adminClasse" + elementS + elementP + i).css("color", getRandomColor());
            }
        });
    });
</script>

</html>