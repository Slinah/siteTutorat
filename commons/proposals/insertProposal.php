<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/insert.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idMatiere = $_POST['matiere'];

    $niveau = $_POST['classe'];
    
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

    if (verifExistPropositionByIdMatiereIdPromo($idMatiere, $niveau) == 'aucune proposition avec ces id') {
        insertProposition($idMatiere, $niveau, secuStg());
        insertPersonneProposition($_SESSION['id_personne'], selectLastProposition());
        insertLogProposition(selectLastProposition(), date("Y-m-d H:i:s", $localDate));
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
