<div class="content">
    
    <?php
    
    echo form_open('modifier/'.$id_sd,array('method'=>'post', 'enctype'=>'multipart/form-data'));
    if (!is_null($sd) && $sd->get('supprimer') != 1 && $sd->get('id_etat') == 1) {
    
    $blocked = (!$sd_is_blocked)?'enabled':'disabled';
    
//    if ( $sd->get('id_etat') == 1 && $sd->get('supprimer') != 1) {
        echo '<div class="bloc light-blue-white">';
            echo '<h2>Modification d\'une situation dangereuse</h2>';
            echo '<div class="group"  id="form_situation">';
                echo form_row_input(array("id" => "libelle", "name" => "txt_detecteur", "class" => "text ", "label_value" => "Détecteur", 'disabled'=>'true'), $sd->get('lib_detecteur'));

                echo form_row_select(array('name'=>'lst_sites', 'label_value'=>'Site concerné', $blocked => true), $arr_sites, 'Tous', $sd->get('id_site'));
                
                echo form_row_select(array('name'=>'lst_domaines', 'label_value'=>'Domaine', $blocked => true, 'id' => 'lst_domaines'), $arr_domaines, 'Choisir un domaine', $sd->get('id_domaine'));
                echo '<div id="message_reservware" class="form_row" style="display:none"><div class="label_field">&nbsp;</div><div class="field"><a href="http://planetcommercial-dcouest.edf.fr/reservware/index.php/c_voiture/probleme_technique" target="_blank">Merci de déclarer aussi un incident sur Reservware <- cliquer</a></div></div>';
                echo form_row_input(array("id" => "libelle", "name" => "txt_libelle", "class" => "text ", "label_value" => "Libellé de la situation dangereuse<br/>(50 caractères max)",'maxlength'=>'50', $blocked => true), $sd->get('libelle'));
                echo form_row_textarea(array("id" => "description", "name" => "txt_desc", "class" => "text ", 
                    "label_value" => "Décrire ici la situation<br/>dangereuse détectée", 
                    'placeholder' => 'Décrire le plus précisément possible : localisation, explications ...', $blocked => true
                    ), $sd->get('description') );

                echo form_row_upload('Vous pouvez joindre une photo<br/>pour mieux décrire la situation',
                        array('name'=>'upload','class' => 'parcourir', 'id'=>'file_upload',
                            'filename' => $name, $blocked => true, 'accept' => 'image/*'));
                
                $array = array(array("name"=>"annuler", "value"=>"Retour à la fiche",'type'=>'submit', 'class'=> 'button')) ;
                if ($sd_is_blocked != true) {
                    $array[] = array("name"=>"enregistrer", "value"=>"Enregistrer",'type'=>'submit', 'class'=> 'button');
                    $array[] = array("name"=>"supprimer", "value"=>"Supprimer",'type'=>'submit', 'class'=> 'button');
                }
                
                echo form_array_row_button($array);
                
//                echo '<div class="form_row">';
//                echo form_submit(array("name"=>"annuler", "value"=>"Retour à la fiche"));
//                if ($sd_is_blocked != true) {
//                    echo form_submit(array("name"=>"enregistrer", "value"=>"Enregistrer"));
//                    echo form_submit(array("name"=>"supprimer", "value"=>"Supprimer"));
//                }
//                echo '</div>';
                
            echo '</div>';
        echo '</div>';
//    }else{
//        $this->load->view('utilisateur/v_description_situation');
//    }
    
        
    ?>
    
<!--        <div class="bloc light-blue-white">
            <h2>Avancement du traitement</h2>
            <div class="group" id="form_situation">
                <?php 

                echo form_row_input(array('class' => 'text', 'label_value' => 'Etat actuel', 'id' => 'etat_situation', 'disabled'=>'true'), 
                        $sd->get('etat'));
                $disabled = (isset($traitement))?'enabled':'disabled';
                echo form_row_textarea(array("id" => "description", "name" => "txt_desc_detecteur", "class" => "text ", $disabled=>'true',
                    "label_value" => 'Commentaire'), $sd->get('com_detecteur'));


                    

                ?>

            </div>
        </div>-->
    <?php }else{ 
        ?>
<div class="bloc light-orange-white">
    <h2>Modification d\'une situation dangereuse</h2>
    <div class="message_important">
        Vous ne pouvez pas ou plus modifier cette situation dangereuse.<br/>
        <?php echo form_submit(array("name"=>"annuler", "value"=>"Annuler")); ?>
    </div>
</div>
                    
    <?php } ?>
                <?php echo form_close(); ?>
</div>