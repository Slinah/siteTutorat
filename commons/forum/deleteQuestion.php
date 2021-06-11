<?php
session_start();
require_once '../../requests/delete.php';
require_once '../../requests/select.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idQuestion = $_GET['question'];
    deleteQuestionByIdQuestion($idQuestion);

    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
    updateToken($tkn, $_SESSION['id_personne']);
    header('location: questionForum.php?forum=questDelete');
} else {
    echo 'Bien essayé';
}