<?php
/**
 * Description of table_helper
 * date 19 05 2014
 */
/**
 * Génère un <table> HTML à partir d'un tableau de données et d'un tableau d'entete.
 * @param array $arr_donnees Tableau à deux dimensions
 * @param array $arr_titre Tableau d'objet qui determine le nom de la colonne la clé associé au données et si on doit 
 * pourvoir la trier ou pas
 * @param array $lien optionnel qui permet de générer une premiere colonne de liens :
 *  -> clef 0 = doit contenir la clef qui permet d'accèder à l'information du premier tableau
 *  -> clef 1 = doit contenir les variables GET pour pointer la bonne page
 * @param boolean $image_lien boolean pour savoir si le lien est sur la ligne ou avec une image 
 *  -> false = Sur la ligne du tableau  
 *  -> true = Avec une l'image par defaut donc nouvelle colonne par defaut en première position
 *  -> array :
 *          -> ['name_img'] = nom de l'image (exemple : "toto.png")
 *          -> ['emplacement_img'] = first OU last (positionnera a la dernière colonne ou à la première)
 *          -> ['title'] = donnera un title à l'image
 * Il gère les tableau d'objet et des objet dans les objet mais pas une troisieme couche cad : array[obj->obj2->obj3->var]
 * @return string
 */

function getHtmlTable($arr_donnees, $nom_param, $lien = null, $image_lien = null)
{
    // Si il n'y a aucune données à afficher on renvoie pas de tableau 
    if(count($arr_donnees) < 1)
        return false;
    $tab_params = enteteTable();
    $arr_titre = $tab_params[$nom_param];
    
    $str = '';
    $first = true;
    
    if(!is_null($image_lien) && (is_array($image_lien) && !isset($image_lien['emplacement_img']) && !isset($image_lien['name_img'])))
    {
        echo 'Erreur sur le quatrième paramètre passé';
        return false;
    }
    
    $str .= '
        <table class="w_skinnedTable">
            <thead>
                <tr>';
    
            if(!is_null($image_lien) && ((is_array($image_lien) && $image_lien['emplacement_img'] == 'first')||(is_bool($image_lien) && $image_lien)) && !is_null($lien))
            {
                $str .= '<th class="first" style="width:20px;"></th>';
                $first = false;
            }
            
            foreach($arr_titre as $un_titre)
            {
                $str .= '<th '.((!is_null($un_titre['width']))?'style="width : '.$un_titre['width'].'px"':'').' class="'.(($first)?'first':'').' '.(($un_titre['trie'])?'tri_thead':'').'">'.$un_titre['libelle'].'</th>';
                $first = false;
            }
            
            if(!is_null($image_lien) && is_array($image_lien) && $image_lien['emplacement_img'] == 'last' && !is_null($lien))
                $str .= '<th style="width:20px;"></th>';
        
     $str .= '   </tr>
            </thead>
            <tbody class="curseur" id="tbody_page">';
                
                    foreach ($arr_donnees as $une_donne) {
                        $tab_donnee = (array)$une_donne;
                        
                        foreach($lien as $key=>$valeur)
                            if($key != 0 && !isset($tab_donnee[$valeur]) && ENVIRONMENT == 'development')
                                return 'la clé : "'.$valeur.'" du lien est introuvable dans le tableau de données envoyé';
                            
                        $str .= '<tr ';
                        
                        if(isset($tab_donnee['color']) && !is_null($tab_donnee['color']))
                            $str .= 'class="tr_'.$tab_donnee['color'].'" ';
                        
                        if((is_bool($image_lien) && !$image_lien) && !is_null($lien))
                        {
                            $str .= 'onclick=\'location.href="'.  APPLICATION_URI .$lien[0];
                        
                            foreach($lien as $key=>$valeur)
                            {
                                if($key != 0)
                                    $str .= $tab_donnee[$valeur];
                                
                                if(end(array_keys($lien)) != $key)
                                    $str .= '/';
                                    
                            }

                            $str .= '"\'';
                        }
                        
                        $str .= '>';
                        
                        if(!is_null($image_lien) && ((is_array($image_lien) && $image_lien['emplacement_img'] == 'first')||(is_bool($image_lien) && $image_lien)) && !is_null($lien))
                        {
                            $str .= '<td class = "first">
                                        <a href="' . APPLICATION_URI . $lien[0];
                            
                            foreach($lien as $key=>$valeur)
                            {
                                if($key != 0)
                                    $str .= $tab_donnee[$valeur];
                                
                                if(end(array_keys($lien)) != $key)
                                    $str .= '/';
                            }
                                
                            $str .= '   ">
                                        <img src="'.base_url().'/web/img/' . (is_bool($image_lien)? 'header-search-btn.png' : $image_lien['name_img'] ) . '" class="myPngFix"';
                            if (isset($image_lien['title']) && is_string($image_lien['title']))
                            $str .= ' title = "' . $image_lien['title'] . '" ';
                            $str .= '/>
                                        </a>
                                    </td>';
                        }
                        
                        foreach($arr_titre as $num => $un_titre)
                        {
                            $cle = $un_titre['cle'];
                            
                            if(is_array($un_titre['cle']))
                            {
                                foreach($un_titre['cle'] as $uneCle)
                                {
                                    if(array_key_exists($uneCle, $tab_donnee))
                                    {
                                        $tab_donnee = $tab_donnee[$uneCle];
                                        if(is_object($tab_donnee))
                                            $tab_donnee = (array)$tab_donnee;
                                    }
                                    else
                                    {
                                        return 'la clé : "'.$uneCle.'" de la colones :"'.$un_titre['libelle'].'" est introuvable dans le tableau de données envoyé';
                                    }
                                }
                                $valeur_afficher = $tab_donnee;
                            }
                            else
                            {
                                if(!array_key_exists($un_titre['cle'], $tab_donnee) && ENVIRONMENT == 'development')
                                    return 'la clé : "'.$un_titre['cle'].'" de la colone :"'.$un_titre['libelle'].'" est introuvable dans le tableau de données envoyé';
                                else
                                    $valeur_afficher = $tab_donnee[$un_titre['cle']];
                            }
                            ($num == 0)?$firstClass = "first":$firstClass = "";
                            if(is_numeric($valeur_afficher))
                                if(isset($un_titre['nb_decimal']))
                                    $str .= '<td class="numeric '.$firstClass.'" >'.number_format($valeur_afficher, $un_titre['nb_decimal'], ',', ' ').'</td>';
                                else
                                    $str .= '<td class="numeric '.$firstClass.'">'.number_format($valeur_afficher, 0, ',', '').'</td>';
                            else
                                $str .= '<td class = "'.$firstClass.'">'.$valeur_afficher.'</td>';
                        }
                        
                        if(!is_null($image_lien) && is_array($image_lien) && $image_lien['emplacement_img'] == 'last' && !is_null($lien))
                        {
                            $str .= '<td>
                                        <a href="' . APPLICATION_URI . $lien[0];
                            
                            foreach($lien as $key=>$valeur)
                            {
                                if($key != 0)
                                    $str .= $tab_donnee[$valeur];
                                
                                if(end(array_keys($lien)) != $key)
                                    $str .= '/';
                            }
                                
                            $str .= '   ">
                                        <img src="'.base_url().'/web/img/' . $image_lien['name_img']  . '" class="myPngFix"';
                            if (isset($image_lien['title']) && is_string($image_lien['title']))
                            $str .= ' title = "' . $image_lien['title'] . '" ';
                            $str .= '/>
                                        </a>
                                    </td>';
                        }

                        $str .=    '</tr>';
                    }
    $str .=  '</tbody>
        </table>';

    return $str;
}


