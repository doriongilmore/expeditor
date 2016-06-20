$().ready(function(){
   $('.tuile').on('click',function(){
       if(tabTuile != undefined )
        {
            if(tabTuile[$(this).attr('id')] != undefined && tabTuile[$(this).attr('id')] != '')
            {
                if($(this).attr('class').search('tuile_active') == -1)
                    window.location.replace(tabTuile[$(this).attr('id')]);
            }
            else
                alert('Veuillez vérifier les constantes, ' + $(this).attr('id') + ' est introuvable.');

        }else
            alert('Il manque la variable tabTuile dans le fichier constant.js');
   });
});