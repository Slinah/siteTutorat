//Graphique représentant le nombre de participants par rapport au nombre d'inscrits
//on récupère la variable promo si elle n'est pas définie.
if (typeof promo === 'undefined') {
    promo = $("#idPromo").val();
}
// initialisation des tableaux d'inscrits, de participants,
// de la date et des mois
let arrayInsc = new Array;
let arrayPart = new Array;
let arrayDate = new Array;
let arrayMois = new Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$.post("../../chartRequests/getPartInsc.php", {
    // récupération/envoie de idpromo
    idPromo : promo,
}, function (arrayJSON) {
    //on récupère les infos de la requête et on les push dans les différents tableaux
    var jsonPartInsc = JSON.parse(arrayJSON);
    for (i = 0; i < jsonPartInsc.length; i++) {
        arrayInsc.push(jsonPartInsc[i]['inscrits']);
        if (jsonPartInsc[i]['participants'] == null) {
            arrayPart.push(0);
        } else {
            arrayPart.push(jsonPartInsc[i]['participants']);
        }
        let dt = new Date(jsonPartInsc[i]['datee']);
        arrayDate.push(jsonPartInsc[i]['matiere'] + ' (' + dt.getDate() + ' ' + arrayMois[dt.getMonth()] + ')');
    }
}).done(function () {
    // on attend que l'autre fonction soit terminée
    // retourne un context de dessin en 2D dans la div partInsc
    var chartInsc = document.getElementById("partInsc").getContext('2d');

    //Création du Graphique à partir des différents tableaux
        var inscritData = {
            label: 'Inscrits',
            data: arrayInsc,
            backgroundColor: 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)' ,
            borderWidth: 0.2,
            borderColor: 'rgba(0, 0, 0)',
        };

        var participantData = {
            label: 'Participants',
            data: arrayPart,
            backgroundColor: 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)',
            borderWidth: 0.2,
            borderColor: 'rgba(0, 0, 0)',
        };

        var peopleData = {
            labels: arrayDate,
            datasets: [inscritData, participantData]
        };

        var chartOptions = {
            scales: {
                xAxes: [{
                    barPercentage: 1,
                    categoryPercentage: 0.6
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 5
                    }
                }]
            }
        };

        var barChart = new Chart(chartInsc, {
            type: 'bar',
            data: peopleData,
            options: chartOptions
        });
    })

