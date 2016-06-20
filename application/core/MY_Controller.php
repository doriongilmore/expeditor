<?php
  /**
   * MY_Controller extends CI_Controller.
   *
   * date 20 juin 2011
   */

abstract class MY_Controller extends CI_Controller
{
  /** Propriété qui contient les données qui seront passées Ã  la vue */
  public $data = array('titre' => '','types_contenu'=>'','h2'=>'');
  
  /*Propriété qui contient tout les messages d'erreur, d'information ou de validation de l'application*/
  public $message = array();

  /** Permet la gestion des utilisateurs et des sites qui sont actifs ou non. */
  public $showAll = false;

  /**
   * Initialisation de l'application.
   * Le mode light évite l'initialisation du type_contenu, du menu et de la sideBar.
   *
   * @param Boolean $lightMode Permet de passer en mode light
   */
  public function __construct()
  {
      
    parent::__construct();  
    $this->message = initMessage();
    
    $this->_initSession();
    
    $this->load->model('table/m_bdconstant','BdConstant');
    $this->load->model('simple/m_utilisateur','user');
    
    /** Librairie qui permet de loguer les accès utilisateurs */
//    if (!$ajax)
        $this->load->library('log_access');
   
    
    // initialise la les donné de l'utilisateur connecter
    // si il est vide donc qu'aucune session de conexion existe on redirige vers la mire de connexion
    $this->user->init();
    
    if(is_null($this->user->identifiant_actor) && preg_match('/authentification/',$_SERVER['REQUEST_URI']) != 1)
    {
//        $arr = explode('/eclat', $_SERVER['REQUEST_URI']);
//        $arr = explode('.html', $arr[1]);
//        $_SESSION['wished_url'] = ($arr[0] == '/' || $arr[0] == '/index.php')?'accueil':$arr[0];
        $_SESSION['wished_url'] = $this->uri->uri_string();
        redirect('connexion/authentification','refresh');
    }
    else
    {
        $this->data['user'] = $this->user;
    }
//    $this->data['user'] = $this->user;
    /*/* vue pour optimisation*/
//      $this->output->enable_profiler(TRUE);
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
        if($this->verif_matriceDroitProfil($view))
        {
            $this->load->view('common/v_head');
            $this->load->view('common/v_header');
            $this->load->view('common/v_menu', $this->data);
            $this->load->view('common/v_error_validation', $this->data);
            $this->load->view($view,$this->data);
            $this->load->view('common/v_footer');
        } 
        else
        {
            redirect('c_erreur/page_interdite','refresh');
            exit();
        }
    } 
  
  /**
   * Gestion des sessions.
   * Attention, dans le portail cohabite deux systèmes de session.
   * Le système PHP avec $_SESSION pour la session globale intersites.
   * Le système CodeIgniter avec BDD pour la session dédiée au portail.
   */
    
    
  /**
   * Gestion des sessions.
   * Attention, dans le portail cohabite deux systèmes de session.
   * Le système PHP avec $_SESSION pour la session globale intersites.
   * Le système CodeIgniter avec BDD pour la session dédiée au portail.
   */
  public function _initSession()
  {    
    /** Démarrage de la session PHP puis CI */
    session_name($this->config->item('global_session'));
    session_start();
    $this->load->library('session');
    /**
     * Si la session PHP existe mais pas la session CI :
     *  -> Initialisation de la session CI.
     * Si la session PHP n'existe pas mais que la session CI existe :
     *  -> Destruction de la session CI.
     */
    if (isset($_SESSION['user_actor_id']) && ! $this->session->userdata('identifiant'))
    {
        $this->load->model('simple/m_utilisateur', 'User');

        $user = $this->User->getUnUtilisateur($_SESSION['user_actor_id']);

        $this->session->set_userdata('identifiant', $user->identifiant_actor);
    }
    elseif ( ! isset($_SESSION['user_actor_id']) && $this->session->userdata('identifiant'))
        $this->session->unset_userdata('identifiant');
    
    $verifURI = ((preg_match('connexion/',$_SERVER['REQUEST_URI']) == 1)?true:false);
    if(! isset($_SESSION['user_actor_id']) && $verifURI)
        redirect('connexion/authentification','refresh');
  }
    
    /*
     * Chargement des constante si nécessaire
     */
    
    protected function chargement_constantes()
    {
        //temporaire a remplir soit par la bdd soit par une constante
        
    }
    
    protected function verif_matriceDroitProfil($view)
    {
        $this->load->helpers('matrice_droit');
        
        foreach ($this->user->profil as $unProfil) 
            $tab_profil[$unProfil->id_profil] = $unProfil;
        
        return matrice_droit($view, $tab_profil);
    }
}