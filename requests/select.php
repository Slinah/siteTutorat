<?php

// Fichier de conf
include_once dirname(__DIR__) . '/conf/conf.php';

// Connexion à la base
$GLOBALS['db'] = new PDO("mysql:host=" . Config::SERVERNAME . ";dbname=" . Config::DBNAME, Config::USER, Config::PASSWORD);

// Mise à jour V2.0
// Sélection d'une personne en fonction d'un mail
function selectPersonneByMail($mailPersonne)
{
    $personne = $GLOBALS['db']->prepare("SELECT id_personne, prenom, nom, role FROM personne WHERE mail=:mail");
    $personne->bindParam(":mail", $mailPersonne);
    $personne->execute();
    $resultat = $personne->fetchAll();
    return $resultat;
}

// Mise à jour V2.0
// Sélection du mot de passe hashé en fonction du mail d'une personne
function selectHashPasswordPersonneByMail($mailPersonne)
{
    $hashPersonne = $GLOBALS['db']->prepare('SELECT password FROM personne WHERE mail = :mail');
    $hashPersonne->bindParam(":mail", $mailPersonne);
    $hashPersonne->execute();
    $hashP = $hashPersonne->fetchAll();
    $hashP = $hashP[0][0];
    return $hashP;
}

// Mise à jour V2.0
// Sélection des classes d'une promo donnée
function selectClassesPromoEcoles($promo, $ecole)
{
    $classes = $GLOBALS['db']->prepare('SELECT c.id_classe, c.intitule AS classe, p.id_promo FROM classe c JOIN promo p ON c.id_promo=p.id_promo JOIN ecole e ON p.id_ecole=e.id_ecole WHERE p.intitule = :promo AND e.intitule = :ecole ORDER BY c.fake_id ASC');
    $classes->bindParam(':promo', $promo);
    $classes->bindParam(':ecole', $ecole);
    $classes->execute();
    $classe = $classes->fetchAll();
    return $classe;
}

// Mise à jour V2.0
// Sélection des promos
function selectPromos()
{
    $promos = $GLOBALS['db']->prepare('SELECT id_promo, intitule AS promo FROM promo ORDER BY fake_id ASC');
    $promos->execute();
    $promo = $promos->fetchAll();
    return $promo;
}

// Mise à jour V2.0
// Sélection des infos d'une promo en fonction de son ID
function selectPromoByIdPromo($idPromo)
{
    $promos = $GLOBALS['db']->prepare('SELECT intitule FROM promo WHERE id_promo = :idp');
    $promos->bindParam(":idp", $idPromo);
    $promos->execute();
    $promo = $promos->fetchAll();
    $promo = $promo[0][0];
    return $promo;
}

// Mise à jour V2.0
// Sélection des matières
function selectMatieresByValidation($bool)
{
    $matieres = $GLOBALS['db']->prepare('SELECT id_matiere, intitule FROM matiere WHERE validationAdmin = :vaa ORDER BY intitule');
    $matieres->bindParam(":vaa", $bool);
    $matieres->execute();
    $matiere = $matieres->fetchAll();
    return $matiere;
}

// Deprecated
// Sélection du dernier cours rentré en base
// function selectIdLastCours()
// {
//     $lastCours = $GLOBALS['db']->prepare('SELECT id_cours FROM cours ORDER BY id_cours DESC LIMIT 1');
//     $lastCours->execute();
//     $cours = $lastCours->fetchAll();
//     $cours = $cours[0][0];
//     return $cours;
// }

// Mise à jour V2.0
// Sélection de l'ID du cours en fonction de son intitule
function selectIdCoursByIntitule($intituleCours)
{
    $idCours = $GLOBALS['db']->prepare('SELECT id_cours FROM cours WHERE intitule = :intit AND status = 0');
    $idCours->bindParam(":intit", $intituleCours);
    $idCours->execute();
    $cours = $idCours->fetchAll();
    if (empty($cours)) {
        $cours = "none";
    } else {
        $cours = $cours[0][0];
    }
    return $cours;
}

// Mise à jour V2.0
// Vérification de l'existence de la corélation prof / cours en fonction de l'ID d'une personne
function verifExistsProfPersonneByIdPersonne($idPersonne)
{
    $countCours = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM personne_cours WHERE id_personne = :idp');
    $countCours->bindParam(":idp", $idPersonne);
    $countCours->execute();
    $count = $countCours->fetchAll();
    $count = $count[0][0];
    return $count;
}

// Mise à jour V2.0
// Sélection des cours ayant un status particulier
function selectCoursByStatus($valueStatus)
{
    $cours = $GLOBALS['db']->prepare('SELECT c.id_cours AS id_cours, c.intitule AS intitule, c.date AS date, c.secu AS secu, m.intitule AS matiere, p.intitule AS promo FROM cours c JOIN matiere m ON m.id_matiere=c.id_matiere JOIN promo p ON p.id_promo=c.id_promo WHERE c.status = :status');
    $cours->bindParam(":status", $valueStatus);
    $cours->execute();
    $cour = $cours->fetchAll();
    return $cour;
}

// Mise à jour V2.0
// Sélection des cours ayant le status 0
function selectCoursStatus()
{
    $cours = $GLOBALS['db']->prepare('SELECT c.id_cours AS id_cours, c.intitule AS intitule, c.date AS date, c.secu AS secu, m.intitule AS matiere, p.intitule AS promo FROM cours c JOIN matiere m ON m.id_matiere=c.id_matiere  JOIN promo p ON p.id_promo=c.id_promo WHERE c.status = 0');
    $cours->execute();
    $cour = $cours->fetchAll();
    if (empty($cour)) {
        $cour = 'none';
    }
    return $cour;
}

