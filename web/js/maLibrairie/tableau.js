/*
 * Variable global
 */
var nbItemParPage = 1;

/*
 * Fin variable global
 */

function initNbPage(val)
{
    nbItemParPage = val;
}

/*
 * Déclencheur du tri du tableau 
 * clique sur une colone
 */
$(document).ready(function(){
    $('table').on('click','.tri_thead', function(){
        trie(this);
    });
});
/*
 *Fin déclencheur
 */


//Fonction permettant l'affichage de resultat dans UNE page
//nb_item = nombre d'item dans une page
//nom_tbody le nom du tableau au quelle on applique le traitement
function initAffichagePage(nom_tbody, nombre_item)
{
    var monBody = document.getElementById(nom_tbody);
    var i=0;
    
    while(monBody.rows[i] != undefined)
    {
        if(i >= nombre_item)
            monBody.rows[i].style.display="none";
        i++;
    }
}

//fonction permettant au tableau "tager" d'avoir un système de pages dynamique et un trie sur les colonnes automatique'
function changementPage(numPage,nb_items_par_page,tbody,nombre_total_page)
{
    nb_items_par_page = nbItemParPage;
    var premier_item = (numPage*nb_items_par_page);
    var dernier_item = (numPage*nb_items_par_page)+nb_items_par_page;
    var div_parent = document.getElementById(tbody);
    clean(div_parent);
    var div_parent_page = document.getElementById('entete_page');
    var i = 0; 
    var j = 0;
    var entier,tmp;
    var premiere_page_dynamique = 0,derniere_page_dynamique = 0;//sont les pages qui apparaitront dans les choix EXLUS la premiere et la derniere
    
    
    //Gestion des pages
    if(nombre_total_page > 10)
    {
        if(numPage >= 0 && numPage <= 4)
        {
            premiere_page_dynamique = 1;
            derniere_page_dynamique = 9;
        }

        if((nombre_total_page-numPage) < 5 && numPage <= nombre_total_page)
        {
            derniere_page_dynamique = nombre_total_page;
            premiere_page_dynamique = nombre_total_page-8;
        }

        if(numPage > 4 && (nombre_total_page-numPage) >= 5)
        {
            premiere_page_dynamique = (numPage-4);
            derniere_page_dynamique = (numPage+5);
        }

        while(div_parent_page.childNodes[0] != undefined )
            div_parent_page.removeChild(div_parent_page.childNodes[0]);

        ajouterPage(div_parent_page,0,nb_items_par_page,tbody,nombre_total_page,false);
        if(nombre_total_page >10 && numPage>=6)
            ajouterPage(div_parent_page,tmp,nb_items_par_page,tbody,nombre_total_page,'premier_nothing');

        for(tmp = premiere_page_dynamique;tmp < derniere_page_dynamique;tmp++)
            ajouterPage(div_parent_page,tmp,nb_items_par_page,tbody,nombre_total_page,false);

        if(nombre_total_page-numPage > 5)
            ajouterPage(div_parent_page,tmp,nb_items_par_page,tbody,nombre_total_page,'deuxieme_nothing');
        ajouterPage(div_parent_page,nombre_total_page,nb_items_par_page,tbody,nombre_total_page,false);
    }
    
     // Mozilla, Safari, ...
    if (navigator.appName == "Netscape") 
    {
        j=1;
    }
    else if (navigator.appName == "Microsoft Internet Explorer") 
    { // IE;
    }
         
        
    while(div_parent_page.childNodes[j] != undefined )
    {
        if(div_parent_page.childNodes[j].className != 'nothing')
            div_parent_page.childNodes[j].className = '';
        j++;
    }
    document.getElementById('page_'+numPage).className = 'current';
    
    //Fin de la gestion pages  

    while(div_parent.childNodes[i] != undefined )
            {
                if(div_parent.childNodes[i].style != undefined )
                    div_parent.childNodes[i].style.display = 'none';
                i++;
            }
    
    for(entier = premier_item; entier < dernier_item; entier++)
    {
        if(div_parent.childNodes[entier] != undefined)
            if(div_parent.childNodes[entier].style != undefined)
                div_parent.childNodes[entier].style.display = '';
    }
    
    
    
}
//Permet de creer le nombre de pages nécessaire pour le système de pages
function ajouterPage(baliseParent,num_page,nb_item,nom_tbody,total_pages,page_nothing)
{
    var nouvelle_page = document.createElement("li");
    if(!page_nothing)
    {
        nouvelle_page.id = "page_"+num_page;
        nouvelle_page.setAttribute("onClick", 'changementPage('+num_page+','+nb_item+',\''+nom_tbody+'\','+total_pages+')');
        nouvelle_page.innerHTML = num_page+1;
    }
    else
    {
        nouvelle_page.id = page_nothing;
        nouvelle_page.className = 'nothing';
        nouvelle_page.innerHTML = '...';
    }        
    
    baliseParent.appendChild(nouvelle_page);
    
}


