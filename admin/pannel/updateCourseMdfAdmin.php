<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idCours = $_GET['course'];

    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
    foreach (selectCoursMatiereNiveauByIdCours($idCours) as $cours) {
        if ($cours['intitule'] == $_POST['intitule'] || $_POST['intitule'] == '' || $_POST['intitule'] ==  null) {
            $newIntitule = '';
        } else {
            $newIntitule = htmlentities($_POST['intitule']);
        }

        if ($cours['date'] == $_POST['date'] || $_POST['date'] ==  null) {
            $newDate = '';
        } else {
            $newDate = $_POST['date'];
        }

        if ($cours['heure'] == $_POST['heure'] || $_POST['heure'] ==  null) {
            $newHeure = '';
        } else {
            $newHeure = $_POST['heure'];
        }

        if ($cours['id_matiere'] == $_POST['matiere'] || $_POST['matiere'] ==  null) {
            $newMatiere = '';
        } else {
            $newMatiere = $_POST['matiere'];
        }

        if ($cours['promo'] == $_POST['classe'] || $_POST['classe'] ==  null) {
            $newPromo = '';
        } else {
            $newPromo = $_POST['classe'];
        }

        if ($newIntitule != '' || $newDate != '' || $newHeure != '' || $newMatiere != '') {
            updateCoursMdf($newIntitule, $newDate, $newHeure, $newMatiere, $idCours);
            if ($newPromo != '') {
                updateCoursPromo($newPromo, $idCours);
                updateToken($tkn, $_SESSION['id_personne']);

                header('location: managementCourse.php?action=updated');
            } else {
                header('location: managementCourse.php?action=updated');
            }
        } else {
            if ($newPromo != '') {
                updateCoursPromo($newPromo, $idCours);
                updateToken($tkn, $_SESSION['id_personne']);

                header('location: managementCourse.php?action=updated');
            } else {
                header('location: editCourseAdmin.php?course=' . $cours['secu'] . '&error=unset&usr=' . $_GET['usr']);
            }
        }
    }
} else {
    echo 'Bien essayé';
}
