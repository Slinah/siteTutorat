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

    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);

    updateCoursCancel($reason, $idCours);
    updateToken($tkn, $_SESSION['id_personne']);
    header('location: courses.php?course=cancel');
} else {
    echo 'Bien essayé';
}
