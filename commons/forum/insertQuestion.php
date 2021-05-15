<?php
include_once '../../requests/select.php';
include_once '../../requests/insert.php';
include_once '../../requests/update.php';

session_start();

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);

if (isset($userTkn) && $userTkn != null) {
    $titreQuestion = htmlentities($_POST["titre"]);
    if ($titreQuestion == "") {
        header("location: questionForum.php?forum=error");
        die;
    }

    $descriptionQuestion = $_POST["description"];
    if ($descriptionQuestion == "") {
        header("location: questionForum.php?forum=error");
        die;
    }

    $idMatiere = htmlentities($_POST["matiere"]);
    if ($idMatiere == "") {
        header("location: questionForum.php?forum=error");
        die;
    }

    $idPromo = htmlentities($_POST["promo"]);
    if ($idPromo == 'nonDefini'){
        $idPromo=NULL;
    }

    $localDate = strtotime('+2 hours');
    $idQuestion = strtoupper(UUID::v4());
    if (selectQuestionByIdPersonneTitreEtMatiere($_SESSION['id_personne'], $titreQuestion, $idMatiere) == "none") {
        insertQuestion($idQuestion, $titreQuestion, $descriptionQuestion, $_SESSION['id_personne'], $idMatiere, $localDate, $idPromo);
        $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
        updateToken($tkn, $_SESSION['id_personne']);
        header("location: questionForum.php");
    } else {
        header("location: questionForum.php?newq=already");
    }
} else {
    echo 'Bien essayé';
}