/*
 * TRIE D'UN TABLEAU 
 * ordre croissant ou décroissant
 * Attention je récupère le numéro de l'entête qui va être trié si il y a des colonnes caché il faut prendre en compte ceci
 * !!!!Important l'index des colonnes commence A 0 !!!!!
 */
function trie(monEntete, castType)
{
    var leTbody;
    var leThead;
    var Tete_colonne;
    var monTableau = new Array();
    var type =false;
    var tmp_str; 
    var leTableau = monEntete.parentNode;
    var numColonne = 0;
    
    while(leTableau.tagName != 'TABLE')
        leTableau = leTableau.parentNode

    if(castType != undefined)
       type =castType;
    
    leThead = leTableau.getElementsByTagName('thead').item(0);
    clean(leThead);
    
    while(leThead.getElementsByTagName('th').item(numColonne).innerHTML != monEntete.innerHTML)
        numColonne++;
    
    Tete_colonne = leThead.firstChild.childNodes[numColonne];
    
    // j'initialise mon tableau qui va après subir le trie
    leTbody = leTableau.getElementsByTagName('tbody').item(0);
    
    monTableau = initTableau(leTbody);
    //je choisi le type de trie date, int ou string
    var index_ligne = 0;
    
    while(tmp_str == null || tmp_str == 0)
    {
        if(monTableau[index_ligne] == undefined)
            break;
        
        tmp_str = monTableau[index_ligne][numColonne];
        index_ligne = index_ligne + 1;
    }
    
    if(!type)
    {
        if(tmp_str != "")
            type = estUneDate(tmp_str);
    }
    if(!type)
    {
        if(tmp_str != "")
            type = estUnEntier(tmp_str);
    }
    if(!type)
    {
        type = 'string';
    }
    
    //je reinit les entetes pour eviter quelle soit bleue je compare pour sa les titre (string) des entetes
    var entier = 0;
    while(leThead.firstChild.childNodes[entier] != undefined)
    {
        if(leThead.firstChild.childNodes[entier].innerHTML != Tete_colonne.innerHTML && leThead.firstChild.childNodes[entier].id != undefined)
            leThead.firstChild.childNodes[entier].id = "";
        entier ++;
    }
    // je choisi par ordre croissant ou décroissant
    if(Tete_colonne.id == "" || Tete_colonne.id =="trie_decroissant")
    {
        Tete_colonne.id = "trie_croissant";
        monTableau = ordre_croissant(type,monTableau,numColonne);
    }
    else if(Tete_colonne.id == "trie_croissant")
    {
        Tete_colonne.id = "trie_decroissant";
        monTableau = ordre_decroissant(type,monTableau,numColonne);
    }
    
    
    // je fait apparaitre sur la page le nouveau tableau trier
    afficherTrie(monTableau,leTbody);
    
    
}

function estUnEntier(chaine) {
    var reg = new RegExp(/^[0-9 ]*[, ]?[0-9 ]*$/);

    if(reg.test(chaine))
    { // VERIFICATION DU FORMAT INT
        return 'int';
    } 
    return false;
}

