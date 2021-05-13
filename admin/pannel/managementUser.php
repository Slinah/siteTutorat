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
        <h3>Utilisateurs enregistrés :</h3>
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
</body>
<script src="../../js/activeMenu.js"></script>

</html>