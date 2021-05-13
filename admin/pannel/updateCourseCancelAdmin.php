<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idCours = $_GET['course'];

    if ($_GET['reason'] == 'sick') {
        $reason = 'Peux pas assurer le cours';
    } else {
        $reason = 'Personne venu';
    }

    $nbInscrits = selectCountParticipantsByIdCours($idCours);

    updateCoursCancel($reason, $nbInscrits, $idCours);

    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
    updateToken($tkn, $_SESSION['id_personne']);
    header('location: managementCourse.php?action=cancel');
} else {
    echo 'Bien essayé';
}