//'c_dossier/afficherUnDossier/'.$une_donne->ref_cloe            ********* '.  base_url() .$lien[1].$une_donne->$lien[0].'

/**
 * Génère un <table> HTML à partir d'un tableau de données.
 * @param array $arr Tableau à deux dimensions
 * @param array $lien optionnel qui permet de générer une premiere colonne de liens :
 *  -> clef 0 = doit contenir la clef qui permet d'accèder à l'information du premier tableau
 *  -> clef 1 = doit contenir les variables GET pour pointer la bonne page
 * @return string
 */
//
//function getHtmlTable($arr, $lien = array())
//{
//  $str = '<div class="table_container">
//            <table cellpadding="0" cellspacing="0" summary="">
//              <thead>
//                <tr class="ligneEnTete">';
//
//  $first = false;
//
//  if($lien)
//  {
//    $str .= '<th id="celHG" class="first" style="width:20px;"></th>';
//    $first = true;
//  }
//
//  foreach($arr[0] as $key => $val)
//  {
//    $first =  $first == false ? 'first' : true;
//    $str .= '<th scope="col" class="'.$first.' sorttable_nosort">'.$key.'</th>';
//  }
//
//  $str .= '</tr>';
//
//  $lgArr = count($arr);
//  for($i=0; $i<$lgArr; $i++)
//  {
//    $str .= '<tr id="classicTr">';
//
//    if($lien && $key = $lien[0])
//    {
//      $str .= '<td>
//                 <a href="'.$lien[1].$arr[$i][$lien[0]].'">
//                   <img src="./img/buttons/magnifier.gif" alt="" class="myPngFix" />
//                 </a>
//               </td>';
//    }
//
//    foreach($arr[$i] as $key => $val)
//      $str .= '<td>'.$val.'</td>';
//
//    $str .= '</tr>';
//  }
//
//  $str .= '</table></div>';
//
//  return $str;
//}