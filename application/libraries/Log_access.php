<?php
  /**
   * Description of Log_Access :
   * Gère l'écriture des logs utilisateur dans la base de données.
   *
   * date 27 juil. 2011
   */

class Log_Access
{
  /** Instance du "super objet" code igniter */
  private $CI = null;

  /**
   * Tableau des données qui seront insérées dans la table b_logs de la BDD.
   * Chaque clef correspond au nom d'un champ de la table b_logs.
   */
  private $datas = array(
    'identifiant' => '',
    'ip'          => '',
    'url'         => '',
    'action'      => '',
    'auth_msg'    => '',
    'date'        => '' 
  );


  /**
   * Lors de l'instanciation, les données déjà disponibles sont stockées dans la propriété "$data".
   */
  public function __construct()
  { 
      
    $this->CI =& get_instance();

    if ($this->CI->session->userdata('identifiant'))
      $this->setIdentifiant($this->CI->session->userdata('identifiant'));
    $this->datas['date'] = date('Y-m-d H:i:s');
    $this->datas['ip'] = $this->CI->input->ip_address();

    $this->datas['url'] = current_url();
  }

  
  /**
   * Permet de renseigner l'identifiant utilisé lors de l'authentification.
   * Par défaut, c'est le constructeur qui s'en charge si il trouve une session.
   *
   * @param String $identifiant Id utilisateur de la BDD ou identifiant (nni) utilisé lors de l'authentification.
   */
  public function setIdentifiant($identifiant)
  {
    $this->datas['identifiant'] = $identifiant;
  }


  /**
   * Permet de renseigner sur ce qui a lieu lors de l'identification.
   *
   * @param String $auth Message d'information sur la tentative de connexion.
   */
  public function setAuthMsg($auth)
  {
    $this->datas['auth_msg'] = $auth;
  }


  /**
   * Éxecutée en fin de script, cette méthode s'occupe de finaliser les logs
   * notamment en récupérant les requêtes INSERT et UPDATE.
   * L'éxecution se termine par l'insert en bdd.
   */
  public function __destruct()
  {    
    foreach ($this->CI->db->queries as $q)
    {
        if (in_array(substr($q, 0, 6), array('UPDATE', 'INSERT', 'DELETE')) && !strpos($q, 'ci_session'))
            $this->datas['action'] .= $q."\n";
    }
    if(!is_null($this->datas['action']))
        $this->CI->db->insert('e_logs', $this->datas);
  }
}