<?php
if (!isset($_SESSION)) {
   session_start();
}
include_once '../../requests/select.php';
include_once '../date.php';

$valueStatusResponse = 0;
$id_question = $_REQUEST['idQuestion'];
$check = $_REQUEST['check'];
?>
<!DOCTYPE html>
<html>
<table class="table"
       data-role="table"
       data-rows="4"
       data-rows-steps="4"
       data-show-table-info="false"
       data-show-pagination="true"
       data-pagination-short-mode="true"
       data-show-rows-steps="false"
       data-show-search="false">


    <?php
    if (selectResponseStatus($id_question) != 'none') {
        echo '<thead>
       <tr>
       <th data-sortable="false">
       
       </th>
       </tr>
       </thead>
       <tbody>';
        foreach (selectResponseByStatusIdQuestionFilterByLike($id_question) as $rf) {

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
