<div id="desc_situation" class="bloc light-blue-white container">

        <h2>Description Situations dangereuses</h2>
        <?php if (!is_null($sd) && $sd->get('supprimer') != 1) { 
            
            echo $desc_situation ; 
            
            
            
        } else {
              echo form_open('',array('method'=>'post'));
              echo '<div class="message_important">Cette situation dangereuse n\'a pas été trouvée.'.  br();
              echo form_submit(array("name"=>"annuler", "value"=>"Annuler"));
              echo '</div>';
              
               echo form_close();
          }    ?>
        
</div>
