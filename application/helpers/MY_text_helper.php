<?php
  /**
   * Description of MY_text_helper
   * date 13 juil. 2011
   */

function cStr($datas)
{
  if (is_array($datas))
    $datas = array_map('cStr', $datas);
  elseif (is_object($datas))
  {
    $arr = get_object_vars($datas);

    foreach ($arr as $key => $val)
      $datas->$key = cStr($val);
  }
  else
    $datas = htmlspecialchars($datas);//, ENT_QUOTES, 'UTF-8');

  return $datas;
}



function cTel($tel, $generateLien = true)
{
  $t = cStr(wordwrap($tel, 2, ' ', true));
    if ($generateLien)
        return '<a href = "tel:'.$tel.'">'.$t.'</a>';
    return $t;
}



function removeSpaces($str)
{
  return str_replace(' ', '', $str);
}



function removeNR($str)
{
  return str_replace(array("\r\n", "\n", "\r"), '', $str);
}



function parseBBCode($str = '', $max_images = 0)
{
  // Max image size eh? Better shrink that pic!
  if($max_images > 0)
     $str_max = "style=\"max-width:".$max_images."px; width: [removed]this.width > ".$max_images." ? ".$max_images.": true);\"";

  $find = array(
//    "'\[b\](.*?)\[/b\]'is",
//    "'\[i\](.*?)\[/i\]'is",
//    "'\[u\](.*?)\[/u\]'is",
//    "'\[s\](.*?)\[/s\]'is",
//    "'\[img\](.*?)\[/img\]'i",
    "'\[url\](http://.*?)\[/url\]'i",
    "'\[url\](https://.*?)\[/url\]'i",
    "'\[url\](.*?)\[/url\]'i",
    "'\n'i",
//    "'\[url=(.*?)\](.*?)\[/url\]'i",
//    "'\[link\](.*?)\[/link\]'i",
//    "'\[link=(.*?)\](.*?)\[/link\]'i",
  );

  $replace = array(
//    '<strong>\\1</strong>',
//    '<em>\\1</em>',
//    '<u>\\1</u>',
//    '<s>\\1</s>',
//    '<img src="\\1" alt="" />',
    '<a href="\\1">\\1</a>',
    '<a href="\\1">\\1</a>',
    '<a href="http://\\1">\\1</a>',
    '<br/>',
//    '<a href="\\1">\\2</a>',
//    '<a href="\\1">\\1</a>',
//    '<a href="\\1">\\2</a>',
  );

  return preg_replace($find, $replace, $str);
}

//renvois un tableau d'index des occurences
function stripos_all($haystack, $needle, $offset=0)
{
    $retour = null;
    $pos = 0;
    
    for($i = 0; $i <= strlen($haystack); $i ++ ) // on parcours le fichier de needle en needle  
    {
        $pos = stripos($haystack, $needle, $offset);
        if($pos !== false) //on recherche le prochain needle 
        {
            $offset = $pos + strlen($needle); //on place l'offset apres le needle 
            $retour[] = $pos; //sauvegarde de la position de l'élément trouvé
            $i = $pos+ strlen($needle);
        }
        else
            $i = strlen($haystack); // sinon on se place à la fin du haystack pour sortir de la boucle
    }
    
    return $retour;
}

//
function preg_match_all_index($reg, $array)
{
    $tab_index = array();
    foreach ($array as $key => $value)
        if(preg_match($reg, $value))
            $tab_index[] = $key;
        
    return $tab_index;    
}

function libelle_prestation_affectation($unePrestation)
{
    return 'CSIT ' . (($unePrestation->affecte)?'affecté (le '.$unePrestation->getEtapeByType(Etape_Affectation)->date_reelle->libelle_date.') :':'proposé :') ;
}

function libelle_prestation_titre_etape($unePrestation)
{
    $label_titre_avec_date = "";
    if($unePrestation->getEtapeByType(Etape_Prise_en_compte))
        $label_titre_avec_date = " Prise en compte le ".$unePrestation->getEtapeByType(Etape_Prise_en_compte)->date_reelle->libelle_date.". ";
    if($unePrestation->getEtapeByType(Etape_Cloture))
        $label_titre_avec_date .= "Clôturée le ".$unePrestation->getEtapeByType(Etape_Cloture)->date_reelle->libelle_date.".";
    return $label_titre_avec_date;
}

function float_fr_to_en($val)
{
    $val_en = str_replace(',','.',$val);
    if(is_numeric($val_en))
        return $val_en;
    
    return 0;
}

function br2nl($string) {
//    var_dump($string);
//    echo '<br/>';
    $string = str_replace(array('<br>','<br/>','<br />'),"",$string);
//    $string = str_replace(array('<br>','<br/>','<br />'),"\n\r",$string);
//    echo '<br/>';
//    var_dump($string);
    return $string;
}