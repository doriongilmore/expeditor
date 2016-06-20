$(document).ready(function()
{
  var TIMER_DURATION = 500; //milisecondes
  var AJAX_URL = 'http://'+window.location.host+'/eclat/ajax/autocomplete/';

  $('div.autocompletion').each(function()
  { /* Initialisations */
    var el = $(this);
    el.prevSearch = '';
    el.schInput   = el.children('input:first-child');
    
    if(el.children('input:last-child').attr('name'))
      el.hidInput = el.children('input:last-child');
    else
      el.hidInput = el.schInput;

    el.schSelect  = el.children('select');        
    
    /* Fonction contenant l'objet AJAX et ses paramètres */
    el.sendRequest = function (fieldName, reqVal)
    {
      if ($("input[name=ci_csrf_token]").val())
        csrfValue = $("input[name=ci_csrf_token]").val();
      else
        csrfValue = false;
      $.ajax(
      {
        url     : AJAX_URL+fieldName,
        type    : 'POST',
        data    : {'reqVal':reqVal, 'ci_csrf_token':csrfValue},
        beforeSend: function()
        {
          el.schInput.css('cursor', 'progress');
        },
        success: function(datas)
        {
          if(datas)
          { //Affichage du résultat de la requête
            el.schSelect.html(datas);
//            el.schSelect.css('visibility', 'visible');
            el.schSelect.show();
//            el.setSelectSize();
          }
          else
            el.schSelect.trigger('blur');

          el.schInput.css('cursor', 'text');
        }
      });
    }

    /* Gestion des events sur le champ de saisie */
    el.schInput.bind('keyup', function(event)
    {
      var inputVal = el.schInput.val();
      
      if(inputVal != '')
      { //On lance la requete si la recherche n'est pas nul ou si elle est différente de la précédente
        if(inputVal != el.prevSearch)
        { //Timeout pour temporiser le requetage et laisser le temps au user de taper.
          clearTimeout(el.myTimer);
          el.myTimer = window.setTimeout(function(){
            el.sendRequest(el.schInput.attr('name'), inputVal);
          }, TIMER_DURATION);
        }
//        else if(el.schSelect.css('visibility') == 'visible' && event.which == '40')
        else if(el.schSelect.css('display') != "none" && event.which == '40')
        { //Si le code de la touche est 'bas' alors on passe le focus à la liste de choix
          el.schSelect.focus();
          el.schSelect.children('option:first-child').attr('selected', 'selected');
        }
      }
      else
      {
        el.schSelect.trigger('blur');
        el.hidInput.val('');
      }
      el.prevSearch = inputVal;
    });

    /* Fonction assurant la gestion de la taille du champ select */
    el.setSelectSize = function()
    { //On ajuste la taille et la position du select à la taille du champ input
//      if ($.browser.msie)
//      {
//        el.schSelect.css('margin-top', el.schInput.height()+5+'px');
//        el.schSelect.css('margin-left', '-'+(el.schInput.width()+3)+'px');
//        el.schSelect.css('width', el.schInput.width()+4+'px');
//      }
//      else
//      {
        el.schSelect.css('margin-top', el.schInput.height()+3+'px');
        el.schSelect.css('margin-left', '-'+(el.schInput.width()+2)+'px');
        el.schSelect.css('width', el.schInput.width()+2+'px');
//      }
    }
    
    /* met à jour les champs schInput et hidInput en fonction de l'élément sélectionné dans la liste */
    el.validChoice = function()
    {
      el.schInput.val(el.schSelect.find(':selected').text());
      el.hidInput.val(el.schSelect.val());
      el.schSelect.trigger('blur');
//      while(el.schSelect.option[0] != undefined)
//          el.schSelect.remove(0);
      el.prevSearch = el.schInput.val();
    };
    
    /* Gestion des événements sur la liste de choix */
    el.schSelect.bind('dblclick', function(){el.validChoice()});
    el.schSelect.bind('keyup', function(event){if(event.which == '13')el.validChoice();});
//    el.schSelect.bind('blur', function(){el.schSelect.css('visibility', 'hidden');});
    el.schSelect.bind('blur', function(){el.schSelect.hide();});
  }); 
});
