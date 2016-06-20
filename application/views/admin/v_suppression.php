<div class="content">
    <?php
    echo form_open('');
        echo 
        "<div id='container_suppression_affectation' class='bloc light-orange-white'>
            <h2>Suppression d'une affectation</h2>
            <div class='message_important'>
                Êtes-vous sûr de vouloir supprimer cette affectation ?
            <br/>".
        form_input(array('name'=>'supprFinale','type'=>'submit','value'=>'Supprimer l\'affectation', 'id' => 'suppression_sd')).
        form_input(array('name'=>'supprCanceled','type'=>'submit','value'=>'Annuler la suppression', 'id' => 'annuler_suppression')).
            "</div>
        </div>";
        echo form_close();
    ?>
</div>
