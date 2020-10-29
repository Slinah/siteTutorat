<?php
include_once dirname(__DIR__) . '/conf/conf.php';

$GLOBALS['db'] = new PDO("mysql:host=" . Config::SERVERNAME . ";dbname=" . Config::DBNAME, Config::USER, Config::PASSWORD);

// Mis a jour V2.0
// Desinscrit quelqu'un d'un cours
function deletePersonneCourseByIdCourseIdPersonne($idCours, $idPersonne)
{
    $deleteEleve = $GLOBALS['db']->prepare('DELETE FROM personne_cours WHERE id_cours = :idc AND id_personne = :idp AND rang_personne = 0');
    $deleteEleve->bindParam(':idc', $idCours);
    $deleteEleve->bindParam(':idp', $idPersonne);
    $deleteEleve->execute();
}

function deletePropositionByIdProposition($idProposition)
{
    $deleteProposition = $GLOBALS['db']->prepare('DELETE FROM proposition WHERE id_proposition = :idp');
    $deleteProposition->bindParam(':idp', $idProposition);
    $deleteProposition->execute();
}

// Mis a jour V2.0
// Delete une proposition a partir de son code secu
function deletePropositionBySecuCode($secuCode)
{
    $deleteProposition = $GLOBALS['db']->prepare('DELETE FROM proposition WHERE secu = :secu');
    $deleteProposition->bindParam(':secu', $secuCode);
    $deleteProposition->execute();
}

function deletePersonne($idPersonne)
{
    $deletePersonne = $GLOBALS['db']->prepare('DELETE FROM personne WHERE id_personne = :idp');
    $deletePersonne->bindParam(":idp", $idPersonne);
    $deletePersonne->execute();
}

function deleteCours($idCours)
{
    $deleteCours = $GLOBALS['db']->prepare('DELETE FROM cours WHERE id_cours = :idc');
    $deleteCours->bindParam(':idc', $idCours);
    $deleteCours->execute();
}

function deleteLog($idCours)
{
    $deleteLog = $GLOBALS['db']->prepare('DELETE FROM logs WHERE id_cours = :idc');
    $deleteLog->bindParam(':idc', $idCours);
    $deleteLog->execute();
}

function deleteMatiere($idMatiere)
{
    $deleteMatiere = $GLOBALS['db']->prepare('DELETE FROM matiere WHERE id_matiere = :idm');
    $deleteMatiere->bindParam(':idm', $idMatiere);
    $deleteMatiere->execute();
}

// Mis a jour V2.0
// Permet de régler un bug d'insert qui insert une proposition avec une matière a null
function deletePropositionWithNullMatiere(){
    $selectPropositionWithNull = $GLOBALS['db']->prepare('SELECT id_proposition FROM proposition WHERE isNull(id_matiere)');
    $selectPropositionWithNull->execute();
    $propsWithNull = $selectPropositionWithNull->fetchAll();
    foreach($propsWithNull as $prop){
        $deleteLogProposition = $GLOBALS['db']->prepare('DELETE FROM logs_proposition WHERE id_proposition = :idprop');
        $deleteLogProposition->bindParam(":idprop", $prop['id_proposition']);
        $deleteLogProposition->execute();

        $deleteProposition = $GLOBALS['db']->prepare('DELETE FROM proposition WHERE id_proposition = :idp');
        $deleteProposition->bindParam(":idp", $prop['id_proposition']);
        $deleteProposition->execute();
    }
}