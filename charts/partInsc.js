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

let arrayInsc = new Array;
let arrayPart = new Array;
let arrayDate = new Array;
let arrayMois = new Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$.post("../../chartRequests/getPartInsc.php", {
    idPromo: idPromo
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
        arrayDate.push(jsonPartInsc[i]['matiere'] + ' (' + dt.getDay() + ' ' + arrayMois[dt.getMonth()] + ')');
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
            }]
        }
    };

    var barChart = new Chart(chartInsc, {
        type: 'bar',
        data: peopleData,
        options: chartOptions
    });
})
