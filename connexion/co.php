<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="metro4:locale" content="fr-FR">
    <!--<link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/metro/4.2.49/css/metro-all.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!--<script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/metro/4.2.49/js/metro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="../medias/squirelMascot.png">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/particle.css">
    <title>ScratchOverflow</title>
    <meta name="google-site-verification" content="-FAkp5XQbDa-zN4Kl3UrlzR5WHeu-sbGdiroRytUeWU" />
</head>
<!-- <body class="h-vh-100 bg-darkCrimson"> -->
<div id="particles-js">

    <?php
    switch ($_GET["co"]) {
        case "error":
            echo '<script type="text/javascript">
            Metro.dialog.create({
                title: "Erreur de connexion.",
                content: "<div>Vos informations de connexion sont incorrectes.</div>",
                closeButton: true
            });
            </script>';
            break;
        case "deco":
            echo '<script type="text/javascript">
            Metro.dialog.create({
                title: "Deconnexion effectuée avec succès",
                content: "<div>Vous avez bien été déconnecté.</div>",
                closeButton: true
            });
            </script>';
    }
    ?>

        <form class="login-form bg-white p-6 mx-auto border bd-default win-shadow" data-role="validator" action="verifCo.php" data-clear-invalid="2000" data-on-error-form="invalidForm" data-on-validate-form="validateForm" method="post">
            <span style="margin-top: -10px;" class="place-right"><img class="co" src="../medias/squirelMascot.png"></span>
            <h2 class="text-light">Bienvenue sur ScratchOverflow</h2>
            <hr class="thin mt-4 mb-4 bg-white">
            <div class="form-group">
                <input name="user" type="text" data-role="input" data-prepend="<span class='mif-envelop'>" placeholder="Email....." data-validate="required email">
            </div>
            <div class="form-group">
                <input name="password" type="password" data-role="input" data-prepend="<span class='mif-key'>" placeholder="Mot de passe....." data-validate="required">
            </div>
            <div class="form-group mt-10">
                <button class="button pos-center" onclick="location.href = verifCo.php">Connexion</button>
            </div> <br>
            <a href="registration.php?regis=co"><i>Tu n'es pas inscrit ? Rejoins-nous !</i></a><br>
            <a href="pwdLost.php?mail=none"><i>Oubli de mot de passe ?</i></a>
        </form>
        <!-- <button class="button pos-bottom-center register" href="registration.php?regis=co">S'enregistrer</button> -->
</div>
</body>
<script src="../js/particle.js"></script>

</html>