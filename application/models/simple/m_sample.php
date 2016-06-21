<?php 

Class M_Sample extends MY_Model 
{
    protected $identifiant = null;
    protected $id_utilisateur = null;
    protected $id_role = null;
    protected $id_type = null;
    protected $date_debut = null;
    protected $date_fin = null;
    protected $entreprise = null;
    protected $lieu = null;
    protected $description_french = null;
    protected $description_english = null;
    protected $description_italian = null;

    public function __construct() {
        parent::__construct();
        $this->load->model('table/m_bdexperience');
    }

    public function get($key) {
        if (array_key_exists($key, get_object_vars($this))) 
            return parent::get($key);
        switch ($key) {
            case 'libelle_experience':
                $date_debut =  DateTime::createFromFormat('Y-m-d', $this->get('date_debut'))      ;
                $date_fin =  DateTime::createFromFormat('Y-m-d', $this->get('date_fin'))      ;
                $duree = date_diff($date_debut, $date_fin);
                $dates='';
                if ($duree->y >= 1){
                    $dates = date_format($date_debut, 'Y') . ' -> ' . date_format($date_fin, 'Y');
                }else{
                    $dates = intval($duree->m * 4 + $duree->d/7) . ' semaines';
                }
                $role = $this->get('role_libelle_french');
                $entreprise = $this->get('entreprise');
                $lieu = $this->get('lieu');
                $type = $this->get('type_libelle_french');
                
                $titre = $dates . ' - <strong>' . $role . '</strong> - <strong>' . $entreprise . '</strong> - ' . $lieu . ' - ' . $type;
                return $titre;
            case 'langages_utilises':
                $return = '';
                $langages = $this->get('langages');
                $count = count($langages);
                for ($i = 0; $i < $count ; $i++){
                    if ($i==0)
                        $return .= $langages[$i]->libelle_french;
                    else
                        $return .= ', '.$langages[$i]->libelle_french;
                }
                return $return;
            case 'logiciels_utilises':
                $return = '';
                $logiciels = $this->get('logiciels');
                $count = count($logiciels);
                for ($i = 0; $i < $count ; $i++){
                    if ($i==0)
                        $return .= $logiciels[$i]->libelle_french;
                    else
                        $return .= ', '.$logiciels[$i]->libelle_french;
                }
                return $return;
            default:
                break;
        }
    }
    
    /**
     * 
     * @param int $id
     * @return M_Competence
     */
    public function getById($id)
    {
        $res = $this->m_bdexperience->getById($id);
        
        if ($res === null) return null;
        
        $u = $this->initialisation($res);
        
        return $u;
    }
 
    /**
     * 
     * @param int $id
     * @return M_Competence
     */
    public function getByIdUtilisateur($id)
    {
        $res = $this->m_bdexperience->getByIdUtilisateur($id);
        
        if ($res === null) return null;
        
        $u = $this->array_initialisation($res);
        
        return $u;
    }
    
    public function getTypeById($id_type){
        $res = $this->m_bdexperience->getTypeById($id_type);
        if (empty($res))
            return null;
        return $res[0];
    }
    
    public function getRoleById($id_role){
        $res = $this->m_bdexperience->getRoleById($id_role);
        if (empty($res))
            return null;
        return $res[0];
    }
    
    public function getLangagesByIdExperience($id_experience){
        return $this->m_bdexperience->getLangagesByIdExperience($id_experience);
    }
    
    public function getLogicielsByIdExperience($id_experience){
        return $this->m_bdexperience->getLogicielsByIdExperience($id_experience);
    }
    
    public function getTachesByIdExperience($id_experience){
        return $this->m_bdexperience->getTachesByIdExperience($id_experience);
    }
    
    public function initialisation($tabInfo) {
        $clone = parent::initialisation($tabInfo);
        
        $type = $this->getTypeById($clone->id_type);
        if (!is_null($type)) {
            $clone->type_libelle_french = $type->libelle_french;
            $clone->type_libelle_english = $type->libelle_english;
            $clone->type_libelle_italian = $type->libelle_italian;
        }
        
        $role = $this->getRoleById($clone->id_role);
        if (!is_null($role)) {
            $clone->role_libelle_french = $role->libelle_french;
            $clone->role_libelle_english = $role->libelle_english;
            $clone->role_libelle_italian = $role->libelle_italian;
        }
        
        $clone->taches = $this->getTachesByIdExperience($clone->identifiant);
        $clone->langages = $this->getLangagesByIdExperience($clone->identifiant);
        $clone->logiciels = $this->getLogicielsByIdExperience($clone->identifiant);
        
        return $clone;
    }
    
}


    