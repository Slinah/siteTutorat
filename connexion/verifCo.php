<?php
require_once '../requests/select.php';
require_once '../requests/update.php';

session_start();

$utilisateurs = htmlentities($_POST["user"]);
$password = htmlentities($_POST["password"]);

$personne = selectPersonneByMail($utilisateurs);

$passDcrypt = password_verify($password, selectHashPasswordPersonneByMail($utilisateurs));

if ($passDcrypt == FALSE) {
    header("location: co.php?co=error");
} else {
    if (count($personne) == 0) {
        header("location: co.php?co=error");
    } else {
        $_SESSION["id_personne"] = $personne[0]["id_personne"];
        $_SESSION["nom"] = $personne[0]["nom"];
        $_SESSION["prenom"] = $personne[0]["prenom"];
        $_SESSION["role"] = $personne[0]["role"];
        $_SESSION["prof"] = verifExistsProfPersonneByIdPersonne($_SESSION["id_personne"]);
        $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
        updateToken($tkn, $personne[0]["id_personne"]);

        header("location: ../commons/views/home.php");
    }
}
