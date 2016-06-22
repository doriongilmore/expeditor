 <div id="Commande">
        <form method="post" action="">
            
            <div id="Commandes">
                <table class="table-striped">
                    <thead class="">
                    <th>N° Commandes</th><th>Statut</th><th>Employé</th><th></th><th></th>
                    </thead>
                    <tbody>
                        <?php foreach($commandes as $m_commandes){ 
                            $m_utilisateur = $m_commandes->get('utilisateur');
//                            var_dump($m_utilisateur);
                            ?>
                            <tr>
                                <td><?php echo $m_commandes->get('num_commande') ; ?></td>
                                <td><?php echo $m_commandes->get('etat') ; ?></td>
                                <td><?php echo (!is_null($m_utilisateur) )?$m_utilisateur->get('nom') . ' ' . $m_utilisateur->get('prenom') : " --- "; ?></td>
                                <!--<td><?php if(!is_null($m_utilisateur)  ){echo $m_utilisateur->get('nom') ;}else{echo " --- ";} ?></td>-->
                                <td><button id="btnConsulter" href class="btn btn-info consulter">Consulter</button></td>
                                <td><button id="btnLiberer" href class="btn btn-danger liberer">Libérer</button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            
            
            <div id="Statistique">
                <table class="table-striped">
                    <thead class="">
                    <th>Employé</th><th>Nombre de commande</th>
                    </thead>
                    <tbody>
                        <?php                    

                           foreach($statistique as $data){
                            ?>
                            <tr>
                                <td><?php echo $data['emp']->get('nom') ; ?></td>
                                <td><?php echo $data['nb'] ; ?></td>
                            </tr>
                           <?php } ?>
                    </tbody>
                </table>
            </div>
            
            
        </form>
    </div>