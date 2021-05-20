$(document).ready(function(){
    //Gestion de l'accès à une question au click sur une ligne du tableau
    $("#forumQuestionsTable").on("click", "tr", function(e){
        if ($(e.target).is("a,input")) {
            return;
        }
        location.href = $(this).find("a").attr("href");
    });


    $("#filterQuestion").click(function(){
    //Ajax permettant de récupérer les questions postées correspondant à la matière sélectionnée
        //TODO : A modifer avec capture d'écran de Cédric
        $.post(
            './forumRequests/getFilterQuestion.php',
            {// Récupération de la valeur de l'input que l'on fait passer à questionForum.php
                idMatiere : $("#matiere").val()
            },
            //Retourne les données
            function(data){
                console.log(data);
                if(data == 'Success'){
                    $("#resultat").html("<p>Filtre bien pris en compte !</p>");
                }
                else{
                    $("#resultat").html("<p>Erreur...</p>");
                }

            },
            // Pour recevoir "Success" ou "Failed", donc on indique text
            'text'
        );
    });
});
