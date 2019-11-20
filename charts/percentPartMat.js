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

let arrayMatPie = new Array;
let arrayPercentPie = new Array;
let arrayColorPie = new Array;
let arrayBorderColorPie = new Array();
$.post("../../chartRequests/getPercentPartMat.php", {
    idPromo: idPromo
}, function (tabInfos) {
    var allJson = JSON.parse(tabInfos);
    for (i = 0; i < allJson.length; i++) {
        arrayMatPie.push(allJson[i]['matiere']);
        arrayPercentPie.push(allJson[i]['participants']);
        arrayColorPie.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
        arrayBorderColorPie.push('rgba(0, 0, 0)');
    }
}).done(function () {
    var ctx = document.getElementById('partPercent').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: arrayMatPie,
            datasets: [{
                label: 'Participants / Matières (' + nomPromo + ')',
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
