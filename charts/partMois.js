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
