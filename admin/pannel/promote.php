<?php
session_start();
require_once '../../requests/update.php';
require_once '../../requests/select.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idUser = $_GET['user'];

    updatePersonnePromote($idUser);

    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
    updateToken($tkn, $_SESSION['id_personne']);
    header('location: managementUser.php?action=promoted');
} else {
    echo 'Bien essayé';
}