function estUneDate(chaine) 
{
    var reg = new RegExp(/^[0-3]{1}[0-9]{1}[\/\-][0-1]{1}[0-9]{1}[\/\-][0-9]{4}$/);

    if(reg.test(chaine))
    { // VERIFICATION DU FORMAT JJ/MM/AAAA
        return 'date';
    } 
    reg = new RegExp(/^[0-3]{1}[0-9]{1}[\-][0-1]{1}[0-9]{1}[\-][0-9]{4}[ ]{1}[0-2]{1}[0-9]{1}[:H]{1}[0-5]{1}[0-9]{1}$/);
    if(reg.test(chaine))
    { // VERIFICATION DU FORMAT JJ/MM/AAAA
        return 'date';
    } 
    return false;
}

// initialise une variable et permet ainsi de remplir la variable du tableau complet
// on lui passe en parametre le tbody qui contient les valeur 
// il retourne en variable un tableau deux 2 dimention qui contient toute les info du tableau précédents

function initTableau(unTbody)
{
    var tableauTrier = new Array();
    
    var index_ligne = 0;
    while(unTbody.rows[index_ligne] != undefined)
    {
        var index_colonne = 0;
        tableauTrier[index_ligne] = new Array();
        while(unTbody.rows[index_ligne].cells[index_colonne] != undefined)
        {
            tableauTrier[index_ligne][index_colonne] = unTbody.rows[index_ligne].cells[index_colonne].innerHTML;
            if(unTbody.rows[index_ligne].cells[index_colonne].getAttribute("class") != undefined)
            {
                tableauTrier[index_ligne]["class_td"] = new Array();
                tableauTrier[index_ligne]["class_td"][index_colonne] = unTbody.rows[index_ligne].cells[index_colonne].getAttribute("class");
            }
            tableauTrier[index_ligne]["onclick"] = unTbody.rows[index_ligne].getAttribute("onclick");
            tableauTrier[index_ligne]["class"] = unTbody.rows[index_ligne].getAttribute("class");
            index_colonne++;
        }
        index_ligne++;
    }
    
    return tableauTrier;
}

function ordre_croissant(type_trie,tmp_tab,index)
{
    if(type_trie == "int")
        tmp_tab.sort(function(a, b){
            return getNumeric(a[index]) - getNumeric(b[index])
        })
  
    //je regarde quelle format va etre trier   
    if(type_trie == "string")
        tmp_tab.sort(function(a, b){
            var nameA=a[index].toLowerCase(), nameB=b[index].toLowerCase()
            if (nameA < nameB) //sort string ascending
                return -1
            if (nameA > nameB)
                return 1
            return 0 //default return value (no sorting)
        })
    
    //je regarde quelle format va etre trier   
    if(type_trie == "date")
        tmp_tab.sort(function(a, b){
            return getTimeByDate(a[index])-getTimeByDate(b[index]);
        })
        
    return tmp_tab
}

function ordre_decroissant(type_trie,tmp_tab,index)
{
    if(type_trie == "int")
        tmp_tab.sort(function(a, b){
            return getNumeric(b[index]) - getNumeric(a[index])
        })
  
    //je regarde quelle format va etre trier   
    if(type_trie == "string")
        tmp_tab.sort(function(a, b){
            var nameA=a[index].toLowerCase(), nameB=b[index].toLowerCase()
            if (nameA < nameB) //sort string ascending
                return 1
            if (nameA > nameB)
                return -1
            return 0 //default return value (no sorting)
        })
    
    //je regarde quelle format va etre trier   
    if(type_trie == "date")
        tmp_tab.sort(function(a, b){
            return getTimeByDate(b[index])-getTimeByDate(a[index]); //sort by date descending
        })
        
    return tmp_tab
}

