<?php
session_start();
include_once '../../requests/select.php';
include_once '../date.php';

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
case "error":
    echo '<script type="text/javascript">
        Metro.dialog.create({
            title: "Erreur de création.",
            content: "<div>Vos informations de créations de cours sont incorrectes.</div>",
            closeButton: true
        });
        </script>';
    break;
//case "already":
//    echo '<script type="text/javascript">
//        Metro.dialog.create({
//            title: "Vous avez déjà créer ce cours.",
//            content: "<div>Ce cours à déjà été créer.</div>",
//            closeButton: true
//        });
//        </script>';
//    break;
}
?>
<div class="container">
    <div class="icon">
        <h1><img src="../../medias/scratchOverflow.png" alt=""></h1>
    </div>
    <?php
    $id_question = $_GET['id_question'];
   foreach (selectQuestionById($id_question) as $qf){
        echo '<div class="card" id="backgroundcolorQ">
                <div class="card-header">
                    <b>Intitule :</b> <i><span class="fg-crimson">' . $qf['titre'] . '</span></i><br>
                    <b>Description :</b> <i><span class="fg-crimson">' . $qf['description'] . '</span></i><br>
                    <b>Matière :</b> <i><span class="fg-crimson">' . $qf['matiere'] . '</span></i><br>
                    <b>A ' . date('H', strtotime($qf['date'])) . 'h' . date('m', strtotime($qf['date'])) . ' le ' . date("d", strtotime($qf['date'])) . ' ' . getMois($qf['date']) . '.</b><br>
                    <b>Par :</b> ';

                    foreach (selectPersonnePromoByIdQuestion($qf['id_question']) as $p) {
                        echo '<i><span class="fg-crimson">' . $p['nom'] . ' ' . $p['prenom'] . ' ' . $p['promo'] . '</span></i>';
                    }?>
                </div>
                    <form action="insertResponse.php" method="post">
                        <input type="hidden" value="<?php echo $id_question?>" name="idQuestion">
                        <textarea data-role="textarea" placeholder="Votre réponse" name="message"></textarea>
                        <button class="button success" onclick="location.href = 'insertResponse.php';"> Répondre</button>
                    </form>
                </div><br>
<?php
    }
    echo '<h3>Liste des réponses : </h3>';
    if (selectResponseStatus($id_question) != 'none') {
        foreach (selectResponseByStatusIdQuestion(0, $id_question) as $rf) {

            echo '<div class="card"><div class="card-header">
                     <p><span class="fg-crimson">' . $rf['message'] . '</span></p><br>
                     <i>A ' . date('H', strtotime($qf['date'])) . 'h' . date('m', strtotime($qf['date'])) . ' le ' . date("d", strtotime($qf['date'])) . ' ' . getMois($qf['date']) . '.</i><br>
                     <b>Par :</b> ';

                foreach (selectPersonnePromoByIdReponse($rf['id_reponse']) as $p) {
                    echo '<i><span class="fg-crimson">' . $p['nom'] . ' ' . $p['prenom'] . ' ' . $p['promo'] . '</span></i>';
                }

                // TODO à utiliser pour les votes :
    ?>
    <!--<form action="insertCourse.php" method="post">
        <h3>Créer un cours</h3>
        <input data-role="input" name="intitule" placeholder="Faire des tableaux de chatons" data-prepend="Intitule" required>
        <br><input name="date" data-role="datepicker" data-year="false">
        <br><input name="heure" data-role="timepicker" data-seconds="false">
        <br><select name="matiere" data-role="select" data-filter="false" data-prepend="Matière">

        </select>
        <br><button class="button success" onclick="location.href = 'insertCourse.php';">
            <span class="mif-checkmark"></span>
            Créer le cours</button>
    </form>

                '<div class="card-content p-2">';
                if (verifExistPersonneResponse($qf['id_reponse']) != 0) {
                echo '<b>Participants : </b><br>';
                }
                //TODO : A utiliser pour mettre le nombre de réponses
                '</div></a>';-->
       <?php }

    }else {
        echo 'Aucune réponse pour le moment';
    }
    ?>
    <br><br><br>

</div>
</body>
<script src="../../js/activeMenu.js"></script>

</html>

