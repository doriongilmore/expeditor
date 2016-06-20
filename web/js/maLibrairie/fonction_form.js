function ChangementValeurSelect(tableauValeur, oldIdSelect)
{
    var idSelect = '#'+oldIdSelect;
    
    if(tableauValeur == undefined || idSelect == undefined)
    {
        alert('Les paramètres passer pour modifier le select sont indefinie');
        return false;
    }
    
    videSelect($(idSelect));
    
    for(var key in tableauValeur)
        $(idSelect).append($('<option>', { value: key, text: tableauValeur[key] }))
}
function videSelect(select)
{
    var childs = $(select).children();
    
    childs.each(function(){
        $(this).remove();
    });
}
