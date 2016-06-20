/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('ready', function(){
   show_hide_reservware_message();
    
    $('.parcourir.button').on('click', function(){
       res = SD.deleteServerFile($(this).attr('name'));
       if(res == 'true'){
           $(this).attr('name', '');
           $(this).hide();
           
           $(this).parent().children('.parcourir.text').val('');
           $(this).parent().children('.parcourir.text').hide();
           
           $(this).parent().children('.parcourir.lien').attr('href', '');
           $(this).parent().children('.parcourir.lien').hide();
           
           $(this).parent().children('input[type="file"]').val('');
           $(this).parent().children('input[type="file"]').show();
       }
       
   });
   
   $('#filtre_site').on('change', function(){
       var id = $('#filtre_site').val();
       resultatRequete = '<option value="0">Tous</option>' + SD.getCdtBySite(id);
       $('#filtre_cdt').empty().append(resultatRequete);
   });
   
   $('input[type=file]').on('change', function(){
       var nomImage = erase_complete_path($('#file_upload').val());
       $(this).hide();
       
       $(this).parent().children('.parcourir.text').val(nomImage);
       $(this).parent().children('.parcourir.text').show();
       
       $(this).parent().children('.parcourir.button').attr('name', nomImage);
       $(this).parent().children('.parcourir.button').show();
       
//       $(this).parent().children('.parcourir.lien').attr('href', 'web/files/temp/'+nomImage);
//       $(this).parent().children('.parcourir.lien').show();
   });
   
   $('#lst_domaines').on('change', function(){
       show_hide_reservware_message();
   });
   
   
   $(window).on('beforeunload', function(){
       var arr_uri = (location.href).split('/'); // sépare l'url grâce aux slashes
       var arr_id = arr_uri[arr_uri.length -1].split('.'); // sépare l'id_sd du .html
       var id = arr_id[0]; // récupère l'id
       if (is_int(id)) 
           SD.debloquerSD(id);
    });

});



function is_int(value){
  if((parseFloat(value) == parseInt(value)) && !isNaN(value))
      return true;
   else 
      return false;
}

function erase_complete_path(filename){
    var res = filename.split('\\');
    return res[res.length - 1];
}

function show_hide_reservware_message(){
        var id = $('#lst_domaines').val();
       var div_message = $('#message_reservware');
       if (id_reservware == id){
           div_message.show();
       }else{
           div_message.hide();
       }
}