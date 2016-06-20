var tab_heure = new Array;

var _event; //contient le dernier caractère saisie
function affKeyCode(event){_event = event;} //récup de la derniere touche 

$(function(){
    $("body").attr("onkeyup", "affKeyCode(event.keyCode);");
});


$(function(){
    //appel du calendar
    var parentNode = $(".date, .date_simple").datepicker({
                                dateFormat: "dd-mm-yy",
                                firstDay: 1,
                                showOn: "button",
                                buttonImageOnly: true,
                                buttonImage: "web/img/cal.gif"
                            }).parent(); 
    if($(parentNode).find('.hasDatepicker').attr('disabled') == 'disabled')
        $(parentNode).find('img').css('visibility','hidden');
});

// gestion injection date
$(function(){
    $(".date").on('blur',function(i){
        reformateDonneDate( $(this) );
    });
});

//appel de l'input "heure"
$(function(){
    $(".heure").each(function(i)
    {
        var input = document.createElement("input");
        
        //on check si les champ date sont utilisable et on desactive les champs heures 
        // si les champ date sont pas actifs
        if($(".date:eq("+ i +")").attr("disabled") != undefined)
            input.setAttribute("disabled", "disable");

        input.setAttribute("class", "heure");
        input.setAttribute("name", $(".date:eq("+ i +")").attr("name") +"_heure");
        input.setAttribute("id", $(".date:eq("+ i +")").attr("name") +"_heure");
        input.setAttribute("onkeyup", "formaterHeure(this);");
        input.setAttribute("onclick", "heure_onclick(this);");
        input.setAttribute("onblur", "heure_onblur(this);");
        input.setAttribute("onload", "heure_onblur(this);");
        input.setAttribute("MAXLENGTH", "5");
        if(typeof(tab_heure[$(".date:eq("+ i +")").attr("name") +"_heure"]) != "undefined" && tab_heure[$(".date:eq("+ i +")").attr("name") +"_heure"] != "")
            input.setAttribute("value", tab_heure[$(".date:eq("+ i +")").attr("name") +"_heure"]);
        else
            input.setAttribute("value", "__:__");
        $(".date:eq("+ i +")").parent().append(input);  // ":eq(i)" prend l'élément d'index i obtenu depuis le each(function(i)
        
        
        return true;
    });
});

//gestion du disabled sur l'image :
//la difficulté est que l'image est construite à la volé
//donc parcours des éléments .date et si ils sont désactivé img = caché
$(function(){
    $(".date").each( function (i){
        if($(".date:eq("+ i +")").attr("disabled") == "disabled")
            $(".date:eq("+ i +")").siblings('img').each( function (){ // parcours des elements freres : siblings()
                $(this)[0].style.display = "none";
            });
    });
});

/// gestion valeur par défaut 
$(function(){
    $(".now").each(function(i){
        var d = new Date(new Date().getTime());
        var time = d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes();
        $(this).attr('value', time);
//        alert(time);
        reformateDonneDate( $(this) );
    });
});

//formatage des éléments heures ***************
function formaterHeure(input)
{   
    var chaine = input.value.replace(':', '');
    if( ! isNaN( chaine))
    {
        if(input.value.length == 2 && _event != 8)
            input.value = input.value +":";
        verif_valeur(input);
    }
    else
    {
        input.value = input.value.substr(0, input.value.length - 1);
    }
}

function verif_valeur(input)
{
    if(input.value != "__:__")
    {
        var elem;
        if(input.value.length == 5){
            elem = input.value.split(':',2);
            
            if(  isNaN( elem[0]) || isNaN( elem[1]) )
            {
                elem[0] = input.value.substr(0, 2);
                elem[1] = input.value.substr(3,2);
            }
            
            if(elem[0] > 23)elem[0] = 23;
            if(elem[0] < 0)elem[0] = 0;
            if(elem[1] > 59)elem[1] = 59;
            if(elem[1] < 0)elem[1] = 0;
            
            input.value = elem[0]+':'+elem[1];
        }
    }
}

function heure_onblur(input)
{
    if(input.value == "")
        input.value = "__:__";
    verif_valeur(input);
}

function heure_onclick(input)
{
    if(input.value == "__:__")
        input.value = "";
    verif_valeur(input);
}

// c'est pour reformater la date de dd/mm/yy hh:ii
function reformateDonneDate(elem)
{
    var date = $.trim(elem.val());
    var reg_date_heure= new RegExp("^[0-9]{1,2}[/-]{1}[0-9]{1,2}[/-]{1}[0-9]{2,4}[ ]{1}[0-9]{1,2}[:]{1}[0-9]{1,2}","g");
    var reg_date=       new RegExp("^[0-9]{1,2}[/-]{1}[0-9]{1,2}[/-]{1}[0-9]{2,4}","g");
    
    var separateur = "";
    var sep_trouve = false;
    for(var i=0; i<date.length ; i++)
    {
        if(isNaN(date[i]) && sep_trouve === false)
        {
            separateur = date[i];
            sep_trouve = true;
        }
    }
    
    if(reg_date_heure.test( date ))
    {
        //date
        var tab_date = date.split(' ')[0];
        var jour = tab_date.split(separateur)[0];
        if(jour.length == 1)
            jour = "0" + jour;
        var mois = tab_date.split(separateur)[1];
        if(mois.length == 1)
            mois = "0" + mois;
        var annee = tab_date.split(separateur)[2];  
        if(annee.length == 2)
            annee = "20" + annee;
        //heure
        var tab_heure = date.split(' ')[1];
        var heure = tab_heure.split(':')[0];
        if(heure.length == 1)
            heure = 0 + heure;
        var minute = tab_heure.split(':')[1];
        if(minute.length == 1)
            minute = 0 + minute;

        elem.val(jour+'-'+mois+'-'+annee);
        $("#"+elem.attr("name")+"_heure").val(heure+":"+minute);
    }
    else if( reg_date.test( date ))
    {
        //date
        var tab_date = date.split(' ')[0];
        var jour = tab_date.split(separateur)[0];
        if(jour.length == 1)
            jour = "0" + jour;
        var mois = tab_date.split(separateur)[1];
        if(mois.length == 1)
            mois = "0" + mois;
        var annee = tab_date.split(separateur)[2];  
        if(annee.length == 2)
            annee = "20" + annee;
        
        elem.val(jour+'-'+mois+'-'+annee);        
    }
    else if( ! reg_date_heure.test( date ) &&  ! reg_date.test( date )){
        elem.val("");
    }
}

//fin formatage des éléments heures ***************
