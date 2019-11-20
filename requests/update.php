<?php
include_once dirname(__DIR__) . '/conf/conf.php';

$GLOBALS['db'] = new PDO("mysql:host=" . Config::SERVERNAME . ";dbname=" . Config::DBNAME, Config::USER, Config::PASSWORD);

function updateCoursMdf($newIntitule, $newDate, $newHeure, $newMatiere, $idCours)
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
    if ($newHeure != '') {
        $updateDate = $GLOBALS['db']->prepare('UPDATE cours SET heure = :heure WHERE id_cours = :idc');
        $updateDate->bindParam(":heure", $newHeure);
        $updateDate->bindParam(":idc", $idCours);
        $updateDate->execute();
    }
    if ($newMatiere != '') {
        $updateDate = $GLOBALS['db']->prepare('UPDATE cours SET id_matiere = :idm WHERE id_cours = :idc');
        $updateDate->bindParam(":idm", $newMatiere);
        $updateDate->bindParam(":idc", $idCours);
        $updateDate->execute();
    }
}

function updateCoursPromo($idPromo, $idCours)
{
    $updateCoursPromo = $GLOBALS['db']->prepare('UPDATE cours_promo SET id_promo = :idp WHERE id_cours = :idc');
    $updateCoursPromo->bindParam(":idp", $idPromo);
    $updateCoursPromo->bindParam(":idc", $idCours);
    $updateCoursPromo->execute();
}

function updateCoursClose($courseComment, $nbInscrits, $nbParticipants, $nbHeure, $idCours)
{
    $updateCours =  $GLOBALS['db']->prepare('UPDATE cours SET commentaires = :comm, nbInscrits = :ins, nbParticipants = :part, duree = :time, status = 1 WHERE id_cours = :idc');
    $updateCours->bindParam(":comm", $courseComment);
    $updateCours->bindParam(":ins", $nbInscrits);
    $updateCours->bindParam(":part", $nbParticipants);
    $updateCours->bindParam(":time", $nbHeure);
    $updateCours->bindParam(":idc", $idCours);
    $updateCours->execute();
}

function updateCoursCancel($raison, $nbInscrits, $idCours)
{
    $updateCours =  $GLOBALS['db']->prepare('UPDATE cours SET commentaires = :comm, nbInscrits = :ins, status = 2 WHERE id_cours = :idc');
    $updateCours->bindParam(":comm", $raison);
    $updateCours->bindParam(":ins", $nbInscrits);
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

function updateToken($token, $idPersonne)
{
    $updateToken = $GLOBALS['db']->prepare('UPDATE personne SET token = :tk WHERE id_personne = :idp');
    $updateToken->bindParam(':tk', $token);
    $updateToken->bindParam(':idp', $idPersonne);
    $updateToken->execute();
}

function updatePassPersonneByMail($mail, $pass)
{
    $passPersonne = $GLOBALS['db']->prepare('UPDATE personne SET mdp = :mdp WHERE mail = :mail');
    $passPersonne->bindParam(':mdp', $pass);
    $passPersonne->bindParam(':mail', $mail);
    $passPersonne->execute();
}
