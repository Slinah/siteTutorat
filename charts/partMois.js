switch (nom) {
    case 'chartsB1':
        idPromo = 1;
        nomPromo = 'B1';
        break;

    case 'chartsB2':
        idPromo = 2;
        nomPromo = 'B2';
        break;

    case 'chartsB3':
        idPromo = 3;
        nomPromo = 'B3';
        break;

    case 'chartsI1':
        idPromo = 4;
        nomPromo = 'I1'
        break;

    case 'chartsI2':
        idPromo = 5;
        nomPromo = 'I2'
        break;
}

let arrayMoisLine = ['Octobre', 'Novembre', 'Décembre', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre'];
let arrayPartLine = new Array;
$.post("../../chartRequests/getPartMois.php", {
    idPromo: idPromo
}, function (tabInfos) {
    var allJson = JSON.parse(tabInfos);
    for (i = 0; i < allJson.length; i++) {
        arrayPartLine.push(allJson[i]['participants']);
    }
}).done(function () {
    var ctx = document.getElementById('partMois').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: arrayMoisLine,
            datasets: [{
                label: 'Participation / Mois (' + nomPromo + ')',
                data: arrayPartLine,
                backgroundColor: 'rgba(255, 0, 0, 1)',
                borderColor: 'rgba(128, 0, 0, 1)',
                borderWidth: 0.6,
                showLine: true,
                fill: false
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 5
                    }
                }]
            }
        }
    });
})
