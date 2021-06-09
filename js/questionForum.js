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
            let thisCheck = $(this);
            let checked;
            if (thisCheck.is(':checked')) {
                checked=1;
                alert("questions filtrées par matière => OK")
            }else{
                checked=0;
                alert("filtre inactif")
            }
                //Permet de récupérer les questions postées correspondant à la matière sélectionnée
                $.post(
                    './forumRequests/getFilterQuestion.php',
                    {// Récupération de la valeur de l'input que l'on fait passer à questionForum.php
                        idMatiere: $("#matiere").val(),
                        checked,
                        //Retourne les données
                    }, function (data) {
                        let parsedDatas = JSON.parse(data);
                        let str = '<table id="forumQuestionsTable" class="table striped table-border mt-2" data-role="table" data-show-search="false"' +
                            '            data-show-table-info="false" data-show-rows-steps="false" data-pagination-short-mode="true" ' +
                            '            data-show-pagination="true" data-rows="5">' +
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
                            str += '<tr><td><a href="reponseForum.php?id_question=' +
                                element['id_question'] +
                                '&forum=unset" class = "question">' + element['titre'] +
                                '</td>' +
                                '<td>' + element['description'] +
                                '</td>' +
                                '<td>' + element['matiere'] +
                                '</td>' +
                                '<td>' + element['date'] +
                                '</td>' +
                                '<td>' + element['prenom'] + ' ' + element['nom'] +
                                '</td>' +
                                '<td>' + element['nbReponses'] +
                                '</td>' +
                                '</a></tr>';
                            $("#resultat").html(str);
                        });
                        str += '</tbody></table>';
                    });
        });
    });



