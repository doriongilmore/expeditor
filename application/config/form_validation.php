<?php
/**
 * Description of form_validation
 * date 20 juin 2011
 */

/**
 * Astuce pour attribuer les mêmes règles de validations à différents pages/formulaires...
 * Ce tableau est utilisé pour "mouv/recherche" et "mouv/export_recherche".
 */
$config = array(
  'authentification' => array(
    array(
      'field' => 'identifiant_user',
      'label' => 'Identifiant',
      'rules' => 'trim|callback__habilitationCheck',
    ),
    array(
      'field' => 'mot_de_passe',
      'label' => 'Mot de passe',
      'rules' => 'trim|callback__connexionCheck',
    ),
  ),
  'habilitationUser' => array(
    array(
      'field' => 'check_habilitation_'.PROFIL_UTLISATEUR,
      'label' => 'Utilisateur',
      'rules' => 'requiredDateSiCocher|coherenceDate',
    ),
    array(
      'field' => 'check_habilitation_'.PROFIL_ADMIN,
      'label' => 'Administrateur',
      'rules' => 'requiredDateSiCocher|coherenceDate',
    )
  ),
  'creationSD' => array(
    array(
      'field' => 'lst_sites',
      'label' => 'Site',
      'rules' => 'select',
    ),
    array(
      'field' => 'lst_domaines',
      'label' => 'Domaine',
      'rules' => 'select',
    ),
    array(
      'field' => 'txt_libelle',
      'label' => 'Libelle',
      'rules' => 'required',
    ),
    array(
      'field' => 'txt_desc',
      'label' => 'Description',
      'rules' => 'required',
    )
  )
 );
