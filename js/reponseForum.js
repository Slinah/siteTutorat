$(document).ready(function(){
    $("#filterReponse").click(function(){

        $.post(
            './_content_reponseForum.php', {
                valueStatusResponse : $("#valueStatus").val(), // Récupération des valeur status et id_question pour le select pour afficher la réponse
                idQuestion : $("#idQuestion").val()

            },
            function(){
                $("#result").load('../forum/_content_reponseForum.php', {idQuestion : $("#idQuestion").val()});

            });
    });
});