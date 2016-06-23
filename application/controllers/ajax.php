<?php

/**
 * Description of ajax :
 * Controller dédié aux requêtes asynchrones de technologie AJAX.
 *
 * date 30 juin 2011
 */
class ajax extends MY_Controller {

    public $showAll = false;
    
    public function __construct() {
        parent::__construct();
        
        if (!$this->input->is_ajax_request())
            redirect('c_erreur/page_interdite', 'refresh');
    }
	
    
    public function liberer($id_commande){
        $this->load->model('simple/M_Commandes');
        $res = $this->M_Commandes->liberer($id_commande);
        if (is_null($res))
            echo 'true';
        else
            echo 'false';
    }
    
    public function sauvegarderEmploye(){
        
        $this->load->model('simple/M_Utilisateur');
        $newEmploye = new M_Utilisateur();
        $newEmploye->set('id_profil', $_POST['type']);
        $newEmploye->set('nom', $_POST['nom']);
        $newEmploye->set('prenom', $_POST['prenom']);
        $newEmploye->set('login', $_POST['login']);
        $newEmploye->set('password', $_POST['password']);
     
        $res = $this->M_bdUtilisateur->insert($newEmploye);
        if (is_null($res))
            echo 'true';
        else
            echo 'false';
    }
    
        public function sauvegarderArticle(){
        
        $this->load->model('simple/M_Article');
        $newArticle = new M_Article();
        $newArticle->set('nom', $_POST['nom']);
        $newArticle->set('quantite_stock', $_POST['qte']);
        $newArticle->set('poids', $_POST['poids']);
        $newArticle->set('prix', $_POST['prix']);
     
        $res = $this->M_bdArticle->insert($newArticle);
        if (is_null($res))
            echo 'true';
        else
            echo 'false';
    }
    
}