/*
 *  Objet Prospect 
 *  
 *  Permet la gestion d'un prospect son mode lecture ecriture ETC ...
 */
var SD = {

/*
* Attribut de l'objet sd
*/

/*
* Méthodes de l'objet sd
*/
    debloquerSD : function(id){
        var url = URI + 'ajax/debloquerSD/'+id;
        var res = Constant.requetePost(url);
        return res;
        
    },
    deleteServerFile : function(name){
        var url = URI + 'ajax/deleteServerFile/'+name;
        var res = Constant.requetePost(url);
        return res;
        
    },
    getCdtBySite : function(id){
        var url = URI + 'ajax/cdtBySite/'+id;
        var res = Constant.requetePost(url);
        return res;
        
    }
}
