<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/insert.php';
require_once '../../requests/update.php';
require_once '../../mailer/mainMailer.php';
require_once '../date.php';

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

    function secuStg($length = 15)
    {
        $lettre = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $lettre[rand(0, strlen($lettre) - 1)];
        }
        return $string;
    }
    $localDate = strtotime('+2 hours');
    $idQuestion = strtoupper(UUID::v4());
    if (selectQuestionByIdPersonneTitreEtMatiere($_SESSION['id_personne'], $titreQuestion, $idMatiere) == "none") {
        insertQuestion($idQuestion, $titreQuestion, $descriptionQuestion, $_SESSION['id_personne'], $idMatiere, secuStg());
        $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
        updateToken($tkn, $_SESSION['id_personne']);
        header("location: questionForum.php?forum=questSend");
    } else {
        header("location: questionForum.php?newq=already");
    }
} else {
    echo 'Bien essayé';
}