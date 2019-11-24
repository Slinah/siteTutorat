function heuresMat(promo) {
    let arrayMatBar = new Array;
    let arrayHeureBar = new Array;
    let arrayColorBar = new Array;
    let arrayBorderColorBar = new Array();
    $.post("chartRequests/getHeuresMat.php", {
        idPromo: promo
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
                    label: 'Heures / Matières',
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
}

function callJs(promo) {
    if (promo == 0) {
        let arrayMatiereSum = new Array;
        let arrayHeureSum = new Array;
        let arrayColorSum = new Array;
        let arrayBorderColorSum = new Array();
        $.post("chartRequests/getGlobalChartMat.php",
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
        $('#globalMat').text('Graphique global des tuteurs');
        let arrayTuteurPart = new Array;
        let arrayHeurePart = new Array;
        let arrayColorPart = new Array;
        let arrayBorderColorPart = new Array();
        $.post("chartRequests/getGlobalChartPart.php",
            function (tabInfos) {
                var allJson = JSON.parse(tabInfos);
                for (i = 0; i < allJson.length; i++) {
                    arrayTuteurPart.push(allJson[i]['prenom'] + ' ' + allJson[i]['nom'] + ' (' + allJson[i]['promo'] + ')');
                    arrayHeurePart.push(allJson[i]['duree']);
                    arrayColorPart.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
                    arrayBorderColorPart.push('rgba(0, 0, 0)');
                }
            }).done(function () {
                var ctx = document.getElementById('globalChartParticipation').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: arrayTuteurPart,
                        datasets: [{
                            label: 'Participation (en heures)',
                            data: arrayHeurePart,
                            backgroundColor: arrayColorPart,
                            borderColor: arrayBorderColorPart,
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
        $('#globalPart').text('Graphique global des matières');
    } else if (promo == 1) {
        $('#globalMat').text('');
        $('#globalPart').text('');
        $('#globalChartMatiereDiv').text('');
        $('#globalChartParticipationDiv').text('');
        heuresMat(promo);
    }
}