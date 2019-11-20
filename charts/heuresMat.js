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

let arrayMatBar = new Array;
let arrayHeureBar = new Array;
let arrayColorBar = new Array;
let arrayBorderColorBar = new Array();
$.post("../../chartRequests/getHeuresMat.php", {
    idPromo: idPromo
}, function (tabInfos) {
    var allJson = JSON.parse(tabInfos);
    for (i = 0; i < allJson.length; i++) {
        arrayMatBar.push(allJson[i]['matiere']);
        arrayHeureBar.push(allJson[i]['duree']);
        arrayColorBar.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
        arrayBorderColorBar.push('rgba(0, 0, 0)');
    }
}).done(function () {
    var ctx = document.getElementById('heuresMat').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: arrayMatBar,
            datasets: [{
                label: 'Heures / Matières (' + nomPromo + ')',
                data: arrayHeureBar,
                backgroundColor: arrayColorBar,
                borderColor: arrayBorderColorBar,
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
