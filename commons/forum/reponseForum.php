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

case "error":
    echo '<script type="text/javascript">
        Metro.dialog.create({
            title: "Erreur de création.",
            content: "<div>Vos informations de créations de cours sont incorrectes.</div>",
            closeButton: true
        });
        </script>';
    break;
case "upvoted":
    echo '<script>Metro.toast.create("Vous avez voté pour la réponse", null, null, "success");</script>';
    break;

case "deleted":
    echo '<script>Metro.toast.create("Vous avez supprimé votre vote avec succès.", null, null, "success");</script>';
    break;

case "repdeleted":
    echo '<script>Metro.toast.create("La réponse à été supprimée avec succès.", null, null, "success");</script>';
    break;
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
                    <b>A ' . date('H\\hi', strtotime($qf['date'])) . ' le ' . date("d", strtotime($qf['date'])) . ' ' . getMois($qf['date']) . '.</b><br>
                    <b>Par :</b> ';

                    foreach (selectPersonnePromoByIdQuestion($qf['id_question']) as $p) {
                        echo '<i><span class="fg-crimson">' . $p['nom'] . ' ' . $p['prenom'] . ' ' . $p['promo'] . '</span></i>';
                    }?>
                </div>
                    <form action="insertResponse.php" method="post">
                        <input id="idQuestion" type="hidden" value="<?php echo $id_question?>" name="idQuestion">
                        <?php
                        if ($qf['status']==1) {
                            echo ' <textarea readonly data-role="textarea" data-cls-textarea="ribbed-red fg-white border bd-amber" placeholder="Votre réponse" name="message">Les réponses sont bloquées pour cette question</textarea>
                        <div class="grid">
                            <div class="row">
                                <div class="cell">';
                        } else {
                            echo ' <textarea data-role="textarea" placeholder="Votre réponse" name="message"></textarea>
                         <div class="grid">
                            <div class="row">
                                <div class="cell">
                                    <button class="button success" onclick="location.href = `insertResponse.php`;"> Répondre</button>';
                        }?>

                    </form>
                    <?php
                    if ($_SESSION["role"] == 1) {
                        if ($qf['status']==1){
                            echo " 
                        <button class='button bg-crimson fg-white' onclick='Metro.dialog.open(`#" . $qf['secu'] . "`)'><span class='mif-cross'></span> Débloquer </button>
                        </div>
                        </div>
                        </div>";
                        }else{
                            echo " 
                        <button class='button bg-crimson fg-white' onclick='Metro.dialog.open(`#" . $qf['secu'] . "`)'><span class='mif-cross'></span> Bloquer</button>
                        </div>
                        </div>
                        </div>";
                        }
                        if ($qf['status']==1) {
                            echo '<div id="' . $qf['secu'] . '" class="dialog warning" data-role="dialog">
                                <div class="dialog-title">Voulez-vous vraiment débloquer les <br> réponses ?</div>
                                <div class="dialog-actions">
                                    <button class="button js-dialog-close"><span class="mif-keyboard-return"></span>Retour</button>
                                    <button class="button" onclick="location.href = `reponseForum.php?id_question=' . $qf['id_question'] . '&forum=deblock`;"><span class="mif-cross"></span> Bloquer les réponses</button>
                                </div>
                              </div>';
                              }else{
                            echo '
                              <div id="' . $qf['secu'] . '" class="dialog alert" data-role="dialog">
                                <div class="dialog-title">Voulez-vous vraiment bloquer les réponses ?</div>
                                <div class="dialog-actions">
                                    <button class="button js-dialog-close"><span class="mif-keyboard-return"></span>Retour</button>
                                    <button class="button" onclick="location.href = `reponseForum.php?id_question=' . $qf['id_question'] . '&forum=block`;"><span class="mif-cross"></span> Bloquer les réponses</button>
                                </div>
                              </div>';
                        }
                    } else {
                    echo " ";
                    }?>

              </div><br>
<?php
    }
    ?>
<div class="grid">
    <div class="row">
        <div class="cell"><h3>Liste des réponses :</h3></div>
        <div class="cell-2"><input id="filterReponse" type="checkbox" data-role="checkbox" data-caption="filtrer par Likes"></div>
    </div>
</div>

<div id="result">
    <?php
    include_once "_content_reponseForumByDate.php";
    ?>
</div>

</div>
</body>

<script src="../../js/activeMenu.js"></script>
<script src="../../js/reponseForum.js"></script>

</html>

