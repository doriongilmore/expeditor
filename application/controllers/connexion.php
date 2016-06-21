<?php
/**
 * Description of authentification :
 * Classe permettant l'authentification via LDAP au portail.
 * La configuration du LDAP se trouve dans "application/config/ldap.php".
 *
 * date 24 juin 2011
 */

class Connexion extends MY_Controller
{
  const ERR_CONNEXION     = 1;
  const ERR_HABILITATION  = 2;
  const ERR_IS_CONNECTED  = 3;
  const ERR_LDAP          = 4;

  private $errorCode = null;


  /**
   * MÃ©thode de gestion de la connexion au portail.
   * Initialise la session si authentification OK.
   * Redirige vers la page d'accueil definie par l'utilisateur.
   */
  public function authentification()
  {
//    if ($this->session->userdata('identifiant') && $this->uri->segment(2) != 'deja_connecte')
//      redirect('connexion/deja_connecte', 'refresh');

    $this->load->model('simple/m_utilisateur');
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<li>', '</li>');
	
    /** Si authentification ok ou mode dÃ©veloppement */
    if ($this->form_validation->run('authentification'))
    {
      /** RÃ©cupÃ©ration de l'identifiant BDD de l'utilisateur */
      // $u = $this->m_utilisateur->getUnUtilisateur($this->m_utilisateur->getByNni($this->input->post('identifiant_user')));

      /** Initialisation de la session PHP*/
      // $_SESSION['user_id'] = $u->identifiant;
//      $_SESSION['user_id'] = 1;
      
      /** Initialisation de la session CI */
      // $this->session->set_userdata('identifiant', $u->identifiant);
//      $this->session->set_userdata('identifiant', 1);

      /** On met Ã  jour les informations de log */
      // $this->log_access->setIdentifiant($u->identifiant);
      // $this->log_access->setIdentifiant(1);
      // $this->log_access->setAuthMsg('identification OK');

      /** Redirection vers la page d'accueil*/
            redirect('accueil','refresh');
    }
    else
    {
        //redirect('connexion/authentification','refresh');
      switch ($this->errorCode)
      {
        case self::ERR_CONNEXION:
          $this->data['titre']      = 'Identification incorrecte';
          $this->data['show_form']  = true;
          break;

        case self::ERR_IS_CONNECTED:
          $this->data['titre']      = 'Vous êtes déjà  connecté à  '.NOM_APPLICATION.'.';
          $this->data['alt_link']   = anchor('connexion/deconnexion', 'Déconnexion', array('class' => 'btn_large btn_link'));
          $this->data['show_form']  = false;
          break;

        default:
          $this->data['titre']      = 'Se connecter à '.NOM_APPLICATION.'.';
          $this->data['show_form']  = true;
          break;
      }
      
      $this->_loadView('authentification');
    }
  }


  /**
   * DÃ©connecte l'utilisateur du bouquet applicatif.
   * Renvoie vers l'accueil.
   */
  public function deconnexion()
  {
    /** Destruction de la session PHP*/
    session_destroy();
    /** Gére les opérations nécessaires à la destruction des sessions distantes */
//    $this->session->sess_compatibility_stop();
    /** Destruction de la session CI */
    $this->session->unset_userdata('identifiant');
    
    $this->load->helper('cookie');
    $cookie = array(
                   'name'   => 'spv3',
                   'value'  => '',
                   'expire' => '1',
               );
	  delete_cookie($cookie);

    // $this->log_access->setAuthMsg('deconnexion');
    
    redirect('accueil/index','refresh');
  }


  /**
   * Page affichée en cas d'utilisateur déjà  connecté
   */
  public function deja_connecte()
  {
    /** Si il s'avère que la session n'existe pas on redirige vers la page d'authentification */
    if ( ! $this->session->userdata('identifiant'))
      redirect('connexion/authentification','refresh');

    $this->errorCode = self::ERR_IS_CONNECTED;
    
    redirect('c_erreur/deja_connecte','refresh');
    /** On rappelle l'index pour l'affichage de la vue */
  }


  
  /**
   * MÃ©thode de callback qui procÃ¨de Ã  la connexion au ldap.
   * La connexion n'est tentÃ© que si le callback verifiant l'habilitation s'est bien passÃ©.
   *
   * @param String $pwd
   * @return Boolean
   */
  public function _connexionCheck($pwd)
  {
    /** Si l'utilisateur existe et est autorisÃ© Ã  se loguer. */
    if ( ! validation_errors() )
    {
      // vérifier BDD
	  // login : $this->input->post('identifiant_user')
	  // mdp : $pwd
           
		   
    }
    return true;
  }
  
}  