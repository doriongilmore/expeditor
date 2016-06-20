<div class="content">
    
    <?php
        echo form_open('',array('method'=>'post'));
            $this->load->view('utilisateur/v_description_situation');
        echo form_close();
        if (!is_null($sd) && $sd->get('supprimer') != 1) {
//        if (!is_null($sd->get('com_prevention')) && $sd->get('com_prevention') != '' && !isset($traitement)) {
//    ?>
<!--    <div class="bloc light-orange-white" id="mess_prevention">
            <h2>Message prévention</h2><span>
        <?php //   echo $sd->get('com_prevention');    ?>
        </span></div>-->
        <?php
//        }
        
        
        
    ?>
    
    <div class="bloc light-blue-white">
        <h2>Traiter une situation dangereuse déclarée</h2>
        <div class="group" id="form_situation">
            <?php 
            echo form_open(APPLICATION_URI .'/'.$redirect.'/'.$id_sd,
                    array('method'=>'post', 'enctype'=>'multipart/form-data', 'id'=>'form_traitement' ));
            
            echo form_row_input(array('class' => 'text', 'label_value' => 'Etat actuel', 'id' => 'etat_situation', 'disabled'=>'true'), 
                    $sd->get('etat'));

            $enabled = ($sd->get('id_etat') == 3 || ($sd_is_blocked == true) )?'disabled':'enabled';
            
            
            echo form_row_textarea(array("id" => "description", "name" => "txt_desc_detecteur", "class" => "text ", $enabled=>'true',
                "label_value" => 'Commentaire visible'), ($sd->get('com_detecteur')));
            
                echo form_row_textarea(array("id" => "description", "name" => "txt_desc_prevention", "class" => "text ", $enabled=>'true',
                    "label_value" => "Message prévention"), ($sd->get('com_prevention')));

                echo form_row_textarea(array("id" => "description", "name" => "txt_desc_final", "class" => "text ", $enabled=>'true',
                    "label_value" => "Commentaire interne au traitement"), ($sd->get('com_traitement')));
                
                echo form_row_upload('Joindre un fichier pour mieux<br/>décrire le traitement',
                        array('name'=>'upload','class' => 'parcourir', 'id'=>'file_upload','filename' => $name));
                
                
                
            
                if ($sd_is_blocked != true) 
                    if (( $sd->get('id_etat') == 1) || ( $sd->get('id_etat') == 2))
                        echo '<div class="group">* Attention, la prise en compte/clôture enverra un mail au détecteur</div>';
            
                
                
                
                
                $array = array(array("name"=>"annuler", "value"=>"Retour à la liste",'type'=>'submit', 'class'=> 'button')) ;
                if ($sd_is_blocked != true) {
                    $array[] = array("name"=>"enregistrer", "value"=>"Enregistrer",'type'=>'submit', 'class'=> 'button');
                    
                    if ( $sd->get('id_etat') == 1)
                        $array[] = array("name"=>"suivant", "value"=>"Prendre en compte",'type'=>'submit', 'class'=> 'button');
                    else
                        $array[] = array("name"=>"suivant", "value"=>"Cloturer",'type'=>'submit', 'class'=> 'button');
                    
                    if ( $sd->get('id_etat') != 3)
                        $array[] = array("name"=>"supprimer", "value"=>"Supprimer",'type'=>'submit', 'class'=> 'button');
                }
                
                echo form_array_row_button($array);
                
                
                
                
                
                
                
                
//                echo form_submit(array("name"=>"annuler", "value"=>"Retour à la liste"));
//            
//    
//                if ($sd_is_blocked != true) 
////                if ( $sd->get('id_etat') != 3)
//                echo form_submit(array("name"=>"enregistrer", "value"=>"Enregistrer"));
//                
//                if ($sd_is_blocked != true) 
//                if ( $sd->get('id_etat') == 1) {
//                    echo form_submit(array("name"=>"suivant", "value"=>"Prendre en compte"));
//                }else if ( $sd->get('id_etat') == 2){
//                    echo form_submit(array("name"=>"suivant", "value"=>"Cloturer"));
//                } // else : ne pas afficher de bouton

//                if ($sd_is_blocked != true) 
//                if ( $sd->get('id_etat') != 3)
//                echo form_submit(array("name"=>"supprimer", "value"=>"Supprimer"));
                echo '<div class="invisible">';
                    echo form_row_input(array('name' => 'page'), 'visionner/8');
                echo '</div>';
            
            
            ?>
            <?php echo form_close(); ?>
            
        </div>
    </div>
    <?php } ?>
</div>