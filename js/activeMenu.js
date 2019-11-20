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
        break;

    case 'chartsB2':
        $('#stats').addClass('active');
        break;

    case 'chartsB3':
        $('#stats').addClass('active');
        break;

    case 'chartsI1':
        $('#stats').addClass('active');
        break;

    case 'chartsI2':
        $('#stats').addClass('active');
        break;

    case 'administration':
        $('#admin').addClass('active');
        break;
}