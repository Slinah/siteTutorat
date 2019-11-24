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
        <h3>Graphiques Globaux 2019-2020</h3>
        <div class="row">
            <div class="cell-5">
                <div><canvas id="globalChartParticipation" width="100" height="100"></canvas></div>
            </div>
            <div class="cell-5 offset-2">
                <div><canvas id="globalChartMatiere" width="100" height="100"></canvas></div>
            </div>
        </div>
        <h3>Aperçu Heures par Personnes</h3>
        <?php
        echo '<table class="table striped row-hover table-border">';
        echo '<thead>';
        echo '<tr>';
        echo '<th data-sortable="false"></th>';
        foreach (selectHeuresMatieresCoursClos() as $m) {
            echo '<th data-sortable="false">' . $m['matiere'] . '</th>';
        }
        echo '<th data-sortable="false"><i>Total / Personnes<i></th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach (selectTuteurCoursClosHeures() as $tuteur) {
            echo '<tr><td>' . $tuteur['prenom'] . ' ' .  $tuteur['nom'] . ' (' . $tuteur['promo'] . ')</td>';
            foreach (selectHeuresMatieresCoursClos() as $matiere) {
                if (selectHeuresByIdMatiereIdTuteur($tuteur['id_personne'], $matiere['id_matiere']) != 'none') {
                    echo '<td>' . selectHeuresByIdMatiereIdTuteur($tuteur['id_personne'], $matiere['id_matiere']) . '</td>';
                } else {
                    echo '<td></td>';
                }
            }
            echo '<td><b><i>' . $tuteur['duree'] . '<i><b></td></tr>';
        }
        echo '<tr><td><b><i>Total<i><b></td>';
        foreach (selectHeuresMatieresCoursClos() as $matiere) {
            echo '<td><b><i>' . selectHeureByMatiere($matiere['id_matiere']) . '<i><b></td>';
        }
        echo '<td><b><i>' . selectHeuresTotal() . '<i><b></td></tr></tbody></table>';
        ?>
    </div>
</body>
<script src="../../js/activeMenu.js"></script>
<script src="../../charts/globalPart.js"></script>
<script src="../../charts/globalMat.js"></script>

</html>