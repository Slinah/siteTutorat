<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idCours = $_GET['course'];
    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);

    if ($_POST['nbheure'] != 0 || $_POST['nbheure'] != 0.00) {
        $nbHeure = $_POST['nbheure'];
        $okH = TRUE;
    } else {
        header('location: closeCourseAdmin.php?course=' . selectSecuByIdCours($idCours) . '&error=unset&usr=' . $_GET['usr']);
    }

    if ($_POST['participants'] != 0 || $_POST['participants'] != 0.00) {
        $nbParticipants = $_POST['participants'];
        $okP = TRUE;
    } else {
        header('location: closeCourseAdmin.php?course=' . selectSecuByIdCours($idCours) . '&error=unset&usr=' . $_GET['usr']);
    }

    if ($_POST['comment'] == '') {
        $courseComment = null;
    } else {
        $courseComment = $_POST['comment'];
    }

    $nbInscrits = selectCountParticipantsByIdCours($idCours);

    if ($okH && $okP) {
        updateCoursClose($courseComment, $nbInscrits, $nbParticipants, $nbHeure, $idCours);
        updateToken($tkn, $_SESSION['id_personne']);

        header('location: managementCourse.php?course=closed');
    } else {
        header('location: closeCourseAdmin.php?course=' . selectSecuByIdCours($idCours) . '&error=unset&usr=' . $_GET['usr']);
    }
} else {
    echo 'Bien essayé';
}
