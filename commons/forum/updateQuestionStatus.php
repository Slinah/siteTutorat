<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idQuestion = $_GET['id_question'];

    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
    if ($_GET['forum'] == 'block') {
        updateStatusQuestion($idQuestion, 1);
        updateToken($tkn, $_SESSION['id_personne']);
        header("location: reponseForum.php?id_question=$idQuestion&forum=block");
    } else if ($_GET['forum'] == 'topicClosed') {
        updateStatusQuestion($idQuestion, 2);
        updateToken($tkn, $_SESSION['id_personne']);
        header("location: reponseForum.php?id_question=$idQuestion&forum=topicClosed");
    } else {
        updateStatusQuestion($idQuestion, 0);
        updateToken($tkn, $_SESSION['id_personne']);
        if ($_GET['forum'] == 'unblock') {
            header("location: reponseForum.php?id_question=$idQuestion&forum=unblock");
        } else {
            header("location: reponseForum.php?id_question=$idQuestion&forum=topicUnclosed");
        }
    }

} else {
    echo 'Bien essayé';
}
