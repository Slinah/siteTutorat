<?php
session_start();
include_once '../../requests/select.php';
include_once '../../requests/insert.php';
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
<?php /*
switch ($_GET["forum"]) {
    // TODO : A adapter pour le filtre par matière
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
    }*/
?>
<div class="container">

    <div class="icon">
        <h1><img src="../../medias/scratchOverflow.png" alt=""></h1>
    </div>
    <div data-role="accordion"
         data-one-frame="false"
         data-show-active="true"
         data-on-frame-open="console.log('frame was opened!', arguments[0])"
         data-on-frame-close="console.log('frame was closed!', arguments[0])">
    <div class="frame">
        <div class="heading">Tu ne trouves pas de réponse à ta question? Vas-y balances ta question!</div>
        <div class="content">
            <div class="p-2">Petit conseil : Dans un premier temps, regardes si ta question n'a pas encore été posée... ;)</div>
            <form action="insertQuestion.php" method="post">
                <h3>Créer une question :</h3>
                <div class="card">
                <input data-role="input" name="titre" placeholder="Titre de ta question" data-prepend="Titre" required><br/>
                    <input data-role="input" name="description" placeholder="Décris ta question" data-prepend="Description" required>
                    <br><select name="matiere" data-role="select" data-filter="false" data-prepend="Matière">
                    <?php
                    foreach (selectMatieres() as $matieres) {
                        echo '<option value="' . $matieres['id_matiere'] . '">' . $matieres['intitule'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <br><button class="button success" onclick="location.href = 'insertQuestion.php';">
                    <span class="mif-checkmark"></span>Créer une question</button>
            </form>
        </div>
        </div>
    </div>
</div>

    <h3>Les questions posées : </h3>

<form>
    <p>
        <br><select id="matiere" name="filtreMatiere" data-role="select" data-filter="false" data-prepend="Choisis dans quelle matière">
            <?php
            foreach (selectMatieres() as $matieres) {
                echo '<option value="' . $matieres['id_matiere'] . '">' . $matieres['intitule'] . '</option>';
            }
            ?>
        </select>
        <input type="checkbox" id ="filterQuestion" data-role="switch" data-caption="Apply filter" />
    </p>
</form>

    <?php
    if (selectQuestionStatus() != 'none') {
        echo '
        <table id="forumQuestionsTable" class="table striped table-border mt-2" data-role="table" data-show-search="false"
            data-show-table-info="false" data-show-rows-steps="false" data-pagination-short-mode="true" data-show-pagination="true" data-rows="5">

            <thead>
                <tr>
                    <th>Intitule</th>
                    <th>Description</th>
                    <th>Matière</th>
                    <th>Date</th>
                    <th>Auteur</th>
                    <th>Nombre de réponses</th>
                </tr>
            </thead>
        <tbody>';

        foreach (selectQuestionByStatus(1) as $qf) {
            echo '<tr>
                    <td><a href="reponseForum.php?id_question=' . $qf ['id_question'] . '&forum=unset" class = "question">'.$qf['titre'].'</a></td>
                    <td>'.$qf['description'].'</td>
                    <td>'.$qf['matiere'].'</td>
                    <td>'.date('H\\hi', strtotime($qf['date'])) . ' le ' . date("d", strtotime($qf['date'])) . ' ' . getMois($qf['date']) . ' '. date("Y", strtotime($qf['date'])).'</td>
                    <td>'.$qf['prenom'].' '.$qf['nom'].'</td>
                    <td>'.selectCountResponseByIdQuestion($qf['id_question'])  .'</td>
                </tr>';
        }

        echo '</tbody></table>';
    }else {
        echo 'Aucune question pour le moment';
    }
    ?>
    <br><br><br>

</div>
</body>
<script src="../../js/activeMenu.js"></script>
<!--Faire comme au-dessus pour inclure le fichier .js de la méthode qui suit-->
<script type="application/javascript">
    // TODO : externaliser ceci dans un fichier JS
    jQuery(function($){
        $("#forumQuestionsTable").on("click", "tr", function(e){
            if ($(e.target).is("a,input")) {
                return;
            }
            location.href = $(this).find("a").attr("href");
        });
    });
</script>
<script>
    $(document).ready(function(){
        $("#filterQuestion").click(function(){

            $.post(
                './forumRequests/getFilterQuestion.php',
                {
                    idMatiere : $("#matiere").val() // Récupération de la valeur de l'input que l'on fait passer à questionForum.php
                },

                function(data){
                    console.log(data);
                    if(data == 'Success'){
                        $("#resultat").html("<p>Filtre bien pris en compte !</p>");
                    }
                    else{
                        $("#resultat").html("<p>Erreur...</p>");
                    }

                },
                'text' // Pour recevoir "Success" ou "Failed", donc on indique text
            );
        });
    });

</script>
</html>
