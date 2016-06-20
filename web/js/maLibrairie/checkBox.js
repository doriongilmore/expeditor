function checkBoxAutomatiqueDuMemeGroupe(maCheckBox)
{
    var nomGroupe = '.' + maCheckBox.className;
    if(maCheckBox.checked)
        $(document).find(nomGroupe).each(function(index, uneCheckBox){
            uneCheckBox.checked = true;
        });
    else
        $(document).find(nomGroupe).each(function(index, uneCheckBox){
            uneCheckBox.checked = false;
        });
}