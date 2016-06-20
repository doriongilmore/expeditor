<div id="filtre_situation" class="bloc light-blue-white container">

        <h2>Filtre Situations dangereuses</h2>
        <?php
    echo form_open('',array('method'=>'post'));
        echo '<div class="parti_gauche">';
            echo form_row_autocomplete_complex(array('hidden_name' => 'user', 'name' => '_user', 'label_value' => 'Détecteur', 'id' => 'user', 'class' => 'text'), $filtre['user']);
            echo form_row_select(array('name'=>'filtre_site', 'label_value'=>'Site concerné', 'id'=>'filtre_site'), $arr_sites, 'Tous', $filtre['filtre_site']);
            echo form_row_select(array('name'=>'filtre_etat', 'label_value'=>'Etat fiche'), $arr_etats, 'Tous', $filtre['filtre_etat']);
        echo '</div>';
        
        echo '<div class="parti_droite">';
            echo form_row_select(array('name'=>'filtre_domaine', 'label_value'=>'Domaine'),$arr_domaines, 'Tous', $filtre['filtre_domaine']);
            echo form_row_select(array('name'=>'filtre_cdt', 'label_value'=>'CdT', 'id'=>'filtre_cdt'), $arr_cdt, 'Tous', $filtre['filtre_cdt']);
            echo form_row_input(array('name' => 'filtre_mot_cle', 'label_value' => 'Mot-clé '), $filtre['filtre_mot_cle']);
            
        echo '</div>';
        
        $array = array(
                array('name'=>'filtrer','type'=>'submit','value'=>'Filtrer', 'class'=> 'button'),
                array('name'=>'reinitialiser','type'=>'submit','value'=>'Réinitialiser', 'class'=> 'button')
            ) ;

        echo form_array_row_button($array);
        
        
        
        
        
        
        
//        echo '<div class="clear form_row">';
//                echo form_input(array('name'=>'filtrer','type'=>'submit','value'=>'Filtrer'));
//                echo form_input(array('name'=>'reinitialiser','type'=>'submit','value'=>'Réinitialiser'));
//        echo '</div>';
        
    echo form_close();
    ?>
</div>
