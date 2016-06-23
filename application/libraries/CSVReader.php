<?php

/**
 * Description of csvReader
 *
 * @author NB05125S
 */
class CSVReader {

    protected
            $_file = null,
            $_colMap = array(),
            $_fileArr = array();

    public function __construct() {
        
    }

    public function initFile($file, $colMap) {
        
        $this->setFile($file);
        $this->setcolMap($colMap);

        return $this;
    }

    public function setFile($file) {
        try {
            $fileH = fopen($file, 'r');
            $this->_file = $file;
            fclose($fileH);
        } catch (Exception $e) {
            throw new Exception;
        }
    }

    public function setcolMap($colMap) {
        if (is_array($colMap)) {
            $this->_colMap = $colMap;
        } else {
            throw new Exception;
        }
    }

    public function getcolMap() {
        return $this->_colMap;
    }

    //Fonction utilisé dans mactor à éclaircir
//    public function load() {
//        $fileH = fopen($this->_file, 'r');
//
//        $arrRow = array();
//        $arrFields = array();
//
//        while ($lg = fgets($fileH)) { //Pour chaque ligne du fichier CSV :
//            if (trim($lg)) { //Si la ligne courante n'est pas vide on la traite
//                $lg = str_ireplace(chr(160), '', $lg);
//                $lg = mb_convert_encoding($lg, 'UTF-8');
//                $lg = mb_strtolower($lg, 'UTF-8');
//                $lg = str_ireplace(array("\r\n", "\r", "\n"), ' ', $lg);
//                $arrRow = explode(';', $lg);
//
//                foreach ($this->_colMap as $fieldName => $fieldValues) {
//                    if (isset($arrRow[$fieldValues['csv_column'] - 1])) {
//                        $arrFields[$fieldName] = trim($arrRow[$fieldValues['csv_column'] - 1]);
//                    } else {
//                        fclose($fileH);
//                        return 'Le fichier que vous avez fourni ne correspond pas aux exigences du fichier de configuration.<br />' .
//                                'Vérifez les champs de votre fichier ainsi que la configuration existante pour ce type d\'import.';
//                    }
//                }
//                $this->_fileArr[] = $arrFields;
//            }
//        }
//        fclose($fileH);
//        return $this->_fileArr;
//    }

    /*
     * 
     */

    public function recupDonnees() {
        $fileH = fopen($this->_file, 'r');

        $arrRow = array();
        $arrDonnees = array();
        $ligne_entete = array();
        $numero_ligne = 0;
        
        
        //prepare le tableau configurer plus avant
        foreach ($this->_colMap as $key => $value)
        {
            $value = str_ireplace(chr(176), '', $value);
            $value = mb_convert_encoding($value, 'ISO-8859-1');
            $value = str_ireplace(array("\r\n", "\r", "\n"), ' ', $value);
            $value = strtolower($value);
            $tab_rechercher[$key] = $value;
        }

        while ($lg = fgets($fileH)) { //Pour chaque ligne du fichier CSV :
            if (trim($lg)) { //Si la ligne courante n'est pas vide on la traite
                
                $lg = str_ireplace(array(chr(160), chr(176), '"'), '', $lg);
                $lg = str_ireplace(chr(13), ';', $lg);
//                var_dump($lg);
//                exit(0);
//                $lg = str_replace('","', '";"', $lg);
                $lg = strtolower($lg);
                $arrRow = explode(';', $lg);

                if ($numero_ligne < 1) 
                {//C'est la première ligne donc l'entete
                    $ligne_entete = $arrRow;
                    //Avant d'aller plus loin je vérifie que tout les champ de données sont disponible
                    if(!$this->verifChampEntete($tab_rechercher, $ligne_entete))
                            return 'champ_non_renseigne';
                    else
                        $index_colone = $this->initIndexColonne($tab_rechercher, $ligne_entete);
                } 
                else 
                {
                    foreach ($tab_rechercher as $fieldName => $fieldValues) 
                    {
                            $encode = htmlentities(trim($arrRow[$index_colone[$fieldValues]]));
//                            $val = mb_convert_encoding($encode, 'UTF-8');
                            $arrDonnees[$fieldName] = $encode;
                    }
                    
                    $this->_fileArr[] = $arrDonnees;
                }
                $numero_ligne ++;
            }
        }
        fclose($fileH);
        if(count($this->_fileArr) > 0)
            return $this->_fileArr;
        else
            return 'fichier_vide';
    }
    
    /*
     * On lui passe deux tableau une est l'entete d'un fichier csv l'autre est les champ rechercher dans ce fichier il verifie
     * que les champ rechercher soit bien dans le fichier
     */
    private function verifChampEntete($tab_rechercher, $tab_renseigner)
    {
        $tab_test = array_intersect($tab_rechercher, $tab_renseigner);
        
        if(count($tab_rechercher) == count($tab_test))
            return true;
        else
            return false;
    }
    
    /*
     * cette fonction permet de retourner un tableau indiquant à quelle numéro de colone se trouve les information rechercher
     */
    private function initIndexColonne($tab_rechercher, $tab_renseigner)
    {
        foreach($tab_rechercher as $val)
            $tab_index[$val] = array_search($val, $tab_renseigner);
        
        return $tab_index;
    }
}