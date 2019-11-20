<?php
session_start();
include_once '../../requests/select.php';
include_once '../../commons/date.php';


?>
<!DOCTYPE html>
<html>

<?php

include_once '../../bases/head.php';
include_once '../../requests/select.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] != 1) {

    header("location: ../../connexion/co.php?co=newco");
}
?>

<body>
    <?php include_once '../../bases/menu.php'; ?>
    <div class="container">
        <h3>Inscrits</h3>
        <?php
        echo ' <table class="row-hover striped table table-border mt-2" data-role="table" data-show-search="false" data-show-table-info="false" data-show-rows-steps="false" data-pagination-short-mode="true" data-show-pagination="true" data-pagination-steps="8">
        <thead>
        <tr>
            <th data-sortable="true">Nom</th>
            <th data-sortable="true">Prénom</th>
            <th data-sortable="true">Classe</th>
            <th data-sortable="true">Role</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>';
        foreach (selectPersonnePromoClasse() as $p) {
            echo '<div id="' . $p['id_personne'] . '" class="dialog alert" data-role="dialog">
    <div class="dialog-title">Voulez-vous vraiment exclure ' . $p['prenom'] . ' ' . $p['nom'] . ' du site ?</div>
    <div class="dialog-actions">
        <button class="button js-dialog-close">Retour</button>
    <button class="button" onclick="location.href = `deleteUser.php?user=' . $p['id_personne'] . '`;">Supprimer</button>
    </div>
</div>';
            echo '<tr><td>' . $p['nom'] . '</td><td>' . $p['prenom'] . '</td><td>' . $p['promo'] . ' ' . $p['classe'] . '</td>';
            if ($p['role'] == 1) {
                echo '<td>Admin</td><td><button class="button bg yellow" onclick="location.href = `demote.php?user=' . $p['id_personne'] . '`;"><span class="mif-arrow-down"></span> Demote</button></td>';
            } else {
                echo '<td>User</td><td><button class="button bg info" onclick="location.href = `promote.php?user=' . $p['id_personne'] . '`;"><span class="mif-arrow-up"></span> Promote</button></td>';
            }
            echo '<td><button class="button bg alert" onclick="Metro.dialog.open(`#' . $p['id_personne'] . '`)"><span class="mif-cross"></span> Expulser</button></td></tr>';
        }
        echo '</table></body>'
        ?>
        <br>
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
        echo '<div class="row"><div class="cell-5">';
        echo '<h3>Matières</h3>';
        echo ' <table class="row-hover striped table table-border mt-2" data-role="table" data-show-search="false" data-show-table-info="false" data-show-rows-steps="false" data-pagination-short-mode="true" data-show-pagination="true" data-pagination-steps="8">
        <thead>
        <tr>
            <th data-sortable="false">Matière</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>';
        foreach (selectMatieres() as $m) {
            echo '<div id="' . $m['intitule'] . 'Delete" class="dialog alert" data-role="dialog">
                <div class="dialog-title">Voulez-vous vraiment supprimer cette matière de la base ?</div>
                <div class="dialog-actions">
                <button class="button js-dialog-close">Retour</button>
                <button class="button" onclick="location.href = `deleteMatters.php?mat=' . $m['id_matiere'] . '`;"><span class="mif-done_all"></span> Supprimer la matière</button>
                </div>
            </div>';
            echo '<tr><td>' . $m['intitule'] . '</td><td><button class="button bg info" onclick="location.href = `editMattersAdmin.php?mat=' . $m['id_matiere'] . '`;"><span class="mif-file-text"></span> Modifier la matière</button></td><td><button class="button bg dark" onclick="Metro.dialog.open(`#' . $m['intitule'] . 'Delete`)"><span class="mif-cross"></span></button></td></tr>';
        }
        echo '</table></body></div>';
        echo '</div>';
        ?>
    </div>
</body>
<script src="../../js/activeMenu.js"></script>

</html>