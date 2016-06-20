<?php
/**
 * Description of MY_form_helper
 * date 28 juin 2011
 */

/** corrige un bug de CI :( */

function form_dropdown($name = '', $options = array(), $selected = array(), $extra = '')
{
  if ( ! is_array($selected))
  {
    $selected = isset($_POST[$name]) ? $_POST[$name] : $selected;
    $selected = array($selected);
  }

  // If no selected state was submitted we will attempt to set it automatically
  if (count($selected) === 0)
  {
    // If the form name appears in the $_POST array we have a winner!
    if (isset($_POST[$name]))
    {
      $selected = array($_POST[$name]);
    }
  }

  if ($extra != '') $extra = ' '.$extra;

  $multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

  $form = '<select name="'.$name.'"'.$extra.$multiple.">\n";

  foreach ($options as $key => $val)
  {
    $key = (string) $key;

    if (is_array($val) && ! empty($val))
    {
      $form .= '<optgroup label="'.$key.'">'."\n";

      foreach ($val as $optgroup_key => $optgroup_val)
      {
        $sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

        $form .= '<option value="'.form_prep($optgroup_key).'"'.$sel.'>'.(string) form_prep($optgroup_val)."</option>\n";
      }

      $form .= '</optgroup>'."\n";
    }
    else
    {
      $sel = (in_array($key, $selected)) ? ' selected="selected"' : '';
     
      $form .= '<option value="'.form_prep($key).'"'.$sel.'>'.(string) form_prep($val)."</option>\n";
    }
  }

  $form .= '</select>';

  return $form;
}




function my_form_input($data = '', $value = '', $extra = '')
{    
  $value = set_value($data['name'], $value);
  return form_input($data, $value, $extra);
}


function my_form_textarea($data = '', $value = '', $extra = '')
{
  $value = set_value($data['name'], $value);
  return form_textarea($data, $value, $extra);
}



/**
 * Renvoi un bloc HTML type comprenant les div contenant le label et le champ input text.
 * Les champs ainsi créés seront automatiquement repeuplés en se voyant appliquer "htmlspecialchars".
 *
 * @param array() $params Idem helper form_input avec une entrée en plus : "label_value"
 * @param String $value valeur par défaut du champ (cf doc helper form_input)
 * @param <type> $extra éventuellement du JavaScript (cf doc helper form_input)
 * @return string
 */
function form_row_input($params, $defaultValue = '', $extra = '')
{    
  $str  = '<div class="form_row">';
    $str .= '<div class="label_field">';

  $str .= form_label($params['label_value'], $params['id']);
  $str .= '</div>';

  $str .= '<div class="field">';

  unset($params['label_value']);

  $str .= my_form_input($params, $defaultValue, $extra);

  $str .= '</div></div>';

  return $str;
}


function form_row_textarea($params, $defaultValue = '', $extra = '')
{
  $str  = '<div class="form_row">';

  $str .= '<div class="label_field">';
    $str .= form_label($params['label_value'], $params['id']);
  $str .= '</div>';
  $str .= '<div class="field">';

  unset($params['label_value']);

  $str .= my_form_textarea($params, $defaultValue, $extra);

  $str .= '</div></div>';

  return $str;
}


function form_row_password($params, $defaultValue = '', $extra = '')
{  
  $value = set_value($params['name'], $defaultValue);

  $str  = '<div class="form_row">';
  
  $str .= '<div class="label_field">';
  $str .= form_label($params['label_value'], $params['id']);
  $str .= '</div>';

  $str .= '<div class="field">';

  unset($params['label_value']);

  $str .= form_password($params, '', $extra);

  $str .= '</div></div>';

  return $str;
}

function form_row_autocomplete_simple($params, $defaultValue = '', $extra = '')
{  
  $str  = '<div class="form_row">';

  $str .= form_label($params['label_value'], $params['id']);

  $str .= '<div class="field autocompletion">';

  unset($params['label_value']);

  $params['autocomplete'] = 'off';

  $str .= my_form_input($params, $defaultValue, $extra);

  $str .= '<select size="7"></select>';

  $str .= '</div></div>';

  return $str;
}

