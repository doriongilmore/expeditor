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
    $(document).on('ready', function(){


        var total = 300; // poids initial du carton

        $('.commande_qte_relle').on('change', function(){
            if ($(this).val() < 0){
                alert('Valeur négative impossible.');
                $('#commande_poids_total').val(total);
            }
            else{
                $('.commande_qte_relle').each(function(){
                    var poids = $(this).parent().attr('poids');
                    var qte = $(this).val();
                    total += poids * qte;
                });
                $('#commande_poids_total').val(total);
            }
        });
    });
        
        
//    function  debloquerSD (id){
//        var url = URI + 'ajax/debloquerSD/'+id;
//        var res = Constant.requeteAjax(url);
//        return res;
//        
//    }
        
        
        
    function requeteAjax (ajax_url, type) //Permet de faire n'importe quelle requete Ajax
    {
        if(type == undefined)
            type = 'POST';
        
        var resultatRequete = false;
        $.ajax(
        {
            url     : ajax_url,
            type    : type,
            async : false,
            success: function(datas)
            {
                finChargement();
                if(datas != '' && datas != undefined)
                    resultatRequete = JSON.parse(datas);
            },
            beforeSend:function()
            {
                chargement('Chargement en cours ...');
            }

        });
        
        return resultatRequete;
    }