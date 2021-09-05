<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/insert.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);

if (isset($userTkn) && $userTkn != null) {

    $idQuestion = $_GET["id_question"];

    insertPersonneLike($_SESSION['id_personne'],$_GET['reponse']);
    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
    updateToken($tkn, $_SESSION['id_personne']);
    header("location: reponseForum.php?id_question=$idQuestion&forum=upvoted");

} else {

    echo 'Bien essayé';

}