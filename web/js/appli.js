/* $(document).on('keyup','#txt_nom_equipe',function(){
        nom = $('#txt_nom_equipe').val();
        tabUri = (location.href).split('/');
        URI = tabUri[0]+"//"+tabUri[2];
        urlAjax = URI + '/ajax/nameTeamDispo/'; //+nom;
        nomIndispo = URI + '/web/images/non.png';
        nomDispo = URI + '/web/images/ok.png';
        $.ajax(
        {
            url     : urlAjax ,
            type    : 'POST',
            async : true,
            data : {
                nom:nom
            },
            success: function(datas)
            {
                    if (datas == null){ // erreur
                        $('#equipe_nom_dispo').attr('src', nomIndispo );
                    }else if (datas == 'false'){ // nom indisponible
                        $('#equipe_nom_dispo').attr('src', nomIndispo );
                    }else if (datas == 'true'){ // nom disponible
                        $('#equipe_nom_dispo').attr('src', nomDispo );
                    }
//                resultatRequete = null;
//                if(datas != '' && datas != undefined)
//                    resultatRequete = JSON.parse(datas);
//                console.log(resultatRequete);
            }
            
        });
       
    });

        */
        
        
        