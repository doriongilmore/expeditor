<?php
  /**
   * MY_Model servira de base aux modÃ¨les accÃ¨dant Ã  la BDD.
   *
   * CI ne permettant pas l'utilisation de modÃ¨les abstraits, chaque classe héritant de MY_Model devra initialiser la propriété
   * dbParam de son propre chef.
   * 
   */

class MY_Model extends CI_Model
{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get($key){
        return $this->$key;
    }
    
    public function set($key, $value){
        $this->$key = $value;
    }
    
    /**
     * 
     * @param $tabInfo peut être un tableau de données, un objet MY_Model ou un objet venant d'une fonction d'un m_bd
     * @return \MY_Model
     */
    public function initialisation($tabInfo){
        $clone = clone $this ;
        if (is_null($tabInfo))
            return null;
        foreach ($clone as $key => $value)
            if (is_array($tabInfo))
                $clone->set($key, (array_key_exists($key, $tabInfo)?$tabInfo[$key]:null) );
            else{
                if ($tabInfo instanceof MY_Model) $clone->set($key, $tabInfo->get($key) );
                else{
                    $tabInfo = (array)$tabInfo; 
                    $clone->set($key, (array_key_exists($key, $tabInfo)?$tabInfo[$key]:null) );
                }
            }
        return $clone;
    }
    
    /**
     * 
     * @param $tabInfo peut être un tableau de données, un objet MY_Model ou un objet venant d'une fonction d'un m_bd
     * @return \MY_Model
     */
    public function array_initialisation($tabInfo){
        if (!is_array($tabInfo)) return null;
        $return_array = [];
        
        foreach ($tabInfo as $model){
            $clone = clone $this;
            $return_array[] = $clone->initialisation($model) ;
        }
        return $return_array;
    }
    
    
    
    
    public function getById($table, $id)
    {
        $this->db->select('*',false)
                 ->from($table . ' t')
                 ->where('t.id_'.$table, $id);
        $res = $this->db->get()->result();
        if (empty($res))
            return null;
        return $res[0];
    }
    
    public function getAll($table)
    {
        $this->db->select('*',false)
                 ->from($table);
        $res = $this->db->get()->result();
        if (empty($res))
            return null;
        return $res;
    }
    
    
    public function findBy($table, $champ, $value){
        $this->db->select('*')
                 ->from($table)
                 ->where($champ,$value);
        $res = $this->db->get()->result();
        if(empty($res))
            return null;
        return $res;
    }
    
    public function insert($table, $data, $multiIds = false)
    {
        $arrayData = [];
        if(!is_array($data))
            foreach ($data as $key => $value)
                $arrayData[$key] = $data->get($key) ;
        else
            $arrayData = $data;
        if ($multiIds)
            return $this->db->insert($table,$arrayData);
        $this->db->insert($table,$arrayData);
        
        return $this->db->insert_id();
    }
    
    public function delete($table, $id){
        $this->db->delete($table, array("id_".$table => "$id")); 
        $retour = ($this->db->affected_rows() > 0)?true:false;
        return $retour ;
    
    }
    
    
    public function update($table, $data)
    {
        $arrayData = [];
        if(!is_array($data))
            foreach ($data as $key => $value)
                $arrayData[$key] = $data->get($key) ;
        else
            $arrayData = $data;
        $this->db->where('id_' . $table, $data->get('id_'.$table));
        $this->db->update($table, $arrayData);
        $retour = ($this->db->affected_rows()>0)?true:false;
        return $retour ;
        
    }
    
    
    
    
    
    
    
    
}