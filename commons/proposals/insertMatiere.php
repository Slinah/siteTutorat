<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/insert.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $matiere = htmlentities($_POST['matiere']);
    if ($matiere == "") {
        header('location: proposeCourse.php?proposal=error');
        die;
    }
    if (selectMatiereByIntitule($matiere) == 'aucune matiere avec cet intitule') {
        insertMatiere($matiere);
    }
    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
    updateToken($tkn, $_SESSION['id_personne']);
    header("location: proposeCourse.php?proposal=mat");
} else {
    echo 'Bien essayé';
}
