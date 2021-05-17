<?php
include_once dirname(__DIR__) . '/conf/conf.php';
include_once 'UUID.php';

$GLOBALS['db'] = new PDO("mysql:host=" . Config::SERVERNAME . ";dbname=" . Config::DBNAME, Config::USER, Config::PASSWORD);

// Mis a jour V2.0
// Insertion d'une personne
function insertPersonne($nomPersonne, $prenomPersonne, $passPersonne, $mailPersonne, $idClasse, $token)
{
    $idp = strtoupper(UUID::v4());
    $nomPersonneUpcase = strtoupper($nomPersonne);
    $prenomPersonneFirst = ucfirst($prenomPersonne);
    $personne = $GLOBALS['db']->prepare('INSERT INTO personne(id_personne, id_classe, nom, prenom, role, password, mail, token) VALUES (:idp, :idc, :nom, :prenom, 0, :mdp, :mail, :tk)');
    $personne->bindParam(":idp", $idp);
    $personne->bindParam(":idc", $idClasse);
    $personne->bindParam(":nom", $nomPersonneUpcase);
    $personne->bindParam(":prenom", $prenomPersonneFirst);
    $personne->bindParam(":mdp", $passPersonne);
    $personne->bindParam(":mail", $mailPersonne);
    $personne->bindParam(":tk", $token);
    $personne->execute();
}

// Mis a jour V2.0
// Insertion d'un cours
function insertCours($idCours, $intituleCours, $dateCours, $idMatiere, $secuCode, $idPromo)
{
    $cours = $GLOBALS['db']->prepare('INSERT INTO cours(id_cours, intitule, date, id_matiere, secu, id_promo) VALUES (:idc, :int, :date, :idm, :secu, :idp)');
    $cours->bindParam(":idc", $idCours);
    $cours->bindParam(":int", $intituleCours);
    $cours->bindParam(":date", $dateCours);
    $cours->bindParam(":idm", $idMatiere);
    $cours->bindParam(":secu", $secuCode);
    $cours->bindParam(":idp", $idPromo);
    $cours->execute();
}

// Mis a jour V2.0
// Insere la liaison cours tuteur
function insertPersonneCoursProf($idCours, $idPersonne)
{
    $personneCours = $GLOBALS['db']->prepare('INSERT INTO personne_cours(id_personne, id_cours, rang_personne) VALUES (:idp, :idc, 1)');
    $personneCours->bindParam(":idp", $idPersonne);
    $personneCours->bindParam(":idc", $idCours);
    $personneCours->execute();
}

// Mis a jour V2.0
// Insertion d'un lien entre un eleve et un cours
function insertPersonneCoursEleve($idCours, $idPersonne)
{
    $personneCours = $GLOBALS['db']->prepare('INSERT INTO personne_cours(id_personne, id_cours, rang_personne) VALUES (:idp, :idc, 0)');
    $personneCours->bindParam(":idp", $idPersonne);
    $personneCours->bindParam(":idc", $idCours);
    $personneCours->execute();
}

// Mis a jour V2.0
// Insertion d'une matière
function insertMatiere($intituleMatiere)
{
    $idm = strtoupper(UUID::v4());
    $matiere = $GLOBALS['db']->prepare('INSERT INTO matiere(id_matiere, intitule) VALUES (:idm, :intitule)');
    $matiere->bindParam(":idm", $idm);
    $matiere->bindParam(":intitule", $intituleMatiere);
    $matiere->execute();
}

// Mis a jour V2.0
// Insertion d'une proposition
function insertProposition($idProposition, $idMatiere, $secuCode)
{
    $proposition = $GLOBALS['db']->prepare('INSERT INTO proposition(id_proposition, secu, id_matiere) VALUES (:idpr, :secu, :idm)');
    $proposition->bindParam(":idpr", $idProposition);
    $proposition->bindParam(":secu", $secuCode);
    $proposition->bindParam(":idm", $idMatiere);
    $proposition->execute();
}

// Mis a jour V2.0
// Insertion d'un lien entre proposition et promo
function insertPropositionPromo($idProposition, $idPromo){
    $proposition = $GLOBALS['db']->prepare('INSERT INTO proposition_promo(id_proposition, id_promo) VALUES (:idprop, :idprom)');
    $proposition->bindParam(":idprop", $idProposition);
    $proposition->bindParam(":idprom", $idPromo);
    $proposition->execute();
}

// Mis a jour V2.0
// Insertion du lien personne proposition
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

// Mis a jour V2.0
// Insertion de log proposition
function insertLogProposition($idProposition, $time)
{
    $log = strtoupper(UUID::v4());
    $logProposition = $GLOBALS['db']->prepare('INSERT INTO logs_proposition(id_log, id_proposition, heure) VALUES (:log, :prop, :time)');
    $logProposition->bindParam(':log', $log);
    $logProposition->bindParam(':prop', $idProposition);
    $logProposition->bindParam(':time', $time);
    $logProposition->execute();
}

// Mis a jour V2.0
// Insertion d'une réponse
function insertReponse($idReponse, $messageReponse, $idPersonne, $idQuestion, $secuCode)
{
    $reponse = $GLOBALS['db']->prepare('INSERT INTO reponse_forum(id_reponse, message_reponse, id_personne, id_question, date, secu) VALUES (:idr, :mess, :idp, :idq, NOW(), :secuCode )');
    $reponse->bindParam(":idr", $idReponse);
    $reponse->bindParam(":mess", $messageReponse);
    $reponse->bindParam(":idp", $idPersonne);
    $reponse->bindParam(":idq", $idQuestion);
    $reponse->bindParam(":secuCode", $secuCode);
    $reponse->execute();
}

// Mis a jour V2.0
// Insertion du lien personnne reponse (Like)
function insertPersonneLike($idPersonne, $idReponse)
{
    $vote = $GLOBALS['db']->prepare('INSERT INTO vote(id_personne, id_reponse) VALUES (:idp, :idr)');
    $vote->bindParam(":idp", $idPersonne);
    $vote->bindParam(':idr', $idReponse);
    $vote->execute();
}