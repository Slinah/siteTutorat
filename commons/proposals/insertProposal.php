<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/insert.php';
require_once '../../requests/update.php';
require_once '../../requests/delete.php';
require_once '../../requests/UUID.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {

    $idMatiere = !empty($_POST['matiere']) ? $_POST['matiere'] : null;
    $niveau = !empty($_POST['classe']) ? $_POST['classe'] : null;
    // if (isset($_POST['matiere'])) {
    //     $idMatiere = $_POST['matiere'];
    // } else {
    //     header("location: proposeCourse.php?proposal=error");
    // }

    // if (isset($_POST['classe'])) {
    //     $niveau = $_POST['classe'];
    // } else {
    //     header("location: proposeCourse.php?proposal=error");
    // }

    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
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

    $idProposition = strtoupper(UUID::v4());

    if (verifExistPropositionByIdMatiereIdPromo($idMatiere, $niveau) == 'aucune proposition avec ces id') {
        insertProposition($idProposition, $idMatiere, secuStg());
        insertPropositionPromo($idProposition, $niveau);
        insertPersonneProposition($_SESSION['id_personne'], $idProposition);
        insertLogProposition($idProposition, date("Y-m-d H:i:s", $localDate));
        deletePropositionWithNullMatiere();
        updateToken($tkn, $_SESSION['id_personne']);
        header("location: proposeCourse.php?proposal=success");
    } else {
        insertPersonneProposition($_SESSION['id_personne'], selectPropositionMatierePromo($idMatiere, $niveau));
        updateToken($tkn, $_SESSION['id_personne']);
        header("location: proposeCourse.php?proposal=creaupvoted");
    }
} else {
    echo 'Bien essayé';
}
