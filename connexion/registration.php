<?php
include_once '../requests/select.php';
?>
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

<!-- <body> -->

<div id="particles-js">
    <?php
    switch ($_GET["regis"]) {
        case "deco":
            echo '<script type="text/javascript">
            Metro.dialog.create({
                title: "Deconnexion effectuée avec succès.",
                content: "<div>Vous avez bien été déconnecté.</div>",
                closeButton: true
            });
            </script>';
            break;
        case "error":
            echo '<script type="text/javascript">
            Metro.dialog.create({
                title: "Formulaire mal renseigné.",
                content: "<div>Le formulaire est mal renseigné, il doit manquer des éléments.</div>",
                closeButton: true
            });
            </script>';
            break;
        case "already":
            echo '<script type="text/javascript">
            Metro.dialog.create({
                title: "Cette adresse mail existe déjà.",
                content: "<div>Ce compte existe déjà, contactez votre administrateur pour un changement de mot de passe.</div>",
                closeButton: true
            });
            </script>';
            break;
        case "passErr":
            echo '<script type="text/javascript">
                Metro.dialog.create({
                    title: "Les deux mots de passe sont différents",
                    content: "<div>Veuillez entrer les mêmes mots de passe.</div>",
                    closeButton: true
                });
                </script>';
            break;
    }
    ?>
        <form class="login-form bg-white p-6 mx-auto border bd-default win-shadow" action="regis.php" method="post">
            <h2 class="text-light">ScratchOverflow</h2>
            <div class="form-group"><input data-role="input" name="nom" placeholder="Michu" data-prepend="Nom" required></div>
            <div class="form-group"><input data-role="input" name="prenom" placeholder="Jaqueline" data-prepend="Prénom" required></div>
            <div class="form-group"><input data-role="input" name="mail" placeholder="jaqueline.michu@licorne.fr" data-prepend="Mail" required></div>
            <div class="form-group"><input data-role="input" name="pwd" placeholder="*********" data-prepend="Mot de passe" type="password" required></div>
            <div class="form-group"><input data-role="input" name="pwd-conf" placeholder="*********" data-prepend="Confirmation" type="password" required></div>
            <div class="form-group"><select name="classe" data-role="select" data-filter="false" data-prepend="Classe">
                    <optgroup label="Première année EPSI">
                        <?php
                        foreach (selectClassesPromo("B1") as $classe) {
                            echo '<option value="' . $classe['id_classe'] . '">B1 ' . $classe['classe'] . '</option>';
                        }
                        ?>
                    </optgroup>
                    <optgroup label="Deuxième année EPSI">
                        <?php
                        foreach (selectClassesPromo("B2") as $classe) {
                            echo '<option value="' . $classe['id_classe'] . '">B2 ' . $classe['classe'] . '</option>';
                        }
                        ?>
                    </optgroup>
                    <optgroup label="Troisième année EPSI">
                        <?php
                        foreach (selectClassesPromo("B3") as $classe) {
                            echo '<option value="' . $classe['id_classe'] . '">B3 ' . $classe['classe'] . '</option>';
                        }
                        ?>
                    </optgroup>
                    <optgroup label="Quatrième année EPSI">
                        <?php
                        foreach (selectClassesPromo("I1") as $classe) {
                            echo '<option value="' . $classe['id_classe'] . '">I1 ' . $classe['classe'] . '</option>';
                        }
                        ?>
                    </optgroup>
                    <optgroup label="Cinquième année EPSI">
                        <?php
                        foreach (selectClassesPromo("I2") as $classe) {
                            echo '<option value="' . $classe['id_classe'] . '">I2 ' . $classe['classe'] . '</option>';
                        }
                        ?>
                    </optgroup>
                    <optgroup label="Première année WIS">
                        <?php
                        foreach (selectClassesPromo("WIS 1") as $classe) {
                            echo '<option value="' . $classe['id_classe'] . '">WIS 1 ' . $classe['classe'] . '</option>';
                        }
                        ?>
                    </optgroup>
                    <optgroup label="Deuxième année WIS">
                        <?php
                        foreach (selectClassesPromo("WIS 2") as $classe) {
                            echo '<option value="' . $classe['id_classe'] . '">WIS 2 ' . $classe['classe'] . '</option>';
                        }
                        ?>
                    </optgroup>
                    <optgroup label="Troisième année WIS">
                        <?php
                        foreach (selectClassesPromo("WIS 3") as $classe) {
                            echo '<option value="' . $classe['id_classe'] . '">WIS 3 ' . $classe['classe'] . '</option>';
                        }
                        ?>
                    </optgroup>
                </select></div>
            <div class="form-group mt-10"><button class="button pos-center" onclick="location.href = 'regis.php';">S'inscrire</button></div>
        </form>
</div>
</div>
</body>
<script src="../js/particle.js"></script>

</html>