// Mise à jour V2.0
// Sélection des infos personne et promo en fonction de l'id d'un cours et du rang de la personne
function selectPersonnePromoByIdCoursRangPersonne($idCours, $rangPersonne)
{
    $prof = $GLOBALS['db']->prepare('SELECT p.id_personne AS id_personne, p.nom AS nom, p.prenom AS prenom, cl.intitule AS classe, po.intitule AS promo FROM personne p JOIN personne_cours pc ON p.id_personne=pc.id_personne JOIN classe cl ON p.id_classe=cl.id_classe JOIN promo po ON cl.id_promo=po.id_promo WHERE pc.id_cours = :idc AND rang_personne = :rang');
    $prof->bindParam(":idc", $idCours);
    $prof->bindParam(":rang", $rangPersonne);
    $prof->execute();
    $p = $prof->fetchAll();
    return $p;
}

// Mise à jour V2.0
// Vérification de l'existence d'une liaison cours PROF a partir de l'id de la personne et de l'id du cours
function verifExistProfCoursByIdPersonneIdCours($idPersonne, $idCours, $rang)
{
    $personneCours = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM personne_cours WHERE id_personne = :idp AND id_cours = :idc AND rang_personne = :rang');
    $personneCours->bindParam(":idp", $idPersonne);
    $personneCours->bindParam(":idc", $idCours);
    $personneCours->bindParam(":rang", $rang);
    $personneCours->execute();
    $pc = $personneCours->fetchAll();
    $pc = $pc[0][0];
    return $pc;
}

// Mise à jour V2.0
// Vérification de l'existence d'une liaison cours ELEVE a partir de l'id de la personne et de l'id du cours
function verifExistEleveCoursByIdPersonneIdCours($idPersonne, $idCours)
{
    $personneCours = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM personne_cours WHERE id_personne = :idp AND id_cours = :idc AND rang_personne = 0');
    $personneCours->bindParam(":idp", $idPersonne);
    $personneCours->bindParam(":idc", $idCours);
    $personneCours->execute();
    $pc = $personneCours->fetchAll();
    $pc = $pc[0][0];
    return $pc;
}

// Mise à jour V2.0
// Sélectionne les infos cours, matière, niveau en fonction du status du cours, de l'id de la personne et de son rang
function selectCoursMatiereNiveauByStatusIdPersonneRang($valueStatus, $idPersonne, $rangPersonne)
{
    $cours = $GLOBALS['db']->prepare('SELECT c.id_cours AS id_cours, c.intitule AS intitule, c.date AS date, c.secu AS secu, c.duree AS duree, c.commentaires AS commentaires, c.nbParticipants AS participants, m.intitule AS matiere, p.intitule AS niveau FROM cours c JOIN matiere m ON c.id_matiere=m.id_matiere JOIN promo p ON p.id_promo=c.id_promo JOIN personne_cours pco ON c.id_cours=pco.id_cours WHERE c.status = :status AND pco.id_personne = :idp AND pco.rang_personne = :rang');
    $cours->bindParam(":status", $valueStatus);
    $cours->bindParam(":idp", $idPersonne);
    $cours->bindParam(":rang", $rangPersonne);
    $cours->execute();
    $cour = $cours->fetchAll();
    if (empty($cour)) {
        $cour = 0;
    } else {
        $cour = $cour[0][0];
    }
    return $cour;
}

// Mise à jour V2.0
// Sélectionne le cours la matière le niveau par le code de sécu, l'id de la personne et son rang
function selectCoursMatiereNiveauBySecuIdPersonneRang($secuCode, $idPersonne, $rangPersonne)
{
    $cours = $GLOBALS['db']->prepare('SELECT c.id_cours AS id_cours, c.intitule AS intitule, c.date AS date, m.intitule AS matiere, m.id_matiere AS id_matiere, p.intitule AS niveau, p.id_promo AS id_promo FROM cours c JOIN matiere m ON c.id_matiere=m.id_matiere JOIN promo p ON p.id_promo=c.id_promo JOIN personne_cours pco ON c.id_cours=pco.id_cours WHERE c.secu = :secu AND pco.id_personne = :idp AND pco.rang_personne = :rang');
    $cours->bindParam(":secu", $secuCode);
    $cours->bindParam(":idp", $idPersonne);
    $cours->bindParam(":rang", $rangPersonne);
    $cours->execute();
    $cour = $cours->fetchAll();
    return $cour;
}

// Mise à jour V2.0
// Sélectionne le cours la matière et le niveau d'un cours en fontion de son ID
function selectCoursMatiereNiveauByIdCours($idCours)
{
    $cours = $GLOBALS['db']->prepare('SELECT c.intitule AS intitule, c.date AS date, c.secu AS secu, m.id_matiere AS id_matiere, p.id_promo AS promo FROM cours c JOIN matiere m ON c.id_matiere=m.id_matiere JOIN promo p ON c.id_promo=p.id_promo WHERE c.id_cours = :idc');
    $cours->bindParam(":idc", $idCours);
    $cours->execute();
    $cour = $cours->fetchAll();
    return $cour;
}

