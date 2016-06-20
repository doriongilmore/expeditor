<?php
  /**
   * Description of errors
   * date 22 juin 2011
   */

class C_erreur extends MY_Controller
{
  /**
   * On appelle le constructeur de MY_Controller en mode "light" pour pallier à  un
   * manquement de CodeIgniter.
   * ConcrÃ¨tement on n'initialise pas le menu, la sideBar et le type_contenu
   */
  public function __construct()
  {
    parent::__construct();
  }


  public function incident_serveur()
  {
    $this->data['titre']  = '500';
    $this->data['h2']     = 'Un problème est survenu.<br />'.
                            'Si le problème persiste, merci de contacter l\'administrateur de l\'application.';
    $this->_show(false);
  }
  
  public function expiration_formulaire()
  {
    $this->data['titre']  = '500';
    $this->data['h2']     = 'Pour des raison de sécurité la page a expiré.<br />'.
                            'Merci de reformuler votre demande.<br />'.
                            'ATTENTION : Aucune information n\'a été sauvegardée lors de cette opération.';
    $this->_show(false);
  }
  

  public function page_manquante()
  {
//    $this->load->library('session');
    $this->data['titre']  = '404';
    
    if ($this->session->userdata('identifiant'))
      $this->data['h2']     = 'La page que vous demandez est inexistante.';
    else
      $this->data['h2']     = 'La page demandée est inexistante.<br />'.
                              'Pour accéder au portail, merci de choisir l\'un des environnments suivants :';

    $this->_show();
  }
  
  public function deja_connecte()
  {
        $this->data['titre']  = 'Connexion à '.NOM_APPLICATION.'.';
        $this->data['h2']     = 'Vous êtes déjà connecté à '.NOM_APPLICATION;
        $this->data['show_form']  = true;
        $this->_show(true);
  }
  
  public function habilitation_manquante()
  {
        $this->data['titre']  = 'Se connecter à '.NOM_APPLICATION.'.';
        $this->data['h2']     = 'Vous n\'êtes pas authentifier';
        $this->data['show_form']  = true;
        $this->_show(true);
  }

  public function page_interdite()
  {
//    $this->load->library('session');
    $this->data['titre']  = '403';
    
    if ($this->session->userdata('identifiant'))
    {
      $this->data['h2']     = 'Vous n\'êtes pas autorisé à  visualiser cette page.';
      $light = false; //je fait apparaitre le menu car on est co mais on Ã  pas les droit d'accÃ¨der a la page
    }
    else
    {
      $this->data['h2']     = 'Vous n\'êtes pas autorisé à  visualiser cette page.<br />';
      $light=true; //Le menu n'apparait pas car on est pas co et on essaie de joindre une page autre que celle d'authentification
    }
    
    $this->_show();
  }
  
  public function en_construction()
  {
//    $this->load->library('session');
    $this->data['titre']  = 'En construction';
    
    $this->data['h2']     = 'Vous ne pouvez accéder à  cette page.';
    
    $this->_show();
  }


  /**
   * Traitements effectuÃ©s en cas d'erreur :
   * On efface le type de contenu de base_url.
   * Et on propose de retourner au portail via une liste de type_contenu.
   */
  public function _show($light = false, $db = true)
  {
//    $this->config->set_item('base_url', '');
//
//    if ($db)
//      $this->load->database();
    //On charge le template alternatif, sans menu, header, footer...
    $this->_loadView('v_error', $light, false);
  }
}