//Diagramme représentant le nombre de partipants par matière
//on récupère la variable promo si elle n'est pas définie.
if (typeof promo === 'undefined') {
    promo = $("#idPromo").val();
}
// initialisation des tableaux de matière, de participants,
// de la date et des mois
let arrayMatPie = new Array;
let arrayPercentPie = new Array;
let arrayColorPie = new Array;
let arrayBorderColorPie = new Array();

$.post("../../chartRequests/getPercentPartMat.php", {
    // récupération/envoie de idpromo
    idPromo: promo
}, function (tabInfos) {
    //on récupère les infos de la requête et on les push dans les différents tableaux
    var allJson = JSON.parse(tabInfos);
    for (i = 0; i < allJson.length; i++) {
        arrayMatPie.push(allJson[i]['matiere']);
        arrayPercentPie.push(allJson[i]['participants']);
        arrayColorPie.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
        arrayBorderColorPie.push('rgba(0, 0, 0)');
    }
}).done(function () {
    // on attend que l'autre fonction soit terminée
    // retourne un context de dessin en 2D dans la div globalChartParticipation
    var ctxpercentparmat = document.getElementById('partPercent').getContext('2d');
    //Création du Graphique à partir des différents tableaux
    var myChart = new Chart(ctxpercentparmat, {
        type: 'pie',
        data: {
            labels: arrayMatPie,
            datasets: [{
                label: 'Participants / Matières',
                data: arrayPercentPie,
                backgroundColor: arrayColorPie,
                borderColor: arrayBorderColorPie,
                borderWidth: 0.2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            }
        }
    });
})
