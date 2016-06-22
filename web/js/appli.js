var impression_faite = false;
$(document).on('ready', function(){



    $('.commande_qte_relle').on('change', function(){

        var min = parseInt($(this).attr('min'));
        var max = parseInt($(this).attr('max'));
        var val = parseInt($(this).val());

        if (val < min){
            alert('Valeur négative impossible.');
            $(this).val(min);
        }
        if (val > max){
            alert('Attention, vous mettez plus d\'article que ce que demande le client.');
            $(this).val(max);
        }
        maj_poids();
    });
    maj_poids();
});
        
    function maj_poids(){
        var total = 300; // poids initial du carton
        $('.commande_qte_relle').each(function(){
            var poids = $(this).parent().attr('poids');
            var qte = $(this).val();
            total += poids * qte;
        });
        $('#commande_poids_total').val(total);
    }
    
    
    function validation_commande(){
        if(impression_faite === true){
            return true;
        }else{
            alert('Attention, vous n\'avez pas imprimé le bon de livraison.');
        }
        return false;
    }
    
    function impression(){
        $('.commande_qte_relle').each(function(){
            $(this).parent().html($(this).val());
        });
        $('#commande_poids_total').parent().append( ' : ' + $('#commande_poids_total').val());
        $('#commande_poids_total').attr('style', 'display:none');
        
        impression_faite = true;
        window.print();
    }
        
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