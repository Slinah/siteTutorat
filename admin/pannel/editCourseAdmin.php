<?php
session_start();
include_once '../../requests/select.php';
?>
<!DOCTYPE html>
<html>

<?php
include_once '../../bases/head.php';
?>

<body>
    <?php include_once '../../bases/menu.php'; ?>
    <div class="container">

        <h3>Modification de cours : </h3>
        <?php
        switch($_GET["error"]){
            case "unset":
                echo '<script>Metro.toast.create("Tu n\'as rien modifié !", null, null, "alert");</script>';
                break;
        }
        foreach (selectCoursMatiereNiveauBySecuIdPersonneRang($_GET['course'], $_GET['usr'], 1) as $c) {
            echo '<form action="updateCourseMdfAdmin.php?course=' . $c['id_cours'] . '&usr=' . $_GET['usr'] .'" method="post">';
            echo '<input data-role="input" name="intitule" placeholder="' . $c['intitule'] . '" data-prepend="Intitule">';
            echo '<br><input name="date" data-role="datepicker" data-year="false" data-value="' . $c['date'] . '">';
            echo '<br><input name="heure" data-role="timepicker" data-seconds="false" data-value="' . $c['heure'] . '">';
            echo '<br><select name="matiere" data-role="select" data-filter="false" data-prepend="Matière">';
            echo '<option value="' . $c['id_matiere'] . '">' . $c['matiere'] . '</option>';
            foreach (selectMatieres() as $matieres) {
                if ($c['id_matiere'] != $matieres['id_matiere'] && $c['matiere'] != $matieres['intitule']) {
                    echo '<option value="' . $matieres['id_matiere'] . '">' . $matieres['intitule'] . '</option>';
                } else {
                    echo '';
                }
            }
            echo '</select>';
            echo '<br><select name="classe" data-role="select" data-filter="false" data-prepend="Niveau concerné">';
            echo '<option value="' . $c['id_promo'] . '">' . $c['niveau'] . '</option>';
            foreach (selectPromos() as $promo) {
                if ($c['id_promo'] != $promo['id_promo'] && $c['niveau'] != $promo['promo']) {
                    echo '<option value="' . $promo['id_promo'] . '">' . $promo['promo'] . '</option>';
                } else {
                    echo '';
                }
            }
            echo '</select>';
            echo '<br><button class="button" onclick="location.href = `updateCourseMdfAdmin.php?course=' . $c['id_cours'] . '&usr=' . $_GET['usr'] . '`;"><span class="mif-checkmark"></span> Modifier le cours</button>';
        }
        ?>
        </form>

    </div>
</body>
<script src="../../js/activeMenu.js"></script>
</html>