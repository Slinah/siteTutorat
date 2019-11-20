let arrayMatiereSum = new Array;
let arrayHeureSum = new Array;
let arrayColorSum = new Array;
let arrayBorderColorSum = new Array();
$.post("../../chartRequests/getGlobalChartMat.php",
    function (tabInfos) {
        var allJson = JSON.parse(tabInfos);
        for (i = 0; i < allJson.length; i++) {
            arrayMatiereSum.push(allJson[i]['matiere']);
            arrayHeureSum.push(allJson[i]['duree']);
            arrayColorSum.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
            arrayBorderColorSum.push('rgba(0, 0, 0)');
        }
    }).done(function () {
        var ctx = document.getElementById('globalChartMatiere').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: arrayMatiereSum,
                datasets: [{
                    label: 'Somme Heures/Matières (Global)',
                    data: arrayHeureSum,
                    backgroundColor: arrayColorSum,
                    borderColor: arrayBorderColorSum,
                    borderWidth: 0.2
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }]
                }
            }
        });
    })
