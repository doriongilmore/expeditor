<div class="content">
    <?php echo form_open('',array('method'=>'post', 'enctype'=>'multipart/form-data')); ?>
    <div class="bloc light-blue-white">
        <h2>Déclarer une situation dangereuse</h2>
        <div class="group" id="form_situation">
            <?php 
            
//            echo form_row_autocomplete_complex(array('hidden_name' => 'user','name' => '_user', 'label_value' => 'Demandeur', 'id' => 'utilisateur', 
//                    'onchange'=>    '$(\'#choix_user\').attr(\'disabled\',false);
//                                     $(\'#container_\').attr(\'style\',\'display:none;\');'), set_value());
            echo form_row_input(array("id" => "libelle", "name" => "txt_detecteur", "class" => "text ", "label_value" => "Détecteur", 'disabled'=>'true'), $user_lib);
            
            echo form_row_select(array('name'=>'lst_sites', 'label_value'=>'Site concerné'), $arr_sites, 'Tous', $id_site);
            
            
            
            echo form_row_select(array('name'=>'lst_domaines', 'label_value' => 'Domaine', 'id' => 'lst_domaines'), $arr_domaines, 'Choisir un domaine');
            echo '<div id="message_reservware" class="form_row" style="display:none"><div class="label_field">&nbsp;</div><div class="field"><a href="http://planetcommercial-dcouest.edf.fr/reservware/index.php/c_voiture/probleme_technique" target="_blank">Merci de déclarer aussi un incident sur Reservware <- cliquer</a></div></div>';
            
            echo form_row_input(array("id" => "libelle", "name" => "txt_libelle", "class" => "text ", "label_value" => "Libellé de la situation dangereuse<br/>(50 caractères max)",'maxlength'=>'50'));
            echo form_row_textarea(array("id" => "description", "name" => "txt_desc", "class" => "text ", 
                "label_value" => "Décrire ici la situation<br/>dangereuse détectée", 
                'placeholder' => 'Décrire le plus précisément possible : localisation, explications ...'
                ));
            echo form_row_upload('Vous pouvez joindre une photo<br/>pour mieux décrire la situation',
                    array('name'=>'upload','class' => 'parcourir', 'id'=>'file_upload'
                        , 'filename'=> $name, 'accept' => 'image/*'));
            
            
            echo form_array_row_button(array(
                array('value'=>'Valider','type'=>'submit','name'=>'creation_sd', 'class'=> 'button'),
                array('value'=>'Annuler','type'=>'submit','name'=>'annuler', 'class'=> 'button'),
            ));
            
            
            ?>
            
        </div>
    </div>
            <?php echo form_close(); ?>
</div>