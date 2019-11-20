<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/insert.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $course = $_GET['course'];
    $student = $_GET['student'];
    
    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);

    if (verifExistEleveCoursByIdPersonneIdCours($student, $course) == 0) {
        insertPersonneCoursEleve($course, $student);
        updateToken($tkn, $_SESSION['id_personne']);
        header('location: courses.php?course=success');
    } else {
        header('location: courses.php?course=already');
    }
} else {
    echo 'Bien essayé';
}
