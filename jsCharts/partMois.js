//on récupère la variable promo si elle n'est pas définie.
if (typeof promo === 'undefined') {
    promo = $("#idPromo").val();
}
//création des tableaux de mois, de participants de cette année et de participants de l'année passée
let arrayMoisLine = new Array("Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep");
let arrayPartLine = new Array(12);
let arrayRecap = new Array(12);
$.post("../../chartRequests/getPartMoisNow.php", {
    // récupération/envoie de idpromo
    fakeidPromo: promo
}, function (tabInfos) {
    //on récupère les infos de la requête et on les push dans les différents tableaux
    var allJson = JSON.parse(tabInfos);
    for (i = 0; i < allJson.length; i++) {
        if(allJson[i]['mois']>=10){
            arrayPartLine[parseInt(allJson[i]['mois']) - 10]=[allJson[i]['participants']];
        }else{
            arrayPartLine[parseInt(allJson[i]['mois']) + 2]=[allJson[i]['participants']];
        }
    }
})
$.post("../../chartRequests/getPartMoisLastYear.php", {
    // récupération/envoie de idpromo
    fakeidPromo: promo
}, function (tabInfos) {
    //on récupère les infos de la requête et on les push dans les différents tableaux
    var allJson = JSON.parse(tabInfos);
    for (i = 0; i < allJson.length; i++) {
        if(allJson[i]['mois']>=10) {
            arrayRecap[parseInt(allJson[i]['mois']) - 10] = [allJson[i]['participants']];
        } else {
            arrayRecap[parseInt(allJson[i]['mois']) + 2 ] = [allJson[i]['participants']];
        }
    }

}).done(function () {
    // on attend que l'autre fonction soit terminée
    // retourne un context de dessin en 2D dans la div partInsc
    var b = document.getElementById('partMois').getContext('2d');
    //Création du Graphique à partir des différents tableaux

    var recapData = {
        label: 'Année passée',
        data: arrayRecap,
        backgroundColor: 'rgba(255, 0, 0, 1)',
        borderColor: 'rgba(128, 0, 0, 1)',
        borderWidth: 0.6,
        showLine: true,
        fill: false,
        spanGaps: true,
    };

    var presentData = {
        label: 'Année en cours',
        data: arrayPartLine,
        backgroundColor: 'rgba(0, 0, 255, 1)',
        borderColor: 'rgba(0, 0, 128, 1)',
        borderWidth: 0.6,
        showLine: true,
        fill: false,
        spanGaps: true,
    };

    var mixedData = {
        labels: arrayMoisLine,
        datasets: [recapData, presentData],
    };

    var chartOptions = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    stepSize: 5
                }
            }],

        }
    }

    var chart = new Chart(b, {
        type: 'line',
        data: mixedData,
        chartOptions: chartOptions
    });
})
