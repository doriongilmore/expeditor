<!-- Début de la colonne gauche -->
<div class="columns_left">

  <!-- Début auth -->
  <div class="box box_sky">
    <div class="top_left png_fix">
      <div class="top_middle">
        <div class="top_right">
        </div>
      </div>
    </div>

    <div class="middle_left">
      <div class="middle_right">
        <div class="misc_cartouche">
          <h2 class="tt_cartouche">Paramètres du PORTAIL :</h2>
          <div class="size_pad" ><!--id="bg_key"-->
<?php
  if($this->session->userdata('identifiant'))
  {
    echo '<p>Bienvenue '.ucwords(cStr($this->User->prenom.' '.$this->User->nom)).'.<p><br />';
    echo '<p>Environnement : <b>'.cStr($this->TypeContenu->getLib()).'</b><p><br />';
    echo anchor('authentification/deconnexion', 'Se déconnecter', array('class' => 'btn_large btn_link', 'title' => 'Se déconnecter du portail'));
  }
  else
  {
    echo anchor('authentification', 'Connexion au Portail', array('class' => 'btn_large btn_link', 'title' => 'Accès au formulaire de connexion'));
    echo form_open('utilisateur/choix_contenu', array('name' => 'choix_contenu', 'style' => 'margin-top:5px;'));
    //echo '<label>Choix de l\'environnement :';
    //echo form_dropdown('type_contenu', $types_contenu, $sideBarContenuDefault);
    //echo '</label>';
    echo form_row_select(array('name' => 'type_contenu', 'label_value' => 'Choix de l\'environnement :', 'id' => ''), $types_contenu, false, $sideBarContenuDefault);
    echo form_close();
  }
?>
          </div>
        </div>
      </div>
    </div>

    <div class="bottom_left png_fix">
      <div class="bottom_middle">
        <div class="bottom_right png_fix"></div>
      </div>
    </div>
  </div>
  <!-- Fin de auth -->

  <!-- Début recherche annuaire -->
  <div class="box box_sky">
    <div class="top_left png_fix">
      <div class="top_middle">
        <div class="top_right">
        </div>
      </div>
    </div>

    <div class="middle_left">
      <div class="middle_right">
      <div class="misc_cartouche">
        <h2 class="tt_cartouche">Rechercher une personne :</h2>
        <div class="size_pad" id="bg_magnifying_glass">
<?php echo form_open('mouv/recherche_simple', array('name' => 'sidebar_search')); ?>
<?php
  echo my_form_input(array('name' => 'sb_nom', 'value' => 'Nom', 'class' => 'input_border in_txt', 'style' => 'margin-bottom:5px;'));
  echo my_form_input(array('name' => 'sb_identifiant', 'value' => 'Identifiant', 'class' => 'input_border in_txt'));
  echo form_submit(array('value' => 'Lancer la recherche', 'class' => 'btn_large'));
  echo form_close();
?>          
          <?php echo anchor('mouv/recherche', 'Recherche avancée', array('class' => 'center', 'style' => 'margin-top:5px;display:block;')); ?>
        </div>
      </div>
     </div>
    </div>

    <div class="bottom_left png_fix">
      <div class="bottom_middle">
        <div class="bottom_right png_fix"></div>
      </div>
    </div>
  </div>
  <!-- Fin recherche annuaire -->

  <!-- Début recherche liens utiles -->
  <div class="box box_sky">
    <div class="top_left png_fix">
      <div class="top_middle">
        <div class="top_right">
        </div>
      </div>
    </div>

    <div class="middle_left">
      <div class="middle_right">
      <div class="misc_cartouche">
        <h2 class="tt_cartouche">Rechercher dans le contenu :</h2>
        <div class="size_pad" id="bg_magnifying_glass">
<?php
  echo form_open('contenu/recherche_simple', array('name' => 'recherche_contenu'));
  echo my_form_input(array('name' => 'sb_search', 'value' => 'Recherche', 'class' => 'input_border in_txt'));
  echo form_submit(array('value' => 'Lancer la recherche', 'class' => 'btn_large'));
  echo form_close();
?>
        </div>
      </div>
     </div>
    </div>

    <div class="bottom_left png_fix">
      <div class="bottom_middle">
        <div class="bottom_right png_fix"></div>
      </div>
    </div>
  </div>
  <!-- Fin recherche liens utiles -->
</div>
<!-- Fin de la colonne gauche -->