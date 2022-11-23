<?php
session_start();
require_once '../../requests/select.php';
require_once '../../requests/update.php';

if (!isset($_SESSION["role"])) {

    header("location: ../../connexion/co.php?co=newco");
}

?>
<!DOCTYPE html>
<html>

<?php
include_once '../../bases/head.php';
switch ($_GET["users"]) {

    case "error":
        echo '
        <script type="text/javascript">
            $(document).ready(function(){
                Metro.dialog.create({
                    title: "Erreur de formulaire.",
                    content: "<div>Vous n\'avez pas bien renseigné les champs.</div>",
                    closeButton: true
                });
            });
        </script>';
    break;

    case "updateProfil":
        echo '
        <script type="text/javascript"> 
            $(document).ready(function(){
                Metro.toast.create("Vos modifications ont bien été appliquées", null, null, "success");
            });
        </script>';
    break;

    case "mailError":
        echo '<script type="text/javascript">
            $(document).ready(function(){
                Metro.dialog.create({
                    title: "Erreur d email",
                    content: "<div>Cette adresse mail n\'est pas valide.</div>",
                    closeButton: true
                });
            });
                </script>';
        break;

    case "passError":
        echo '<script type="text/javascript">
            $(document).ready(function(){
                Metro.dialog.create({
                    title: "Ton mot de passe est mal renseigné",
                    content: "<div>Modifies ta saisie.</div>",
                    closeButton: true
                });
            });
                </script>';
        break;

}
?>

<body>
    <?php include_once '../../bases/menu.php'; ?>
    <div class="container">
        <div class="row">
            <h3>Récap du compte</h3><br><br>
            <?php
            $personne = selectPersonneByIdPersonne($_SESSION['id_personne']);
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
                        echo '<td>'. $personne['nom'] . '</td>';
                        echo '<td>'. $personne['prenom'] . '</td>';
                        echo '<td>'. $personne['mail'] . '</td>';
                        echo '<td>'. $personne['ecole'] . '</td>';
                        echo '<td>'. $personne['promo'] . '</td>';
                        echo '<td>'. $personne['classe'] . '</td>';
                    '</tr>';
                    ?>
            <?php
            echo '</tbody></table>';
            ?>
                    <div data-role="accordion"
                         data-one-frame="true"
                         data-show-active="true">
    <div class="frame active">
        <div class="heading">Tu veux modifier tes infos de compte?</div>
        <div class="content">
            <div class="modifInfoCompte">Remplis les champs des infos que tu veux modifier et ensuite click sur "mettre à jour" pour appliquer la ou les modification(s).<br/>
                Attention, pour modifier ton mot de passe, il faudra d'abord que tu renseignes ton mot de passe actuel.
            </div>
            <form action="updateProfilUser.php" method="post">
                <div class="card"><div class="card-header">
                        <input data-role="input" name="newmail" data-prepend="Mail" value="<?php echo $personne['mail'] ?>"><br/>

                        <select id="ecole" name="newecole" data-role="select" data-filter="false" data-prepend="Le nom de ton école : ">
                            <?php
                            foreach (selectEcole() as $ecole) {
                                $ecoleSelected = $ecole['intitule'] == $personne['ecole'] ? ' selected="selected"' : '';
                                echo '<option value="' . $ecole['id_ecole'] . '" ' . $ecoleSelected . '>' . $ecole['intitule'] . '</option>';
                            }
                            ?>
                        </select><br>

                        <div id="divPromo">
                            <select id="promo" name="newpromo" data-role="select" data-filter="false" data-prepend="Ta nouvelle promo : ">
                            <?php
                            foreach (selectPromoBySchoolsId($personne['id_ecole'])as $promos) {
                                $promoSelected = $promos['promo'] == $personne['promo'] ? ' selected="selected"' : '';
                                echo '<option value="' . $promos['id_promo'] . '" ' . $promoSelected . '>' . $promos['promo'] . '</option>';
                           }
                            ?>
                            </select></div><br>

                        <div id="divClasses">
                        <select id="classByPromo" name="newclasse" data-role="select" data-filter="false" data-prepend="Ta nouvelle classe : ">
                            <?php
                            foreach (selectClassByPromo($personne['id_promo']) as $classe){
                                $classeSelected = $classe['classe'] == $personne['classe'] ? ' selected="selected"' : '';
                                echo '<option value="' . $classe['id_classe'] . '" ' . $classeSelected . '>' . $classe['classe'] . '</option>';
                            }
                            ?>
                        </select></div><br>

                        <input type="password" data-role="input" name="password" placeholder="Mot de passe actuel"
                               data-prepend="Mot de passe" data-reveal-button-icon="<span class='mif-lamp mif-2x'></span>"><br/>
                        <input type="password" data-role="input" name="newPassword" placeholder="Nouveau mot de passe"
                                               data-prepend="Nouveau mot de passe" data-reveal-button-icon="<span class='mif-lamp mif-2x'></span>"><br/>
                        <input type="password" data-role="input" name="confirmPassword" placeholder="Confirmation"
                                               data-prepend="Confirme ton nouveau mot de passe " data-reveal-button-icon="<span class='mif-lamp mif-2x'></span>"><br/>
                    </div>
                </div>
                </select>
                <button class="button success place-right">Mettre à jour</button>
            </form>
        </div>
        </div>
    </div>
</body>
<script src="../../js/activeMenu.js"></script>
<script src="../../js/modifyProfilByUser.js"></script>

</html>