// Mise à jour V2.0
// Sélectionne le nombre de participants a un cours en fonction de son ID
function selectCountParticipantsByIdCours($idCours)
{
    $count = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM personne_cours WHERE id_cours = :idc AND rang_personne = 0');
    $count->bindParam(":idc", $idCours);
    $count->execute();
    $cou = $count->fetchAll();
    $cou = $cou[0][0];
    return $cou;
}

// Mise à jour V2.0
// Sélectionne le code de sécu en fonction d'un ID cours
function selectSecuByIdCours($idCours)
{
    $secuCours = $GLOBALS['db']->prepare('SELECT secu FROM cours WHERE id_cours = :idc');
    $secuCours->bindParam(":idc", $idCours);
    $secuCours->execute();
    $secu = $secuCours->fetchAll();
    $secu = $secu[0][0];
    return $secu;
}

// Mise à jour V2.0
// Vérifie l'existence d'une relation cours personne en fonction de l'ID personne, de son rang et de son status
function verifExistCoursByIdPersonneRangStatus($idPersonne, $rangPersonne, $valueStatus)
{
    $existCours = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM personne_cours pc JOIN cours c ON pc.id_cours=c.id_cours WHERE pc.id_personne = :idp AND pc.rang_personne = :rng AND c.status = :stt');
    $existCours->bindParam(':idp', $idPersonne);
    $existCours->bindParam(':rng', $rangPersonne);
    $existCours->bindParam(':stt', $valueStatus);
    $existCours->execute();
    $existCour = $existCours->fetchAll();
    $existCour = $existCour[0][0];
    return $existCour;
}

// Mise à jour V2.0
// Sélectionne la matière a partir de son intitulé
function selectMatiereByIntitule($intituleMatiere)
{
    $matiere = $GLOBALS['db']->prepare('SELECT id_matiere FROM matiere WHERE intitule = :matiere');
    $matiere->bindParam(':matiere', $intituleMatiere);
    $matiere->execute();
    $mat = $matiere->fetchAll();
    if (empty($mat)) {
        $mat = 'aucune matiere avec cet intitule';
    } else {
        $mat = $mat[0][0];
    }
    return $mat;
}

// Mise à jour V2.0
// Sélectionne la dernière proposition insert dans la base
function selectIdLastPropositionByMatiereNiveau($matiere, $niveau)
{
    $proposition = $GLOBALS['db']->prepare('SELECT p.id_proposition FROM proposition p JOIN matiere m ON p.id_matiere=m.id_matiere JOIN proposition_promo pp ON p.id_proposition=pp.id_proposition JOIN promo po ON pp.id_promo=po.id_promo WHERE m.id_matiere = :idm AND po.id_promo = :idp');
    $proposition->bindParam(":idm", $matiere);
    $proposition->bindParam(":idp", $niveau);
    $proposition->execute();
    $prop = $proposition->fetchAll();
    $prop = $prop[0][0];
    return $prop;
}

// Mise à jour V2.0
// Vérification de l'existance d'une proposition en fonction de l'id de la matière et de l'id de la promo
function verifExistPropositionByIdMatiereIdPromo($idMatiere, $idPromo)
{
    $proposition = $GLOBALS['db']->prepare('SELECT id_proposition FROM proposition p JOIN proposition_promo pp ON p.id_proposition=pp.id_proposition JOIN promo po ON pp.id_promo=po.id_promo WHERE id_matiere = :idm AND po.id_promo = :idp');
    $proposition->bindParam(':idm', $idMatiere);
    $proposition->bindParam(':idp', $idPromo);
    $proposition->execute();
    $prop = $proposition->fetchAll();
    if (empty($prop)) {
        $prop = 'aucune proposition avec ces id';
    } else {
        $prop = $prop[0][0];
    }
    return $prop;
}

// Mise à jour V2.0
// Vérification de l'existance de propositions
function verifExistProposition()
{
    $proposition = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM proposition');
    $proposition->execute();
    $prop = $proposition->fetchAll();
    $prop = $prop[0][0];
    return $prop;
}

// Mise à jour V2.0
// Sélectionne les propositions matières et promos
function selectPropositionMatierePromo()
{
    $proposition = $GLOBALS['db']->prepare('SELECT p.id_proposition AS id_proposition, p.secu AS secu, po.intitule AS promo, m.intitule AS matiere from proposition p JOIN proposition_promo pp ON p.id_proposition=pp.id_proposition JOIN promo po ON pp.id_promo=po.id_promo JOIN matiere m ON p.id_matiere=m.id_matiere');
    $proposition->execute();
    $prop = $proposition->fetchAll();
    return $prop;
}

// Mise à jour V2.0
// Vérifie l'existente d'un lien personne proposition
function verifExistPersonneProposition($idPersonne, $idProposition)
{
    $verifProposition = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM personne_proposition WHERE id_personne = :idp AND id_proposition = :idpo');
    $verifProposition->bindParam(':idp', $idPersonne);
    $verifProposition->bindParam(':idpo', $idProposition);
    $verifProposition->execute();
    $verif = $verifProposition->fetchAll();
    $verif = $verif[0][0];
    return $verif;
}

// Mise à jour V2.0
// Compte le nombre de personne inscrites a une proposition en fonction de l'ID proposition
function selectCountPersonnePropositionByIdProposition($idProposition)
{
    $proposition = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM personne_proposition WHERE id_proposition = :idp');
    $proposition->bindParam(':idp', $idProposition);
    $proposition->execute();
    $prop = $proposition->fetchAll();
    $prop = $prop[0][0];
    return $prop;
}

