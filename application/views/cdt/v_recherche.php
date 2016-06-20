<div class="content">
    
    <?php
        $this->load->view('cdt/v_filtre_situation');
    ?>
    
    <div class="" id="container_table">
        <?php
            if(isset($arr_data) && $arr_data)
                    $this->entete_tableau->AfficherEntetePage(count($arr_data), 20, 'tbody_page');
            echo getHtmlTable($arr_data, 'tab_situation', array($lien,'identifiant'), false);
        ?>
    </div>
</div>