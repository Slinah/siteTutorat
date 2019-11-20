<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/insert.php';
require_once '../../requests/delete.php';
require_once '../../requests/update.php';
require_once '../../mailer/mainMailer.php';
require_once '../date.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
if (isset($userTkn) && $userTkn != null) {
    $idPersonne = $_GET['student'];
    $idProposition = selectIdPropositionBySecu($_GET['proposal']);
    $date = $_POST['date'];
    $heure = $_POST['heure'];

    $localDate = strtotime('+2 hours');
    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);

    foreach (selectPropositionMatierePromoByIdProposition($idProposition) as $p) {
        $intitule = $p['matiere'] . ' ' . $p['promo'];
        insertCours($intitule, $heure, $date, $p['id_matiere'], $_GET['proposal']);
        $coursInserted = selectIdLastCours();
        insertLog($coursInserted, date("Y-m-d H:i:s", $localDate));
        insertCoursPromo($coursInserted, $p['id_promo']);
        insertPersonneCoursProf($coursInserted, $idPersonne);
        foreach (selectPersonnePropositionByIdProposition($idProposition) as $pp) {
            insertPersonneCoursEleve($coursInserted, $pp['id_personne']);
        }
        deletePropositionByIdProposition($idProposition);
        if (selectMailByIdPersonne($idPersonne) != "cedric.menanteau@epsi.fr") {
            $mailToSend = 'Pouvez-vous envoyer un mail au tuteur de ce cours (<b>' . selectMailByIdPersonne($idPersonne) . '</b> ou à <b>cedric.menanteau@epsi.fr</b>) ';
        } else {
            $mailToSend = 'Pouvez-vous envoyer un mail au tuteur de ce cours (<b>cedric.menanteau@epsi.fr</b>) ';
        }
        $result = smtpmailer(
            'cedric.menanteau@epsi.fr',
            'https://scratchoverflow.fr',
            'ScratchOverflow',
            'ScratchOverflow - Nouveau cours',
            '<HTML>Bonjour,<br><br>Un nouveau cours a été crée pour les <b>' . $p['promo'] . '</b>.<br>Il est prévu pour le <i><b>' . date("d", strtotime($date)) . ' '  . getMois($date) . '</b></i> à partir de <i><b>' . date("H:i", strtotime($heure)) . '</b></i>.<br><br>
    ' . $mailToSend . 'avec une liste de salles libres à ces horaires ?<br><br>Merci d\'avance !<br><br><i>Ceci est un mail automatique.</i></HTML>'
        );
        if (true !== $result) {
            // erreur -- traiter l'erreur
            echo $result;
        }
    }
    updateToken($tkn, $_SESSION['id_personne']);

    header('location: ../views/courses.php?course=new');
} else {
    echo 'Bien essayé';
}
