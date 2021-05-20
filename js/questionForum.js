$(document).ready(function() {
    //Gestion de l'accès à une question au click sur une ligne du tableau
    $("#forumQuestionsTable").on("click", "tr", function (e) {
        if ($(e.target).is("a,input")) {
            return;
        }
        location.href = $(this).find("a").attr("href");
    });
});

    $(document).ready(function() {
        $("#filterQuestion").click(function () {
            //Ajax permettant de récupérer les questions postées correspondant à la matière sélectionnée
            //TODO : A modifer avec capture d'écran de Cédric
            $.post(
                './forumRequests/getFilterQuestion.php',
                {// Récupération de la valeur de l'input que l'on fait passer à questionForum.php
                    idMatiere: $("#matiere").val()
                    //Retourne les données
                }, function (data) {
                    let parsedDatas;
                    parsedDatas = JSON.parse(data);
                    console.log(parsedDatas);
                    let str;
                    str += '<table id="forumQuestionsTable" class="table striped table-border mt-2" data-role="table" data-show-search="false"' +
                        '            data-show-table-info="false" data-show-rows-steps="false" data-pagination-short-mode="true" ' +
                        '            data-show-pagination="true" data-rows="10">' +
                        '            <thead>' +
                        '                <tr>' +
                        '                    <th>Intitule</th>' +
                        '                    <th>Description</th>' +
                        '                    <th>Matière</th>' +
                        '                    <th>Date</th>' +
                        '                    <th>Auteur</th>' +
                        '                    <th>Réponses</th>' +
                        '                </tr>' +
                        '            </thead>'
                    str += '<tbody>';
                    parsedDatas.forEach(element => {
                        str += '<tr><td>';
                        str += element['titre'];
                        str += '</td>';
                        str += '<td>';
                        str += element['description'];
                        str += '</td>';
                        str += '<td>';
                        str += element['matiere'];
                        str += '</td>';
                        str += '<td>';
                        str += element['date'];
                        str += '</td>';
                        str += '<td>';
                        str += element['prenom'] + ' ' + element['nom'];
                        str += '</td>';
                        str += '<td>';
                        str += element['nbReponses'];
                        str += '</td></tr>';
                        $("#resultat").html(str);
                    });
                    str += '</tbody></table>';
                });
        });
    });