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
                <div class="card"><div class="card-header">
                        <label>
                            <input data-role="input" name="titre" placeholder="Titre de ta question" data-prepend="Titre" required>
                        </label><br/>
                        <label>
                            <input data-role="input" name="description" placeholder="Décris ta question" data-prepend="Description" required>
                        </label>
                        <br><label>
                            <select name="matiere" data-role="select" data-filter="false" data-prepend="Matière">
                            <?php
                            foreach (selectMatieres() as $matieres) {
                                echo '<option value="' . $matieres['id_matiere'] . '">' . $matieres['intitule'] . '</option>';
                            }
                            ?>
                        </select>
                        </label>
                        <br><button class="button success" onclick="location.href = 'insertQuestion.php';">
                    <span class="mif-checkmark"></span>Créer une question</button>
            </form>
        </div>
        </div>
    </div>
</div>
    <h3>Les questions posées : </h3>
<form>
    <p style="height:150px;display:block;" >
        <br><select id="matiere" name="filtreMatiere" data-role="select" data-filter="false" data-prepend="Choisis dans quelle matière">
            <?php
            foreach (selectMatieres() as $matieres) {
                echo '<option value="' . $matieres['id_matiere'] . '">' . $matieres['intitule'] . '</option>';
            }
            ?>
        </select>
        <input type="checkbox" id ="filterQuestion" data-role="switch" data-caption="Apply filter"/>
    </p>
</form>
<div id="resultat">
    <?php
    if (selectQuestionStatus() != 'none') {
        echo '
        <table id="forumQuestionsTable" class="table striped table-border mt-2" data-role="table" data-show-search="false"
            data-show-table-info="false" data-show-rows-steps="false" data-pagination-short-mode="true" 
            data-show-pagination="true" data-rows="2">
            <thead>
                <tr>
                    <th>Intitule</th>
                    <th>Description</th>
                    <th>Matière</th>
                    <th>Date</th>
                    <th>Auteur</th>
                    <th>Réponses</th>
                </tr>
            </thead>
        <tbody>';
        foreach (selectQuestionByStatus(0) as $qf) {
            echo '<tr>
                    <td><a href="reponseForum.php?id_question=' . $qf ['id_question'] . '&forum=unset" class = "question">'.$qf['titre'].'</td>
                    <td>'.$qf['description'].'</td>
                    <td>'.$qf['matiere'].'</td>
                    <td>'.date('H\\hi', strtotime($qf['date'])) . ' le ' . date("d", strtotime($qf['date'])) . ' ' . getMois($qf['date']) . ' '. date("Y", strtotime($qf['date'])).'</td>
                    <td>'.$qf['prenom'].' '.$qf['nom'].'</td>
                    <td>'.selectCountResponseByIdQuestion($qf['id_question'])  .'</td></a>
                </tr>';
        }
        echo '</tbody></table>';
    }else {
        echo 'Aucune question pour le moment';
    }
    ?>
</div>
</body>

<script src="../../js/activeMenu.js"></script>
<script src="../../js/questionForum.js"></script>

</html>
