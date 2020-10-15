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
    <link rel="shortcut icon" type="image/x-icon" href="../medias/scratchOverflow.png">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/particle.css">
    <title>ScratchOverflow</title>
</head>
<div id="particles-js">

    <?php
    switch ($_GET["mail"]) {
        case "error":
            echo '<script type="text/javascript">
            Metro.dialog.create({
                title: "Erreur de mail.",
                content: "<div>Le mail renseigné n\'existe pas</div>",
                closeButton: true
            });
            </script>';
            break;
    }
    ?>
        <form class="login-form bg-white p-6 mx-auto border bd-default win-shadow" data-role="validator" action="mailPwd.php" data-clear-invalid="2000" data-on-error-form="invalidForm" data-on-validate-form="validateForm" method="post">
            <span style="margin-top: -10px;" class="place-right"><img class="co" src="../medias/scratchOverflow.png"></span>
            <h2 class="text-light">Changement de mot de passe</h2>
            <hr class="thin mt-4 mb-4 bg-white">
            <div class="form-group">
                <input name="mail" type="text" data-role="input" data-prepend="<span class='mif-envelop'>" placeholder="Email....." data-validate="required email">
            </div>
            <div class="form-group mt-10">
                <button class="button pos-center" onclick="location.href = mailPwd.php">Recevoir le mail</button>
            </div>
        </form>
</div>
</body>
<script src="../js/particle.js"></script>

</html>