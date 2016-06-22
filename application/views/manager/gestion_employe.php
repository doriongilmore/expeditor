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
                <td><a href="c_gestion_employe/btn_supprimer?id=<?php echo $e->get('id_utilisateur') ?>" id="btnDeleteXXX" 
                       class="btn btn-danger">Supprimer</a></td>
            </tr>
        <?php endforeach; ?>    
	
	</tbody>
</table>
    <a href id="btnUpdate" value="Supprimer" class="btn btn-warning">Modifier</a>
    <a href id="btnAdd" value="Supprimer" class="btn btn-success">Ajouter</a>   

    <input type="button" value="test" onclick="addRow()" >
    <!--<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>-->
</div>

    <script>
    
    function addRow()
    {
       
        
        $('#employeTable > tbody:last-child').append('<tr><td>ddd</td><td>ddddd</td><td>dddd</td><td>dddd</td><td>ddddd</td></tr>');
    }
    
    </script>
</body>
</html>