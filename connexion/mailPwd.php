<?php
require_once '../requests/select.php';
require_once '../requests/update.php';
require_once '../mailer/mainMailer.php';

$mail = htmlentities($_POST['mail']);

if ($mail == '') {
    header('location: pwdLost.php');
}

if (verifExistMail($mail) != 'none') {
    function aleaPass($length = 7)
    {
        $lettre = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $lettre[rand(0, strlen($lettre) - 1)];
        }
        return $string;
    }
    $passPersonne = aleaPass();
    $mdpCrypt = password_hash($passPersonne, PASSWORD_BCRYPT);
    updatePassPersonneByMail($mail, $mdpCrypt);
    $result = smtpmailer(
        $mail,
        'https://scratchoverflow.fr',
        'ScratchOverflow',
        'ScratchOverflow - Changement de mot de passe',
        '<HTML>Bonjour,<br><br>Voici votre mot de passe temporaire suite à votre demande de changement de mot de passe : <b>' . $passPersonne . '<b><br><br><i>Ceci est un mail automatique.</i></HTML>'
    );
    header('location: co.php?co=pwd');
} else {
    header('location: pwdLost.php?mail=error');
}
