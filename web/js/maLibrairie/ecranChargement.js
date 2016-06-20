$().ready(function(){
    $('.chargement').on('click',function(){
       chargement('Chargement, veuillez patienter ...') ;
    });
});

function chargement(message)
{
    //rend opaque le contenue derriere  
//        $('.content').fadeTo('slow', 0.4);
        $('.maPage').fadeTo('slow', 0.4);
        
    //ajout de la div barre de progression
        $("<div id='progress_bar'>"+message+"</div>").appendTo(document.body);
    //méthode jquery qui affiche la barre et son style    
        $('#progress_bar').progressbar({
            value: false
        });
}

function finChargement()
{
    
    $('.maPage').fadeTo('slow', 1);
    
    $('#progress_bar').remove();
}
