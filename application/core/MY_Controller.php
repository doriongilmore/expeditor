<?php
  /**
   * MY_Controller extends CI_Controller.
   *
   * date 04 mars 2015
   */

abstract class MY_Controller extends CI_Controller
{
  /** Propriété qui contient les données qui seront passées Ã  la vue */
  public $data = array();
  
  /*Propriété qui contient tout les messages d'erreur, d'information ou de validation de l'application*/
  public $message = array();

  

  /**
   * Initialisation de l'application.
   *
   */
  public function __construct()
  {
      
    parent::__construct();  
    
    $this->message = initMessage();
    
    $this->_initSession();
    
    $this->load->model('simple/m_utilisateur','user');
    
    /** Librairie qui permet de loguer les accès utilisateurs */
//    $this->load->library('log_access');
    
    // initialise la les donné de l'utilisateur connecter
    if (isset($_SESSION['user_id']))
        $u =  $this->user->getById($_SESSION['user_id']);
    // si il est vide donc qu'aucune session de conexion existe on redirige vers la mire de connexion
    if((!isset($u) ) && $this->uri->segment(1).'/'.$this->uri->segment(2) != 'connexion/authentification')
    {
        redirect('connexion/authentification','refresh');
    }
    elseif(isset ($u))
    {
        $this->data['user'] = $u;
    }
    
    /*/* vue pour optimisation*/
    // if (ENVIRONMENT == MODE_DEVELOPMENT)
      // $this->output->enable_profiler(TRUE);
  }

  /**
   * Méthode qui permet de charger une vue directement dans le template.
   * Elle permet aux controlleurs qui hériteront de MY_Controller de ne pas avoir Ã  se soucier du template.
   *
   * @param string $view Le nom de la vue.
   * @param string $view Le nom du template: par défaut = 'classic'.
   */
    public function _loadView($view,$light = false)
    {         
        // if($this->verif_matriceDroitProfil($view))
        // {
            $this->load->view('common/v_head');
            $this->load->view('common/v_header');
            $this->load->view('common/v_menu', $this->data);
            $this->load->view('common/v_error_validation', $this->data);
            $this->load->view($view, $this->data);
            $this->load->view('common/v_footer');
        // } 
        // else
        // {
            // redirect('c_erreur/page_interdite', 'refresh');
        // }
    } 
  

  

    
  /**
   * Gestion des sessions.
   * Attention, deux systèmes de session.
   * Le système PHP avec $_SESSION pour la session globale intersites.
   * Le système CodeIgniter avec BDD pour la session dédiée au portail.
   */
  public function _initSession()
  {    
    /** Démarrage de la session PHP puis CI */
//    session_name($this->config->item('global_session'));
    session_start();
    $this->load->library('session');

    /**
     * Si la session PHP existe mais pas la session CI :
     *  -> Initialisation de la session CI.
     * Si la session PHP n'existe pas mais que la session CI existe :
     *  -> Destruction de la session CI.
     */
    if (isset($_SESSION['user_id']) && ! $this->session->userdata('identifiant'))
    {
        $this->load->model('simple/m_utilisateur', 'User');

        $user = $this->User->getById($_SESSION['user_id']);

        $this->session->set_userdata('identifiant', $user->identifiant);
    }
    elseif ( ! isset($_SESSION['user_id']) && $this->session->userdata('identifiant'))
      $this->session->unset_userdata('identifiant');
    
  }
    
    /*
     * Chargement des constante si nécessaire
     */
    
    protected function chargement_constantes()
    {
//        $this->load->model('simple/m_constant','constant');
//        
//        $this->data['tab_statut'] = $this->constant->get('statut');
    }
    
    
    
    
    
}