    <table class="table table-striped" id="articleTable">
	<caption>Liste des articles</caption>
	<thead>
	<tr >
		<th>N° Article</th>
		<th>Nom</th>
		<th>Quantité restante</th>
		<th>Poids (gramme)</th>
                <th>Prix (€)</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
       <?php foreach ($articles as $a): ?>
            <tr>
                <td class="idArticle col-md-1"><?php echo $a->get('id_article') ?></td>
                <td class="nom col-md-1"><?php echo $a->get('nom') ?></td>
                <td class="qte col-md-1"><?php echo $a->get('quantite_stock') ?></td>
                <td class="poids col-md-1"><?php echo $a->get('poids') ?></td>
                <td class="prix col-md-1"><?php echo $a->get('prix') ?></td>
                <td class="col-md-2"><a href="c_article/btn_supprimer?id=<?php echo $a->get('id_article') ?>" 
                                    id="btnDelete" class="btn btn-danger">Supprimer</a>
                <input type="button" id="btnUpdate" value="Modifier" class="btn btn-warning" 
                       onclick="btnModif(this, <?php echo $a->get('id_article') ?>)"></td>
                
            </tr>
            <input id="idStock" type="hidden" value=""/>
        <?php endforeach; ?>    
	
	</tbody>
</table>
<div>
    <input type="button" id="btnCancel" value="Annuler" style="display:none" 
           class="btn btn-warning" onclick="btnUpdateEvent()">
    <input type="button" id="btnAdd" value="Ajouter" 
           class="btn btn-success" onclick="btnAddEvent()"> 
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
            try {
                if(parseInt($('.qte').children('input').val()) > 0 ){
                    if(parseInt($('.poids').children('input').val()) > 0 ){
                        if(parseInt($('.prix').children('input').val()) > 0 ){
                            var url = URI + 'ajax/sauvegarderModificationArticle';
                            data = {

                            'id_article' : document.getElementById('idStock').value.toString(),    
                            'nom' : $('.nom').children('input').val(),
                            'qte' : $('.qte').children('input').val(),
                            'poids' : $('.poids').children('input').val(),
                            'prix' : $('.prix').children('input').val()}

                            requeteAjax(url, data);
                            location.reload();
                        }else{
                            alert('Le prix doit être supérieur à 0.');
                        }
                    }else{
                        alert('Le poids doit être supérieur à 0.');
                    }
                }else{
                    alert('La quantité doit être supérieure à 0.');
                }
            }
            catch(e){
                alert('Le prix, le poids et la quantité doivent être des entiers positifs.')
            }
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

        row.remove;

        row.children('.qte')

            .html('<input class="col-md-12" type="text" value="'+row.children('.qte').html()+'"/>');

        row.children('.qte')
            .attr('style', '');

        row.children('.poids')

            .html('<input class="col-md-12" type="text" value="'+row.children('.poids').html()+'"/>');

        row.children('.poids')
            .attr('style', '');

        row.children('.prix')

            .html('<input class="col-md-12" type="text" value="'+row.children('.prix').html()+'"/>');

        row.children('.prix')
            .attr('style', '');
        
    }
    
    function btnAddEvent()
    {      
        if(document.getElementById("btnAdd").value==='Ajouter'){
            $('#btnCancel').attr('style', '');
            document.getElementById("btnAdd").value='Valider'; 
        
            $('#articleTable > tbody:last-child')
            .append('<tr id="newRow">')
   
            .append('<td></td>') /* id artciel */
            .append('<td id="newNom"> <input class="form-control col-md-1" type="text" ></td>') /* nom */
            .append('<td id="newQte"><input class="form-control col-md-1" type="text" ></td>') /* qte */
            .append('<td id="newPoids"><input class="form-control col-md-1" type="text" ></td>') /* poids */
            .append('<td id="newPrix"><input class="form-control col-md-1" type="text" ></td>') /* prix */
                
            .append('</tr>');
        }
        else{
            try {
                if(parseInt($('#newQte').children('input').val()) > 0 ){
                    if(parseInt($('#newPoids').children('input').val()) > 0 ){
                        if(parseInt($('#newPrix').children('input').val()) > 0 ){
                            
                            document.getElementById("btnUpdate").value='Modifier';
                            document.getElementById("btnAdd").value='Ajouter'; 
                            
                            var url = URI + 'ajax/sauvegarderArticle';
                            
                            data = {
                                'id_article' : document.getElementById('idStock').value.toString(),    
                                'nom' : $('#newNom').children('input').val(),
                                'qte' : $('#newQte').children('input').val(),
                                'poids' : $('#newPoids').children('input').val(),
                                'prix' : $('#newPrix').children('input').val()
                            }
                            requeteAjax(url, data);
                            location.reload();
                        }else{
                            alert('Le prix doit être supérieur à 0.');
                        }
                    }else{
                        alert('Le poids doit être supérieur à 0.');
                    }
                }else{
                    alert('La quantité doit être supérieure à 0.');
                }
            }
            catch(e){
                alert('Le prix, le poids et la quantité doivent être des entiers positifs.')
            }
        }
   
    }
    
    
    function btnUpdateEvent()
    {      
        if(document.getElementById("btnAdd").value==='Ajouter'){
            document.getElementById("btnUpdate").value='Annuler';
            document.getElementById("btnAdd").value='Valider'; 
  
        }
        else{
            document.getElementById("btnUpdate").value='Modifier';
            document.getElementById("btnAdd").value='Ajouter'; 
            location.reload();
        }
   
    }

    </script>
