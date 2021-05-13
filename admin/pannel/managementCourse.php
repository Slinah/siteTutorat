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
        <h3>Cours</h3>
        <?php
        echo ' <table class="table table-border">
        <thead>
        <tr>
            <th data-sortable="true">Matière</th>
            <th data-sortable="true">Tuteur</th>
            <th data-sortable="true">Niveau</th>
            <th data-sortable="true">Status</th>
            <th data-sortable="true">Date</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>';
        foreach (selectCoursTuteurMatiere() as $c) {
            echo '<div id="' . $c['secu'] . '" class="dialog alert" data-role="dialog">
    <div class="dialog-title">Voulez-vous vraiment annuler ce cours ?</div>
    <div class="dialog-content">
    <button class="button" onclick="location.href = `updateCourseCancelAdmin.php?course=' . $c['id_cours'] . '&reason=alone`;"><span class="mif-done_all"></span> Il n\'y avais personne</button>
    <button class="button" onclick="location.href = `updateCourseCancelAdmin.php?course=' . $c['id_cours'] . '&reason=sick`;"><span class="mif-done_all"></span> Je ne peux pas assurer le cours</button>
    </div>
    <div class="dialog-actions">
        <button class="button js-dialog-close">Retour</button>
    </div>
</div>';
            echo '<div id="' . $c['secu'] . 'Delete" class="dialog alert" data-role="dialog">
    <div class="dialog-title">Voulez-vous vraiment supprimer ce cours de la base ?</div>
    <div class="dialog-actions">
    <button class="button js-dialog-close">Retour</button>
    <button class="button" onclick="location.href = `deleteCourse.php?course=' . $c['id_cours'] . '`;"><span class="mif-done_all"></span> Supprimer le cours</button>
    </div>
</div>';
            if ($c['status'] === "0") {
                $status = 'Standby';
                echo '<tr class="yellow"><td>' . $c['matiere'] . '</td><td>' . $c['nom'] . ' ' . $c['prenom'] . '</td><td>' . $c['promo'] . '</td><td>' . $status . '</td><td>' . date("d", strtotime($c['date'])) . ' '  . getMois($c['date']) . '</td><td><button class="button bg info" onclick="location.href = `editCourseAdmin.php?course=' . $c['secu'] . '&error=none&usr=' . $c['id_personne'] . '`;"><span class="mif-file-text"></span> Modifier le cours</button></td><td><button class="button bg success" onclick="location.href = `closeCourseAdmin.php?course=' . $c['secu'] . '&error=none&usr=' . $c['id_personne'] . '`;"><span class="mif-done_all"></span> Clore le cours</button></td><td><button class="button bg alert" onclick="Metro.dialog.open(`#' . $c['secu'] . '`)"><span class="mif-cross"></span> Annuler le cours</button></td><td><button class="button bg dark" onclick="Metro.dialog.open(`#' . $c['secu'] . 'Delete`)"><span class="mif-cross"></span></button></td></td></tr>';
            } else if ($c['status'] === "1") {
                $status = 'Terminé';
                echo '<tr class="success"><td>' . $c['matiere'] . '</td><td>' . $c['nom'] . ' ' . $c['prenom'] . '</td><td>' . $c['promo'] . '</td><td>' . $status . '</td><td>' . date("d", strtotime($c['date'])) . ' '  . getMois($c['date']) . '</td><td></td><td></td><td></td><td><button class="button bg dark" onclick="Metro.dialog.open(`#' . $c['secu'] . 'Delete`)"><span class="mif-cross"></span></button></td></tr>';
            } else {
                $status = 'Annulé';
                echo '<tr class="alert"><td>' . $c['matiere'] . '</td><td>' . $c['nom'] . ' ' . $c['prenom'] . '</td><td>' . $c['promo'] . '</td><td>' . $status . '</td><td>' . date("d", strtotime($c['date'])) . ' '  . getMois($c['date']) . '</td><td></td><td></td><td></td><td><button class="button bg dark" onclick="Metro.dialog.open(`#' . $c['secu'] . 'Delete`)"><span class="mif-cross"></span></button></td></tr>';
            }
        }
        echo '</table></body>';
       
        ?>
    </div>
</body>
<script src="../../js/activeMenu.js"></script>

</html>