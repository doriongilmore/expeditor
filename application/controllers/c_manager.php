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
                $this->load->model('simple/M_Ligne_Commandes');
                $this->load->model('simple/M_Commandes');
                $this->load->model('simple/M_Client');
                $this->load->model('simple/M_Article');
                $handle = fopen($filepath, 'r');
                $cpt = 0;
                while ($arrayData = fgetcsv($handle, 1000, ',')){
                    if ($cpt !== 0) { // ne pas gérér l'entete
                        $com = new M_Commandes();
                        $date_commande = $arrayData[0]; //date
                        $tmp_date = DateTime::createFromFormat('d/m/Y H:i:s', $date_commande);
                        $com->set('date_demande', date_format($tmp_date, FORMAT_DATE_COMMANDE));
                        $numéro_commande = $arrayData[1]; //numéro
                        $com->set('num_commande', $numéro_commande);
                        
                        
                        
                        $nom_client = trim($arrayData[2]); //nom
                        $adresse_client = trim($arrayData[3]); //adresse
                        
                        $clients = $this->M_Client->getByNomAdresse($nom_client, $adresse_client);
                        if (count($clients) == 0) {
                            $id_client = $this->M_Client->insert($nom_client, $adresse_client);
                        }
                        if (isset($id_client))
                            $com->set('id_client', $id_client);
                        else
                            $com->set('id_client', $clients[0]->get('id_client'));
                        unset($id_client); // supprimer l'id pour le prochain passage
                        
                        $com->set('id_etat', ETAT_ATTENTE);
                        
                        $id_commande = $this->M_Commandes->insert($com);
                        
                        $articles_commande = $arrayData[4]; //séparés par un ;
                        $array_article = explode(';', $articles_commande);
                        
                        foreach ($array_article as $art) {
//                            $test = preg_split('/([a-z ]*)(\([0-9]*\))/i', $art);
                            $tmp_arr = explode('(', $art);
                            $libelle_article = trim($tmp_arr[0]);
                            $tmp_arr = explode(')', $tmp_arr[1]);
                            $nb_article = trim($tmp_arr[0]);
                            
                            $a = $this->M_Article->getByNom($libelle_article);
                            if (!is_null($a)) {
                                
//                            $lc = new M_Ligne_Commandes();
                                $lc = $this->M_Ligne_Commandes->initialisation(array(
                                    'id_ligne_commande' => null,
                                    'id_commande' => $id_commande,
                                    'id_article' => $a->get('id_article'),
                                    'quantite_demande' => $nb_article,
                                    'quantite_reelle' => 0,   
                                ));
                                $this->M_Ligne_Commandes->insert($lc);
                            }
                        }
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