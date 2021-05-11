<?php
session_start();
include_once '../../requests/select.php';

if (!isset($_SESSION["role"])) {

    header("location: ../../connexion/co.php?co=newco");
}

?>
<!DOCTYPE html>
<html>

<?php
include_once '../../bases/head.php';
?>

<body>
<?php include_once '../../bases/menu.php'; ?>
<?php
switch ($_GET["forum"]) {
    // TODO : A adapter pour le filtre par matière
}
    /*case "error":
        echo '<script type="text/javascript">
            Metro.dialog.create({
                title: "Erreur de création.",
                content: "<div>Vos informations de créations de cours sont incorrectes.</div>",
                closeButton: true
            });
            </script>';
        break;
    case "already":
        echo '<script type="text/javascript">
            Metro.dialog.create({
                title: "Vous avez déjà créer ce cours.",
                content: "<div>Ce cours à déjà été créer.</div>",
                closeButton: true
            });
            </script>';
        break;
}*/
?>
<div class="container">
    <div class="icon">
        <h1><img src="../../medias/scratchOverflow.png" alt=""></h1>
    </div>
    <h3>Les questions posées : </h3>
    <?php


    if (selectQuestionStatus() != 'none') {
        foreach (selectQuestionByStatus(0) as $c) {
            echo '<div class="card"><div class="card-header"><b>Intitule :</b> <i><span class="fg-crimson">' . $c['intitule'] . '</span></i><br><b>Matière :</b> <i><span class="fg-crimson">' . $c['matiere'] . '</span></i><br><b>A ' . date('H', strtotime($c['date'])) . 'h' . date('m', strtotime($c['date'])) . ' le ' . date("d", strtotime($c['date'])) . ' ' . getMois($c['date']) . '.</b><br><b>Par :</b> ';
        foreach (selectPersonnePromoByIdQuestionRangPersonne($c['id_question'], 1) as $p) {
            echo '<i><span class="fg-crimson">' . $p['nom'] . ' ' . $p['prenom']  . ' ' . $p['promo'] . '</span></i>';
    }
    echo '<br><b>Niveau :</b> <i><span class="fg-crimson">' . $c['promo'] . '</span></i></div><div class="card-content p-2">';
    /*if (verifExistPersonneResponse($c['id_reponse']) != 0) {
        echo '<b>Participants : </b><br>
    TODO : A utiliser pour mettre le nombre de réponses

            

    }*/
    else {
        echo 'Aucune question pour le moment';
    }
    ?>
    <br><br><br>
    <form action="insertCourse.php" method="post">
        <h3>Créer un cours</h3>
        <input data-role="input" name="intitule" placeholder="Faire des tableaux de chatons" data-prepend="Intitule" required>
        <br><input name="date" data-role="datepicker" data-year="false">
        <br><input name="heure" data-role="timepicker" data-seconds="false">
        <br><select name="matiere" data-role="select" data-filter="false" data-prepend="Matière">
            <?php
            foreach (selectMatieres() as $matieres) {
                echo '<option value="' . $matieres['id_matiere'] . '">' . $matieres['intitule'] . '</option>';
            }
            ?>
        </select>
        <br><select name="classe" data-role="select" data-filter="false" data-prepend="Niveau concerné">
            <?php
            foreach (selectPromos() as $promo) {
                echo '<option value="' . $promo['id_promo'] . '">' . $promo['promo'] . '</option>';
            }
            ?>
        </select>
        <br><button class="button success" onclick="location.href = 'insertCourse.php';"><span class="mif-checkmark"></span> Créer le cours</button>
    </form>
</div>
</div>
</body>
<script src="../../js/activeMenu.js"></script>

</html>
