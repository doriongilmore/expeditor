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
                    <?php echo $client->get('nom') . ' ' .$client->get('prenom') ; ?>
                </div>
                <div class=""><label>Adresse :</label> 
                    <?php echo $client->get('adresse_1') . ' ' .$client->get('adresse_2') .br() ; ?>
                    <?php echo $client->get('code_postal') . ' ' .$client->get('ville') .br() ; ?>
                </div>
            </div>
            <div id="Articles">
                <table class="table-striped">
                    <thead class="">
                    <th>Articles</th><th>Quantité commandée</th>
                    </thead>
                    <tbody>
                        <?php // foreach($articles as $m_article){}; ?>
                        <tr>
                            <td>Disque Dur interne 2.5 pouces</td>
                            <td>5</td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <div class="input-group-addon">
        <input type="submit" value="Libérer"/>
    </div>
    

    <!--<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>-->
</div>

</body>
</html>