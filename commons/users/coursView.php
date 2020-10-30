<?php
session_start();
include_once '../../requests/select.php';
include_once '../../commons/date.php';

if (!isset($_SESSION["role"])) {

    header("location: ../../connexion/co.php?co=newco");
}

?>
<!DOCTYPE html>
<html>

<?php
include_once '../../bases/head.php';
?>

<body>
    <?php include_once '../../bases/menu.php'; ?>
    <div class="container">
        <div class="row">
            <div class="cell-4 offset-1">
                <h3>Vos cours clos :</h3>
                <?php
                if (verifExistCoursByIdPersonneRangStatus($_SESSION['id_personne'], 1, 1) != 0) {
                    foreach (selectCoursMatiereNiveauByStatusIdPersonneRang(1, $_SESSION['id_personne'], 1) as $c) {
                        echo '<div class="remark success"><b>Intitule :</b> <i><span class="fg-crimson">' . $c['intitule'] . '</span></i><br><b>Matière :</b> <i><span class="fg-crimson">' . $c['matiere'] . '</span></i><br><b>Le ' . date("d", strtotime($c['date'])) . ' ' . getMois($c['date']) . ' à ' . date('H', strtotime($c['date'])) . 'h' . date('m', strtotime($c['date'])) . '</b><br><b>Durée :</b> <i><span class="fg-crimson">' . $c['duree'] . '</span></i><br><b>Inscrits :</b> <i><span class="fg-crimson">' . selectCountParticipantsByIdCours($c['id_cours']) . '</span></i><br><b>Participants :</b> <i><span class="fg-crimson">' . $c['participants'] . '</span></i>';
                        if ($c['commentaires'] != '') {
                            echo '<br><b>Commentaires :</b> <i><span class="fg-crimson">' . $c['commentaires'] . '</span></i>';
                        }
                        echo '</div>';
                    }
                } else {
                    echo 'Vous n\'avez clos aucun cours.';
                }
                ?>
            </div>
            <div class="cell-4 offset-2">
                <h3>Vos cours annulés :</h3>
                <?php
                if (verifExistCoursByIdPersonneRangStatus($_SESSION['id_personne'], 1, 2) != 0) {
                    foreach (selectCoursMatiereNiveauByStatusIdPersonneRang(2, $_SESSION['id_personne'], 1) as $c) {
                        echo '<div class="remark alert"><b>Intitule :</b> <i><span class="fg-crimson">' . $c['intitule'] . '</span></i><br><b>Matière :</b> <i><span class="fg-crimson">' . $c['matiere'] . '</span></i><br><b>Le ' . date("d", strtotime($c['date'])) . ' ' . getMois($c['date']) . ' à ' . date('H', strtotime($c['date'])) . 'h' . date('m', strtotime($c['date'])) . '</b><br><b>Inscrits :</b> <i><span class="fg-crimson">' . selectCountParticipantsByIdCours($c['id_cours']) . '</span></i><br><b>Motif :</b> <i><span class="fg-crimson">' . $c['commentaires'] . '</span></i></div>';
                    }
                } else {
                    echo 'Vous n\'avez annulé aucun cours.';
                }
                ?>
            </div>
        </div>
    </div>
</body>
<script src="../js/activeMenu.js"></script>

</html>