// Mise à jour V2.0
// Sélectionne l'ID d'une proposition en fonction de son code de sécurité
function selectIdPropositionBySecu($secuCode)
{
    $idProposition = $GLOBALS['db']->prepare('SELECT id_proposition FROM proposition WHERE secu = :secu');
    $idProposition->bindParam(':secu', $secuCode);
    $idProposition->execute();
    $id = $idProposition->fetchAll();
    $id = $id[0][0];
    return $id;
}

// Mise à jour V2.0
// Sélectonne la proposition, matiere promo en fonction de l'ID proposition
function selectPropositionMatierePromoByIdProposition($idProposition)
{
    $proposition = $GLOBALS['db']->prepare('SELECT p.secu AS secu, p.id_matiere AS id_matiere, po.id_promo AS id_promo, po.intitule AS promo, m.intitule AS matiere from proposition p JOIN proposition_promo ppo ON p.id_proposition=ppo.id_proposition JOIN promo po ON ppo.id_promo=po.id_promo JOIN matiere m ON p.id_matiere=m.id_matiere WHERE p.id_proposition = :idp');
    $proposition->bindParam(':idp', $idProposition);
    $proposition->execute();
    $prop = $proposition->fetchAll();
    return $prop;
}

// Mise à jour V2.0
// Sélectionne un lien personne proposition en fonction de l'id proposition
function selectPersonnePropositionByIdProposition($idProposition)
{
    $personneProposition = $GLOBALS['db']->prepare('SELECT id_personne FROM personne_proposition WHERE id_proposition = :idp');
    $personneProposition->bindParam(':idp', $idProposition);
    $personneProposition->execute();
    $personnes = $personneProposition->fetchAll();
    return $personnes;
}

// Mise à jour V2.0
// Compte le nombre d'incrits a une proposition
function selectCountPersonnePropositionByIdPersonneIdProposition($idPersonne, $idProposition)
{
    $personneProposition = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM personne_proposition WHERE id_proposition = :idpo AND id_personne = :idpe');
    $personneProposition->bindParam(':idpo', $idProposition);
    $personneProposition->bindParam(':idpe', $idPersonne);
    $personneProposition->execute();
    $personne = $personneProposition->fetchAll();
    if (empty($personne)) {
        $personne = 'none';
    } else {
        $personne = $personne[0][0];
    }
    return $personne;
}

// Mis à jour V2.1
// Return les cours clos par tuteurs et le nombres d'heures dispensées
function selectTuteurCoursClosHeures()
{
    $tuteurHeure = $GLOBALS['db']->prepare('SELECT p.id_personne AS id_personne, p.nom AS nom, p.prenom AS prenom, po.intitule AS promo, SUM(c.duree) AS duree FROM personne p INNER JOIN classe cl ON p.id_classe=cl.id_classe INNER JOIN promo po ON cl.id_promo=po.id_promo INNER JOIN personne_cours pc ON p.id_personne=pc.id_personne INNER JOIN cours c ON pc.id_cours=c.id_cours WHERE c.status=1 AND pc.rang_personne=1 GROUP BY p.id_personne, p.nom, p.prenom, po.intitule ORDER BY SUM(c.duree) DESC');
    $tuteurHeure->execute();
    $tutHeure = $tuteurHeure->fetchAll();
    return $tutHeure;
}

// Mis à jour V2.1
// Return les cours clos le nombres d'heures dispensées
function selectHeuresMatieresCoursClos()
{
    $heureMatiere = $GLOBALS['db']->prepare('SELECT m.id_matiere AS id_matiere, m.intitule AS matiere, SUM(c.duree) AS duree FROM cours c INNER JOIN matiere m ON c.id_matiere=m.id_matiere WHERE c.status=1 GROUP BY m.id_matiere, m.intitule ORDER BY SUM(c.duree) DESC');
    $heureMatiere->execute();
    $heuMat = $heureMatiere->fetchAll();
    return $heuMat;
}

// Mis à jour V2.1
// Return le nombre d'heures en fonctions d'une matière et d'un tuteur
function selectHeuresByIdMatiereIdTuteur($idPersonne, $idMatiere)
{
    $heureMatiere = $GLOBALS['db']->prepare('SELECT SUM(c.duree) AS duree FROM cours c INNER JOIN personne_cours pc ON c.id_cours=pc.id_cours WHERE c.status=1 AND pc.rang_personne=1 AND c.id_matiere=:idm AND pc.id_personne=:idp');
    $heureMatiere->bindParam(':idm', $idMatiere);
    $heureMatiere->bindParam(':idp', $idPersonne);
    $heureMatiere->execute();
    $heure = $heureMatiere->fetchAll();
    if (empty($heure)) {
        $heure = 'none';
    } else {
        $heure = $heure[0][0];
    }
    return $heure;
}

// Mis à jour V2.1
// Return le nombre d'heures en fonction d'une matière
function selectHeureByMatiere($idMatiere)
{
    $heure = $GLOBALS['db']->prepare('SELECT SUM(c.duree) AS duree FROM cours c WHERE c.id_matiere=:idm AND c.status=1 GROUP BY c.id_matiere');
    $heure->bindParam(':idm', $idMatiere);
    $heure->execute();
    $heur = $heure->fetchAll();
    $heur = $heur[0][0];
    return $heur;
}

