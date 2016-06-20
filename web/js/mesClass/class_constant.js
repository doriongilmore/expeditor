/*
 *  Objet Prospect 
 *  
 *  Permet la gestion d'un prospect son mode lecture ecriture ETC ...
 */
var Constant = {



/*
* Méthodes de l'objet Constant
*/
    requeteAjax : function(ajax_url, type) //Permet de faire n'importe quelle requete Ajax
    {
        if(type == undefined)
            type = 'GET';
        
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
    },
    requetePost : function(ajax_url,datas) //Permet de faire n'importe quelle requete Ajax en mode POST
    {
        var resultatRequete = false;
        $.ajax(
        {
            url : ajax_url,
            type    : 'POST',
            data: datas,// ca peut être un string, un int, un tableau, ... mais pas un objet.     
            async : false,
            success: function(datas){
                finChargement();
                if(datas != undefined)
                    resultatRequete = datas;
            },
            beforeSend:function()
            {
                chargement('Chargement en cours ...');
            }
        });
        
        return resultatRequete;
    }
}
