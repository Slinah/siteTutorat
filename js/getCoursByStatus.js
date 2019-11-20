function getCoursByStatus(){
    $.post("../external/getCourseStatus.php",{
        status: 0
    },function (jsonByPhp){
        var tabCours = JSON.parse(jsonByPhp);
        alert(tabCours);
    });
}