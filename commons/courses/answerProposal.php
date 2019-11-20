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
    <h3>Sélectionnez une date et une heure pour le cours sélectionné : </h3>
    <?php echo '<form action="insertCourseByProposal.php?proposal=' . $_GET['proposal'] . '&student=' . $_SESSION['id_personne'] . '" method="post">'; ?>
    <br><input name="date" data-role="datepicker" data-year="false">
    <br><input name="heure" data-role="timepicker" data-seconds="false">
    <?php
    echo '<br><button class="button" onclick="location.href = `insertCourseByProposal.php?proposal=' . $_GET['proposal'] . '&student=' . $_SESSION['id_personne'] . '`;"><span class="mif-checkmark"></span> Créer le cours</button>';
    ?>
    </form>
</body>
<script src="../../js/activeMenu.js"></script>

</html>