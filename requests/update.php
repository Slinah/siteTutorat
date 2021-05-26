<?php
include_once dirname(__DIR__) . '/conf/conf.php';

$GLOBALS['db'] = new PDO("mysql:host=" . Config::SERVERNAME . ";dbname=" . Config::DBNAME, Config::USER, Config::PASSWORD);

// Mis a jour V2.0
// Modification d'un cours
function updateCoursMdf($newIntitule, $newDate, $newMatiere, $idCours, $newPromo)
{
    if ($newIntitule != '') {
        $updateIntitule = $GLOBALS['db']->prepare('UPDATE cours SET intitule = :intitule WHERE id_cours = :idc');
        $updateIntitule->bindParam(":intitule", $newIntitule);
        $updateIntitule->bindParam(":idc", $idCours);
        $updateIntitule->execute();
    }
    if ($newDate != '') {
        $updateDate = $GLOBALS['db']->prepare('UPDATE cours SET date = :date WHERE id_cours = :idc');
        $updateDate->bindParam(":date", $newDate);
        $updateDate->bindParam(":idc", $idCours);
        $updateDate->execute();
    }
    if ($newMatiere != '') {
        $updateMatiere = $GLOBALS['db']->prepare('UPDATE cours SET id_matiere = :idm WHERE id_cours = :idc');
        $updateMatiere->bindParam(":idm", $newMatiere);
        $updateMatiere->bindParam(":idc", $idCours);
        $updateMatiere->execute();
    }
    if ($newPromo != ''){
        $updatePromo = $GLOBALS['db']->prepare('UPDATE cours SET id_promo = :idp WHERE id_cours = :idc');
        $updatePromo->bindParam(":idp", $newPromo);
        $updatePromo->bindParam(":idc", $idCours);
        $updatePromo->execute();
    }
}

// Mis a jour V2.0
// Modification du niveau d'un cours
// function updateCoursPromo($idPromo, $idCours)
// {
//     $updateCoursPromo = $GLOBALS['db']->prepare('UPDATE cours_promo SET id_promo = :idp WHERE id_cours = :idc');
//     $updateCoursPromo->bindParam(":idp", $idPromo);
//     $updateCoursPromo->bindParam(":idc", $idCours);
//     $updateCoursPromo->execute();
// }


// Mis a jour V2.0
// Fermeture d'un cours aporès sa réalisation
function updateCoursClose($courseComment, $nbParticipants, $nbHeure, $idCours)
{
    $updateCours =  $GLOBALS['db']->prepare('UPDATE cours SET commentaires = :comm, nbParticipants = :part, duree = :time, status = 1 WHERE id_cours = :idc');
    $updateCours->bindParam(":comm", $courseComment);
    $updateCours->bindParam(":part", $nbParticipants);
    $updateCours->bindParam(":time", $nbHeure);
    $updateCours->bindParam(":idc", $idCours);
    $updateCours->execute();
}

// Mis a jour V2.0
// Met a jours un cours ou le cours est annulé
function updateCoursCancel($raison, $idCours)
{
    $updateCours =  $GLOBALS['db']->prepare('UPDATE cours SET commentaires = :comm, status = 2 WHERE id_cours = :idc');
    $updateCours->bindParam(":comm", $raison);
    $updateCours->bindParam(":idc", $idCours);
    $updateCours->execute();
}

function updatePersonnePromote($idUser)
{
    $updateRole = $GLOBALS['db']->prepare('UPDATE personne SET role = 1 WHERE id_personne = :idp');
    $updateRole->bindParam(":idp", $idUser);
    $updateRole->execute();
}

function updatePersonneDemote($idUser)
{
    $updateRole = $GLOBALS['db']->prepare('UPDATE personne SET role = 0 WHERE id_personne = :idp');
    $updateRole->bindParam(":idp", $idUser);
    $updateRole->execute();
}

function updateMatiereMdf($intituleMatiere, $idMatiere)
{
    $updateMatiere = $GLOBALS['db']->prepare('UPDATE matiere SET intitule = :int WHERE id_matiere = :idm');
    $updateMatiere->bindParam(':int', $intituleMatiere);
    $updateMatiere->bindParam(':idm', $idMatiere);
    $updateMatiere->execute();
}

// Mis a jour V2.0
// Update le token des personnes
function updateToken($token, $idPersonne)
{
    $updateToken = $GLOBALS['db']->prepare('UPDATE personne SET token = :tk WHERE id_personne = :idp');
    $updateToken->bindParam(':tk', $token);
    $updateToken->bindParam(':idp', $idPersonne);
    $updateToken->execute();
}

// Mis a jour V2.0
// Update le mot de passe d'une personne
function updatePassPersonneByMail($mail, $pass)
{
    $passPersonne = $GLOBALS['db']->prepare('UPDATE personne SET password = :mdp WHERE mail = :mail');
    $passPersonne->bindParam(':mdp', $pass);
    $passPersonne->bindParam(':mail', $mail);
    $passPersonne->execute();
}

// Mis a jour V2.1
// Met à jour le status d'une question bloqué(1), sujet-clos (2) ou débloqué et non-clos (0)
function updateStatusQuestion($idQuestion, $status)
{
    $updateQuestion =  $GLOBALS['db']->prepare('UPDATE question_forum SET status = :status WHERE id_question = :idq');
    $updateQuestion->bindParam(":idq", $idQuestion);
    $updateQuestion->bindParam(":status", $status);
    $updateQuestion->execute();
}