function afficherTrie(unTableau,unTbody)
{
        var boolTotal = false;
        
        $(unTableau).each(function(index, value){
            $(value).each(function(ind, val){
                if(!boolTotal && val == 'TOTAL')
                {
                    unTableau.push(value);
                    unTableau.splice(index,1);
                    boolTotal = true;
                }
            });
        });
        
        var item_par_page = nbItemParPage;
     
        //calcul du nombre total d'item 
        var reste = unTableau.lenght % item_par_page;
        var total_pages = parseInt(unTableau.lenght/item_par_page);
        if(reste == 0)
            total_pages = total_pages-1;
     
     //j'efface toutes les lignes
        while(unTbody.rows[0] != undefined)
        {
            unTbody.deleteRow(-1);
        }
    // je rerempli le tableau avec mon nouveau tableau trier passer en paramètre    
        var numLigne = 0;
        while (unTableau[numLigne] != undefined)
        {
            var nouvelle_ligne = unTbody.insertRow(-1);
            nouvelle_ligne.id = "classicTrTrie";
            nouvelle_ligne.setAttribute("onclick", unTableau[numLigne]["onclick"]);
            nouvelle_ligne.setAttribute("class", unTableau[numLigne]["class"]);
            var numColonne = 0;
            while (unTableau[numLigne][numColonne] != undefined)
            {
                var nouvelle_cellule = nouvelle_ligne.insertCell(-1);
                nouvelle_cellule.innerHTML += unTableau[numLigne][numColonne];
                if(unTableau[numLigne]['class_td'] != undefined)
                    for(var increment in unTableau[numLigne]['class_td'])
                        if(unTableau[numLigne]['class_td'][increment] != undefined)
                            nouvelle_cellule.setAttribute("class", unTableau[numLigne]['class_td'][increment]);
                numColonne ++;
            }
            numLigne ++;
        }
        
      // puis je réinitialise mon changement de page par défaut je me met sur la page 0
      //Si il éxiste une entete page
      if(document.getElementById('entete_page') != null)
        changementPage(0, nbItemParPage, unTbody.id, total_pages);
}

// cette fonction permet de normaliser les numeric pour le trie
function getNumeric(num)
{
    var newNum = num
    
    while(newNum.match(' ') != null)
    {
        newNum = newNum.replace(' ','');
    }
    
    newNum = newNum.replace(',','.');
    if(newNum == 0)
        newNum = '';
    
    return newNum;
}

//cette fonction transforme un string en date
function getTimeByDate(date)
{
    var format = getFormatDate(date);
    var tabDate;
    var tmpDate;
    var tabHeure;
    
    switch(format)
    {
        case 'dd/mm/yyyy' :
            tabDate = date.split('/');
            return  new Date(tabDate[2],tabDate[1],tabDate[0]);
            break;
        case 'dd-mm-yyyy' :
            tabDate = date.split('-');
            return  new Date(tabDate[2],tabDate[1],tabDate[0]);
            break;
        case 'dd/mm/yyyy hhHii' :
            tmpDate = date.split(' ');
            tabDate = tmpDate[0].split('/');
            tabHeure = tmpDate[1].split('H');
            return  new Date(tabDate[2],tabDate[1],tabDate[0],tabHeure[0],tabHeure[1]);
            break;
        case 'dd/mm/yyyy hhhii' :
            tmpDate = date.split(' ');
            tabDate = tmpDate[0].split('/');
            tabHeure = tmpDate[1].split('h');
            return  new Date(tabDate[2],tabDate[1],tabDate[0],tabHeure[0],tabHeure[1]);
            break;
        case 'dd/mm/yyyy hh:ii' :
            tmpDate = date.split(' ');
            tabDate = tmpDate[0].split('/');
            tabHeure = tmpDate[1].split(':');
            return  new Date(tabDate[2],tabDate[1],tabDate[0],tabHeure[0],tabHeure[1]);
            break;
        case 'dd-mm-yyyy hhHii' :
            tmpDate = date.split(' ');
            tabDate = tmpDate[0].split('-');
            tabHeure = tmpDate[1].split('H');
            return  new Date(tabDate[2],tabDate[1],tabDate[0],tabHeure[0],tabHeure[1]);
            break;
        case 'dd-mm-yyyy hhhii' :
            tmpDate = date.split(' ');
            tabDate = tmpDate[0].split('-');
            tabHeure = tmpDate[1].split('h');
            return  new Date(tabDate[2],tabDate[1],tabDate[0],tabHeure[0],tabHeure[1]);
            break;
        case 'dd-mm-yyyy hh:ii' :
            tmpDate = date.split(' ');
            tabDate = tmpDate[0].split('-');
            tabHeure = tmpDate[1].split(':');
            return  new Date(tabDate[2],tabDate[1],tabDate[0],tabHeure[0],tabHeure[1]);
            break;
        default :
            return 0;
    }
}

