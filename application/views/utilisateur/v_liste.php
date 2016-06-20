<div class="content">
    <?php
//        $this->load->view('utilisateur/v_filtre_situation');
    
    
    ?>
    <div class="" id="container_table">
        <?php
            if ($arr_data){
                if(isset($arr_data) && $arr_data)
                    $this->entete_tableau->AfficherEntetePage(count($arr_data), 20, 'tbody_page');
                echo getHtmlTable($arr_data, 'tab_situation', array($lien,'identifiant'), false);
                if (isset($legende))
                    echo $legende;
            }
            else{
                echo '<div class="bloc light-blue-white container"><h2>Liste de situations dangereuses</h2>';
                echo '<div class="message_important">'. $message .  br();
                echo '</div></div>';
            }
        ?>
    </div>
    
    
    
    
</div>