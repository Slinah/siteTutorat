let changePromoFunction = function() {
    $("#promo").on("change", function () {
        alert('onChange promo');
        //refaire la même mécanique pour rafraichir le select pour les classes

        let promo = $(this).val()//if(booleen paramètre==1){afficher l'url qui va avec 1}
        console.log(promo);
        $.post(
            './userRequests/getFilterClassForUpdateProfil.php',
            {
                idPromo: promo,
                //Retourne les données
            }, function (data) {
                let parsedDatas = JSON.parse(data);
                console.log(parsedDatas);
                let str = '<select id="classByPromo" name="classe" data-role="select" data-filter="false" data-prepend="Ta nouvelle classe : ">';
                parsedDatas.forEach(element => {
                    str += '<option value="' + element['id_classe'] + '">' + element['classe'] + '</option>'
                });
                str += '</select>';
                console.log(str);
                $("#divClasses").html(str);
                //S'execute une fois la classe changée et une fois que les nouvelles promos auront été chargées en Ajax
            });
    });
}

$("#ecole").on("change", function (){
    let ecole = $(this).val()//if(booleen paramètre==1){afficher l'url qui va avec 1}
    console.log(ecole);
    $.post(
        './userRequests/getFilterPromoForUpdateProfil.php',
        {
            idEcole: ecole,
            //Retourne les données
        }, function (data) {
            let parsedDatas = JSON.parse(data);
            console.log(parsedDatas);
            let str = '<select id="promo" name="promo" data-role="select" data-filter="false" data-prepend="Ta nouvelle promo : ">';
            parsedDatas.forEach(element => {
                str+='<option value="'+element['id_promo']+'">'+element['promo']+'</option>'
            });
            str+='</select>';
            console.log(str);
            $("#divPromo").html(str);
//S'execute une fois la classe changée et une fois que les nouvelles promos auront été chargées en Ajax
            changePromoFunction();
    });
});
// S'execute au chargement de la page
changePromoFunction();

