<?php
session_start();

include_once '../../requests/select.php';
include_once '../../requests/delete.php';
include_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {

    $id_reponse = $_GET['reponse'];
    $id_question = $_GET['id_question'];
    deleteLikeByIdPersonneIdReponse($_SESSION['id_personne'], $id_reponse);

    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
    updateToken($tkn, $_SESSION['id_personne']);
    header("location: reponseForum.php?id_question=$id_question&forum=deleted");
} else {
    echo 'Bien essayé';
}