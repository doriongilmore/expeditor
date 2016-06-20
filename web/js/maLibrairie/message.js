$(document).ready(function(){
    if(checkMessage())
        setTimeout(function(){disparitionMessage()}, 8000);
});

function checkMessage()
{
    if(($('.valid').size() > 0 && $('.valid').css('display') == 'block') || 
       ($('.error').size() > 0 && $('.error').css('display') == 'block') || 
       ($('.info').size() > 0 && $('.info').css('display') == 'block'))
        return true;
    else
        return false;
}


/*
 * Fonction permetant la disparition d'un éventuelle message
 */
function disparitionMessage()
{
    if(checkMessage())
    {
        var monMessage = null;

        if($('.valid').size() > 0)
            monMessage = $('.valid')[0];
        if($('.error').size() > 0)
            monMessage = $('.error')[0];
        if($('.info').size() > 0){
            return false;
            monMessage = $('.info')[0];
        }

        $(monMessage).hide('blind',1000);
    }
}

/*
 * Gestion message obligatoire
 */
var Testable = true;
function affichageMessageObligatoire(bool)
{
    if(bool)
    {
        if($('.obligatory').css('display') == 'none')
        {
            Testable = true;
            $('.obligatory').show('blind',1000);
        }
    }
    else
    {
        if($('.obligatory').css('display') != 'none' && Testable)
        {
            Testable = false;
            $('.obligatory').hide('blind',1000);
        }
    }
}

function changerMessageObligatoire(message)
{
    $('.obligatory > label').text(message);
}



/*
 * Gestion message d'erreur
 */
var Tmp = true;
function affichageMessageErreurJS(bool)
{
    if(bool)
    {
        if($('.erreur_js').css('display') == 'none')
        {
            Tmp = true;
            $('.erreur_js').show('blind',1000);
        }
    }
    else
    {
        if($('.erreur_js').css('display') != 'none' && Testable)
        {
            Tmp = false;
            $('.erreur_js').hide('blind',1000);
        }
    }
}