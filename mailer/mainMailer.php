<?php
require_once '_lib/class.phpmailer.php';

define('GMailUser', 'scratchoverflow@gmail.com'); // utilisateur Gmail
define('GMailPWD', 'mailTutorat!'); // Mot de passe Gmail

function smtpMailer($to, $from, $from_name, $subject, $body)
{
    $mail = new PHPMailer();  // Cree un nouvel objet PHPMailer
    $mail->CharSet = 'utf-8';
    $mail->SetLanguage('fr');
    $mail->IsSMTP(); // active SMTP
    $mail->SMTPDebug = 0;  // debogage: 1 = Erreurs et messages, 2 = messages seulement
    $mail->SMTPAuth = true;  // Authentification SMTP active
    $mail->SMTPSecure = 'ssl'; // Gmail REQUIERT Le transfert securise
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = GMailUser;
    $mail->Password = GMailPWD;
    $mail->IsHTML(true);
    $mail->From = $from;
    $mail->FromName = $from_name;
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);
    // $mail->AddAddress('mathias.braux@epsi.fr');
    // $mail->AddAddress('frederic.reinold@epsi.fr');

    if (!$mail->Send()) {
        return 'Mail error: ' . $mail->ErrorInfo;
    } else {
        return true;
    }
}
