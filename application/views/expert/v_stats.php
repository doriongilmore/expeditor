<div class="content">
    <div class="bloc light-blue-white" id="statsAnnees">
        <h2>Choisir une année</h2>
        <div class="group" id="choix_campagne">
            <?php
            echo form_open('', array('id'=>'form_annee_stat'));
                echo '<h3>Choisissez l\'année pour laquelle vous souhaitez voir les statistiques.</h3>';
                echo form_row_select(array('name' => 'lst_annee', 'label_value' => 'Année : '), $listeAnnees, false, $annee);
                echo form_input(array('type'=>'submit','name'=>'generer', 'value'=>'Afficher'));
                ?>
            <div class="group">
                Nombre de situations dangereuses détectées durant l'année <u><?php echo $annee ;?></u> (tous sites confondus) : <b><?php echo $nbTotal ;?></b>
            </div>
            <?php
            echo form_close();
            ?>
        </div>
    </div>
    <div class="bloc light-green-white" id="v_statistiques">
        <h2>Statistiques</h2>
        <div id = "statsDomaines" class="">
                <?php
                    graph_pie($graph['sdByDomaine']['info'], $graph['sdByDomaine']['param'], $graph['sdByDomaine']['info_ie'], 'graph_domaine');
                ?>
        </div> 
        <div id = "statsSites" class="">
                <?php
                    graph_vertical_bar($graph['sdBySite']['info'], $graph['sdBySite']['param'], $graph['sdBySite']['info_ie'], 'graph_site');
                ?>
        </div> 
    </div>
</div>
