<?php

/**
 * Description of ajax :
 * Controller dédié aux requêtes asynchrones de technologie AJAX.
 * Il n'hérite pas de "MY_Controller" afin d'éviter de lancer des requêtes d'initialisation inutiles.
 *
 * date 30 juin 2011
 */
//class ajax extends CI_Controller {
class ajax extends MY_Controller {

    public $showAll = false;
    
    public function __construct() {
        parent::__construct();
        
        // permet de recuperer mes variable sessions dans ma requete ajax pour ensuite les utiliser
//        session_name('dco_global_session');
//        session_start();
        
        if (!$this->input->is_ajax_request())
            redirect('c_erreur/page_interdite', 'refresh');
    }
    /**
     * Méthode renvoyant une liste d'options HTML en fonction d'un texte envoyé en POST
     * 
     * Seul les association champs/tables présentes dans le tableau $field sont autoriées.
     * Il est donc nécessaire de mettre à jour ce tableau pour ajouter une autocomplétion.
     *
     * Le champ duquel provient la requete, est présent dans le troisième segment de l'URI.
     * Par exemple : "ajax/autocompletion/emploi"
     */
    public function autocomplete($p = '') {

        /**
         * Mappages des autocomplétions de l'ensemble du portail avec les modèles concernés.
         * Si getId est à true, la rechecher renverra une liste d'options avec un id en value.
         */
        $fields = array(
            '_user' => array('model' => 'm_bdutilisateur', 'get_id' => true),
            '_cdt' => array('model' => 'm_bdcdt', 'get_id' => true),
        );

        $str = '';
        $fieldName = strtolower($p);

        /**
         * Si le champ demandé est présent dans $fields et
         * qu'une requête POST a bien été envoyée.
         */
        if (array_key_exists($fieldName, $fields)
                && $this->input->post('reqVal')) {
            $modelName = $fields[$fieldName]['model'];
            $this->load->model('table/' . $modelName);

            /** Le modèle est interrogé avec la valeur en provenance du POST */
            $res = $this->$modelName->getAllByLibelle($this->input->post('reqVal'));
            
            foreach ($res as $row) {
                /** Si il s'agit d'une autocomplétion avec identifiant en value, on valorise l'attribut value="" */
                if ($fields[$fieldName]['get_id'])
                    $val = 'value="' . $row->identifiant . '"';
                else
                    $val = '';

                $str .= '<option ' . $val . ' >' . $row->libelle . '</option>';
            }
        }
        /** Envoi des résultats au client sous forme de texte */
        $this->output->set_content_type('txt');
        $this->output->set_output($str);
    }

    public function deleteServerFile($filename){
//        $this->load->model('simple/m_utilisateur', '_user');
        $this->load->model('simple/m_situation');
        
        $folder = './web/files/';
        if (file_exists($folder.$filename)) {
            $id = explode('_', $filename);
            $cdt = false;
            foreach ($id as $string) {
                if ($string == "cdt")
                    $cdt = true;
            }
            $id = $id[3];
            if ($cdt)
                $bool = $this->m_situation->supprimerPieceJointe($id, true) ;
            else
                $bool = $this->m_situation->supprimerPieceJointe($id) ;
        }else{
            $folder .= 'temp/';
            if (file_exists($folder.$filename))
                $bool = true ;
            else{
                echo 'true';
                exit(0);
            }
        }
        if ($bool){
            $link = $folder.$filename ;
            if (unlink($link))
                echo 'true';
            else
                echo 'false';
        }else
            echo 'false';
    }
    
    public function cdtBySite($id_site) {
        if ($id_site == 0) 
            $id_site = null ;
        
        $this->load->model('table/m_bdsituation');
        $res = $this->m_bdsituation->getCdtBySite($id_site);
        $str = '';
        
        foreach ($res as $object) {
            $val = 'value="' . $object->id . '"';
            $str .= '<option ' . $val . ' >' . $object->libelle . '</option>';
        }
        
        echo $str;
    }

    public function debloquerSD($id_sd) {
        $this->load->model('simple/m_situation');
        $sd = $this->m_situation->debloquerSD($id_sd);
        if (is_null($sd->get('lecteur')))
            echo 'true';
        else
            echo 'false';
    }
    
}