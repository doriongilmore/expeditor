
    <table class="table table-striped" id="employeTable">
	<caption>Liste des employés</caption>
	<thead>
	<tr>
		<th>N°Employé</th>
		<th>Type</th>
		<th>Prénom</th>
		<th>Nom</th>
                <th>Login</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
       <?php foreach ($employes as $e): ?>
            <tr>
                <td class="id_utilisateur"><?php echo $e->get('id_utilisateur') ?>
        <input class="id_utilisateur_hidden" type="hidden" value="<?php echo $e->get('id_utilisateur') ?>"/></td>
                <td class="id_profil">
                    
                    <?php 
                    
                 
                    if($e->get('id_profil')==1){
                        echo "Employé";
                    }else{
                        echo "Manager";
                    }
                            
                            ?>
                
                
                
                </td>
                <td class="prenom"><?php echo $e->get('prenom') ?></td>
                <td class="nom"><?php echo $e->get('nom') ?></td>
                <td class="login"><?php echo $e->get('login') ?></td>
                <td><a href="c_gestion_employe/btn_supprimer?id=<?php echo $e->get('id_utilisateur') ?>" id="btnDelete" 
                       class="btn btn-danger">Supprimer</a>
                <input type="button" id="btnUpdate" value="Modifier" class="btn btn-warning" onclick="btnModif(this, <?php echo $e->get('id_utilisateur') ?>)"></td>
            </tr>
             <input id="idStock" type="hidden" value=""/>
        <?php endforeach; ?>    
	
	</tbody>
</table>
    <input type="button" id="btnCancel" value="Annuler" style="display:none" class="btn btn-warning" onclick="btnUpdateEvent()">
    <input type="button" id="btnAdd" value="Ajouter" class="btn btn-success" onclick="btnAddEvent()"> 
    <!--<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>-->
</div>
    
    <script>
   
        function btnModif(btn_modif, id)
    {
      
        if(id != undefined){
            document.getElementById('idStock').value=id;
        }
        
        $('#btnAdd').attr('onclick', '');
        $('#btnAdd').attr('onclick', 'btnModif()');
        
        if(document.getElementById('btnAdd').value==='Valider')
        {      
       
            var url = URI + 'ajax/sauvegarderModificationEmploye';
            data = {
                
            'id_utilisateur' : document.getElementById('idStock').value.toString(),    
            'profil' : $('.id_profil').children('input').val(),
            'prenom' : $('.prenom').children('input').val(),
            'nom' : $('.nom').children('input').val()}

            requeteAjax(url, data);
            location.reload();
        }
        
        document.getElementById("btnCancel").value='Annuler';
        document.getElementById("btnAdd").value='Valider';  
        
        
        $('input').each(function(){
            if($(this).val() == "Modifier"){
                $(this).attr('disabled', '');
            }
        });
        $('#btnCancel').attr('style', '');
        
        var row = $(btn_modif).parent().parent();

        if($.trim(row.children('.id_profil').html()) == 'Manager'){
               row.children('.id_profil')
                .html('<select class="form-control col-md-1">\n\
                <option value="1">Employé</option>\n\
                <option selected="selected" value="2">Manager</option>\n\
                </select>')
        }else{
             row.children('.id_profil')
                .html('<select class="form-control col-md-1">\n\
                <option selected="selected" value="1">Employé</option>\n\
                <option value="2">Manager</option>\n\
                </select>')
        }
                
        row.children('.id_profil').attr('style', '');
        
        row.children('.prenom')
                .html('<input type="text" value="'+row.children('.prenom').html()+'"/>');
        row.children('.prenom').attr('style', '');
        
        row.children('.nom')
                .html('<input type="text" value="'+row.children('.nom').html()+'"/>');
        row.children('.nom').attr('style', '');
    }
    
    
    function btnAddEvent()
    {      
        if(document.getElementById("btnAdd").value==='Ajouter'){
//            document.getElementById("btnCancel").style='display:';
            $('#btnCancel').attr('style', '');
            document.getElementById("btnAdd").value='Valider'; 
        
            $('#employeTable > tbody:last-child')
            .append('<tr i="newRow">')
   
            .append('<td></td>') /* id utilisateur */
            .append('<td id="newType"> <select class="form-control col-md-1"><option value="1">Employé</option><option value="2">Manager</option></select></td>') /* idprofil */
            .append('<td id="newPrenom"><input class="form-control col-md-1" type="text" ></td>') /* prenom */
            .append('<td id="newNom"><input class="form-control col-md-1" type="text" ></td>') /* nom */
            .append('<td id="newLogin"><input class="form-control col-md-1" type="text" ></td>') /* login */
                
            .append('</tr>');
        }
        else{
            document.getElementById("btnUpdate").value='Modifier';
            document.getElementById("btnAdd").value='Ajouter'; 
            

            
    var url = URI + 'ajax/sauvegarderEmploye';
            data = {
            'type' : $('#newType').children('select').val(),
            'prenom' : $('#newPrenom').children('input').val(),
            'nom' : $('#newNom').children('input').val(),
            'login' : $('#newLogin').children('input').val(),
            'password' : 'password'};

        
        requeteAjax(url, data);
        
        location.reload();
            

        }
   
    }
    
    
    
    
    function btnUpdateEvent(btn_modif)
    {            
        if(document.getElementById("btnAdd").value==='Ajouter'){
            document.getElementById("btnCancel").value='Annuler';
            document.getElementById("btnAdd").value='Valider'; 
  
        }
        else{
            document.getElementById("btnUpdate").value='Modifier';
            document.getElementById("btnAdd").value='Ajouter'; 
            location.reload();
        }
    }
   
    
    </script>
