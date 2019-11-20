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

        <?php
        switch($_GET["error"]){
            case "unset":
                echo '<script>Metro.toast.create("Il manque des éléments pour clore ton cours !", null, null, "alert");</script>';
                break;
        }
        foreach (selectCoursMatiereNiveauBySecuIdPersonneRang($_GET['course'], $_GET['usr'], 1) as $c) {
            echo '<h3>Clore le cours - ' . $c['intitule'] . '</h3>';
            echo '<form action="updateCourseClosedAdmin.php?course=' . $c['id_cours'] . '" method="post">';
            echo '<span>Nombre d\'heures :</span>';
            echo '<br><input name="nbheure" type="text" data-role="spinner" data-min-value="0" data-max-value="4" data-step="0.25" data-fixed="2">';
            echo '<br><span>Nombre de personnes ayant participées :</span>';
            echo '<br><input name="participants" type="text" data-role="spinner" data-min-value="0" data-max-value="40" data-step="1" data-fixed="0">';
            echo '<br><textarea name="comment" data-role="textarea" data-prepend="Commentaires" placeholder="Problèmes précis / sujets abordés ..."></textarea>';
            echo '<br><button class="button" onclick="location.href = `updateCourseClosedAdmin.php?course=' . $c['id_cours'] . '&usr=' . $_GET['usr'] . '`;"><span class="mif-checkmark"></span> Modifier le cours</button>';
        }
        ?>
        </form>

    </div>
</body>
<script src="../js/activeMenu.js"></script>
</html>