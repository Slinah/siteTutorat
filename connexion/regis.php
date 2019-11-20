<?php
require_once '../requests/select.php';
require_once '../requests/insert.php';

$n = htmlentities($_POST["nom"]);
if ($n == "") {
    header("location: registration.php?regis=error");
    die;
}

$p = htmlentities($_POST["prenom"]);
if ($p == "") {
    header("location: registration.php?regis=error");
    die;
}

$m = htmlentities($_POST["mail"]);
if ($m == "") {
    header("location: registration.php?regis=error");
}
if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $_POST['mail'])) {
    header("location: registration.php?regis=error");
}

$mdp = htmlentities($_POST["pwd"]);
if ($mdp == "") {
    header("location: registration.php?regis=error");
}

$mdp_conf = htmlentities($_POST["pwd-conf"]);
if ($mdp_conf != $_POST["pwd-conf"]) {
    header("location: registration.php?regis=error");
}

$c = $_POST["classe"];
if ($c == "") {
    header("location: registration.php?regis=error");
}

$mdpCrypt = password_hash($mdp, PASSWORD_BCRYPT);
$pbymail = selectPersonneByMail($m);
$verifExist = empty($pbymail);
if ($mdp == $mdp_conf) {
    if ($verifExist == true) {
        $tkn = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
        insertPersonne($n, $p, $mdpCrypt, $m, $c, $tkn);
        header("location: ../connexion/co.php?co=success");
        var_dump($tkn);
    } else {
        header("location: registration.php?regis=already");
    }
} else {
    header("location: registration.php?regis=passErr");
}
