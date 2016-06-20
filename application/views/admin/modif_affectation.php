<div class="content"> 
    <?php echo form_open('affecter/'.$id_site,array('method'=>'post')); ?>
    <div  id="container_affectation" class="bloc light-green-white">
        <h2>Affectation d'un chargé de traitement au site de <?php echo $lib_site ; ?></h2>
            <div class="group">
                <?php
                    echo form_row_autocomplete_complex(array('hidden_name' => 'cdt', 'name' => '_cdt', 'label_value' => 'Utilisateur', 'id' => 'user', 'class' => 'text'), $idUser);
                    
                    
                    
//                    $array = array(
//                        array("name"=>"choix_user", "value"=>"Selectionner",'type'=>'button', 'class'=> 'button', 'id'=>'choix_user'),
//                        array("name"=>"retour_liste", "value"=>"Retour à la liste des sites",'type'=>'submit', 'class'=> 'button', 'id'=>'retour_liste'),
//                        ) ;
//                
//                    echo form_array_row_button($array);
                    
                    
                    echo '<div class="form_row">';
                    echo '<button id="choix_user" name="choix_user" class="button">Selectionner</button>';
                    echo form_input(array('id' => 'retour_liste', 'name' => 'retour_liste', 'type'=>'submit', 'value'=>'Retour à la liste des sites'));
                    echo '</div>';
                ?>
            </div>
    </div>
    
    
    <?php
        echo form_close();
    ?>
    
    
    <div id="container_affect_cdt">
    <?php
        echo getHtmlTable($arr_data, 'tab_affectation_site', array('/supprAffect/'.$id_site,'id'), array('name_img'=>'form_picto_remove.png', 'emplacement_img'=>'last', 'title'=>'Supprimer l\'affectation'));
//        echo getHtmlTable($arr_data, 'tab_affectation_site');
    ?>
    </div>
    
    
    
    
    
    
    
</div>