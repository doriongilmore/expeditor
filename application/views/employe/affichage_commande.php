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
            <div id="Client">
                <div class="row"><label>Nom de la société :</label> 
                    Fictive S.A.
                    <?php // echo $user->nom_client; ?>
                </div>
                <div class="row"><label>Adresse :</label> 
                        <?php // echo $user->adresse; ?>
                </div>
            </div>
            <div id="Articles">
                <table>
                    <thead>
                    <th><td>Articles</td><td>Quantité commandée</td><td>Quantité réelle</td></th>
                    </thead>
                    <tbody>
                        <?php // foreach($articles as $m_article){}; ?>
                        <tr>
                            <td>Disque Dur interne 2.5 pouces</td>
                            <td>5</td>
                            <td><input type="text" name="qte_relle" /></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>