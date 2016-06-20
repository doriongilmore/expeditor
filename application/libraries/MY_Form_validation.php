<?php
/**
 * Description of MY_form_validation
 * date 19 juil. 2011
 */

class MY_Form_validation extends CI_Form_validation
{
  
  /** Permet de réinitaliser les valeurs servant au repeuplement des formulaires */
  public function clearDatas()
  {
    $_POST = array();
    $this->_field_data = array();
  }
  
  /**
   * Remove all string spaces
   *
   * @access	public
	 * @param	string
	 * @return	bool
   */
  public function remove_spaces($str)
  {    
    return removeSpaces($str);
  }


  /**
   * Add spaces every 2 chars.
   *
   * @param String $str
   * @return String
   */
  public function format_tel($str)
  {
    return cTel($str, false);
  }

  /**
   * Verifie que les date des habilitations sont présentes si la case est coché
   *
   * @param String $str
   * @return Boolean
   */
  public function requiredDateSiCocher($str)
  {
        if(isset($_POST['date_debut_'.$str]) && isset($_POST['date_fin_'.$str])) //Si les dates sont présentes
            if($this->valid_human_date($_POST['date_debut_'.$str]) && $this->valid_human_date($_POST['date_fin_'.$str]))
                return true;

        return false;
  }

  /**
   * Verifie que les date des habilitations sont cohérente DATE DEBUT < DATE FIN
   *
   * @param String $str
   * @return Boolean
   */
  public function coherenceDate($str)
  {
        if(isset($_POST['date_debut_'.$str]) && isset($_POST['date_fin_'.$str])) //Si les dates sont présentes
            if(strtotime($_POST['date_debut_'.$str]) < strtotime($_POST['date_fin_'.$str]))
                return true;

        return false;
  }


  /**
   * Valid telephone number
   *
   * @param String $str
   * @return Bool
   */
  public function valid_tel($str)
  {
    if ($str)
    {
      if ( ! parent::min_length($str, 4))
        return FALSE;

      if ( ! parent::max_length($str, 10))
        return FALSE;

      if ( ! parent::is_natural($str))
        return FALSE;
    }

    return TRUE;
  }


  public function valid_human_date($date)
  {
    $syntaxe = '#^[0-9]{2}\-[0-9]{2}\-[0-9]{4}$#';

    if( ! $date || preg_match($syntaxe, $date))
      return TRUE;

    return FALSE;
  }
  
  public function valid_timeHm($time)
  {
    $syntaxe = '#^[0-9]{2}:[0-9]{2}$#';

    if( ! $time || preg_match($syntaxe, $time))
      return TRUE;

    return FALSE;
  }


  /**
   * Accept alpha numeric and spaces.
   *
   * @access	public
	 * @param	string
	 * @return	bool
   */
  public function alpha_numeric_spaces($num)
  {
    $num = removeSpaces($num);
    return (bool) $this->alpha_numeric($num);
  }
  
  public function identifiantEDF($id)
  {
      $reg = '#^[a-zA-Z]{2}(?=.*\d).{5}[NnSs]$|^[a-zA-Z]{1}[0-9]{5}$#';
      return (bool)preg_match($reg, $id);
  }
  
  public function num_geisha($num)
  {
      $reg = '#[0-9a-zA-Z -_]#';
      return (bool)preg_match($reg, $num);
  }
  
  public function date_demande_geisha($date)
  {
      if($date == null || $this->valid_human_date($date))
          return true;
      
      return false;
  }
  
  public function heure_demande_geisha($hm)
  {
      if($hm == "__:__" || $this->valid_timeHm($hm))
          return true;
      
      return false;
  }
  
  public function url($url)
  {
      $reg = '#[0-9a-zA-Z -/_%$.?,;:!]#';
      return (bool)preg_match($reg, $url);
  }
  
  public function select($value)
  {
      if($value && $value > 0)
          return true;
      
      return false;
  }
  
  // ******* FONCTIONS VERIF MAISON *****
  
  public function verif_champs_presta_dynamique($nb_presta)
    {
        $error = '';
        if(is_array($nb_presta))
            for($i = 0 ; $i < count($nb_presta); $i++)
            {
                $this->set_rules('famille_presta_'.$nb_presta[$i], 'Famille de prestation n°'.$nb_presta[$i], 'select');
                $this->set_rules('type_presta_'.$nb_presta[$i], 'Type de prestation n°'.$nb_presta[$i], 'select');
                $this->set_rules('csit_presta_'.$nb_presta[$i], 'CSIT pour la prestation n°'.$nb_presta[$i], '');
                $this->set_rules('id_presta_'.$nb_presta[$i], 'identifiant pour la prestation n°'.$nb_presta[$i], '');

                if ($this->run() == FALSE)
                    $error .= validation_errors();
            }
        elseif(is_numeric($nb_presta))
            for($i = 0 ; $i < $nb_presta; $i++)
            {
                $this->set_rules('famille_presta_'.$nb_presta, 'Famille de prestation', 'select');
                $this->set_rules('type_presta_'.$nb_presta, 'Type de prestation', 'select');
                $this->set_rules('csit_presta_'.$nb_presta, 'CSIT pour la prestation', '');
                $this->set_rules('id_presta_'.$nb_presta, 'identifiant pour la prestation', '');

                if ($this->run() == FALSE)
                    $error .= validation_errors();
            }
        elseif(is_nan($nb_presta))
            $error .= "Erreur lors de la vérification des champs presta (code : 567)";
        
        if($error == '')
            return true;
        else
        {
            $this->data['error'] .= $error;
            return false;
        }
        
        return false;
    }
  
    // on parcoure les type de presta enregistrer a la demande et verifie qu'il ne soient pas identique.
    public function DuplicationTypePresta($nb_presta)
    {
        for($i = 0 ; $i < count($nb_presta); $i++)
        {
            for($j = 0 ; $j < count($nb_presta); $j++)
            {
                if($i != $j && $_POST['type_presta_'.$nb_presta[$i]] == $_POST['type_presta_'.$nb_presta[$j]])
                    return false;
            }
        }
          
        return true;
    }
}