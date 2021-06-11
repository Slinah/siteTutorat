// Graphique du nombre d'heures de participations des tuteurs
// initialisation des tableaux de tuteurs, d'heure par tuteurs,
// de la couleur et des bordures
let arrayTuteurPart = new Array;
let arrayHeurePart = new Array;
let arrayColorPart = new Array;
let arrayBorderColorPart = new Array();
$.post("../../chartRequests/getGlobalChartPart.php",
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
    // retourne un context de dessin en 2D dans la div partInsc
        var ctx = document.getElementById('globalChartParticipation').getContext('2d');

    //Création du Graphique à partir des différents tableaux
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
