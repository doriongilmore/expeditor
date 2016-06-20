<div id="page_erreur" class="bloc light-green-white quatre_vingt_pourc" >
  <h2><?php echo $titre; ?></h2>
  <div class="middle clear_fix">

    <div class="round content_block">

      <h5><?php echo $h2; ?></h5>
      <div style="width:100%;">
<?php
  if(isset($types_contenu) && ! $this->session->userdata('identifiant'))
  {
    echo '<ul>';

    foreach ($types_contenu as $name => $val)
    {
      $page = $this->data['titre'] == '403' ? 'authentification' : 'accueil';
      echo '<li>'.anchor(str2url($val).'/'.$page, 'Portail version '.$val).'</li>';
    }
    
    echo '</ul>';
  }
?>
      </div>

    </div>

    <div class="round content_block" style="_height:0;">
      <div id="infos_titles">
        <h2>
          <?php echo mailto($this->config->item('mail', 'portail').'?subject=Incident '.$this->config->item('name', 'portail'), 'Contact'); ?>
        </h2>
      </div>

      Si vous êtes confronté à un problème concernant l'utilisation de l'application vous pouvez contacter
      les administrateurs de l'outil via la boite mail générique
      <?php echo mailto($this->config->item('mail', 'portail').'?subject=Incident '.$this->config->item('name', 'portail'), 'DC-DP_P-DVOUEST-MCO-DEV/F/EDF/FR'); ?>.

    </div>

  </div>
</div>