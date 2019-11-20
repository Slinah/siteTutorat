<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/insert.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    insertPersonneProposition($_GET['student'], $_GET['proposal']);
    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
    updateToken($tkn, $_SESSION['id_personne']);
    header('location: proposeCourse.php?proposal=upvoted');
} else {
    echo 'Bien essayé';
}
