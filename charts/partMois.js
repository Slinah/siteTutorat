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

let arrayMoisLine = ['Septembre', 'Octobre', 'Novembre', 'Décembre', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout'];
let arrayPartLine = new Array;
let arrayColorLine = new Array;
let arrayBorderColorLine = new Array();
$.post("../../chartRequests/getPartMois.php", {
    idPromo: idPromo
}, function (tabInfos) {
    var allJson = JSON.parse(tabInfos);
    for (i = 0; i < allJson.length; i++) {
        if (allJson[i]['mois'] == 9) {
            arrayPartLine[0] = allJson[i]['participants'];
        } else {
            arrayPartLine[0] = 0;
        }
        if (allJson[i]['mois'] == 10) {
            arrayPartLine[1] = allJson[i]['participants'];
        } else {
            arrayPartLine[1] = 0;
        }
        if (allJson[i]['mois'] == 11) {
            arrayPartLine[2] = allJson[i]['participants'];
        } else {
            arrayPartLine[2] = 0;
        }
        if (allJson[i]['mois'] == 12) {
            arrayPartLine[3] = allJson[i]['participants'];
        } else {
            arrayPartLine[3] = 0;
        }
        if (allJson[i]['mois'] == 1) {
            arrayPartLine[4] = allJson[i]['participants'];
        } else {
            arrayPartLine[4] = 0;
        }
        if (allJson[i]['mois'] == 2) {
            arrayPartLine[5] = allJson[i]['participants'];
        } else {
            arrayPartLine[5] = 0;
        }
        if (allJson[i]['mois'] == 3) {
            arrayPartLine[6] = allJson[i]['participants'];
        } else {
            arrayPartLine[6] = 0;
        }
        if (allJson[i]['mois'] == 4) {
            arrayPartLine[7] = allJson[i]['participants'];
        } else {
            arrayPartLine[7] = 0;
        }
        if (allJson[i]['mois'] == 5) {
            arrayPartLine[8] = allJson[i]['participants'];
        } else {
            arrayPartLine[8] = 0;
        }
        if (allJson[i]['mois'] == 6) {
            arrayPartLine[9] = allJson[i]['participants'];
        } else {
            arrayPartLine[9] = 0;
        }
        if (allJson[i]['mois'] == 7) {
            arrayPartLine[10] = allJson[i]['participants'];
        } else {
            arrayPartLine[10] = 0;
        }
        if (allJson[i]['mois'] == 8) {
            arrayPartLine[11] = allJson[i]['participants'];
        } else {
            arrayPartLine[11] = 0;
        }
        // arrayPartLine.push(allJson[i]['participants']);
        arrayColorLine.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
        arrayBorderColorLine.push('rgba(0, 0, 0)');
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
                backgroundColor: arrayColorLine,
                borderColor: arrayBorderColorLine,
                borderWidth: 0.2
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
