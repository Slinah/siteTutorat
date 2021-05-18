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
case "upvoted":
    echo '<script>Metro.toast.create("Vous avez voté pour la réponse", null, null, "success");</script>';
    break;

case "deleted":
    echo '<script>Metro.toast.create("Vous avez supprimé votre vote avec succès.", null, null, "success");</script>';
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
                        <input type="hidden" value="<?php echo $id_question?>" name="idQuestion">
                        <textarea data-role="textarea" placeholder="Votre réponse" name="message"></textarea>
                        <button class="button success" onclick="location.href = 'insertResponse.php';"> Répondre</button>
                    </form>
              </div><br>
<?php
    }
    echo '<h3>Liste des réponses : </h3>
<div>
    <input type="checkbox" data-role="switch"
        data-caption="filtrer par Likes" onchange="toggleFilter(this.checked)">
</div>';
    if (selectResponseStatus($id_question) != 'none') {
        '<table class="table striped table-border mt-4"
       data-role="table"
       data-rows="5"
       data-rows-steps="5, 10"
       data-show-activity="false"
       data-source="data/table.json"
       data-rownum="true"
       data-check="true"
       data-check-style="2">';
        foreach (selectResponseByStatusIdQuestionFilterByLike(0, $id_question) as $rf) {

            echo '<div class="card"><div class="card-header">
                     <p><span class="fg-crimson">' . $rf['message'] . '</span></p><br>
                     <i>A ' . date('H\\hi', strtotime($rf['date'])) . ' le ' . date("d", strtotime($rf['date'])) . ' ' . getMois($rf['date']) . '.</i><br>
                     <b>Par :</b> ';

            foreach (selectPersonnePromoByIdReponse($rf['id_reponse']) as $p) {
                echo '<i><span class="fg-crimson">' . $p['nom'] . ' ' . $p['prenom'] . ' ' . $p['promo'] . '</span></i><br>';
            }

            // TODO à utiliser pour les votes :
            if (verifExistPersonneVote($_SESSION['id_personne'], $rf['id_reponse']) == 0) {
                echo '<div class="info-button ">
                        <a href="newLike.php?id_question=' . $rf['id_question'] . '&reponse=' . $rf['id_reponse'] . '" class="button"><span class="mif-thumbs-up"></span></a>
                        <a href="newLike.php?id_question=' . $rf['id_question'] . '&reponse=' . $rf['id_reponse'] . '" class="info">' . selectCountVoteByIdReponse($rf['id_reponse']) . '</a>
                      </div>';
            } else {
                echo '<div class="info-button success bd-green rounded">
                        <a href="deleteLike.php?id_question=' . $rf['id_question'] . '&reponse=' . $rf['id_reponse'] . '" class="button"><span class="mif-thumbs-up"></span></a>
                        <a href="deleteLike.php?id_question=' . $rf['id_question'] . '&reponse=' . $rf['id_reponse'] . '" class="info">' . selectCountVoteByIdReponse($rf['id_reponse']) . '</a>
                      </div>';
            }
            if ($_SESSION["role"] == 1) {
                echo "<td><button class='button bg-crimson fg-white' onclick='Metro.dialog.open(`#" . $rf['secu'] . "`)'> <span class='mif-cross'></span> Supprimer</button></td>";
            } else {
                echo "<td></td>";
            }
            echo '</div></div>
        </table>';
        }
    }else {
        echo 'Aucune réponse pour le moment';
    }
    ?>
    <br><br><br>

</div>
</body>
<script src="../../js/activeMenu.js"></script>
<script src="../../js/filtreReponse.js"></script>

</html>

