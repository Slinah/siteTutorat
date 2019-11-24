let arrayMoisLine = ['Octobre', 'Novembre', 'Décembre', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre'];
let arrayPartLine = new Array;
let arrayRecap = [24, 64, 53, 13, 0, 1]
$.post("../../chartRequests/getPartMois.php", {
    idPromo: idPromo
}, function (tabInfos) {
    var allJson = JSON.parse(tabInfos);
    for (i = 0; i < allJson.length; i++) {
        arrayPartLine.push(allJson[i]['participants']);
    }
}).done(function () {
    var ctx = document.getElementById('partMois').getContext('2d');

    var recapData = {
        label: 'Année passée',
        data: arrayRecap,
        backgroundColor: 'rgba(255, 0, 0, 1)',
        borderColor: 'rgba(128, 0, 0, 1)',
        borderWidth: 0.6,
        showLine: true,
        fill: false
    };

    var presentData = {
        label: 'Année en cours',
        data: arrayPartLine,
        backgroundColor: 'rgba(0, 0, 255, 1)',
        borderColor: 'rgba(0, 0, 128, 1)',
        borderWidth: 0.6,
        showLine: true,
        fill: false
    };

    var mixedData = {
        labels: arrayMoisLine,
        datasets: [recapData, presentData]
    };

    var chartOptions = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    stepSize: 5
                }
            }]
        }
    }

    var chart = new Chart(ctx, {
        type: 'line',
        data: mixedData,
        chartOptions: chartOptions
    });
})