function form_row_autocomplete_complex($params, $defaultIdValue = '', $defaultLibValue = '', $extra = '')
{
  $str  = '<div class="form_row">';

  $str .= '<div class="label_field">';
    $str .= form_label($params['label_value'], $params['id']);
  $str .= '</div>';

  unset($params['label_value']);

  if (isset($_POST[$params['name']]))
      if (!isset ($_POST['reinitialiser']))
        $defaultLibValue = $_POST[$params['name']];
  
  $str .= form_autocomplete_complex($params, $defaultIdValue, $defaultLibValue, $extra);

  $str .= '</div>';

  return $str;
}

function form_autocomplete_complex($params, $defaultIdValue = '', $defaultLibValue = '', $extra = '')
{
  $str = '<div class="field autocompletion">';

  $hidden_name = $params['hidden_name'];

  unset($params['hidden_name']);

  $params['autocomplete'] = 'off';
  
  $str .= my_form_input($params, $defaultLibValue, $extra);

  $str .= '<select size="7" />';

  $str .= my_form_input(array('name' => $hidden_name, 'type' => 'hidden'), $defaultIdValue);

  $str .= '</div>';

  return $str;
}

function form_row_select($params, $options, $blankOpt = false, $value = null)
{
  $name   = $params['name'];
  $str  = '<div class="form_row">';
  
  foreach ($params as $key => $val)
    if(preg_match('#^label#', $key))
    {
        $tab_param = split('_', $key);
        if($tab_param[1] != 'value')
            $attr = array($tab_param[1] => $val); 
    }
$str .= '<div class="label_field">';
  $str .= form_label($params['label_value'], $params['id'], $attr);
$str .= '</div>';
  $str .= '<div class="field">';

  unset($params['label_value']);
  unset($params['name']);

  $extra = '';
  foreach ($params as $key => $val)
    $extra .= ' '.$key.'="'.$val.'" ';
  
  if($blankOpt !== false)
    $options = array(0 => $blankOpt)+$options;

  $str .= form_dropdown($name, $options, $value, $extra);

  $str .= '</div></div>';

  return $str;
}


function form_row_radio($params = array(), $values = array())
{ 
  $str  = '<div class="form_row">';

  $str .= form_label($params['label_value']);

  $str .= '<div class="field radio_checkbox">';

  $extra = '';
  foreach ($params as $key => $val)
    $extra .= ' '.$key.'="'.$val.'" ';

  foreach ($values as $val)
  {
    $checked = isset($params['checked_val']) && $params['checked_val'] == $val['value'] ? true : false;
    
    $str .= form_radio($val['name'], $val['value'], $checked, 'id="'.$val['id'].'"');
    $str .= '<label for="'.$val['id'].'">'.$val['label_value'].'</label>';
  }

  $str .= '</div></div>';

  return $str;
}

function form_array_row_habilitation($tab_habilitation)
{
    $str = '<div class="form_row">';
        $str .= '<div class="label_habilitation">';
            $str .= '<div class="label_field">';
                $str .= form_label('Profil');
            $str .= '</div>';
            $str .= '<div class="field">';
                $str .= form_label('Date début');
                $str .= form_label('Date Fin');
            $str .= '</div>';
        $str .= '</div>';
    $str .= '</div>';
    foreach($tab_habilitation as $key => $une_habilitation)
    {
        $str .= form_row_habilitation($key, $une_habilitation['label'], $une_habilitation['checked'], $une_habilitation['date_debut'], $une_habilitation['date_fin']);
    }
    return $str;
}

function form_row_habilitation($id_hab, $profil = null, $checked = false, $date_debut='', $date_fin = '')
{
    $str = '';
    if(is_null($checked))
        $checked = false;
    
    if(is_null($profil))
        return false;
    
    $str .= '<div class="form_row">';
        $str .= '<div class="label_field">';
            $str .= form_checkbox(array('class'=>'checkBox_habilitation', 'name'=>'check_habilitation_'.$id_hab),$id_hab,$checked);
            $str .= form_label($profil);
        $str .= '</div>';
        $str .= '<div class="field">';
            $str .= form_input(array('label_value' => 'Date début : ', (($checked)?'':'disabled')=>'', 'class'=> 'text date_simple date_habilitation','name'=>'date_debut_'.$id_hab, 'value'=>  $date_debut));
            $str .= form_input(array('label_value' => 'Date fin : ', (($checked)?'':'disabled')=>'', 'class'=> 'text date_simple date_habilitation','name'=>'date_fin_'.$id_hab, 'value'=>  $date_fin));
        $str .= '</div>';
    $str .= '</div>';
    
    return $str;
}

