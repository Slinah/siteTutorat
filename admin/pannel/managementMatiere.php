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
        <?php
        echo '<div class="row"><div class="cell-5">';
        echo '<h3>Matières validées</h3>';
        if(verifExistMatiereByVal(1) != 0){
        echo ' <table class="row-hover striped table table-border mt-2" data-role="table" data-show-search="false" data-show-table-info="false" data-show-rows-steps="false" data-pagination-short-mode="true" data-show-pagination="true" data-pagination-steps="8">
        <thead>
        <tr>
            <th data-sortable="false">Matière</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        </thead>
        <tbody>';
        foreach (selectMatieresByValidation(1) as $m) {
            echo '<div id="' . $m['intitule'] . 'Delete" class="dialog alert" data-role="dialog">
                <div class="dialog-title">Voulez-vous vraiment supprimer cette matière de la base ?</div>
                <div class="dialog-actions">
                <button class="button js-dialog-close">Retour</button>
                <button class="button" onclick="location.href = `deleteMatters.php?mat=' . $m['id_matiere'] . '`;"><span class="mif-done_all"></span> Supprimer la matière</button>
                </div>
            </div>';
            echo '<tr><td>' . $m['intitule'] . '</td><td><button class="button bg info" onclick="location.href = `editMattersAdmin.php?mat=' . $m['id_matiere'] . '`;"><span class="mif-file-text"></span> Modifier la matière</button></td><td><button class="button bg dark" onclick="Metro.dialog.open(`#' . $m['intitule'] . 'Delete`)"><span class="mif-cross"></span></button></td></tr>';
        }
        echo '</table>';
    } else {
        echo 'Aucune matière dans la base de données';
    }
        echo '</body></div>';
        echo '<div class="cell-5 offset-1"><h3>Matières non validées</h3>';
        if (verifExistMatiereByVal(0) != 0){
        echo ' <table class="row-hover striped table table-border mt-2" data-role="table" data-show-search="false" data-show-table-info="false" data-show-rows-steps="false" data-pagination-short-mode="true" data-show-pagination="true" data-pagination-steps="8">
        <thead>
        <tr>
            <th data-sortable="false">Matière</th>
            <th>Modifier</th>
            <th>Validation</th>
            <th>Supprimer</th>
        </tr>
        </thead>
        <tbody>';
        foreach (selectMatieresByValidation(0) as $m) {
            echo '<div id="' . $m['intitule'] . 'Delete" class="dialog alert" data-role="dialog">
                <div class="dialog-title">Voulez-vous vraiment supprimer cette matière de la base ?</div>
                <div class="dialog-actions">
                <button class="button js-dialog-close">Retour</button>
                <button class="button" onclick="location.href = `deleteMatters.php?mat=' . $m['id_matiere'] . '`;"><span class="mif-done_all"></span> Supprimer la matière</button>
                </div>
            </div>';
            echo '<tr><td>' . $m['intitule'] . '</td><td><button class="button bg info" onclick="location.href = `editMattersAdmin.php?mat=' . $m['id_matiere'] . '`;"><span class="mif-file-text"></span> Modifier la matière</button></td><td><button class="button bg success" onclick="location.href = `validateMatter.php?matter=' . $m['id_matiere'] . '`;"><span class="mif-arrow-up"></span> Valider</button></td><td><button class="button bg dark" onclick="Metro.dialog.open(`#' . $m['intitule'] . 'Delete`)"><span class="mif-cross"></span></button></td></tr>';
        }
        echo '</table>';
    } else {
        echo 'Aucune matière à valider.';
    }
        echo '</body></div>';
        echo '</div>';
        ?>
    </div>
</body>
<script src="../../js/activeMenu.js"></script>

</html>