<?php
session_start();
require_once '../../requests/delete.php';
require_once '../../requests/select.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idCours = $_GET['course'];

    deleteCours($idCours);
    deleteLog($idCours);

    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
    updateToken($tkn, $_SESSION['id_personne']);
    header('location: administration.php?action=courseSuppressed');
} else {
    echo 'Bien essayé';
}
