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
    if ($this->session->userdata('identifiant') && $this->uri->segment(3) != 'deja_connecte')
      redirect('connexion/deja_connecte', 'refresh');

    $this->load->model('simple/m_utilisateur', 'User');
    $this->form_validation->set_error_delimiters('<li>', '</li>');
	
    /** Si authentification ok ou mode dÃ©veloppement */
    if ($this->form_validation->run('authentification'))
    {
      /** RÃ©cupÃ©ration de l'identifiant BDD de l'utilisateur */
      $u = $this->User->getUnUtilisateur($this->User->getByNni($this->input->post('identifiant_user')));

      /** Initialisation de la session PHP*/
      $_SESSION['user_actor_id'] = $u->identifiant_actor;
      
      /** Initialisation de la session CI */
      $this->session->set_userdata('identifiant', $u->identifiant_actor);

      /** On met Ã  jour les informations de log */
      $this->log_access->setIdentifiant($u->identifiant_actor);
      $this->log_access->setAuthMsg('identification OK');

      /** Redirection vers la page d'accueil*/
      if (isset($_SESSION['wished_url'])){
          $tmp = $_SESSION['wished_url'] ;
          unset($_SESSION['wished_url']);
        redirect($tmp,'refresh');
      }
      else
            redirect('accueil','refresh');
    }
    else
    {
        //redirect('connexion/authentification','refresh');
      switch ($this->errorCode)
      {
        case self::ERR_LDAP:
          $this->data['titre']      = 'Un problème est survenu';
          $this->data['show_form']  = true;
          break;
        case self::ERR_CONNEXION:
          $this->data['titre']      = 'Identification incorrecte';
          $this->data['show_form']  = true;
          break;

        case self::ERR_HABILITATION:
          $this->data['titre']      = 'Habilitation incorrecte';
          $this->data['alt_link']   = anchor('connexion', 'Retour au formulaire', array('class' => 'btn_large btn_link'));
          $this->data['show_form']  = false;
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

    $this->log_access->setAuthMsg('deconnexion');
    
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
//    $this->authentification();
  }


  /**
   * MÃ©thode de callback qui procÃ¨de Ã  la vÃ©rification de l'habilitation
   *
   * @param String $pwd
   * @return Boolean
   */
  public function _habilitationCheck($login)
  {    
    if ($this->User->checkHabilitation($login))
      return true;
    else
    {
      $this->errorCode = self::ERR_HABILITATION;

      $msg = 'Vous n\'êtes pas habilité à  cette application.<br />';
      
      $this->form_validation->set_message(__FUNCTION__, $msg);

      $this->log_access->setIdentifiant($login);
      $this->log_access->setAuthMsg('non habilité');

      return false;
    }
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
      if ($this->input->post('identifiant_user') && ENVIRONMENT === 'development')
        return true;
                        
        include_once("./application/libraries/Ldap.php"); 
          
        try {       
            $ldapAuth =& new LdapAuth(ldap());
            $ldapAuth->authenticateUser($this->input->post('identifiant_user'), $pwd);    
        } catch (LdapException $e) {
        	 $this->form_validation->set_message(__FUNCTION__, $e->getMessage());  
          return false;
        }     
    }
    return true;
  }
  
}  