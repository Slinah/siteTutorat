// Graphique du nombre d'heures de tutorat données par matière

// initialisation des tableaux de matière, d'heure par matière,
// de la couleur et des bordures
let arrayMatiereSum = new Array;
let arrayHeureSum = new Array;
let arrayColorSum = new Array;
let arrayBorderColorSum = new Array();
$.post("../../chartRequests/getGlobalChartMat.php",
    function (tabInfos) {
        //on récupère les infos de la requête et on les push dans les différents tableaux
        var allJson = JSON.parse(tabInfos);
        for (i = 0; i < allJson.length; i++) {
            // ajoute la matière qui est dans la boucle
            arrayMatiereSum.push(allJson[i]['matiere']);
            arrayHeureSum.push(allJson[i]['duree']);
            arrayColorSum.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
            arrayBorderColorSum.push('rgba(0, 0, 0)');
        }
    }).done(function () {
    // on attend que l'autre fonction soit terminée
    // retourne un context de dessin en 2D dans la div partInsc
        var ctx = document.getElementById('globalChartMatiere').getContext('2d');

    //Création du Graphique à partir des différents tableaux
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
