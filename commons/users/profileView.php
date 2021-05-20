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
            <h3>Récap du compte</h3><br><br>
            <?php
            foreach (selectPersonneByIdPersonne($_SESSION['id_personne']) as $p) {
                ?>
                <table id="recapCompte" class= "table table-border cell-border">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Mail</th>
                        <th>Ecole</th>
                        <th>Promo</th>
                        <th>Classe</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    '<tr>';
                        echo '<td>'. $p['nom'] . '</td>';
                        echo '<td>'. $p['prenom'] . '</td>';
                        echo '<td>'. $p['mail'] . '</td>';
                        echo '<td>'. $p['ecole'] . '</td>';
                        echo '<td>'. $p['promo'] . '</td>';
                        echo '<td>'. $p['classe'] . '</td>';
                    '</tr>';
                    ?>
            <?php
            }
            echo '</tbody></table>';
            ?>
                    <div data-role="accordion"
                         data-one-frame="false"
                         data-show-active="true"
                         data-on-frame-open="console.log('frame was opened!', arguments[0])"
                         data-on-frame-close="console.log('frame was closed!', arguments[0])">
    <div class="frame">
        <div class="heading">Tu veux modifier tes infos de compte?</div>
        <div class="content">
            <div class="modifInfoCompte">Remplis les champs des infos que tu veux modifier et ensuite click sur la flêche pour appliquer la ou les modification(s).</div>
            <form action="insertQuestion.php" method="post">
                <div class="card"><div class="card-header">
                        <input data-role="input" name="mail" data-prepend="Mail"><button class="button light place-right" onclick="location.href = 'insertQuestion.php';">
                            <span class="mif-near-me mif-2x"></span></button><br/>
                        <select name="ecole" data-role="select" data-filter="false" data-prepend="Le nom de ton école : ">
                            <?php
                            foreach (selectEcole() as $ecole) {
                                echo '<option value="' . $ecole['id_ecole'] . '">' . $ecole['intitule'] . '</option>';
                            }
                            ?>
                        </select><br>
                        <select name="promo" data-role="select" data-filter="false" data-prepend="Ta nouvelle promo : ">
                            <?php
                            foreach (selectPromos() as $promo) {
                                echo '<option value="' . $promo['id_promo'] . '">' . $promo['promo'] . '</option>';
                            }
                            ?>
                        </select><br>
                        <select name="classe" data-role="select" data-filter="false" data-prepend="Ta nouvelle classe : "><br>
                            <?php
                            foreach (selectClasses() as $classe){
                                echo '<option value="' . $classe['id_classe'] . '">' . $classe['intitule'] . '</option>';
                            }
                            ?>
                            </select><br>
                        <input type="password" data-role="input" name="password" placeholder="Mot de passe actuel"
                               data-prepend="Mot de passe" data-reveal-button-icon="<span class='mif-lamp mif-2x'></span>"><button class="button light place-right" onclick="location.href = 'insertQuestion.php';">
                            <span class="mif-near-me mif-2x"></span></button><br/>
                        <input type="password" data-role="input" name="password" placeholder="Nouveau mot de passe"
                                               data-prepend="Nouveau mot de passe" data-reveal-button-icon="<span class='mif-lamp mif-2x'></span>"><br/>
                        <input type="password" data-role="input" name="password" placeholder="Confirmation"
                                               data-prepend="Confirme ton nouveau mot de passe " data-reveal-button-icon="<span class='mif-lamp mif-2x'></span>"><button class="button light place-right" onclick="location.href = 'insertQuestion.php';">
                            <span class="mif-near-me mif-2x"></span></button><br/>
                        <!--<br><select name="password" data-role="input" data-filter="false" data-prepend="Mot de passe">-->
                    </div>
                </div>
                </select>
            </form>
        </div>
        </div>
    </div>
</body>
<script src="../js/activeMenu.js"></script>

</html>

