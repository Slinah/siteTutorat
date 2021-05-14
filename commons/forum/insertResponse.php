<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/insert.php';
require_once '../../requests/update.php';
require_once '../../mailer/mainMailer.php';
require_once '../date.php';


$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idQuestion = $_POST["idQuestion"];
    $messageReponse = htmlentities($_POST["message"]);
    if ($idQuestion == "") {
        header("location: reponseForum.php?id_question=$idQuestion&forum=error");
        die;
    }

    if ($messageReponse == "") {
        header("location: reponseForum.php?id_question=$idQuestion&forum=error");
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
    $id_reponse = strtoupper(UUID::v4());
    if (selectIdReponseByMessage($messageReponse) == "none") {
        insertReponse($id_reponse, $messageReponse, $_SESSION['id_personne'], $idQuestion, $localDate, secuStg());
        $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
        updateToken($tkn, $_SESSION['id_personne']);
        header("location: ../views/home.php?callback=forum");
    } else {
        header("location: reponseForum.php?id_question=$idQuestion=&forum=already");
    }
} else {
    echo 'Bien essayé';
}
