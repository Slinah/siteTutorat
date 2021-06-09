// fonction appelé de base ligne 19 dans dashboard.php
function callJs(promo) {
    // on vérifie si une promo a été choisie
    // si non :
    if (promo === 0) {
        $.post(
            '../../admin/charts/globalCharts.php', {
            },

            function(){
                $("#result").load('../../admin/charts/globalCharts.php');
            });
    } else {
        $.post(
            '../../admin/charts/promoCharts.php', {
                // Récupération des valeur id_question pour le select pour afficher la réponse
                idPromo : promo,
            },

            function(){
                $("#result").load('../../admin/charts/promoCharts.php', {idPromo : promo});

            });
    }
}