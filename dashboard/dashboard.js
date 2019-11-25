function partPercent(promo) {
    let arrayMatPie = new Array;
    let arrayPercentPie = new Array;
    let arrayColorPie = new Array;
    let arrayBorderColorPie = new Array();
    $.post("chartRequests/getPercentPartMat.php", {
        idPromo: promo
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
                    label: 'Participants / Matières',
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
}

function partInsc(promo) {
    let arrayInsc = new Array;
    let arrayPart = new Array;
    let arrayDate = new Array;
    let arrayMois = new Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    $.post("chartRequests/getPartInsc.php", {
        idPromo: promo
    }, function (arrayJSON) {
        var jsonPartInsc = JSON.parse(arrayJSON);
        for (i = 0; i < jsonPartInsc.length; i++) {
            arrayInsc.push(jsonPartInsc[i]['inscrits']);
            if (jsonPartInsc[i]['participants'] == null) {
                arrayPart.push(0);
            } else {
                arrayPart.push(jsonPartInsc[i]['participants']);
            }
            let dt = new Date(jsonPartInsc[i]['date']);
            arrayDate.push(jsonPartInsc[i]['matiere'] + ' (' + dt.getDate() + ' ' + arrayMois[dt.getMonth()] + ')');
        }
    }).done(function () {
        var chartInsc = document.getElementById("partInsc");


        var inscritData = {
            label: 'Inscrits',
            data: arrayInsc,
            backgroundColor: 'rgba(0, 99, 132, 0.6)',
            borderWidth: 0
        };

        var participantData = {
            label: 'Participants',
            data: arrayPart,
            backgroundColor: 'rgba(99, 132, 0, 0.6)',
            borderWidth: 0
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
}

function partMois(promo) {
    let arrayMoisLine = ['Octobre', 'Novembre', 'Décembre', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre'];
    let arrayPartLine = new Array;
    let arrayRecap = [24, 64, 53, 13, 0, 1]
    $.post("chartRequests/getPartMois.php", {
        idPromo: promo
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
}

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
        $('#heuresM').text('');
        $('#partM').text('');
        $('#partI').text('');
        $('#partP').text('');
        $('#heureMatDiv').text('');
        $('#partMoisDiv').text('');
        $('#partInscDiv').text('');
        $('#partPercentDiv').text('');
        $('#globalMat').text('Graphique global des tuteurs');
        $('#globalPart').text('Graphique global des matières');
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
    } else {
        $('#globalMat').text('');
        $('#globalPart').text('');
        $('#globalChartMatiereDiv').text('');
        $('#globalChartParticipationDiv').text('');
        $('#heuresM').text('Heures de tutorats par matières');
        $('#partM').text('Participants par mois');
        $('#partI').text('Nombre de participants par rapport au nombre d\'inscrits');
        $('#partP').text('Nombre de participants par matières');
        $('#heureMatDiv').text('');
        $('#partMoisDiv').text('');
        $('#partInscDiv').text('');
        $('#partPercentDiv').text('');
        heuresMat(promo);
        partMois(promo);
        partInsc(promo);
        partPercent(promo);
    }
}