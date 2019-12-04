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
    switch ($_GET['proposal']) {
        case "upvoted":
            echo '<script>Metro.toast.create("Vous avez voté pour le cours avec succès !", null, null, "success");</script>';
            break;

        case "error":
            echo '<script>Metro.toast.create("Vous n\'avez pas rentré de matiere.", null, null, "alert");</script>';
            break;

        case "success":
            echo '<script>Metro.toast.create("Vous avez créer la proposition avec succès !", null, null, "success");</script>';
            break;

        case "creaupvoted":
            echo '<script>Metro.toast.create("La proposition existait déjà, vous avez voté.", null, null, "alert");</script>';
            break;

        case "deleted":
            echo '<script>Metro.toast.create("La proposition à été supprimée avec succès.", null, null, "success");</script>';
            break;

        case "mat":
            echo '<script>Metro.toast.create("La matière à bien été ajoutée", null, null, "success");</script>';
            break;
    }
    ?>
        <div class="icon">
            <h1><img src="../../medias/squirrelIcon.png" alt=""></h1>
        </div>
        <h3>Les propositions actuelles : </h3>
        <?php
        if (verifExistProposition() != 0) {
            echo '<table class="table striped table-border mt-2" data-role="table" data-show-search="false" data-show-table-info="false" data-show-rows-steps="true" data-pagination-short-mode="true" data-show-pagination="true" data-rows="5">
            <thead>
            <tr>
                <th data-sortable="false">Matière</th>
                <th data-sortable="false">Niveau</th>
                <th data-sortable="false">Votes</th>
                <th data-sortable="false"> </th>
                <th data-sortable="false"> </th>
            </tr>
            </thead>
            <tbody>';
            foreach (selectPropositionMatierePromo() as $p) {
                echo '<div id="' . $p['secu'] . '" class="dialog alert" data-role="dialog">
                <div class="dialog-title">Voulez-vous vraiment supprimer cette proposition ?</div>
                <div class="dialog-actions">
                    <button class="button js-dialog-close"><span class="mif-keyboard-return"></span>Retour</button>
                <button class="button" onclick="location.href = `deleteProp.php?prop=' . $p['secu'] . '`;"><span class="mif-cross"></span> Supprimer la proposition</button>
                </div>
            </div>';
                echo '<tr><td>' . $p['matiere'] . '</td><td>' . $p['promo'] . '</td><td>' . selectCountPersonnePropositionByIdProposition($p['id_proposition']) . '</td>';
                if (verifExistPersonneProposition($_SESSION['id_personne'], $p['id_proposition']) == 0) {
                    echo '<td><button class="button secondary" onclick="location.href = `newVote.php?proposal=' . $p['id_proposition'] . '&student=' . $_SESSION['id_personne'] . '`;"><span class="mif-cross"></span> Voter</button></td>';
                } else {
                    echo '<td>Déjà voté</td>';
                }
                if ($_SESSION["role"] == 1) {
                    echo "<td><button class='button bg-crimson fg-white' onclick='Metro.dialog.open(`#" . $p['secu'] . "`)'> <span class='mif-cross'></span> Supprimer</button></td>";
                } else {
                    echo "<td></td>";
                }
            }
            echo '</tbody></table>';
        } else {
            echo 'Aucune propositions pour le moment';
        }
        ?>
        <br><br><br><br>
        <div class="row">
            <div class="cell-5">
                <h3>Aucune proposition ne t'intéresse ?</h3>
                <?php echo '<form action="insertProposal.php" method="post">'; ?>
                <select name="matiere" data-role="select" data-filter="false" data-prepend="La matière que tu veux : ">
                    <?php
                    foreach (selectMatieres() as $matiere) {
                        echo '<option value="' . $matiere['id_matiere'] . '">' . $matiere['intitule'] . '</option>';
                    }
                    ?>
                </select>
                <br><select name="classe" data-role="select" data-filter="false" data-prepend="La promo qui veut ce cours : ">
                    <?php
                    foreach (selectPromos() as $promo) {
                        echo '<option value="' . $promo['id_promo'] . '">' . $promo['promo'] . '</option>';
                    }
                    ?>
                </select>
                <?php echo '<br><button class="button success" onclick="location.href = `insertProposal.php`;"><span class="mif-checkmark"></span> Créer la proposition</button>'; ?>
                </form>
            </div>
            <div class="cell-5 offset-2">
                <h3>Aucune matière ne t'intéresse ?</h3>
                <?php echo '<form action="insertMatiere.php" method="post">'; ?>
                <input data-role="input" name="matiere" placeholder="PHP ... MATHS ... DROIT.." data-prepend="Matière : " required>
                <br>
                <?php echo '<br><button class="button success" onclick="location.href = `insertMatiere.php`;"><span class="mif-checkmark"></span> Ajouter la matière</button>'; ?>
                </form>
            </div>
        </div>

</body>
<script src="../../js/activeMenu.js"></script>

</html>