// Mis à jour V2.1
// Return le nombre d'heures total
function selectHeuresTotal()
{
    $heures = $GLOBALS['db']->prepare('SELECT SUM(c.duree) AS duree FROM cours c WHERE c.status=1');
    $heures->execute();
    $heure = $heures->fetchAll();
    $heure = $heure[0][0];
    return $heure;
}

// Mis à jour V2.1
// Return le nombre d'heures par matière par id de promo
function selectMatieresHeuresByIdPromo($idPromo)
{
    $heureMatiere = $GLOBALS['db']->prepare('SELECT SUM(c.duree) AS duree, m.intitule AS matiere FROM cours c INNER JOIN matiere m ON c.id_matiere=m.id_matiere INNER JOIN promo p ON c.id_promo=p.id_promo WHERE c.status=1 AND p.id_promo=:idp GROUP BY m.intitule ORDER BY SUM(c.duree) DESC');
    $heureMatiere->bindParam(':idp', $idPromo);
    $heureMatiere->execute();
    $heure = $heureMatiere->fetchAll();
    return $heure;
}

// Mis à jour V2.1
// Return le nombre de participants par matière par id de promo
function selectParticipantsMatiereByIdPromo($idPromo)
{
    $nbParticipant = $GLOBALS['db']->prepare('SELECT m.intitule AS matiere, SUM(c.nbParticipants) AS participants FROM cours c INNER JOIN matiere m ON c.id_matiere=m.id_matiere INNER JOIN promo p ON c.id_promo=p.id_promo WHERE c.status=1 AND p.id_promo=:idp GROUP BY m.intitule');
    $nbParticipant->bindParam(':idp', $idPromo);
    $nbParticipant->execute();
    $nbPart = $nbParticipant->fetchAll();
    return $nbPart;
}

// Mis à jour V2.1
// Return le nombre de participants par mois par id de promo
function selectPartMoisByIdPromo($idPromo)
{
    $partMois = $GLOBALS['db']->prepare('SELECT SUM(c.nbParticipants) AS participants, MONTH(c.date) AS mois FROM cours c INNER JOIN promo p ON c.id_promo=p.id_promo WHERE c.status=1 AND p.id_promo=:idp GROUP BY MONTH(c.date) ORDER BY MONTH(c.date)');
    $partMois->bindParam(':idp', $idPromo);
    $partMois->execute();
    $part = $partMois->fetchAll();
    return $part;
}

// Mis à jour V2.1
// Return les logs
function selectLogs()
{
    $logs = $GLOBALS['db']->prepare('SELECT heure AS heure, id_cours AS id_cours FROM logs');
    $logs->execute();
    $l = $logs->fetchAll();
    return $l;
}

// Mis à jour V2.1
// Return un cours en fonction d'un log
function selectCourseProfByLogs($idCours)
{
    $cours = $GLOBALS['db']->prepare('SELECT c.duree AS heure, c.date as date, m.intitule as matiere, p.nom AS nom, p.prenom AS prenom, po.intitule AS promo FROM cours c INNER JOIN matiere m on c.id_matiere=m.id_matiere INNER JOIN personne_cours pc ON pc.id_cours=c.id_cours INNER JOIN personne p ON pc.id_personne=p.id_personne INNER JOIN promo po ON po.id_promo=c.id_promo WHERE pc.rang_personne=1 AND c.id_cours=:idc');
    $cours->bindParam(':idc', $idCours);
    $cours->execute();
    $cour = $cours->fetchAll();
    return $cour;
}

// Mis à jour V2.1
// Return la liste des user
function selectPersonnePromoClasse()
{
    $admin = $GLOBALS['db']->prepare('SELECT p.id_personne AS id_personne, p.nom AS nom, p.prenom AS prenom, p.role AS role, po.intitule AS promo, c.intitule AS classe FROM personne p JOIN classe c ON p.id_classe=c.id_classe JOIN promo po ON c.id_promo=po.id_promo WHERE id_personne > 1 ORDER BY po.fake_id ASC, c.fake_id ASC');
    $admin->execute();
    $adm = $admin->fetchAll();
    return $adm;
}

// Mis à jour V2.1
// Return le mail d'un user en fonction de son ID
function selectMailByIdPersonne($idPersonne)
{
    $mail = $GLOBALS['db']->prepare('SELECT mail FROM personne WHERE id_personne = :idp');
    $mail->bindParam(':idp', $idPersonne);
    $mail->execute();
    $m = $mail->fetchAll();
    $m = $m[0][0];
    return $m;
}

// Mis à jour V2.1
// Return la liste des cours en fonction des tuteurs
function selectCoursTuteurMatiere()
{
    $cours = $GLOBALS['db']->prepare('SELECT c.id_cours AS id_cours, c.secu AS secu, c.status AS status, c.date AS date, p.nom AS nom, p.prenom AS prenom, p.id_personne AS id_personne, po.intitule AS promo, m.intitule AS matiere FROM cours c JOIN personne_cours pc on c.id_cours=pc.id_cours JOIN personne p ON pc.id_personne=p.id_personne JOIN promo po ON c.id_promo=po.id_promo JOIN matiere m ON c.id_matiere=m.id_matiere WHERE pc.rang_personne=1 ORDER BY c.date DESC');
    $cours->execute();
    $cour = $cours->fetchAll();
    return $cour;
}

