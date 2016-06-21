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
                                <td poids="<?php echo $m_article->get('poids') ; ?>">
                                    <input type="text" name="qte_relle" class="commande_qte_relle" value="0" />
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <div class="input-group-addon">
        <input type="button" value="Imprimer" onClick="window.print()"/>
        <input type="submit" value="Valider"/>
    </div>
    <div class="input-group-addon">
        <label>Poids (en grammes)</label>
        <input type="text" readonly="readonly" class="readonly" value="300" id="commande_poids_total"/>
        
    </div>