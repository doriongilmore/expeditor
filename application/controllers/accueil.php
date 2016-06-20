<?php

class Accueil extends MY_Controller
{ 
    public function index()
    {
        //regarde si l'utilsiateur est connecte ou était connecté récement
//        if(!$this->session->userdata('identifiant'))
//            redirect('connexion/authentification', 'refresh');

//        $this->data['droits'] = $this->chargement_droit_user();
//        var_dump(base_url());
        $this->_loadView('accueil');
    }
    
}
?>
