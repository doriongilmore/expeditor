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
                    <th>Articles</th><th>Quantité commandée</th><th>Quantité réelle</th>
                    </thead>
                    <tbody>
                        <?php foreach($lignes as $m_ligne_commande){ 
                            $m_article = $m_ligne_commande->get('article');
                            ?>
                            <tr>
                                <td><?php echo $m_article->get('nom') ; ?></td>
                                <td><?php echo $m_ligne_commande->get('quantite_demande') ; ?></td>
                                 <td><?php echo $m_ligne_commande->get('quantite_reelle') ; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <div class="input-group-addon">
        <input type="submit" id="btnLiberer" value="Libérer" onClick="libere(<?php echo  $m_article->get('id_article') ;?>)"/>
    </div>
   
<script>
    function libere(id_commande){
       // appel de liberer(id) depuis fichier ajax
    }
</script>