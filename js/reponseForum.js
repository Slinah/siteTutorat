$(document).ready(function(){
    $("#filterReponse").click(function(){
        let thisCheck = $(this);
        if (thisCheck.is (':checked'))
        {
            $.post(
                './_content_reponseForumByLike.php', {
                    // Récupération des valeur id_question pour le select pour afficher la réponse
                    idQuestion : $("#idQuestion").val(),
                },

                function(){
                    let check = 1;
                    $("#result").load('../forum/_content_reponseForumByLike.php', {idQuestion : $("#idQuestion").val(), check});

                });
        }
        else {
            $.post(
                './_content_reponseForumByDate.php', {
                    // Récupération des valeur id_question pour le select pour afficher la réponse
                    idQuestion : $("#idQuestion").val(),
                },

                function(){
                    let check = 0;
                    $("#result").load(
                        '../forum/_content_reponseForumByDate.php', {
                            idQuestion : $("#idQuestion").val(),
                            check
                        });

                });
        }
    });
});