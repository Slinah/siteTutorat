<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/insert.php';
require_once '../../requests/update.php';
require_once '../../mailer/mainMailer.php';
require_once '../date.php';


$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $i = htmlentities($_POST["intitule"]);
    if ($i == "") {
        header("location: newCourse.php?newc=error");
        die;
    }

    $d = $_POST["date"];
    if ($d == "") {
        header("location: newCourse.php?newc=error");
        die;
    }

    $h = $_POST["heure"];
    if ($h == "") {
        header("location: newCourse.php?newc=error");
        die;
    }

    $m = $_POST["matiere"];
    if ($m == "") {
        header("location: newCourse.php?newc=error");
        die;
    }

    $c = $_POST["classe"];
    if ($c == "") {
        header("location: newCourse.php?newc=error");
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
    if (selectIdCoursByIntitule($i) == "none") {
        insertCours($i, $h, $d, $m, secuStg());
        insertPersonneCoursProf(selectIdLastCours(), $_SESSION['id_personne']);
        insertCoursPromo(selectIdLastCours(), $c);
        insertLog(selectIdLastCours(), date("Y-m-d H:i:s", $localDate));
        if (selectMailByIdPersonne($_SESSION['id_personne']) != "cedric.menanteau@epsi.fr") {
            $mailToSend = 'Pouvez-vous envoyer un mail au tuteur de ce cours (<b>' . selectMailByIdPersonne($_SESSION['id_personne']) . '</b> ou à <b>cedric.menanteau@epsi.fr</b>) ';
        } else {
            $mailToSend = 'Pouvez-vous envoyer un mail au tuteur de ce cours (<b>cedric.menanteau@epsi.fr</b>) ';
        }
        $result = smtpmailer(
            'cedric.menanteau@epsi.fr',
            'https://scratchoverflow.fr',
            'ScratchOverflow',
            'ScratchOverflow - Nouveau cours',
            '<HTML>Bonjour,<br><br>Un nouveau cours a été crée pour les <b>' . selectPromoByIdPromo($c) . '</b>.<br>Il est prévu pour le <i><b>' . date("d", strtotime($d)) . ' '  . getMois($d) . '</b></i> à partir de <i><b>' . date("H:i", strtotime($h)) . '</b></i>.<br><br>
    ' . $mailToSend . 'avec une liste de salles libres à ces horaires ?<br><br>Merci d\'avance !<br><br><i>Ceci est un mail automatique.</i></HTML>'
        );
        if (true !== $result) {
            // erreur -- traiter l'erreur
            echo $result;
        }
        $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
        updateToken($tkn, $_SESSION['id_personne']);
        header("location: ../views/home.php?callback=course");
    } else {
        header("location: newCourse.php?newc=already");
    }
} else {
    echo 'Bien essayé';
}
