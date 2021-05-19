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
switch ($forum=$_GET["forum"]) {

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
                        <input type="hidden" value="<?php echo $id_question?>" name="idQuestion">
                        <?php
                        if ($forum="block") {
                            echo ' <textarea readonly data-role="textarea" data-cls-textarea="ribbed-red fg-white border bd-amber" placeholder="Votre réponse" name="message">Les réponses sont bloquées pour cette question</textarea>';
                        } else {
                            echo ' <textarea data-role="textarea" placeholder="Votre réponse" name="message"></textarea>';
                        }?>
                        <button class="button success" onclick="location.href = 'insertResponse.php';"> Répondre</button>
                    </form>
                    <?php
                    if ($_SESSION["role"] == 1) {
                        echo " <button class='button bg-crimson fg-white' onclick='Metro.dialog.open(`#" . $qf['secu'] . "`)'><span class='mif-cross'></span> Bloquer</button>";
                        echo '<div id="' . $qf['secu'] . '" class="dialog alert" data-role="dialog">
                                <div class="dialog-title">Voulez-vous vraiment bloquer les réponses ?</div>
                                <div class="dialog-actions">
                                    <button class="button js-dialog-close"><span class="mif-keyboard-return"></span>Retour</button>
                                    <button class="button" onclick="location.href = `reponseForum.php?id_question=' . $qf['id_question'] . '&forum=block`;"><span class="mif-cross"></span> Bloquer les réponses</button>
                                </div>
                              </div>';
                    } else {
                    echo " ";
                    }?>

              </div><br>
<?php
    }
    echo '
<table class="table"
       data-role="table"
       data-rows="4"
       data-rows-steps="4"
       data-show-table-info="true" 
       data-show-pagination="true"
       data-pagination-short-mode="true" 
       data-show-rows-steps="false"
       data-show-search="false">
       <thead>
       <tr>
       <th data-sortable="false">
            <div class="grid">
                <div class="row row flex-align-center">
                    <div class="cell"><h3>Liste des réponses : </h3></div>
                    <div class="cell-2"><input type="checkbox" data-role="switch" data-caption="filtrer par Likes" onchange="toggleFilter(this.checked)"></div>
                </div>
            </div>
       </th>
       </tr>
       </thead>
       <tbody>
    
';
    if (selectResponseStatus($id_question) != 'none') {
        '';
        foreach (selectResponseByStatusIdQuestionFilterByLike(0, $id_question) as $rf) {

            echo '
            <tr>
                <td>
                <div class="card"><div class="card-header">
                        <p><span class="fg-crimson">' . $rf['message'] . '</span></p><br>
                        <i>A ' . date('H\\hi', strtotime($rf['date'])) . ' le ' . date("d", strtotime($rf['date'])) . ' ' . getMois($rf['date']) . '.</i><br>
                         <b>Par :</b> ';

                foreach (selectPersonnePromoByIdReponse($rf['id_reponse']) as $p) {
                    echo '<i><span class="fg-crimson">' . $p['nom'] . ' ' . $p['prenom'] . ' ' . $p['promo'] . '</span></i><br>';
                }

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
                    echo " <button class='button bg-crimson fg-white' onclick='Metro.dialog.open(`#" . $rf['secu'] . "`)'><span class='mif-cross'></span> Supprimer</button>";
                    echo '<div id="' . $rf['secu'] . '" class="dialog alert" data-role="dialog">
                            <div class="dialog-title">Voulez-vous vraiment supprimer cette réponse ?</div>
                            <div class="dialog-actions">
                                <button class="button js-dialog-close"><span class="mif-keyboard-return"></span>Retour</button>
                                <button class="button" onclick="location.href = `deleteReponse.php?id_question=' . $rf['id_question'] . '&rep=' . $rf['secu'] . '`;"><span class="mif-cross"></span> Supprimer la proposition</button>
                            </div>
                          </div>';
                } else {
                    echo " ";
                }
            echo '</div></div>
                </td>
            </tr>';
        }
    }else {
        echo 'Aucune réponse pour le moment';
    }
    ?>

</tbody>
</table>

</div>
</body>
<script src="../../js/activeMenu.js"></script>
<script src="../../js/filtreReponse.js"></script>

</html>

