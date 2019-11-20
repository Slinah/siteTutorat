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
        <h3>Graphiques Globaux I1 2019-2020</h3>
        <div class="row">
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
        </div>
    </div>
</body>
<script src="../../js/activeMenu.js"></script>
<script src="../../charts/percentPartMat.js"></script>
<script src="../../charts/heuresMat.js"></script>
<script src="../../charts/partMois.js"></script>
<script src="../../charts/partInsc.js"></script>

</html>