// faire un function save a appelé une fois le graph fait
// faire une fonction restore

function saveGraph(chart) {
    chart.save();
    return chart
}


//fonction pour le graphique qui affiche le pourcentage de participants par matière ??
function partPercent(promo) {
    //création des tableaux de matières et de pourcentage
    let arrayMatPie = new Array;
    let arrayPercentPie = new Array;
    let arrayColorPie = new Array;
    let arrayBorderColorPie = new Array();
    $.post("chartRequests/getPercentPartMat.php", {
        // récupération/envoie de idpromo
        idPromo: promo
    }, function (tabInfos) {
        var allJson = JSON.parse(tabInfos);
        for (i = 0; i < allJson.length; i++) {
            // ajoute les matieres et les partipants
            arrayMatPie.push(allJson[i]['matiere']);
            arrayPercentPie.push(allJson[i]['participants']);
            arrayColorPie.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
            arrayBorderColorPie.push('rgba(0, 0, 0)');
        }
    }).done(function () {
        var ctxpercentparmat = document.getElementById('partPercent').getContext('2d');
        var myChart = new Chart(ctxpercentparmat, {
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
        saveGraph(ctxpercentparmat);
    })
}

//fonction pour le graph du nombre de participants inscrits ??
function partInsc(promo) {
    // création des
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
    let arrayMoisLine = new Array("Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep");
    let arrayPartLine = new Array(12);
    let arrayRecap = new Array(12);
    $.post("chartRequests/getPartMoisNow.php", {
        //promo n'est pas l'idPromo mais le fake idPromo: 1,2,3,4...
        fakeidPromo: promo
    }, function (tabInfos) {
        var allJson = JSON.parse(tabInfos);
        for (i = 0; i < allJson.length; i++) {
            if(allJson[i]['mois']>=10){
                arrayPartLine[parseInt(allJson[i]['mois']) - 10]=[allJson[i]['participants']];
            }else{
                arrayPartLine[parseInt(allJson[i]['mois']) + 2]=[allJson[i]['participants']];
            }
        }
    })
    $.post("chartRequests/getPartMoisLastYear.php", {
            //promo n'est pas l'idPromo mais le fake idPromo: 1,2,3,4...
            fakeidPromo: promo
        }, function (tabInfos) {
            var allJson = JSON.parse(tabInfos);
            for (i = 0; i < allJson.length; i++) {
                if(allJson[i]['mois']>=10) {
                    arrayRecap[parseInt(allJson[i]['mois']) - 10] = [allJson[i]['participants']];
                } else {
                    arrayRecap[parseInt(allJson[i]['mois']) + 2 ] = [allJson[i]['participants']];
                }
            }

    }).done(function () {
        console.log(arrayMoisLine)
        console.log(arrayRecap)
        console.log(arrayPartLine)
        var b = document.getElementById('partMois').getContext('2d');

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
        var c = document.getElementById('heuresMat').getContext('2d');
        var myChart = new Chart(c, {
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

// fonction appelé de base ligne 19 dans dashboard.php
function callJs(promo) {
    console.log(promo);
    // on vérifie si une promo a été choisie
    // si non :
    if (promo === 0) {
        // on vide les textes ? (des div en bas de la page)
        $('#heuresM').text('');
        $('#partM').text('');
        $('#partI').text('');
        $('#partP').text('');
        //si on a changé de choix et que l'on a déjà fait une sauvegarde, on restaure les canvas
        // $('#heureMatDiv').text('');
        //$('#heureMat').restore();
        // $('#partMoisDiv').text('');
       // $('#partMois').restore();
        // $('#partInscDiv').text('');
       // $('#partInsc').restore();
        // $('#partPercentDiv').text('');
        //$('#partPercent').restore();

        //(inscrit le titre au dessus des 2 graphiques globaux)
        $('#globalPart').text('Graphique du nombre d\'heures de participation des tuteurs');
        $('#globalMat').text('Graphique du nombre d\'heures données des matières');
        // création des tableaux (sommes des matières, sommes d'heures, sommes des couleurs et bordures
        let arrayMatiereSum = new Array;
        let arrayHeureSum = new Array;
        let arrayColorSum = new Array;
        let arrayBorderColorSum = new Array();
        // appel de la page qui va faire la requête
        $.post("chartRequests/getGlobalChartMat.php",
            //envoie des informations
            function (tabInfos) {
                var allJson = JSON.parse(tabInfos);
                for (i = 0; i < allJson.length; i++) {
                    //ajoute les matières et les durées une part une avec la boucle
                    arrayMatiereSum.push(allJson[i]['matiere']);
                    arrayHeureSum.push(allJson[i]['duree']);
                    //ajoute les infos sur la couleur (aléatoire) + bordure
                    arrayColorSum.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
                    arrayBorderColorSum.push('rgba(0, 0, 0)');
                }
            }).done(function () {
                // on attend que l'autre fonction soit terminée
                // retourne un context de dessin en 2D dans la div globalChartMatiere
                var ctxhparmatiere = document.getElementById('globalChartMatiere').getContext('2d');
                var myChart = new Chart(ctxhparmatiere, {
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
                saveGraph(ctxhparmatiere);
            })
        //création de tableaux pour le graph des heures par tuteurs
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
                var ctxhpartuteurs = document.getElementById('globalChartParticipation').getContext('2d');
                var myChart = new Chart(ctxhpartuteurs, {
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
                saveGraph(ctxhpartuteurs);
            })
    } else {

        //si la promo a été choisie
        //effacer ce qu'il y a de noté dans les div des graph globaux sur les h/tuteurs et h/matieres
        $('#globalMat').text('');
        $('#globalPart').text('');
        $('#globalChartMatiereDiv').text('');
        $('#globalChartParticipationDiv').text('');
        //on insère le titres des autres graph
        $('#heuresM').text('Heures de tutorats par matières');
        $('#partM').text('Participants par mois');
        $('#partI').text('Nombre de participants par rapport au nombre d\'inscrits');
        $('#partP').text('Nombre de participants par matières');

        //on restaure les graph s'ils ont déjà été lancés

        // $('#heureMatDiv').text('');
        // $('#heuresMat').restore();
        // document.getElementById('#heuresMat').getContext('2d').restore();
        // // $('#partMoisDiv').text('');
        // // $('#partMois').restore();
        // document.getElementById('#partMois').getContext('2d').restore();
        // // $('#partInscDiv').text('');
        // // $('#partInsc').restore();
        // document.getElementById('#partInsc').getContext('2d').restore();
        // // $('#partPercentDiv').text('');
        // // $('#partPercent').restore();
        // document.getElementById('#partPercent').getContext('2d').restore();
        // //on appelle les fonctions qui s'occupent de ces graph et on leur passe la promo choisie
        heuresMat(promo);
        partMois(promo);
        partInsc(promo);
        partPercent(promo);
    }
}