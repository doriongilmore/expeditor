$().ready(function(){
    $('.checkBox_habilitation').on('click',function(){
        profilChecked(this);
    });
    $('#container_habilitation #user').on('focus',function(){
        $('.liste_profil').hide('blind',1000);
    });
});

function profilChecked(profil)
{
    var nodeParent = $(profil).parent();
    var aujourdhui = new Date();
    var options = {day: "2-digit", month: "2-digit", year: "numeric"};
    
    if(profil.checked)//Si la case est coché
    {
        nodeParent.find(".date_habilitation").removeAttr('disabled');
        nodeParent.find("img").css('visibility','visible');
//        nodeParent.find(".date_habilitation[name^='date_debut']").val(aujourdhui.toLocaleFormat('%d-%m-%Y')); Pas compatible IE 7
        nodeParent.find(".date_habilitation[name^='date_debut']").val(("0" + (aujourdhui.getDate())).slice(-2) + '-' + ("0" + (aujourdhui.getMonth()+1)).slice(-2) + '-' +aujourdhui.getFullYear());
//        nodeParent.find(".date_habilitation[name^='date_debut']").val(aujourdhui.toLocaleDateString('fr-FR',options).replace('/', '-').replace('/', '-'));
        aujourdhui.setYear(aujourdhui.getFullYear()+3);
//        nodeParent.find(".date_habilitation[name^='date_fin']").val(aujourdhui.toLocaleFormat('%d-%m-%Y')); Pas compatible IE 7
        nodeParent.find(".date_habilitation[name^='date_fin']").val(("0" + (aujourdhui.getDate())).slice(-2) + '-' + ("0" + (aujourdhui.getMonth()+1)).slice(-2) + '-' +aujourdhui.getFullYear());
    }
    else
    {
        nodeParent.find("img").css('visibility','hidden');
        nodeParent.find(".date_habilitation").attr('disabled','').removeClass('date_simple');
        nodeParent.find(".date_habilitation").val('');
            
    }
}