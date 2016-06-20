<div class="content">
    
    <?php
//    echo form_open('', array('method'=>'post'));
    echo form_open('visionner/'.$id_sd,array('method'=>'post'));
    
        $this->load->view('utilisateur/v_description_situation');

        if (!is_null($sd) && $sd->get('supprimer') != 1) {
    

        if (!is_null($sd->get('com_prevention')) && $sd->get('com_prevention') != '' ) {
        ?>
                <div class="bloc light-orange-white" id="mess_prevention">
                    <h2>Message prévention</h2>
                    <p><?php   echo nl2br($sd->get('com_prevention')); ?></p>
                </div>
        <?php } ?>
    
        <div class="bloc light-blue-white">
            <h2>Avancement du traitement</h2>
            <div class="group" id="form_situation">
                <?php 
                echo '<h3>Situation dangereuse '. $sd->get('etat') .'</h3>';
//                echo form_row_input(array('class' => 'text', 'label_value' => 'Etat actuel', 'id' => 'etat_situation', 'disabled'=>'true'), $sd->get('etat'));
                
                $disabled = (isset($traitement))?'enabled':'disabled';
                
                if (!is_null($sd->get('com_detecteur')) && $sd->get('com_detecteur') != '')
                    echo '<h3>Commentaire du chargé de traitement :</h3><p class="">'.nl2br($sd->get('com_detecteur')).'</p><br/>' ;
//                echo form_row_textarea(array("id" => "description", "name" => "txt_desc_detecteur", "class" => "text ", $disabled=>'true', "label_value" => 'Commentaire'), $sd->get('com_detecteur'));

            if ($traitement === true)
                if (!is_null($sd->get('com_traitement')) && $sd->get('com_traitement') != '')
                    echo '<h3>Commentaire interne au traitement :</h3><p class="">'.nl2br($sd->get('com_traitement')).'</p><br/>' ;
                
        $img_path_download = '<img src="'.APPLICATION_URI . '/web/img/picto_pagination_bas.png"/>';
        $bool_cdt = ($sd->get('piecejointe_cdt') != '');
        $path_img_cdt = ($bool_cdt)?APPLICATION_URI . '/web/files/img_situation_n_'. $sd->get('identifiant') .'_cdt_'. $sd->get('piecejointe_cdt'):'' ;
        if ($bool_cdt) {
//            $desc .= '<div class="form_row">';
//            $desc .= '<div class="label_field">';
//            $desc .= '<label>Télécharger</label>';
//                
//            $desc .= '</div>';
//            $desc .= '<div class="field">';
            $desc .= '<a href="'.$path_img_cdt.'" download>Télécharger la pièce jointe</a>';
//            $desc .= '</div>';
            
//            $desc .= '</div>';
//            $desc .= '<div><a href="'.$path_img_cdt.'" target="_blank"><button>Télécharger la pièce jointe</button></a></div>';
            echo $desc;
        } 
        
        
        $array = array(array('value'=>'Retour à la liste','type'=>'submit','name'=>'annuler', 'class'=> 'button'));
        if ( $canModify )
            $array[] = array("name"=>"modifier", "value"=>"Modifier",'type'=>'submit', 'class'=> 'button');
        
        echo form_array_row_button($array);
        
//                array('value'=>'Valider','type'=>'submit','name'=>'creation_sd', 'class'=> 'button');
        
//                echo form_submit(array("name"=>"annuler", "value"=>"Retour à la liste"));

//                    echo form_submit();
                

                ?>
                <?php echo form_close(); ?>

            </div>
        </div>
    <?php } ?>
</div>