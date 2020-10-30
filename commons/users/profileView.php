<?php
session_start();
include_once '../../requests/select.php';
include_once '../../commons/date.php';

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
    <div class="container">
        <div class="row">
            <h3>Récap du compte</h3><br>

            <?php
            foreach (selectPersonneByIdPersonne($_SESSION['id_personne']) as $p) {
                echo '<br>Nom : ' . $p['nom'];
                echo '<br>Prenom : ' . $p['prenom'];
                echo '<br>Mail : ' . $p['mail'];
                echo '<br>Classe : ' . $p['classe'];
            }
            ?>
        </div>
    </div>
</body>
<script src="../js/activeMenu.js"></script>

</html>