// Mis à jour V2.1
// Return l'intitule d'une matière
function selectMatiereById($idMat)
{
    $matiere = $GLOBALS['db']->prepare('SELECT intitule FROM matiere WHERE id_matiere = :idm');
    $matiere->bindParam(':idm', $idMat);
    $matiere->execute();
    $matiere = $matiere->fetchAll();
    $mati = $matiere[0][0];
    return $mati;
}

// Mise à jour V2.0
// Select le token d'une personne a l'aide de son ID
function selectTokenByIdPersonne($idPersonne)
{
    $token = $GLOBALS['db']->prepare('SELECT token FROM personne WHERE id_personne = :idp');
    $token->bindParam(':idp', $idPersonne);
    $token->execute();
    $token = $token->fetchAll();
    $token = $token[0][0];
    return $token;
}

// Mis a jour V2.0
// Return la list des props dans logs
function selectLogsProp()
{
    $logsProp = $GLOBALS['db']->prepare('SELECT heure AS heure, id_proposition AS id_proposition FROM logs_proposition');
    $logsProp->execute();
    $l = $logsProp->fetchAll();
    return $l;
}

// Mis a jour V2.1
// Return la list des props
function selectProposition()
{
    $proposition = $GLOBALS['db']->prepare('SELECT m.intitule AS matiere, po.intitule AS promo FROM proposition p JOIN matiere m ON p.id_matiere=m.id_matiere JOIN proposition_promo pp ON p.id_proposition=pp.id_proposition JOIN promo po ON pp.id_promo=po.id_promo');
    $proposition->execute();
    $p = $proposition->fetchAll();
    return $p;
}

// Mis a jour V2.1
// Return une prop
function selectPropositionByLogs($idProposition)
{
    $proposition = $GLOBALS['db']->prepare('SELECT m.intitule AS matiere, po.intitule AS promo FROM proposition p JOIN matiere m ON p.id_matiere=m.id_matiere JOIN proposition_promo pp ON p.id_proposition=pp.id_proposition JOIN promo po ON pp.id_promo=po.id_promo WHERE id_proposition = :idp');
    $proposition->bindParam(':idp', $idProposition);
    $proposition->execute();
    $prop = $proposition->fetchAll();
    return $prop;
}

// Mise à jour V2.0
// Récupère les infos d'une personne par son ID
function selectPersonneByIdPersonne($idPersonne)
{
    $personne = $GLOBALS['db']->prepare('SELECT p.prenom AS prenom, p.nom AS nom, p.password AS mdp, p.mail AS mail, c.intitule AS classe FROM personne p JOIN classe c ON p.id_classe=c.id_classe WHERE id_personne = :idp');
    $personne->bindParam(':idp', $idPersonne);
    $personne->execute();
    $per = $personne->fetchAll();
    return $per;
}

// Mise à jour V2.0
// Check si le mail d'une personne existe
function verifExistMail($mailPersonne)
{
    $mail = $GLOBALS['db']->prepare('SELECT id_personne FROM personne where mail = :mail');
    $mail->bindParam(':mail', $mailPersonne);
    $mail->execute();
    $m = $mail->fetchAll();
    if (empty($m)) {
        $m = 'none';
    } else {
        $m = $m[0][0];
    }
    return $m;
}

// Mise à jour V2.0
// Check s'il y a plus d'un cours pour une promo sélectionnée
function selectCountCoursByPromo($promo)
{
    $countCours = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM cours c JOIN promo p ON c.id_promo=p.id_promo WHERE p.promo = :promo AND c.status = 1');
    $countCours->bindParam(":promo", $promo);
    $countCours->execute();
    $count = $countCours->fetchAll();
    if (empty($count)){
        $count = 'none';
    } else {
        $count = $count[0][0];
    }
    return $count;
}

// Mis a jour V2.1
// Select le nb de participants a un cours
function selectInscritParticipantsCours($promo)
{
    $inscPart = $GLOBALS['db']->prepare('SELECT DATE_FORMAT(c.date, "%d %M %Y") AS date, m.intitule AS matiere, c.nbParticipants AS participants, p.intitule AS niveau FROM cours c JOIN matiere m ON c.id_matiere=m.id_matiere JOIN promo p ON c.id_promo=p.id_promo WHERE p.id_promo=:idp AND c.status > 0 ORDER BY c.date ASC');
    $inscPart->bindParam(":promo", $promo);
    $inscPart->execute();
    $insc = $inscPart->fetchAll();
    return $insc;
}


// Mise à jour V2.0
// Permet de vérifier si des gens sont inscrits au cours
function verifExistPersonneInscrits($idCours){
    $inscrits = $GLOBALS['db']->prepare('SELECT count(*) FROM personne_cours WHERE id_cours = :idc AND rang_personne = 0');
    $inscrits->bindParam(":idc", $idCours);
    $inscrits->execute();
    $count = $inscrits->fetchAll();
    $c = $count[0][0];
    return $c;
}

// Mise à jour V2.0
// Permet de sélectionner toutes les matieres et leurs ID de la base
function selectMatieres(){
    $matieres = $GLOBALS['db']->prepare('SELECT id_matiere, intitule FROM matiere WHERE validationAdmin = 1 ORDER BY intitule');
    $matieres->execute();
    return $matieres->fetchAll();
}

// Mise à jour V2.0
// Renvoie le prenom d'une personne en fonction de son ID
function selectPrenomById($idPersonne){
    $prenom = $GLOBALS['db']->prepare('SELECT prenom FROM personne WHERE id_personne = :idp');
    $prenom->bindParam(":idp", $idPersonne);
    $prenom->execute();
    $prenom = $prenom->fetchAll();
    return $prenom[0][0];
}

