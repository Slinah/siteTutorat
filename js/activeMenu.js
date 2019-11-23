var nom = window.location.pathname;
nom = nom.split("/");
nom = nom[nom.length - 1];
nom = nom.substr(0, nom.lastIndexOf("."));
nom = nom.replace(new RegExp("(%20|_|-)", "g"), "");

$('#' + nom).addClass('active');

switch (nom) {
    case 'editCourse':
        $('#administration').addClass('active');
        break;

    case 'closeCourse':
        $('#administration').addClass('active');
        break;

    case 'globalCharts':
        $('#stats').addClass('active');
        break;

    case 'chartsB1':
        $('#stats').addClass('active');
        idPromo = 1;
        nomPromo = 'B1';
        break;

    case 'chartsB2':
        $('#stats').addClass('active');
        idPromo = 2;
        nomPromo = 'B2';
        break;

    case 'chartsB3':
        $('#stats').addClass('active');
        idPromo = 3;
        nomPromo = 'B3';
        break;

    case 'chartsI1':
        $('#stats').addClass('active');
        idPromo = 4;
        nomPromo = 'I1'
        break;

    case 'chartsI2':
        $('#stats').addClass('active');
        idPromo = 5;
        nomPromo = 'I2'
        break;

    case 'administration':
        $('#admin').addClass('active');
        break;
}