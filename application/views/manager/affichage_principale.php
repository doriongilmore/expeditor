 <div id="Commande">
        <!--<form method="post" action="">-->
            
            <div id="Statistique">
                
                <h3>Statistique</h3>
                <table class="table table-striped table-bordered">
                    <thead class="">
                    <th>Employé</th><th>Nombre de commande</th>
                    </thead>
                    <tbody>
                        <?php                    

                           foreach($statistique as $data){
                            ?>
                            <tr>
                                <td><?php echo $data['emp']->get('nom') ; ?></td>
                                <td><?php echo $data['nb'] ; ?></td>
                            </tr>
                           <?php } ?>
                    </tbody>
                </table>
            </div><br/>
            
            <h3>Importer les commandes</h3>
            
            <?php echo form_open_multipart('') ?>
            <?php // echo form_upload('Fichier Commandes Clients', array('name'=>'upload','class' => 'parcourir', 'id'=>'file_upload')) ?>
            <div class="form_row">
                <br/>
                <div class="field">
                    <?php echo form_upload(array('name'=>'upload','class' => 'parcourir', 'id'=>'file_upload'));?>
                </div>
            </div>
            <br/>
            <br/>
            <br/>
            <div class="btn-group-sm">
            <!--<a href id="btnUpdate" value="Modifier" class="btn btn-warning">Modifier</a>-->
                <input type="submit" value="Importer" class=" btn btn-default"  />
            </div>
            <?php echo form_close() ?>
            <br/>
            
            <h3>Toutes les commandes à traiter</h3>
            <div id="Commandes">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="">
                                <th>N° Commandes</th><th>Statut</th><th>Employé</th><th></th><th></th>
                            </thead>
                            <tbody id="myTable">
                                <?php foreach($commandes as $m_commandes){ 
                                    $m_utilisateur = $m_commandes->get('utilisateur');
                                    ?>
                                    <tr>
                                        <td><?php echo $m_commandes->get('num_commande') ; ?></td>
                                        <td class="etat"><?php echo $m_commandes->get('etat') ; ?></td>
                                        <td class="utilisateur"><?php echo (!is_null($m_utilisateur) )?$m_utilisateur->get('nom') . ' ' . $m_utilisateur->get('prenom') : " --- "; ?></td>
                                        <!--<td><?php if(!is_null($m_utilisateur)  ){echo $m_utilisateur->get('nom') ;}else{echo " --- ";} ?></td>-->
                                        <td><button id="btnConsulter" href class="btn btn-info consulter" onclick="OnClickConsulter(<?php echo $m_commandes->get('id_commande') ;  ?>)"><i class="fa fa-beer" aria-hidden="true"></i></button></td>
                                        <?php if($m_commandes->get('id_etat')== ETAT_EN_COURS){ ?>
                                        <td><button id="btnLiberer" href class="btn btn-danger liberer" onclick="OnClickLiberer(<?php echo $m_commandes->get('id_commande') ;  ?>, this )">Libérer</button></td>
                                        <?php }else{ ?>
                                         <td><button id="btnLiberer" href class="btn disabled liberer" >Libérer</button></td>
                                       <?php }?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
         <div class="col-md-12 text-center">
            <ul class="pagination pagination-lg pager" id="myPager"></ul>
        </div>
            
            
        <!--</form>-->
    </div>

<script>
    
    function OnClickLiberer(id_commande, object){
        var url = URI + 'ajax/liberer/'+id_commande;
        var res = requeteAjax(url);
       $(object).removeClass("btn-danger");
       $(object).addClass("disabled");
       $(object).parent().parent().children(".etat").html("En attente");
       $(object).parent().parent().children(".utilisateur").html(" --- ");
        return res;
    }
    
    function OnClickConsulter(id_commande){
        document.location.href="c_manager/affichageCommande/"+id_commande
        
    }
    
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 7,
            showPrevNext: false,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);
    
    var listElement = $this;
    var perPage = 10; 
    var children = listElement.children();
    var pager = $('.pager');
    
    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }
    
    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }
    
    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);

    pager.data("curr",0);
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
    }
    
    var curr = 0;
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
    }
    
    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
  	pager.children().eq(1).addClass("active");
    
    children.hide();
    children.slice(0, perPage).show();
    
    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });
    
    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }
     
    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }
    
    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;
        
        children.css('display','none').slice(startAt, endOn).show();
        
        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }
        
        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }
        
        pager.data("curr",page);
      	pager.children().removeClass("active");
        pager.children().eq(page+1).addClass("active");
    
    }
};

$(document).ready(function(){
    
  $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:4});
    
});    
</script>
