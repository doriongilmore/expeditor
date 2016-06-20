<div class="content"> 
    <?php
        echo form_open('habilitation',array('method'=>'post'));
    ?>
    <div  id="container_habilitation" class="bloc light-blue-white">
        <h2>Utilisateurs :</h2>
            <div class="group">
                <?php
                    echo form_row_autocomplete_complex(array('hidden_name' => 'user', 'name' => '_user', 'label_value' => 'Utilisateur', 'id' => 'user', 'class' => 'text'), $idUser);
                    
//                echo form_array_row_button(array(
//                    array('value'=>'Selectionner','type'=>'button','name'=>'choix_user', 'id'=>'choix_user', 'class'=> 'button')
//                ));
                ?>
                <div class="form_row">
                    <button id="choix_user" name="choix_user" class="button">Selectionner</button>
                </div>
            </div>
    </div>
<?php // echo var_dump($affHab); ?>
    <div id="container_habilitation" class="liste_profil bloc light-green-white <?php echo $affHab; ?>">
        <h2>Habilitations</h2>
        <div class="group">
            <div class="framed">
            <?php
                echo form_array_row_habilitation($tab_habilitation);
                echo form_array_row_button(array(
                    array('value'=>'Enregistrer','type'=>'submit','name'=>'enregistrer', 'id'=>'ajout_admin', 'class'=> 'button'),
                    array('value'=>'Annuler','type'=>'submit','name'=>'annuler', 'class'=> 'button')
                ));
            ?>
            </div>  
        </div>  
    </div>
    <?php
        echo form_close();
    ?>
</div>