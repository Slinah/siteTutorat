//Initialisation de la fonction changePromoFunction
let changePromoFunction = function() {
    $("#promo").on("change", function () {
        //On refais la même mécanique pour rafraichir le select pour les classes
        let promo = $(this).val()
        $.post(
            './userRequests/getFilterClassForUpdateProfil.php',
            {
                idPromo: promo,
                //Retourne les données
            }, function (data) {
                let parsedDatas = JSON.parse(data);
                let str = '<select id="classByPromo" name="newclasse" data-role="select" data-filter="false" data-prepend="Ta nouvelle classe : ">';
                parsedDatas.forEach(element => {
                    str += '<option value="' + element['id_classe'] + '">' + element['classe'] + '</option>'
                });
                str += '</select>';
                $("#divClasses").html(str);
            });
    });
}

$("#ecole").on("change", function (){
    let ecole = $(this).val()
    $.post(
        './userRequests/getFilterPromoForUpdateProfil.php',
        {
            idEcole: ecole,
            //Retourne les données
        }, function (data) {
            let parsedDatas = JSON.parse(data);
            let str = '<select id="promo" name="newpromo" data-role="select" data-filter="false" data-prepend="Ta nouvelle promo : ">';
            parsedDatas.forEach(element => {
                str+='<option value="'+element['id_promo']+'">'+element['promo']+'</option>'
            });
            str+='</select>';
            $("#divPromo").html(str);
//S'execute une fois la classe changée et une fois que les nouvelles promos auront été chargées en Ajax
            changePromoFunction();
    });
});
// S'execute au chargement de la page
changePromoFunction();


