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
    switch ($_GET["newc"]) {
        case "error":
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
    }
    ?>
    <div class="container">
        <div class="icon">
            <h1><img src="../../medias/scratchOverflow.png" alt=""></h1>
        </div>
        <h3>Les propositions actuelles : </h3>
        <?php
        if (verifExistProposition() != 0) {
            echo '<table class="table striped table-border mt-2" data-role="table" data-show-search="false" data-show-table-info="false" data-show-rows-steps="false" data-pagination-short-mode="false" data-show-pagination="false" data-rows="5">
            <thead>
            <tr>
                <th data-sortable="false">Matière</th>
                <th data-sortable="false">Niveau</th>
                <th data-sortable="false">Votes</th>
                <th data-sortable="false"> </th>
            </tr>
            </thead>
            <tbody>';
            foreach (selectPropositionMatierePromo() as $p) {
                echo '<tr><td>' . $p['matiere'] . '</td><td>' . $p['promo'] . '</td><td>' . selectCountPersonnePropositionByIdProposition($p['id_proposition']) . '</td>';
                if (selectCountPersonnePropositionByIdPersonneIdProposition($_SESSION['id_personne'], $p['id_proposition']) == '0') {
                    echo '<td><button class="button secondary" onclick="location.href = `answerProposal.php?proposal=' . $p['secu'] . '`;"><span class="mif-cross"></span> Créer ce cours</button></td>';
                } else {
                    echo '<td>Vous avez voté ou créer cette proposition</td>';
                }
            }
            echo '</tbody></table>';
        } else {
            echo 'Aucune propositions pour le moment';
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