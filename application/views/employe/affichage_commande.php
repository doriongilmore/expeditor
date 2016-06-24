    <?php if (!is_null($commande)) {?>
    <?php echo form_open('', array('method'=>'post', 'onSubmit'=>'return validation_commande();')) ; ?>
    

    <?php echo form_hidden('id_commande', $commande->get('id_commande'))  ; ?>
    <div id="Commande">
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
                                <?php echo form_hidden('id_ligne_commande[]', $m_ligne_commande->get('id_ligne_commande'))  ; ?>
                                <td><?php echo $m_article->get('nom') ; ?></td>
                                <td><?php echo $m_ligne_commande->get('quantite_demande') ; ?></td>
                                <td poids="<?php echo $m_article->get('poids') ; ?>">
                                    <input type="number" name="qte_reelle[]" 
                                           class="commande_qte_relle" value="<?php echo $m_ligne_commande->get('quantite_reelle') ; ?>" 
                                           min ="0" max ="<?php echo $m_ligne_commande->get('quantite_demande') ; ?>" />
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
    </div>
    <div class="input-group-addon">
        <input type="button" value="Imprimer" onClick="impression()"/>
        <!--<input type="button" value="Valider" onClick="impression()"/>-->
        <?php echo form_submit(array(), 'Valider', '') ; ?>
    </div>
    <div class="input-group-addon">
        <label>Poids (en grammes)</label>
        <input type="text" readonly="readonly" class="readonly" value="300" id="commande_poids_total"/>
        
    </div>
        <?php echo form_close() ; ?>
<?php } ?>