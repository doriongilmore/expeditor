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
    /*
     * Permet de configurer les tableau genere grace au helper "table helper"
     * une variable pour configurer plusieurs tableau d'une application
     * pour chaque tableau on peut configurer : 
     * libelle(string) => entete du tableau OBLIGATOIRE
     * cle(string) => valeur que l'on veut affiche correspond a la cle du tableau de donnee passer OBLIGATOIRE
     * trie(boolean) => true ou false si on veut ou pas activer le trie sur la colonne
     * nb_decimal(int) => un entier qui correspond au nombre de chiffre après la virgule des chiffres numeric
     * 
     * exemple : 
     * On veut affiché le tableau $toto['nom','prenom','age'] 
     * array(
            'var_tableau_toto' => array (
                        array('libelle'=>'Nom',
                                'cle'=>'nom',
                                'trie'=>true),
                        array('libelle'=>'Age',
                                'cle'=>'age',
                                'trie'=>false,
                                'decimal'=>0)
                    )
     */
     
    public $titre_tab = array(
                                'nom_tableau' => array (
                                            array('libelle'=>'entete colonne',
                                                    'cle'=>'cle du tableau',
                                                    'trie'=>true)
                                        )
        );
        
  public function __construct() {
        parent::__construct();
  }
  
}