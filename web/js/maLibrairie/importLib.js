
include('constant');
include('tableau');
include('message');
include('checkBox');
include('fenetre_modale');
include_css('fenetre_modale');
include('gestion_visuelle');
include('graph');
include('ecranChargement');
include('fonction_form');
include('gestion_tuile');
include('datepicker');
include('admin');
include('autocomplete');

function include(fileName){
document.write("<script type='text/javascript' src='web/js/maLibrairie/"+fileName+".js'></script>" );
}
function include_css(fileName){
document.write("<link href='web/css/"+fileName+".css' rel='stylesheet' type='text/css' media='screen' />" );
}

//permet de nettoyer les noeud idésirable sous FF
function clean(nde){
    var q, bal, p;
	bal=nde.getElementsByTagName('*');
	for(var j=0;j<bal.length;j++){
		if(!q){
			q=true
		}
		else{
			q=false;
			j++;
		}
 
                if(bal[j] != undefined)
                    p=bal[j].parentNode.childNodes;
		for(var i=0;i<p.length;i++){
			if(p[i].data && !p[i].data.replace(/\s/g,'')){
				p[i].parentNode.removeChild(p[i])
//                                alert("supprime");
			};
		}
	}
}