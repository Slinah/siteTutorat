<?php
include_once dirname(__DIR__) . '/conf/conf.php';

$GLOBALS['db'] = new PDO("mysql:host=" . Config::SERVERNAME . ";dbname=" . Config::DBNAME, Config::USER, Config::PASSWORD);

function insertPersonne($nomPersonne, $prenomPersonne, $passPersonne, $mailPersonne, $idClasse, $token)
{
    $personne = $GLOBALS['db']->prepare('INSERT INTO personne(nom, prenom, role, mdp, mail, token, id_classe) VALUES (:nom, :prenom, 0, :mdp, :mail, :tk, :idc)');
    $personne->bindParam(":nom", $nomPersonne);
    $personne->bindParam(":prenom", $prenomPersonne);
    $personne->bindParam(":mdp", $passPersonne);
    $personne->bindParam(":mail", $mailPersonne);
    $personne->bindParam(":tk", $token);
    $personne->bindParam(":idc", $idClasse);
    $personne->execute();
}

function insertCours($intituleCours, $heureCours, $dateCours, $idMatiere, $secuCode)
{
    $cours = $GLOBALS['db']->prepare('INSERT INTO cours(intitule, heure, date, id_matiere, secu) VALUES (:int, :heure, :date, :idm, :secu)');
    $cours->bindParam(":int", $intituleCours);
    $cours->bindParam(":heure", $heureCours);
    $cours->bindParam(":date", $dateCours);
    $cours->bindParam(":idm", $idMatiere);
    $cours->bindParam(":secu", $secuCode);
    $cours->execute();
}

function insertPersonneCoursProf($idCours, $idPersonne)
{
    $personneCours = $GLOBALS['db']->prepare('INSERT INTO personne_cours(id_personne, id_cours, rang_personne) VALUES (:idp, :idc, 1)');
    $personneCours->bindParam(":idp", $idPersonne);
    $personneCours->bindParam(":idc", $idCours);
    $personneCours->execute();
}

function insertPersonneCoursEleve($idCours, $idPersonne)
{
    $personneCours = $GLOBALS['db']->prepare('INSERT INTO personne_cours(id_personne, id_cours, rang_personne) VALUES (:idp, :idc, 0)');
    $personneCours->bindParam(":idp", $idPersonne);
    $personneCours->bindParam(":idc", $idCours);
    $personneCours->execute();
}

function insertCoursPromo($idCours, $idPromo)
{
    $coursPromo = $GLOBALS['db']->prepare('INSERT INTO cours_promo(id_cours, id_promo) VALUES (:idc, :idp)');
    $coursPromo->bindParam(":idp", $idPromo);
    $coursPromo->bindParam(":idc", $idCours);
    $coursPromo->execute();
}

function insertMatiere($intituleMatiere)
{
    $matiere = $GLOBALS['db']->prepare('INSERT INTO matiere(intitule) VALUES (:intitule)');
    $matiere->bindParam(":intitule", $intituleMatiere);
    $matiere->execute();
}

function insertProposition($idMatiere, $idPromo, $secuCode)
{
    $proposition = $GLOBALS['db']->prepare('INSERT INTO proposition(id_matiere, id_promo, secu) VALUES (:idm, :idp, :secu)');
    $proposition->bindParam(":idm", $idMatiere);
    $proposition->bindParam(":idp", $idPromo);
    $proposition->bindParam(":secu", $secuCode);
    $proposition->execute();
}

function insertPersonneProposition($idPersonne, $idProposition)
{
    $personneProposition = $GLOBALS['db']->prepare('INSERT INTO personne_proposition(id_personne, id_proposition) VALUES (:idpe, :idpo)');
    $personneProposition->bindParam(':idpe', $idPersonne);
    $personneProposition->bindParam(':idpo', $idProposition);
    $personneProposition->execute();
}

function insertLog($idCours, $time)
{
    $logCours = $GLOBALS['db']->prepare('INSERT INTO logs(id_cours, heure) VALUES (:cours, :time)');
    $logCours->bindParam(':cours', $idCours);
    $logCours->bindParam(':time', $time);
    $logCours->execute();
}

function insertLogProposition($idProposition, $time)
{
    $logProposition = $GLOBALS['db']->prepare('INSERT INTO logs_proposition(id_proposition, heure) VALUES (:prop, :time)');
    $logProposition->bindParam(':prop', $idProposition);
    $logProposition->bindParam(':time', $time);
    $logProposition->execute();
}