// Mise à jour V2.0
// Renvoie le nom d'une personne en fonction de son ID
function selectNomById($idPersonne){
    $nom = $GLOBALS['db']->prepare('SELECT nom FROM personne WHERE id_personne = :idp');
    $nom->bindParam(":idp", $idPersonne);
    $nom->execute();
    $nom = $nom->fetchAll();
    return $nom[0][0];
}

//Mise à jour V2.1
// Sélection des questions ayant un status particulier
function selectQuestionByStatus($valueStatusQuestion){
    $questions = $GLOBALS['db']->prepare('SELECT qf.id_question AS id_question, p.prenom AS prenom, p.nom AS nom, 
                                          qf.titre AS titre, qf.description AS description, qf.status AS status, 
                                          qf.date AS date, qf.secu AS secu, m.intitule AS matiere
                                          FROM question_forum qf 
                                          JOIN matiere m ON m.id_matiere=qf.id_matiere 
                                          JOIN personne p ON p.id_personne=qf.id_personne
                                          WHERE qf.status = :status
                                          ORDER BY date DESC');
    $questions->bindParam(":status", $valueStatusQuestion);
    $questions->execute();
    $question = $questions->fetchAll();
    return $question;
}

//Mise à jour V2.1
// Sélection des questions ayant le status 0
function selectQuestionStatus(){
    $question_forum = $GLOBALS['db']->prepare('SELECT qf.id_question AS id_question, qf.id_personne AS id_personne, 
                                               qf.titre AS titre, qf.description AS description, qf.status AS status, 
                                               qf.date AS date, qf.secu AS secu, m.intitule AS matiere
                                               FROM question_forum qf JOIN matiere m ON m.id_matiere=qf.id_matiere  
                                               WHERE qf.status = 0
                                               ORDER BY date DESC');
    $question_forum->execute();
    $questions = $question_forum->fetchAll();
        if (empty($questions)) {
            $questions = 'none';
        }
    return $questions;
}

//Mise à jour V2.1
// Sélectionne des infos personne et promo suivant l'id de la question
function selectPersonnePromoByIdQuestion($idQuestion){
    $questionneur = $GLOBALS['db']->prepare('SELECT questionneur.id_personne AS id_questionneur, 
                                             questionneur.nom AS nom, questionneur.prenom AS prenom, 
                                             cl.intitule AS classe, po.intitule AS promo 
                                             FROM question_forum qf JOIN personne questionneur ON  qf.id_personne = questionneur.id_personne 
                                             JOIN classe cl ON questionneur.id_classe=cl.id_classe 
                                             JOIN promo po ON cl.id_promo=po.id_promo
                                             WHERE id_question = :idq');
    $questionneur->bindParam(':idq', $idQuestion);
    $questionneur->execute();
    $personneQuestionneur = $questionneur->fetchAll();
    return $personneQuestionneur;
}

//Mise à jour V2.1
//Sélectionne les infos question suivant l'id de la personne, le titre de la question et l'id de la matière
function selectQuestionByIdPersonneTitreEtMatiere($idPersonne, $titreQuestion, $idMatiere){
    $questionneur = $GLOBALS['db']->prepare(
        'SELECT *
         FROM question_forum qf 
         WHERE id_personne = :idp AND titre = :titre AND id_matiere = :idm');
    $questionneur->bindParam(':idp', $idPersonne);
    $questionneur->bindParam(':titre', $titreQuestion);
    $questionneur->bindParam(':idm', $idMatiere);
    $questionneur->execute();
    $personneQuestionneur = $questionneur->fetchAll();

    if (empty($personneQuestionneur)) {
        $personneQuestionneur = "none";
    } else {
        $personneQuestionneur = $personneQuestionneur[0][0];
    }
    return $personneQuestionneur;
}

// Mis à jour V2.1
// Return le nombre d'heures par matière par id de promo
function selectQuestionByIdPromo($idMatiere)
{
    $filtreMatiere = $GLOBALS['db']->prepare(
        'SELECT qf.id_question AS id_question, p.prenom AS prenom, p.nom AS nom, 
              qf.titre AS titre, qf.description AS description, qf.status AS status, 
              qf.date AS date, qf.secu AS secu, m.intitule AS matiere
              FROM question_forum qf 
              JOIN matiere m ON m.id_matiere=qf.id_matiere 
              JOIN personne p ON p.id_personne=qf.id_personne
              WHERE qf.status = 0
                AND m.id_matiere = :idm
              ORDER BY date DESC');
    $filtreMatiere->bindParam(':idm', $idMatiere);
    $filtreMatiere->execute();
    $filtre = $filtreMatiere->fetchAll();
    return $filtre;
}

//Mise à jour V2.1
// Sélection la question correpondant à l'id demandé.
function selectQuestionById($id_question){
    $questions = $GLOBALS['db']->prepare('SELECT qf.id_question AS id_question, qf.id_personne AS id_personne, 
                                               qf.titre AS titre, qf.description AS description, qf.status AS status, 
                                               qf.date AS date, qf.secu AS secu, m.intitule AS matiere
                                               FROM question_forum qf JOIN matiere m ON m.id_matiere=qf.id_matiere  
                                               WHERE qf.id_question = :idq');
    $questions->bindParam(":idq", $id_question);
    $questions->execute();
    $question = $questions->fetchAll();
    return $question;
}

//Mise à jour V2.1
// Sélection des réponses ayant un status particulier et filtré par date
function selectResponseByStatusIdQuestionByDate($valueStatusResponse,$id_question){
    $reponses = $GLOBALS['db']->prepare('SELECT rf.id_reponse AS id_reponse, rf.id_personne AS id_personne, 
                                               rf.message_reponse AS message, rf.id_question AS id_question, rf.status AS status, 
                                               rf.date AS date, rf.secu AS secu
                                               FROM reponse_forum rf JOIN question_forum qf ON qf.id_question=rf.id_question
                                               WHERE rf.status = :status AND rf.id_question= :idq ORDER BY date DESC');
    $reponses->bindParam(":status", $valueStatusResponse);
    $reponses->bindParam(":idq", $id_question);
    $reponses->execute();
    $reponse = $reponses->fetchAll();
    return $reponse;
}

//Mise à jour V2.1
// Sélection des réponses ayant un status particulier et filtrées par likes
function selectResponseByStatusIdQuestionFilterByLike($valueStatusResponse,$id_question){
    $reponses = $GLOBALS['db']->prepare('SELECT COUNT(v.id), rf.id_reponse AS id_reponse, rf.id_personne AS id_personne, 
                                               rf.message_reponse AS message, rf.id_question AS id_question, rf.status AS status, 
                                               rf.date AS date, rf.secu AS secu FROM reponse_forum rf 
                                            JOIN question_forum qf ON rf.id_question=qf.id_question 
                                            JOIN vote v ON rf.id_reponse=v.id_reponse GROUP BY rf.id_reponse ORDER BY 1 DESC');
    $reponses->bindParam(":status", $valueStatusResponse);
    $reponses->bindParam(":idq", $id_question);
    $reponses->execute();
    $reponse = $reponses->fetchAll();
    return $reponse;
}

//Mise à jour V2.1
// Sélection des réponses ayant le status 0
function selectResponseStatus($id_question){
    $reponse = $GLOBALS['db']->prepare('SELECT rf.id_reponse AS id_reponse, rf.id_personne AS id_personne, 
                                               rf.message_reponse AS message, rf.id_question AS id_question, rf.status AS status, 
                                               rf.date AS date, rf.secu AS secu
                                               FROM reponse_forum rf JOIN question_forum qf ON qf.id_question=rf.id_question
                                               WHERE rf.status = 0 AND rf.id_question= :idq');
    $reponse->bindParam(":idq", $id_question);
    $reponse->execute();
    $reponses = $reponse->fetchAll();
    if (empty($reponses)) {
        $reponses = 'none';
    }
    return $reponses;
}

//Mise à jour V2.1
// Sélectionne des infos personne et promo suivant l'id de la réponse
function selectPersonnePromoByIdReponse($idReponse){
    $repondant = $GLOBALS['db']->prepare('SELECT repondant.id_personne AS id_repondant, repondant.nom AS nom, repondant.prenom AS prenom, cl.intitule AS classe, po.intitule AS promo FROM reponse_forum rf JOIN personne repondant ON  rf.id_personne = repondant.id_personne JOIN classe cl ON repondant.id_classe=cl.id_classe JOIN promo po ON cl.id_promo=po.id_promo WHERE id_reponse = :idr');
    $repondant->bindParam(':idr', $idReponse);
    $repondant->execute();
    $personneRepondant = $repondant->fetchAll();
    return $personneRepondant;
}

function selectIdReponseByMessage($message){
    $idReponse = $GLOBALS['db']->prepare('SELECT id_reponse FROM reponse_forum WHERE message_reponse = :mess AND status = 0');
    $idReponse->bindParam(":mess", $message);
    $idReponse->execute();
    $reponse = $idReponse->fetchAll();
    if (empty($reponse)) {
        $reponse = "none";
    } else {
        $reponse = $reponse[0][0];
    }
    return $reponse;
}

// Mise à jour V2.1
// Vérifie l'existence d'un lien personne Like
function verifExistPersonneVote($idPersonne, $idReponse)
{
    $verifLike = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM vote WHERE id_personne = :idp AND id_reponse = :idr');
    $verifLike->bindParam(':idp', $idPersonne);
    $verifLike->bindParam(':idr', $idReponse);
    $verifLike->execute();
    $verif = $verifLike->fetchAll();
    $verif = $verif[0][0];
    return $verif;
}

// Mise à jour V2.1
// Compte le nombre de personne qui ont liké la réponse
function selectCountVoteByIdReponse($idReponse)
{
    $vote = $GLOBALS['db']->prepare('SELECT COUNT(*) FROM vote WHERE id_reponse = :idr');
    $vote->bindParam(':idr', $idReponse);
    $vote->execute();
    $votes = $vote->fetchAll();
    $votes = $votes[0][0];
    return $votes;
}

// Mise à jour V2.1
// Sélectionne le nombre de réponses à une question cours en fonction de l'ID question
function selectCountResponseByIdQuestion($idQuestion)
{
    $countResponse = $GLOBALS['db']->prepare(
        'SELECT COUNT(*) 
         FROM reponse_forum 
         WHERE reponse_forum.id_question = :idq');
    $countResponse->bindParam(':idq', $idQuestion);
    $countResponse->execute();
    $nbResponse = $countResponse->fetchAll();
    $nbResponse = $nbResponse[0][0];
    return $nbResponse;
}