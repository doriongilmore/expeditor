/*
 *  Declencheur en fonction de la class css passer dans le titre il cache les group qui sont dans la balise block
*/
$().ready(function(){
    $(".affichage_accordeon").on('click',function(){
        $(this).parent().children('div').each(function(){
            visible_cache($(this)); 
        });
    });
    //En fonction de la constant le menu apparaitra ou pas modifiable dans le fichier constant.js
    initAffichage(!affichageDefault);
        
    
});

/*
 * Gestion d'affichage d'un contenu par le click de l'entete
 */
function visible_cache(elem, time, effet)
{
    if(time == undefined)
         time = 1000;
     
    if(effet == undefined)
        effet = 'blind';
     
    if($(elem).css('display') == "block")
        $(elem).hide(effet, time);
    else if($(elem).css('display') == "none")
        $(elem).show(effet, time);
    else
        $(elem).hide(effet, time);
}

function initAffichage(affichage)
{
    //En fonction de la constant le menu apparaitra ou pas modifiable dans le fichier constant.js
    if(affichage)
        $(".affichage_accordeon").parent().children('div').each(function(){
            visible_cache($(this), 1,false); 
        });
}
/*
 * Hack pour IE qui permet aux option dans un select qui contient un texte plus long que la largeur du select
 * d'éviter qu'il se fasse couper par le navigateur.
 */

//function gestionLargeurSelect(element)
//{
//    var taille_max_option = 0;
//    element.find('option').each(function(){
//        console.log($(this).css('width'));
//        if(taille_max_option < $(this).css('width'))
//            taille_max_option = $(this).css('width');
//    });
//    if(taille_max_option > 300)//si une option est plus grande que le select alors redimenssionement
//    {
//        element.css('width',taille_max_option);
//    }
//        console.log(taille_max_option);
//}