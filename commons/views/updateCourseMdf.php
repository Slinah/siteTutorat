<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/update.php';


$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idCours = $_GET['course'];

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
        $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
        if ($newIntitule != '' || $newDate != '' ||  $newMatiere != '') {
            updateCoursMdf($newIntitule, $newDate, $newMatiere, $idCours);
            if ($newPromo != '') {
                updateCoursPromo($newPromo, $idCours);
                updateToken($tkn, $_SESSION['id_personne']);
                header('location: courses.php?course=update');
            } else {
                header('location: courses.php?course=update');
            }
        } else {
            if ($newPromo != '') {
                updateCoursPromo($newPromo, $idCours);
                updateToken($tkn, $_SESSION['id_personne']);
                header('location: courses.php?course=update');
            } else {
                header('location: editCourse.php?course=' . $cours['secu'] . '&error=unset');
            }
        }
    }
} else {
    echo 'Bien essayé';
}
