<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>EXPEDITOR</title>
</head>
<body>

<div id="container">
    <h1></h1>
    <div id="logo">
    </div>

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
                <td><?php echo $e->get('id_utilisateur') ?></td>
                <td><?php echo $e->get('id_profil') ?></td>
                <td><?php echo $e->get('prenom') ?></td>
                <td><?php echo $e->get('nom') ?></td>
                <td><?php echo $e->get('login') ?></td>
                <td><a href="c_gestion_employe/btn_supprimer?id=<?php echo $e->get('id_utilisateur') ?>" id="btnDelete" 
                       class="btn btn-danger">Supprimer</a>
                <input type="button" id="btnUpdate" value="Modifier" class="btn btn-warning" onclick="btnUpdateEvent()"></td>
            </tr>
        <?php endforeach; ?>    
	
	</tbody>
</table>
    <input type="button" id="btnCancel" value="Annuler" style="display:none" class="btn btn-warning" onclick="btnUpdateEvent()">
    <input type="button" id="btnAdd" value="Ajouter" class="btn btn-success" onclick="btnAddEvent()"> 
    <!--<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>-->
</div>
    
    <script>
    
    function btnAddEvent()
    {      
        if(document.getElementById("btnUpdate").value==='Modifier'){
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
    
    
    
    
    function btnUpdateEvent()
    {      
        if(document.getElementById("btnUpdate").value==='Modifier'){
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
</body>
</html>