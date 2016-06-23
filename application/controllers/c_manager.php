<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Manager extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

    public function affichageCommande($id)
    {
        $this->load->model('simple/M_Commandes');

        //$this->data['commande'] = $this->M_Commandes->getFirstCommande();
        $this->data['commandes'] = $this->M_Commandes->getById($id);
        var_dump($this->data['commandes']);
        $this->data['client'] = $this->data['commandes']->get('client');
        $this->data['lignes'] = $this->data['commandes']->get('lignes_commande');
        $this->_loadView('manager/affichage_commande');
    }

    public function affichageStatistique()
    {
        $this->load->model('simple/M_Utilisateur');
        $this->load->model('simple/M_Commandes');

        $this->data['commandes'] = $this->M_Commandes->getAllNonTraitee();
        $this->data['statistique'] = $this->M_Utilisateur->getAllStatCommande();

        $this->_loadView('manager/affichage_principale');
    }

    
    public function importer_commandes(){
        if (!empty($_FILES)) {
            try {
                $csv = preg_match('/([.]csv)$/', $_FILES['upload']['name']);
                $bool = $this->importer_fichier_temporaire('upload');
            } catch (Exception $ex) {
                $bool = $ex->getMessage();
            }
            if($bool === true){ // fichier importé avec succès
                $filepath = APPLICATION_URI . '/web/files/import_commande.' . ($csv?'csv':'xls');
                
//                if (!$csv){
//                    $this->load->library('xls_converter');
//                    $filepath = $this->xls_converter->convert_xls_to_csv($filepath);
//                }
                $this->load->model('simple/M_Commandes');
                $this->load->model('simple/M_Client');
                $handle = fopen($filepath, 'r');
                $cpt = 0;
                while ($arrayData = fgetcsv($handle, 1000, ',')){
                    if ($cpt !== 0) { // ne pas gérér l'entete
                        $com = new M_Commandes();
                        $date_commande = $arrayData[0]; //date
                        $com->set('date_demande', $date_commande);
                        $numéro_commande = $arrayData[1]; //numéro
                        $com->set('num_commande', $numéro_commande);
                        
                        
                        
                        $nom_client = $arrayData[2]; //nom
//                        $com->set('date_demande', $nom_client);
                        $adresse_client = $arrayData[3]; //adresse
//                        $com->set('date_demande', $adresse_client);
                        $this->M_Client->getByNomAdresse($nom_client, $adresse_client);
                        
                        
                        $articles_commande = $arrayData[4]; //séparés par un ;
                    }
                    $cpt++;
                }
//                $ext = pathinfo($filepath, PATHINFO_EXTENSION);
            }else{ // afficher erreur à l'utilisateur
                $this->data['message']['error'] = $bool;
            } 
        }
        
        
        $this->_loadView('manager/import');
    }
    
    
    function importer_fichier_temporaire($document)
    {
        $config['file_name'] = 'import_commande';
        $config['remove_spaces'] = TRUE;
        $config['overwrite'] = TRUE;
        $config['upload_path'] = 'web/files';
        $config['allowed_types'] = '*';
        
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload($document)){
            throw new Exception($this->upload->display_errors());
        }
        return true;//Chargement réussit
    }
    
    
//    function importer_fichier($document, $id, $traitement = false)
//    {
//        $document = str_replace(array('(',')',' '),array('','','_'),convert_accented_characters($document)) ;
//        
//        
//        $tmp = './web/files/temp/'.($document);
//        $upload_path = './web/files/'.($document);
//        $bool_copy = copy($tmp, $upload_path);
//
//        if(file_exists($tmp))//si le fichier existe on le supprime
//            unlink($tmp);//suppression du fichier
//        
//        return $document;
//    }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */