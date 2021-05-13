<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idMatiere = $_GET['mat'];

    if ($_POST['matiere'] == '' || $_POST['matiere'] == null) {
        $newIntitule = '';
    } else {
        $newIntitule = $_POST['matiere'];
    }

    if ($newIntitule != '') {
        $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
        updateMatiereMdf($newIntitule, $idMatiere);
        updateToken($tkn, $_SESSION['id_personne']);
        header('location: managementCourse.php?action=updated');
    } else {
        header('location: editMattersAdmin.php?mat=' . $idMatiere);
    }
} else {
    echo 'Bien essayé';
}
