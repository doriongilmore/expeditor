<div id="container_connexion" class="bloc light-green-white js-auto-height direct-access">
    <h2>
        <u>Connexion</u>
    </h2>
      <?php if (validation_errors()): ?>
          <div class="form_errors_search error_msg">
            <ul>
        <?php echo validation_errors(); ?>
            </ul>
          </div>
      <?php endif; ?>
    <?php 
        echo form_open('/connexion/authentification',array('id'=>'Connexion','method'=>'post','name'=>'connexion'));
            echo form_row_input(array('class'=>'text','name'=>'identifiant_user', 'id' => 'identifiant_user','label_value'=>'Identifiant(NNI) :'),  set_value('identifiant_user'));
            echo form_row_password(array('class'=>'text','name'=>'mot_de_passe', 'id' => 'pwd_field','label_value'=>'Mot de passe(SESAME) :'));
            echo form_submit(array( "id"=>"connect",'name' => 'authentification'), 'VALIDER');
        echo form_close(); 
        ?>
</div>