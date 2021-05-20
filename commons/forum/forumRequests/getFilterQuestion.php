<?php
require_once '../../../requests/select.php';
//TODO : A modifer avec capture d'ecran Cedric
function getPromoChartFilterQuestion(){
    $idMatiere = $_REQUEST['idMatiere'];
    // on récupère le template json et on le parse en objet PHP
    // on devrait peut être utiliser directement un objet PHP plutôt que de transformer
    // le fichier json en php pour le retransfromer plus loin en json à nouveau

    // on ajoutes les données dans "data"
    $tableObject = selectQuestionByIdPromo($idMatiere);
    echo json_encode($tableObject);
}

getPromoChartFilterQuestion();