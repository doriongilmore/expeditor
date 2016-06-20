<?php
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
     
$config['entete_tableau'] = array(
                                'tab_admin' => array (
                                            array(  'libelle'=>'NNI',
                                                    'cle'=>'nni',
                                                    'trie'=>true),
                                            array(  'libelle'=>'Nom',
                                                    'cle'=>'nom',
                                                    'trie'=>true),
                                            array(  'libelle'=>'Prenom',
                                                    'cle'=>'prenom',
                                                    'trie'=>true),
                                            array(  'libelle'=>'Profil',
                                                    'cle'=>'profil',
                                                    'trie'=>true)
                                        ),
                                'tab_situation' => array (
                                            array(  'libelle'=>'Date',
                                                    'cle'=>'date_creation',
                                                    'trie'=>true),
                                            array(  'libelle'=>'Site',
                                                    'cle'=>'site',
                                                    'trie'=>true),
                                            array(  'libelle'=>'Détecteur',
                                                    'cle'=>'detecteur',
                                                    'trie'=>true),
                                            array(  'libelle'=>'Etat',
                                                    'cle'=>'etat',
                                                    'trie'=>true),
                                            array(  'libelle'=>'Libellé',
                                                    'cle'=>'libelle',
                                                    'width'=>'100',
                                                    'trie'=>true),
                                            array(  'libelle'=>'Domaine',
                                                    'cle'=>'domaine',
                                                    'trie'=>true),
                                            array(  'libelle'=>'Chargé de traitement',
                                                    'cle'=>'cdt',
                                                    'trie'=>true),
                                        ),
                                'tab_affectation' => array (
                                            array(  'libelle'=>'Site',
                                                    'cle'=>'libelle_site',
                                                    'trie'=>false),
                                            array(  'libelle'=>'Nombre de chargés de traitement affectés',
                                                    'cle'=>'nb',
                                                    'trie'=>false)
//                                            array(  'libelle'=>'Modifier',
//                                                    'cle'=>'modif',
//                                                    'trie'=>false),
                                        ),
                                'tab_affectation_site' => array (
                                            array(  'libelle'=>'Nom',
                                                    'cle'=>'nom',
                                                    'trie'=>true),
                                            array(  'libelle'=>'Prénom',
                                                    'cle'=>'prenom',
                                                    'trie'=>true),
                                            array(  'libelle'=>'NNI',
                                                    'cle'=>'nni',
                                                    'trie'=>true)
//                                            array(  'libelle'=>'Supprimer',
//                                                    'cle'=>'suppr',
//                                                    'trie'=>false),
                                        ),
                            );