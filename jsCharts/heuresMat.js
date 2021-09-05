//Graphique représentant le nombre de participants par rapport au nombre d'inscrits
//on récupère la variable promo si elle n'est pas définie.
if (typeof promo === 'undefined') {
    promo = $("#idPromo").val();
}
// initialisation des tableaux de Matière, d'heure,
// de la couleur et des bordures
let arrayMatBar = new Array;
let arrayHeureBar = new Array;
let arrayColorBar = new Array;
let arrayBorderColorBar = new Array();
    $.post("../../chartRequests/getHeuresMat.php", {
        // récupération/envoie de idpromo
        idPromo: promo,
    }, function (tabInfos) {
        //on récupère les infos de la requête et on les push dans les différents tableaux
        var allJson = JSON.parse(tabInfos);
        for (i = 0; i < allJson.length; i++) {
            arrayMatBar.push(allJson[i]['matiere']);
            arrayHeureBar.push(allJson[i]['duree']);
            arrayColorBar.push('rgba(' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', ' + Math.floor(Math.random() * 256) + ', 0.2)');
            arrayBorderColorBar.push('rgba(0, 0, 0)');
        }
    }).done(function () {
        // on attend que l'autre fonction soit terminée
        // retourne un context de dessin en 2D dans la div partInsc
        var c = document.getElementById('heuresMat').getContext('2d');

        //Création du Graphique à partir des différents tableaux
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
