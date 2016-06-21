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

    <div id="Commande">
        <form method="post" action="">
            <div id="Client" class="panel-title bloc">
                <div class=""><label>Nom de la société :</label> 
                    Fictive S.A.
                    <?php // echo $user->get('nom_client'); ?>
                </div>
                <div class=""><label>Adresse :</label> 
                    <?php // echo $user->get('adresse'); ?>
                </div>
            </div>
            <div id="Articles">
                <table class="table-striped">
                    <thead class="">
                    <th>Articles</th><th>Quantité commandée</th><th>Quantité réelle</th>
                    </thead>
                    <tbody>
                        <?php // foreach($articles as $m_article){}; ?>
                        <tr>
                            <td>Disque Dur interne 2.5 pouces</td>
                            <td>5</td>
                            <td poids="150"><input type="text" name="qte_relle" class="commande_qte_relle" value="0" /></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <div class="input-group-addon">
        <input type="submit" value="Imprimer"/>
        <input type="submit" value="Valider"/>
    </div>
    <div class="input-group-addon">
        <label>Poids (en grammes)</label>
        <input type="text" readonly="readonly" class="readonly" value="0" id="commande_poids_total"/>
        
    </div>
    

    <!--<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>-->
</div>

</body>
</html>