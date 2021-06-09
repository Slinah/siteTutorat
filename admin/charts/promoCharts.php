<?php
require_once '../../requests/select.php';
$idPromo = $_REQUEST['idPromo'];



if (selectCountCoursByPromo($idPromo) != 0) {?>
<div class="grid">
    <div class="row">
        <div class="cell-4 offset-1">
            <input id="idPromo" type="hidden" value="<?php echo $idPromo?>" name="idQuestion">
            <div id="heuresM">Graphique représentant le nombre d'heures de tutorats par matière</div>
            <div id="heureMatDiv"><canvas id="heuresMat" width="100" height="100"></canvas></div>
        </div>
        <div class="cell-4 offset-2">
            <div id="partM">Graphique représentant l'évolution du nombre de participants par mois</div>
            <div id="partMoisDiv"><canvas id="partMois" width="100" height="100"></canvas></div>
        </div>
    </div>
    <div class="row">
        <div class="cell-4 offset-1">
            <div id="partI">Graphique représentant le nombre de participants par rapport au nombre d'inscrits</div>
            <div id="partInscDiv"><canvas id="partInsc" width="100" height="100"></canvas></div>
        </div>
        <div class="cell-4 offset-2">
            <div id="partP">Diagramme représentant le nombre de partipants par matière</div>
            <div id="partPercentDiv"><canvas id="partPercent" width="100" height="100"></canvas></div>
        </div>
    </div>
</div>

<?php } else {
echo '<br> Aucune data a afficher pour cette promo.';
}
?>

<script src="../../jsCharts/heuresMat.js"></script>
<script src="../../jsCharts/partInsc.js"></script>
<script src="../../jsCharts/partMois.js"></script>
<script src="../../jsCharts/percentPartMat.js"></script>
