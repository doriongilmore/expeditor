<?php
  /**
   * Cette classe existe uniquement pour assurer la transmission de session vers le serveur Tanneur 1
   * Elle peut être supprimée si toutes les applications qui se servaient de l'authentification du
   * portail v2 ont migré vers le système d'authentification du portail v3.
   *
   * date 7 nov. 2011
   */

class MY_Session extends CI_Session
{
  const COMPATIBILITY_COOKIE_NAME   = 'spv3';
  const COMPATIBILITY_COOKIE_PATH   = '/';
  const COMPATIBILITY_COOKIE_DOMAIN = '.edf.fr';


  public function __construct()
  {
    parent::__construct();
  }

  
  /**
	 * Réécriture de la méthode initiale.
   * Met à jour l'idientfiant de session du cookie spv3 lorsque CI le change.
	 *
	 * @access	public
	 * @return	void
	 */
	public function sess_update()
	{
    parent::sess_update();

    if ($this->CI->input->cookie(self::COMPATIBILITY_COOKIE_NAME))
      $this->set_compatibility_cookie();
  }


  /**
   * Méthode qui gère les opérations nécessaires au lancement des sessions distantes :
   * Reservware, transat, oapsst par exemple...
   *
   * @param String $identifiantEDF Doit contenir l'identifiant_edf NNI de l'utilisateur courant.
   */
  public function sess_compatibility_start($identifiantEDF)
  {
    $this->set_userdata('nni', $identifiantEDF);
    $this->set_compatibility_cookie();
  }


  /**
   * Méthode qui gère les opérations nécessaires à la destruction des sessions distantes :
   * Reservware, transat, oapsst par exemple...
   */
  public function sess_compatibility_stop()
  {
    setcookie(
      self::COMPATIBILITY_COOKIE_NAME,
      false,
      0,
      self::COMPATIBILITY_COOKIE_PATH,
      self::COMPATIBILITY_COOKIE_DOMAIN
    );
  }


  /**
   * Initialise le cookie nécessaire au transfert de session.
   */
  private function set_compatibility_cookie()
  {
    $expire = time()+$this->CI->config->item('sess_expiration');

    setcookie(
      self::COMPATIBILITY_COOKIE_NAME,
      $this->userdata('session_id'),
      $expire,
      self::COMPATIBILITY_COOKIE_PATH,
      self::COMPATIBILITY_COOKIE_DOMAIN
    );
  }
}