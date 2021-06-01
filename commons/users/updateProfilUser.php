<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
/**
 * Check si le formulaire est renseigné de façon sécurisée et correctement
 *
 * @param $personne array informations de l'utilisateur en base de donnees
 * @param $tkn string token de securite sur roles
 */
function checkAndUpdatePassword($personne, $tkn)
{
    $oldPassword = htmlentities($_POST['password']);
    $newPassword = htmlentities($_POST['newPassword']);
    $confirmPassword = htmlentities($_POST['confirmPassword']);

    if($oldPassword != '' || $newPassword != '' || $confirmPassword != '' ){
        if (isEmptyPasswordFields($oldPassword, $newPassword, $confirmPassword)
            //gère le cas où le mot de passe existe déjà
            || password_verify($oldPassword, $personne['mdp'])
            || arePasswordDifferent($confirmPassword, $newPassword)
            || isSamePassword($oldPassword, $newPassword, $confirmPassword)){
            header('location: profileView.php?users=passError');
            exit;
        }else {
            updatePassword(password_hash($newPassword, PASSWORD_BCRYPT), $personne['id']);
            updateToken($tkn, $personne['id']);
        }
    }
}

/**
 * gère si le mot de passe d'origine est égal au nouveau mot de passe
 * ou si le mot de passe d'origine est égal au mot de passe confirmé
 *
 * @param $oldPassword string l'ancien mot de passe
 * @param $newPassword string le nouveau mot de passe
 * @param $confirmPassword string confirmation du nouveau mot de passe
 * @return bool true si les deux mots de passes sont identiques
 */

function isSamePassword($oldPassword, $newPassword, $confirmPassword)
{
    return (($oldPassword == $newPassword) || ($oldPassword == $confirmPassword));
}

/**
 * gère le cas où le mot de passe confirmé est différent du mot de passe renseigné
 *
 * @param $confirmPassword string confirmation du nouveau mot de passe
 * @param $newPassword string le nouveau mot de passe
 * @return bool true si les deux mots de passes sont différents
 */

function arePasswordDifferent($confirmPassword, $newPassword)
{
    return ($confirmPassword != $newPassword);
}

/**
 * gère le cas où un des champs password ne sont pas rempli
 *
 * @param $oldPassword string l'ancien mot de passe
 * @param $newPassword string le nouveau mot de passe
 * @param $confirmPassword string confirmation du nouveau mot de passe
 * @return bool true si un des mots de passe est vide
 */
function isEmptyPasswordFields($oldPassword, $newPassword, $confirmPassword)
{
    return $oldPassword == '' || $newPassword == '' || $confirmPassword == '';
}

/**
 * Modification de la classe de l'utilisateur en base de données
 *
 * @param $personne array informations de l'utilisateur en base de donnees
 * @param $tkn string token de securite sur roles
 */
function updateClasse($personne, $tkn)
{
    if ($personne['classe'] == $_POST['newclasse'] || $_POST['newclasse'] == null && $_POST['newclasse'] != $personne['classe']) {
        $newClasse = '';
    } else {
        $newClasse = $_POST['newclasse'];
    }
    if ($newClasse != '') {
        updateClassUser($newClasse, $personne['id']);
        updateToken($tkn, $personne['id']);
    } else {
        header('location: profileView.php?users=error');
    }
}

/**
 * Modification du mail de l'utilisateur en base de données
 *
 * @param $personne array informations de l'utilisateur en base de donnees
 * @param $tkn string token de securite sur roles
 */
function updateMail($personne, $tkn)
{
//Verif si le nouveau mail est identique à l'ancien mail,
//s'il est vide,
//s'il est null
    if ($personne['mail'] == $_POST['newmail']
                || $_POST['newmail'] == ''
                || $_POST['newmail'] == null)
    {//On laisse vide
        $newMail = '';
    } else {
        $newMail = htmlentities($_POST['newmail']);
    }

    if ($newMail != ''){
        if (1 != preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $newMail)) {
            header("location: profileView.php?users=mailError");
            exit;
        }else {
            updateMailUser($newMail, $personne['id']);
            updateToken($tkn, $personne['id']);
        }
    }

}

if (isset($userTkn) && $userTkn != null) {
    $personne = selectPersonneByIdPersonne($_SESSION['id_personne']);
    $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);

        updateMail($personne, $tkn);

        updateClasse($personne, $tkn);

        checkAndUpdatePassword($personne, $tkn);

        header('location: profileView.php?users=updateProfil');

} else {
    echo 'Bien essayé';
}
