<?php
session_start();
include_once '../../requests/select.php';
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
        <h3>Graphiques Globaux I1 2019-2020</h3>
        <?php
        if (selectCountCoursByPromo('I1') != 0) {
            echo '<div class="row">
            <div class="cell-5">
                <div><canvas id="heuresMat" width="100" height="100"></canvas></div>
            </div>
            <div class="cell-5 offset-2">
                <div><canvas id="partMois" width="100" height="100"></canvas></div>
            </div>
        </div>
        <div class="row">
            <div class="cell-5">
                <div><canvas id="partInsc" width="100" height="100"></canvas></div>
            </div>
            <div class="cell-5 offset-2">
                <div><canvas id="partPercent" width="100" height="100"></canvas></div>
            </div>
        </div>';
        } else {
            echo 'Aucune data a afficher pour cette promo.';
        }
        ?>
    </div>
</body>
<script src="../../js/activeMenu.js"></script>
<script src="../../charts/percentPartMat.js"></script>
<script src="../../charts/heuresMat.js"></script>
<script src="../../charts/partMois.js"></script>
<script src="../../charts/partInsc.js"></script>

</html>