function form_row_upload($label_value, $data = '', $value = '', $extra = '')
{
    $filename = $data['filename'];
    unset($data['filename']);
    
  $str  = '<div class="form_row">';

  $str .= '<div class="label_field">';
  $str .= form_label($label_value);
  $str .= '</div >';

  $str .= '<div class="field">';
  if (!isset($filename) || is_null($filename) || $filename == ''){
        $str .= form_upload($data, $value, $extra.' class="text"');
        $str .= form_input('_upload', $filename, 'class="parcourir text" id="input_upload" readonly="" style="display:none"');
        
//        $str .= '<a class="parcourir lien" style="display:none" href="" id="see_file_upload" target="_blank">Voir la pièce jointe</a>';
        $str .= '<a class="parcourir button" style="display:none" name="'.$filename.'" id="suppr_file_upload">Supprimer la pièce jointe</a>';
  }
  else{
        $str .= form_upload($data, $value, $extra.' class="text" style="display:none"');
        $str .= form_input('_upload', $filename, 'class="parcourir text" id="input_upload" readonly=""');
        
        if (substr($filename, 0, 3) == 'img') 
            $lien = APPLICATION_URI.'/web/files/'.$filename;
        else
            $lien = APPLICATION_URI.'/web/files/temp/'.$filename;
        
        $str .= '<a class="parcourir lien" href="'.$lien.'" id="see_file_upload" target="_blank">Voir la pièce jointe</a>';
        $str .= '<a class="parcourir button" name="'.$filename.'" id="suppr_file_upload">Supprimer la pièce jointe</a>';
  }
  $str .= '</div>';
  
  $str .= '</div>';

  return $str;
}

function form_row_information($texte_champ, $texte_info, $id = null, $params = null)
{
    $str = '<div class="form_row">
                <div class="champ">';
            $str .= form_label($texte_champ, $id, $params);
    $str .= '   </div>
                <div class="form_info">';
    if(!is_null($texte_info) && $texte_info != "")
        $str .= form_label($texte_info, $id, $params);
    else
        $str .= form_label("N.C.", $id, $params);
    $str .= '   </div>
            </div>';
    
    return $str;
}

function form_row_label($label)
{
    $str = "<div class='form_row'>";
    $str .= $label;
    $str .= "</div>";
    
    return $str;
}

function form_array_row_label($arr_label)
{
    $str = '';
    foreach($arr_label as $unLabel => $unSpan){
        $row = '<label>'.$unLabel.'</label><span>'.$unSpan.'</span>';
        $str .= form_row_label($row);
    }
    
    return $str;
}

function form_array_row_button($arr_button){
    $str = '<div class="form_row">';
    foreach($arr_button as $unBouton){
        $str .= form_input($unBouton);
    }
    $str .= '</div>';
    
    return $str;
    
}

//function graph_pie($tab_info, $param, $tab_info_ie)
//{
//    echo '
//            <div class="container_graph">
//                <div class="graph">';
//    if(isset($param['titre']))
//    {
//        echo        '<h1>'.$param['titre'].'</h1>';
//        unset($param['titre']);
//    }
//    echo                '<canvas 
//                    id="graph"';
//    foreach($param as $nameParam => $valueParam)
//        echo $nameParam .'="'.$valueParam.'"';
//    echo '  >';
//    //pour IE    ************************
//    foreach($tab_info_ie as $info)
//        echo '<span name="'.$info['lien'].'" class="libelle_stat_ie">'.$info['title'].': '.$info['value'].'</span><br>';
//    // **********************************
//    echo '</canvas>
//                    <div id="graph_legend"></div>
//                </div>
//            </div>
//            <script>
//                insererGraph('. $tab_info .', "' . $param['lien'] . '");
//            </script>   ';
//}