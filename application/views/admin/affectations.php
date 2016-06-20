<div class="content"> 
<!--    <div class="bloc light-green-white">
        <h2>Affectations</h2>-->
        
        <?php
//        echo getHtmlTable($arr_data, 'tab_affectation');
        echo getHtmlTable($arr_data, 'tab_affectation', array($lien,'identifiant'), array('name_img'=>'form_picto_add.png', 'emplacement_img'=>'last', 'title'=>'Affecter un Cdt au site'));
        ?>
        
        
<!--    </div>-->
    
</div>