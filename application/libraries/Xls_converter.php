<?php
  /**
   * XLSConverter opère la conversion d'arrays en fichiers .xls
   * date 22 juil. 2011
   */

class XLS_Converter
{
  /** Stocke les données préparées pour la conversion */
    private $_processedDatas    = array();

    /** Stocke le fichier .xls finalisé */
    private $_finalizedXLSFile = null;


    /** Constructeur qui charge la librairie XLS_Writer de pear */
    public function  __construct($p = array())
    {
        require_once 'pear_xls_writer/Writer.php';
    }


  /**
   * Traitement des données d'un array clef valeur pour la création d'un fichier XLS.
   * Les clefs textes du array deviendront les noms du fichier xls.
   *
   * @param Array Les données à préparer.
   * @return Array Les données préparées.
   */
    public function processDatas($arrDatas)
    {
        $arr      = array();

        $lg = count($arrDatas);
        for ($i = 0; $i < $lg; $i++)
        {
        foreach ($arrDatas[$i] as $key => $val)
        {
            $arr[$i][]                  = utf8_decode($val);
            $arr[$i][utf8_decode($key)] = utf8_decode($val);
        }
        }

        $this->_processedDatas = $arr;

        return $this->_processedDatas;
    }


  /**
   * Effectue la conversion en fichier XLS du tableau préparé avec "processData".
   * 
   * @param String $fileName Le nom du fichier final :
   *        Si le nom est fournie, le fichier sera écrit sur le disque.
   *        Sinon il sera renvoyé comme une chaine.
   * 
   * @param Array $arr Si fournit, les données éventuellement préparées avec "processData" ne seront pas utilisées.
   */
    public function convert($fileName = '', $arr = array())
    {
        if ( ! $arr && $this->_processedDatas)
        $arr = $this->_processedDatas;
        else
        return false;

        $workbook   =  new Spreadsheet_Excel_Writer($fileName);
        $worksheet  =& $workbook->addWorksheet('Classeur 1');// Création d'une feuille de travail

        /** Création du style de titre */
        $head_format =  $workbook->addformat();
        $head_format -> setBold();

        /** Création des colonnes */
        if(isset($arr[0]) && $arr[0])
        $arr_col_name = array_keys($arr[0]);
        else
        return false;

        $i=0;
        foreach($arr_col_name as $col_name)
        {
            if(!is_numeric($col_name))
            {
                $worksheet->write(0, $i, $col_name, $head_format);
                $i++;
            }
        }

        /** Remplissage du tableau **/
        for($i=0;$i<count($arr);$i++)
        {            
            for($j=0;$j<(count($arr[$i])/2); $j++){
                $index = strpos($arr[$i][$j], 'http') ;
                if ($index !== false && $index >= 0)
                    $worksheet->writeUrl ( $i+1, $j , $arr[$i][$j]);
                else
                    $worksheet->writeString($i+1, $j, $arr[$i][$j]);
            }
        }
        /** Transmission des données sous forme de fichier ou de chaine,
        *  en fonction de la présence de $fileName.
        *  Si $fileName, on renvoie un fichier
        *  Sinon une chaine.
        */
        if ($fileName)
        {
        $workbook->close();
        $this->_finalizedXLSFile = $fileName;
        }
        else
        {
        ob_start();
        $workbook->close();
        $this->_finalizedXLSFile = ob_get_contents();
        ob_end_clean();
        }
    }


  /**
   * Permet de récupérer le fichier XLS créé avec convert().
   *
   * @return Resource Le fichier créé en amont ou false.
   */
    public function getFile()
    {
        if ($this->_finalizedXLSFile)
        return $this->_finalizedXLSFile;

        return false;
    }
  
    public function read_xls($file)
    {
        require_once 'PHPExcel/IOFactory.php';
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        //return de la première feuille du xls
        return $objPHPExcel->getSheet(0);

    }
  
    public function recupDonnees_xls($file, $tab_champ)
    {
        $num_ligne = 0;  
        $sheet = $this->read_xls($file);
        $tab_retour = array();
        $tab_index = array();
        $entete = array();
        
        $num_ligne = 0;
        //parcours de la table xls
        foreach($sheet->getRowIterator() as $row) {
            if($num_ligne == $num_ligne)
            {
                foreach ($row->getCellIterator() as $cell) {
                    $entete[] = $cell->getValue();
                }
                if(!$this->verifChampEntete($tab_champ, $entete))
                    return 'champ_non_renseigne';
                else
                    $tab_index = $this->initIndexColonne($tab_champ, $entete);
            }
            elseif($num_ligne > $num_ligne)
            {
                $tab_temp = array();
                $ligne = array();
                foreach ($row->getCellIterator() as $cell) {
                    $ligne[] = $cell->getValue();
                }
                foreach ($tab_champ as $fieldName => $fieldValues) {
                        $tab_temp[$fieldName] = trim($ligne[$tab_index[$fieldValues]]);
                }
                $tab_retour[] = $tab_temp;
            }   
            $num_ligne ++;
        }
        
        if(count($tab_retour) > 0)
            return $tab_retour;
        else
            return 'fichier_vide';
    }
    
    private function verifChampEntete($tab_rechercher, $tab_renseigner)
    {
        $tab_test = array_intersect($tab_rechercher, $tab_renseigner);
        
        if(count($tab_rechercher) == count($tab_test))
            return true;
        else
            return false;
    }
    
    private function initIndexColonne($tab_rechercher, $tab_renseigner)
    {
        foreach($tab_rechercher as $val)
            $tab_index[$val] = array_search($val, $tab_renseigner);
        
        return $tab_index;
    }

    public function convert_xls_to_csv($file)
    {
        require_once 'PHPExcel/IOFactory.php';
        $fileType=PHPExcel_IOFactory::identify($file);
        $objReader = PHPExcel_IOFactory::createReader($fileType);
        $objReader->setReadDataOnly(true);   
        //lecture fichier
        $objPHPExcel = $objReader->load($file);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        $objWriter->setDelimiter(';');
        $name_csv = str_replace('.xls', '.csv', $file);
        if(file_exists($name_csv))
            unlink($name_csv);
        $objWriter->save($name_csv);
        return $name_csv;
    }

//    public function convert_csv_to_csv($file)
//    {
//        require_once 'PHPExcel/IOFactory.php';
//        $fileType=PHPExcel_IOFactory::identify($file);
//        $objReader = PHPExcel_IOFactory::createReader($fileType);
//        $objReader->setReadDataOnly(true);   
//        //lecture fichier
//        $objPHPExcel = $objReader->load($file);
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
//        if($objWriter->getDelimiter() == ',')
//        {
//            $objWriter->setDelimiter(';');
//            if(file_exists($file))
//                unlink($file);
//            $objWriter->save($file);
//        }
//        return $file;
//    }
}