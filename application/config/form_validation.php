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
      'rules' => 'trim',
    ),
    array(
      'field' => 'mot_de_passe',
      'label' => 'Mot de passe',
      'rules' => 'trim|callback__connexionCheck',
    ),
  )
 );
