

<div id="container">

    <?php echo form_open_multipart('') ?>
    <?php // echo form_upload('Fichier Commandes Clients', array('name'=>'upload','class' => 'parcourir', 'id'=>'file_upload')) ?>
    <div class="form_row">
        <div class="label_field">
            <label>Fichier Commandes Clients</label>   
        </div>
        <div class="field">
            <?php echo form_upload(array('name'=>'upload','class' => 'parcourir', 'id'=>'file_upload'));?>
        </div>
    </div>
    <br/>
    <br/>
    <br/>
    <div class="btn-group-sm">
    <!--<a href id="btnUpdate" value="Modifier" class="btn btn-warning">Modifier</a>-->
        <input type="submit" value="Importer" class="btn btn-default"  />
    </div>
    <?php echo form_close() ?>
    

</div>
