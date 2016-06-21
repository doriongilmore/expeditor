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

    <table class="table table-striped">
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
                <td><?php echo $a->get('id_article') ?></td>
                <td><?php echo $a->get('nom') ?></td>
                <td><?php echo $a->get('quantite_stock') ?></td>
                <td><?php echo $a->get('poids') ?></td>
                <td><?php echo $a->get('prix') ?></td>
                <td><a id="btnDeleteXXX" href class="btn btn-danger">Supprimer</a></td>
            </tr>
        <?php endforeach; ?>    
	
	</tbody>
</table>
    <a href id="btnUpdate" value="Supprimer" class="btn btn-warning">Modifier</a>
    <a href id="btnAdd" value="Supprimer" class="btn btn-success">Ajouter</a>   

    <!--<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>-->
</div>

</body>
</html>