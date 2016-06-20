<?php

/*
 * fonction permettant d'afficher un graph Pie de base (sans données dynamiques)
 *  public function getStatsDomaine($annee){
        $liste_couleur = array( "#FE5815","#FFA02F","#C4D600","#509E2F","#005BBB","#001A70","#000000",
                                "#9900CC","#00CCFF","#006633","#663300","#FF3300","#0033FF","#CCCCCC");
        $this->load->model('table/m_bddomaine');
        $res =  $this->m_bddomaine->getAllDomaine();
        
        
        $array_libelles = array(); $cpt = 0 ;
        foreach ($res as $key=>$unDomaine) {
            $array_libelles[$cpt] = array(
                'title' => $unDomaine,
                'color' => $liste_couleur[$cpt],
                'value' => $cpt,
                'identifiant' => $key
            );
            $cpt++;
        }
        return $array_libelles;
    }
 */
function graph_pie($tab_info, $param, $tab_info_ie, $identifiant = "graph", $type = "Pie")
{
//    var_dump($tab_info);
    if ($tab_info == "[]")
        echo '<div class="container_graph">
                    <div class="graph">
                        Aucun graphique statistique ne peut être affiché. Vérifiez les informations renseignées.
                    </div>
              </div>';
    
    else{
        echo '
                <div class="container_graph">
                    <div class="graph">';
        if(isset($param['titre']))
        {
            echo        '<h1>'.$param['titre'].'</h1>';
            unset($param['titre']);
        }

        /*
        * Test pour plusieur graphique pour une légende Test Concluant mais projet laisser de coté pour l'instant décembre 2014
        */
    //    echo '<canvas 
    //                    id="graph_volume"';
    //    foreach($param as $nameParam => $valueParam)
    //        echo $nameParam .'="'.$valueParam.'"';
    //    echo '  >';
    //    //pour IE    ************************
    //    foreach($tab_info_ie as $info)
    //        echo '<span name="'.$info['lien'].'" class="libelle_stat_ie">'.$info['title'].': '.$info['value'].'</span><br>';
    //    // **********************************
    //
    //    echo '</canvas>';
        /*
        * FIN DU TEST
        */

        echo '<canvas class="graph_canvas" id="'.$identifiant.'"';
        foreach($param as $nameParam => $valueParam)
            echo $nameParam .'="'.$valueParam.'"';
        echo '  >';
        //pour IE    ************************
        foreach($tab_info_ie as $info)
            echo '<span name="'.$info['lien'].'" class="libelle_stat_ie">'.$info['title'].': '.$info['value'].'</span><br>';
        // **********************************

        echo '</canvas>
            <div id="'.$identifiant.'_legend" class="legend"></div>
        </div>
    </div>
    <script>
        insererGraph('. $tab_info .', "' . $param['lien'] . '","#' . $identifiant . '","' . $type . '");
    </script>   ';
    }
}

function graph_vertical_bar($tab_info, $param, $tab_info_ie, $identifiant = "graph"){
    if ($tab_info == "null" || count($tab_info_ie["labels"]) == 0 ) 
        echo '<div class="container_graph">
                    <div class="graph">
                        Aucun graphique statistique ne peut être affiché. Vérifiez les informations renseignées.
                    </div>
              </div>';
    
    else{
        echo '
                <div class="container_graph">
                    <div class="graph">';
        if(isset($param['titre']))
        {
            echo        '<h1>'.$param['titre'].'</h1>';
            unset($param['titre']);
        }

        echo '<canvas class="graph_canvas" id="'.$identifiant.'"';
        foreach($param as $nameParam => $valueParam)
            echo $nameParam .'="'.$valueParam.'"';
        echo '  >';
        //pour IE    ************************
        foreach($tab_info_ie['datasets'] as $dataset){
            $str = '<u>' . $dataset["title"].'</u><br>';
            foreach($dataset["data"] as $key => $value)
                $str .= '<span name="" class="libelle_stat_ie">'. $tab_info_ie['labels'][$key].' : '. $value .'</span><br>';
            echo $str;
        }
        // **********************************


        echo '</canvas>
            <div id="'. $identifiant .'_legend" class="legend"></div>
        </div>
    </div>
    <script>
        insererGraph('. $tab_info .', "' . $param['lien'] . '","#' . $identifiant . '", "Bar");
    </script>   ';
    }
}