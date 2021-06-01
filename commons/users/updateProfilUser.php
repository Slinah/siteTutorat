<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/update.php';

$userTkn = selectTokenByIdPersonne($_SESSION['id_personne']);
/**
 * @param $personne
 * @param $tkn
 */
function checkAndUpdatePassword($personne, $tkn)
{
    $oldPassword = htmlentities($_POST['password']);
    $newPassword = htmlentities($_POST['newPassword']);
    $confirmPassword = htmlentities($_POST['confirmPassword']);

    if($oldPassword != '' || $newPassword != '' || $confirmPassword != '' ){
        // gere le cas où un des champs password ne sont pas rempli
        if (isEmptyPasswordFields($oldPassword, $newPassword, $confirmPassword)
            //gère le cas où le mot de passe existe déjà
            || password_verify($oldPassword, $personne['mdp'])
            //gère le cas où le mot de passe confirmé est différent du mot de passe renseigné
            || isPasswordAreDifferent($confirmPassword, $newPassword)
            //gère si le mot de passe d'origine est égal au nouveau mot de passe
            //ou si le mot de passe d'origine est égal au mot de passe confirmé
            || isSamePassword($oldPassword, $newPassword, $confirmPassword)){
            header('location: profileView.php?users=passError');
            exit;
        }else {
            updatePassword(password_hash($newPassword, PASSWORD_BCRYPT), $personne['id']);
            updateToken($tkn, $personne['id']);
            var_dump($newPassword);
            die();
        }
    }
}

/**
 * @param $oldPassword
 * @param $newPassword
 * @param $confirmPassword
 * @return bool
 */
function isSamePassword($oldPassword, $newPassword, $confirmPassword)
{
    return (($oldPassword == $newPassword) || ($oldPassword == $confirmPassword));
}

/**
 * @param $confirmPassword
 * @param $newPassword
 * @return bool
 */
function isPasswordAreDifferent($confirmPassword, $newPassword)
{
    return ($confirmPassword != $newPassword);
}

/**
 * @param $oldPassword
 * @param $newPassword
 * @param $confirmPassword
 * @return bool
 */
function isEmptyPasswordFields($oldPassword, $newPassword, $confirmPassword)
{
    return $oldPassword == '' || $newPassword == '' || $confirmPassword == '';
}

/**
 * @param $personne
 * @param $tkn
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
 * @param $personne
 * @param $tkn
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
