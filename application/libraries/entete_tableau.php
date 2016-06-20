<?php

class entete_tableau
{
    /**
    * Méthode qui permet d'afficher une liste d'item avec un système de page.
    * Elle permet aux vue qu'ils l'appeleront l'affichage du tableau.
    *
    * @param string $nb_item Item à afficher par pages. par défaut 10.
    * @param string $tab_items Items à afficher dans le tableau.
    * @param string $nom_tbody est le nom du tbody du tableau dans lequelle on fait les pages.
    * @param string $tab bouton est les attribut ou autre du bouton qui colle en haut à droite le tableau mettre false si on ne veut pas de bouton.
    * @param string $nb_item_limite est la limite éventuelle du nombre de resultat dans la recherche par defaut elle est désactiver "false" on lui passe un int indiquand la limite fixer.
    */
   
   public function AfficherEntetePage($nb_item_total,$nb_item,$nom_tbody, $nb_item_limite = false, $tab_bouton = false)
   { 
        $reste = fmod($nb_item_total, $nb_item);
        $total_pages = intval($nb_item_total/$nb_item);
        if($reste == 0)
            $total_pages = $total_pages-1;
        
        if($total_pages > 10)
            $max_page = 9;
        else
            $max_page = false;

        // Si Aucun résultat on n'affiche pas les pages
            echo '<div class="entete_page bloc js-auto-height">
            
            <div style="text-align : left">';
            if($nb_item_limite)
                echo   '    <label style="color : red">Attention le nombre de résultats affichés est limités.</label>
                            <br>';
            echo   '    <label>'.(($nb_item_total >0)? $nb_item_total.' résultat'.(($nb_item_total > 1)?'s':'').', pages :':'Aucun résultat trouvé.').'</label>
                    </div>';
            
            echo '  <ul class="page" id="entete_page" style="width : 85%;float : left;">';
            if(!$max_page)
                for($i=0;$i <= $total_pages;$i++)
                    echo '  <li id="page_'.$i.'" onclick="changementPage('.$i.','.$nb_item.',\''.$nom_tbody.'\','.$total_pages.')" '.(($i == 0)?'class="current"':'').'>'.($i+1).'</li>';
            else
            {
                echo '  <li id="page_0" onclick="changementPage(0,'.$nb_item.',\''.$nom_tbody.'\','.$total_pages.')" class="current">1</li>';
                echo '  <li id="premier_nothing" style="display:none" class="nothing">...</li>';

                for($i=1;$i <= $max_page;$i++)
                    echo '  <li id="page_'.$i.'" onclick="changementPage('.$i.','.$nb_item.',\''.$nom_tbody.'\','.$total_pages.')">'.($i+1).'</li>';

                echo '  <li id="deuxieme_nothing"  class="nothing">...</li>';
                echo '  <li id="page_'.$total_pages.'" onclick="changementPage('.$total_pages.','.$nb_item.',\''.$nom_tbody.'\','.$total_pages.')">'.($total_pages+1).'</li>';
            }

            
            echo '  </ul>';
            
        if($tab_bouton != false)
        {
            echo '  <div style="float : left;margin: 16px 0 0 0;">
                        <input  type="submit" class="btn_large"';
            foreach ($tab_bouton as $key=>$val)
                echo $key.'="'.$val.'"';
            echo '/>
                    </div>';
        }
        
            echo '  </div>
                <script type="text/javascript">
                    onload = function(){
                                initNbPage('.$nb_item.');
                                initAffichagePage(\''.$nom_tbody.'\','.$nb_item.');
                            }
                </script>';

   }
}
?>