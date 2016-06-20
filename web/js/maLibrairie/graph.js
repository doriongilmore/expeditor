/*
 *Cette fonction permet d'inserer des graphique dans une page html
 *
 * param : 
 * @tab_info(array) : permet de remplir le graphique et de le configurer
 * @lien(string) : permet d'ajouter des liens sur la légende par défaut cette fonctionalité est désactivé
 *                 indiquer lui le chemin avec la variable lien si il y a des variables renseigner les dans les id das tab_info
 * return : un joli graphique !!
*/
function insererGraph(tab_info, lien, id, type)
{
    
    var reg = new RegExp('MSIE [7|8]\.0');
    if(lien == undefined || lien == "")
        lien = false;
    var parEtapePERSOData = tab_info;
    
    //si ce n'est pas IE <9
    if(!reg.test(navigator.userAgent))
    {
        if(type == undefined)
            choisirTypeGraph('Pie', id, parEtapePERSOData);
        else
            choisirTypeGraph(type, id, parEtapePERSOData);
//        var myPie = new Chart($(id).get(0).getContext("2d")).Pie(parEtapePERSOData);
//        var myPie2 = new Chart($('#graphique_nombre').get(0).getContext("2d")).Pie(parEtapePERSOData);
//        var myPie = new Chart($('#graph_volume').get(0).getContext("2d")).Pie(parEtapePERSOData);
        
        legend($(id +'_legend').get(0), parEtapePERSOData);
    }
    
    if(lien !== false)
    {
        lien = URI + lien;
        $().ready(function(){
            //Pour mozilla
            $('.legend span').on('click',function(){
                remplirFormulaire($(this).attr('name'),lien);
            });
            //Pour IE
            $('.graph span').on('click',function(){
                remplirFormulaire($(this).attr('name'),lien);
            });
        });
    }
    
}

function choisirTypeGraph(type, id, data){
    switch (type) {
        case 'Pie' :
            var myPie = new Chart($(id).get(0).getContext("2d")).Pie(data);
            break;
        case 'Bar' :
            var myBar = new Chart($(id).get(0).getContext("2d")).Bar(data);
            break;
    }
    
    
}

function remplirFormulaire(val_session, lien_redirection)
{
      $.ajax(
      {
        url     : URI_AJAX_SESSION + val_session,
        type    : 'POST',
        success: function(datas)
        {
                window.location.replace(lien_redirection);
        }
      });
}

function suligneLegend(id)
{
    var newId = "#"+id;
    
    $('.legend span').each(function(index, value){
        $(this).css('background-color', 'white');
    });
    $(newId).css('background-color', '#c6ffa3');
    
    $('.graph').on('mouseout',function(){
        $('.legend span').each(function(index, value){
            $(this).css('background-color', 'white');
        }); 
    });
}