<?php
session_start();
include_once '../../requests/select.php';
include_once '../date.php';

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
    <?php
    switch ($_GET['course']) {
        case "success":
            echo '<script>Metro.toast.create("Inscription au cours réussie !", null, null, "success");</script>';
            break;
        case "already":
            echo '<script>Metro.toast.create("Vous vous êtes déjà inscrit à ce cours.", null, null, "info");</script>';
            break;
        case "sucsupr":
            echo '<script>Metro.toast.create("Vous vous êtes désinscrit avec succes !", null, null, "alert");</script>';
            break;
        case "update":
            echo '<script>Metro.toast.create("Modification de cours réussie avec succès !", null, null, "success");</script>';
            break;
        case "closed":
            echo '<script>Metro.toast.create("Cours terminé avec succès !", null, null, "success");</script>';
            break;
        case "cancel":
            echo '<script>Metro.toast.create("Cours annulé avec succès !", null, null, "success");</script>';
            break;
        case "created":
            echo '<script>Metro.toast.create("Cours créé à partir d\'une proposition avec succès avec succès !", null, null, "success");</script>';
            break;
        case "new":
            echo '<script>Metro.toast.create("Cours créé avec succès avec succès !", null, null, "success");</script>';
            break;
    }
    foreach (selectCoursMatiereNiveauByStatusIdPersonneRang(0, $_SESSION['id_personne'], 1) as $c) {
        echo '<div id="' . $c['secu'] . '" class="dialog alert" data-role="dialog">
    <div class="dialog-title">Voulez-vous vraiment annuler ce cours ?</div>
    <div class="dialog-content">
    <button class="button" onclick="location.href = `updateCourseCancel.php?course=' . $c['id_cours'] . '&reason=alone`;"><span class="mif-done_all"></span> Il n\'y avais personne</button>
    <button class="button" onclick="location.href = `updateCourseCancel.php?course=' . $c['id_cours'] . '&reason=sick`;"><span class="mif-done_all"></span> Je ne peux pas assurer le cours</button>
    </div>
    <div class="dialog-actions">
        <button class="button js-dialog-close">Retour</button>
    </div>
</div>';
    }
    ?>
        <div class="container">
            <div class="icon">
                <h1><img src="../../medias/scratchOverflow.png" alt=""></h1>
            </div>
            <h3>Les cours à venir : </h3>
            <?php
            if (selectCoursStatus() != 'none') {
                foreach (selectCoursByStatus(0) as $c) {
                    echo '<div class="card"><div class="card-header"><b>Intitule :</b> <i><span class="fg-crimson">' . $c['intitule'] . '</span></i><br><b>Matière :</b> <i><span class="fg-crimson">' . $c['matiere'] . '</span></i><br><b>Le ' . date("d", strtotime($c['date'])) . ' ' . getMois($c['date']) . '.</b><br><b>Tuteur :</b> ';
                    foreach (selectPersonnePromoByIdCoursRangPersonne($c['id_cours'], 1) as $p) {
                        echo '<i><span class="fg-crimson">' . $p['nom'] . ' ' . $p['prenom']  . ' ' . $p['promo'] . '</span></i>';
                    }
                    echo '<br><b>Niveau :</b> <i><span class="fg-crimson">' . $c['promo'] . '</span></i></div><div class="card-content p-2"><b>Participants : </b><br>
            <table class="table striped table-border mt-2" data-role="table" data-show-search="false" data-show-table-info="false" data-show-rows-steps="false" data-pagination-short-mode="true" data-show-pagination="true" data-rows="5">
            <thead>
            <tr>
                <th data-sortable="false">Nom</th>
                <th data-sortable="false">Prénom</th>
                <th data-sortable="false">Classe</th>
                <th data-sortable="false">Promo</th>
                <th></th>
            </tr>
            </thead>
            <tbody>';
                    foreach (selectPersonnePromoByIdCoursRangPersonne($c['id_cours'], 0) as $t) {
                        echo '<tr><td>' . $t['nom'] . '</td><td>' . $t['prenom'] . '</td><td>' . $t['classe'] . '</td><td>' . $t['promo'] . '</td>';
                        if ($_SESSION['id_personne'] == $t['id_personne'] && $_SESSION['role'] != 1) {
                            echo '<td><button class="button" onclick="location.href = `delStudent.php?course=' . $c['id_cours'] . '&student=' . $_SESSION['id_personne'] . '`;"><span class="mif-cross"></span> Se désinscrire</button></td>';
                        } elseif ($_SESSION['role'] == 1) {
                            echo '<td><button class="button bg-crimson fg-white" onclick="location.href = `delStudent.php?course=' . $c['id_cours'] . '&student=' . $t['id_personne'] . '`;"><span class="mif-cross"></span> Retirer du cours</button></td>';
                        } else {
                            echo '<td> </td></tr>';
                        }
                    }
                    if (verifExistProfCoursByIdPersonneIdCours($_SESSION['id_personne'], $c['id_cours']) == 0) {
                        echo '</tbody></table><button class="button bg-darkViolet fg-white" onclick="location.href = `insertStudent.php?course=' . $c['id_cours'] . '&student=' . $_SESSION['id_personne'] . '`;"><span class="mif-add"></span> S\'inscrire au cours</button>';
                    } else {
                        echo '</tbody></table><div class="row"><div class="cell-2"><button class="button bg info" onclick="location.href = `editCourse.php?course=' . $c['secu'] . '&error=none`;"><span class="mif-file-text"></span> Modifier le cours</button></div><div class="cell-2"><button class="button bg success" onclick="location.href = `closeCourse.php?course=' . $c['secu'] . '&error=none`;"><span class="mif-done_all"></span> Clore le cours</button></div><div class="cell-2"><button class="button bg alert" onclick="Metro.dialog.open(`#' . $c['secu'] . '`)"><span class="mif-cross"></span> Annuler le cours</button></div></div>';
                    }
                    echo '</div></div>';
                }
            } else {
                echo 'Aucun cours à venir pour le moment.';
            }
            ?>
        </div>

</body>
<script src="../../js/activeMenu.js"></script>

</html>