//me permet de savori sous qu'elle format date est le string format différent retourner :
/*
 * - dd/mm/yyyy
 * - dd/mm/yyyy hhHii
 * - dd/mm/yyyy hhhii
 * - dd/mm/yyyy hh:ii
 * - dd-mm-yyyy
 * - dd-mm-yyyy hhHii
 * - dd-mm-yyyy hhhii
 * - dd-mm-yyyy hh:ii
 */
function getFormatDate(date)
{
    // dd/mm/yyyy
    var reg = new RegExp(/^[0-3]{1}[0-9]{1}[/][0-1]{1}[0-9]{1}[/][0-9]{4}$/);
    if(reg.test(date))
        return 'dd/mm/yyyy';
    
    // dd/mm/yyyy hhHii
    reg = new RegExp(/^[0-3]{1}[0-9]{1}[/][0-1]{1}[0-9]{1}[/][0-9]{4}[ ]{1}[0-2]{1}[0-9]{1}[H]{1}[0-5]{1}[0-9]{1}$/);
    if(reg.test(date))
        return 'dd/mm/yyyy hhHii';
    
    // dd/mm/yyyy hhhii
    reg = new RegExp(/^[0-3]{1}[0-9]{1}[/][0-1]{1}[0-9]{1}[/][0-9]{4}[ ]{1}[0-2]{1}[0-9]{1}[h]{1}[0-5]{1}[0-9]{1}$/);
    if(reg.test(date))
        return 'dd/mm/yyyy hhhii';
    
    // dd/mm/yyyy hh:ii
    reg = new RegExp(/^[0-3]{1}[0-9]{1}[/][0-1]{1}[0-9]{1}[/][0-9]{4}[ ]{1}[0-2]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$/);
    if(reg.test(date))
        return 'dd/mm/yyyy hh:ii';
    
    // dd-mm-yyyy
    reg = new RegExp(/^[0-3]{1}[0-9]{1}[-][0-1]{1}[0-9]{1}[-][0-9]{4}$/);
    if(reg.test(date))
        return 'dd-mm-yyyy';
    
    // dd-mm-yyyy hhHii
    reg = new RegExp(/^[0-3]{1}[0-9]{1}[-][0-1]{1}[0-9]{1}[-][0-9]{4}[ ]{1}[0-2]{1}[0-9]{1}[H]{1}[0-5]{1}[0-9]{1}$/);
    if(reg.test(date))
        return 'dd-mm-yyyy hhHii';
    
    // dd-mm-yyyy hhhii
    reg = new RegExp(/^[0-3]{1}[0-9]{1}[-][0-1]{1}[0-9]{1}[-][0-9]{4}[ ]{1}[0-2]{1}[0-9]{1}[h]{1}[0-5]{1}[0-9]{1}$/);
    if(reg.test(date))
        return 'dd-mm-yyyy hhhii';
    
    // dd-mm-yyyy hh:ii
    reg = new RegExp(/^[0-3]{1}[0-9]{1}[-][0-1]{1}[0-9]{1}[-][0-9]{4}[ ]{1}[0-2]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$/);
    if(reg.test(date))
        return 'dd-mm-yyyy hh:ii';
}