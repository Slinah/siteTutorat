<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idCours = $_GET['course'];

    if ($_POST['nbheure'] != 0 || $_POST['nbheure'] != 0.00) {
        $nbHeure = $_POST['nbheure'];
        $okH = TRUE;
    } else {
        header('location: closeCourse.php?course=' . selectSecuByIdCours($idCours) . '&error=unset');
    }

    if ($_POST['participants'] != 0 || $_POST['participants'] != 0.00) {
        $nbParticipants = $_POST['participants'];
        $okP = TRUE;
    } else {
        header('location: closeCourse.php?course=' . selectSecuByIdCours($idCours) . '&error=unset');
    }

    if ($_POST['comment'] == '') {
        $courseComment = null;
    } else {
        $courseComment = htmlentities($_POST['comment']);
    }
    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);

    // $nbInscrits = selectCountParticipantsByIdCours($idCours);

    if ($okH && $okP) {
        updateCoursClose($courseComment, $nbParticipants, $nbHeure, $idCours);
        updateToken($tkn, $_SESSION['id_personne']);
        header('location: courses.php?course=closed');
    } else {
        header('location: closeCourse.php?course=' . selectSecuByIdCours($idCours) . '&error=unset');
    }
} else {
    echo 'Bien essayé';
}
