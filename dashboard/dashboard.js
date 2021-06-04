//fonction qui gère les graphiques globaux
function graphGlobaux(){
    // on effacent les textes des graphiques si on a choisit une promo particulière
    $('#heuresM').text('');
    $('#partM').text('');
    $('#partI').text('');
    $('#partP').text('');
    //inscrit le titre au dessus des 2 graphiques globaux
    $('#globalPart').text('Graphique du nombre d\'heures de participation des tuteurs');
    $('#globalMat').text('Graphique du nombre d\'heures données des matières');

    // Graphique du nombre d'heures données des matières
    // création des tableaux (sommes des matières, sommes d'heures, sommes des couleurs et bordures)
    let arrayMatiereSum = new Array;
    let arrayHeureSum = new Array;
    let arrayColorSum = new Array;
    let arrayBorderColorSum = new Array();
    // appel de la page qui va faire la requête
    $.post("chartRequests/getGlobalChartMat.php",
        function (tabInfos) {
        //on récupère les infos de la requête et on les push dans les différents tableaux
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
        //Création du Graphique à partir des différents tableaux
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

    })

    // Graphique du nombre d'heures de participation des tuteurs
    //création de tableaux pour les Tuteurs, Heures, couleurs aléatoires et bordures
    let arrayTuteurPart = new Array;
    let arrayHeurePart = new Array;
    let arrayColorPart = new Array;
    let arrayBorderColorPart = new Array();
    $.post("chartRequests/getGlobalChartPart.php",
        function (tabInfos) {
            //on récupère les infos de la requête et on les push dans les différents tableaux
            var allJson = JSON.parse(tabInfos);
            for (i = 0; i < allJson.length; i++) {
                arrayTuteurPart.push(allJson[i]['prenom'] + ' ' + allJson[i]['nom'] + ' (' + allJson[i]['promo'] + ')');
                arrayHeurePart.push(allJson[i]['duree']);
                arrayColorPart.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
                arrayBorderColorPart.push('rgba(0, 0, 0)');
            }
        }).done(function () {
        // on attend que l'autre fonction soit terminée
        // retourne un context de dessin en 2D dans la div globalChartParticipation
        var ctxhpartuteurs = document.getElementById('globalChartParticipation').getContext('2d');
        //Création du Graphique à partir des différents tableaux
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
    })

}

//fonction pour le Diagramme représentant le nombre de partipants par matière
function partPercent(promo) {
    //création des tableaux de matières, du nombre de participants, couleurs aléatoires et bordures
    let arrayMatPie = new Array;
    let arrayPercentPie = new Array;
    let arrayColorPie = new Array;
    let arrayBorderColorPie = new Array();
    $.post("chartRequests/getPercentPartMat.php", {
        // récupération/envoie de idpromo
        idPromo: promo
    }, function (tabInfos) {
        //on récupère les infos de la requête et on les push dans les différents tableaux
        var allJson = JSON.parse(tabInfos);
        for (i = 0; i < allJson.length; i++) {
            arrayMatPie.push(allJson[i]['matiere']);
            arrayPercentPie.push(allJson[i]['participants']);
            arrayColorPie.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
            arrayBorderColorPie.push('rgba(0, 0, 0)');
        }
    }).done(function () {
        // on attend que l'autre fonction soit terminée
        // retourne un context de dessin en 2D dans la div globalChartParticipation
        var ctxpercentparmat = document.getElementById('partPercent').getContext('2d');
        //Création du Graphique à partir des différents tableaux
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
    })
}

//fonction pour le graphique du nombre de participants par rapport au nombre d'inscrits
function partInsc(promo) {
    //création des tableaux d'Inscrits, du nombre de participants, de dates et des mois
    let arrayInsc = new Array;
    let arrayPart = new Array;
    let arrayDate = new Array;
    let arrayMois = new Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    $.post("chartRequests/getPartInsc.php", {
        // récupération/envoie de idpromo
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
            let dt = new Date(jsonPartInsc[i]['datee']);
            arrayDate.push(jsonPartInsc[i]['matiere'] + ' (' + dt.getDate() + ' ' + arrayMois[dt.getMonth()] + ')');
        }
    }).done(function () {
        var chartInsc = document.getElementById("partInsc");
        console.log(arrayDate)

        var inscritData = {
            label: 'Inscrits',
            data: arrayInsc,
            backgroundColor: 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)' ,
            borderWidth: 0.2,
            borderColor: 'rgba(0, 0, 0)',
        };

        var participantData = {
            label: 'Participants',
            data: arrayPart,
            backgroundColor: 'rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)',
            borderWidth: 0.2,
            borderColor: 'rgba(0, 0, 0)',
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
        console.log(arrayMatBar)
        console.log(arrayHeureBar)
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
        graphGlobaux();
    } else {
        //si la promo a été choisie
        //effacer ce qu'il y a de noté dans les div des graph globaux sur les h/tuteurs et h/matieres
        $('#globalMat').text('');
        $('#globalPart').text('');
        //on insère le titres des autres graph
        $('#heuresM').text('Graphique représentant le nombre d\'heures de tutorats par matières');
        $('#partM').text('Graphique représentant l\'évolution du nombre de participants par mois');
        $('#partI').text('Graphique représentant le nombre de participants par rapport au nombre d\'inscrits');
        $('#partP').text('Diagramme représentant le nombre de partipants par matière ');
        heuresMat(promo);
        partMois(promo);
        partInsc(promo);
        partPercent(promo);
    }
}