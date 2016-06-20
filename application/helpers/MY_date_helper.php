<?php

/**
 * Description of MY_date_helper
 * date 26 juil. 2011
 */
function mysql_to_human($date) {
    $syntaxe = '#^[0-9]{4}\-[0-9]{2}\-[0-9]{2}#';

    if (preg_match($syntaxe, $date)) {
        $tab_date = explode('-', $date);
        $new_date = substr($tab_date[2], 0, 2) . '-' . $tab_date[1] . '-' . $tab_date[0];

        return $new_date;
    }
    else
        return false;
}

function human_to_mysql($date) {
    $syntaxe = '#^[0-9]{2}\-[0-9]{2}\-[0-9]{4}$#';

    if (preg_match($syntaxe, $date)) {
        $tab_date = explode('-', $date);
        $new_date = $tab_date[2] . '-' . $tab_date[1] . '-' . $tab_date[0];

        return $new_date;
    }
    else
        return false;
}

function date_heureMinute_to_datetime($date, $heureMinute) {
    if (is_int($date))
        return date('d-m-Y H:i', $date);
    elseif (!is_null($date) && !empty($date))
        return date('d-m-Y H:i', strtotime($date.' '.$heureMinute));

    return false;
//    if(human_to_mysql($date) && heureMinute_correcte($heureMinute)){
//        $dateEng = human_to_mysql($date).' '.$heureMinute.':00';
//        return new DateTime($dateEng);
//    }
//    else
//        return null;
}

function heureMinute_correcte($heureMinute) {
    return preg_match('#^[0-9]{2}:[0-9]{2}$#', $heureMinute);
}

/*
 * Fonction permettant le calcul de jour ouvrable et/ou les heures de travail effective des CSIT
 * Avant il faut paramètrer les horraire de début et de fin dans une journé d'un csit dans le fichier des constants
 */
/*
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++ Module complémentaire ajout des horaires ++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 */

// On passe deux date a cette fonction (prend en compte les heures) et calculera le nombre d'heure 
// qu'aura passer le csit a faire le travail nuit week end et jour ferier retirer
// Jour ouvré : Jour férier et week end
// L'algo est le suivant 
/*
 * Le temps Total (TT) est le temp fin (TF) moins le Temps Debut (TB)
 * TT = TT moins le nombre de jour ouvré (JOE) fois la durée d'une journé (24H)
 * puis TT = TT moins le (nombre de jour ouvrable moins un) le tout fois la durée 
 * d'une nuit entre deux jour de travail 
 * On obtien au final le nombre d'heure de travail d'un csit entre ces deux date
 */

Function CalculHorraireCSIT($tempDebut, $tempFin) {
    (!isset($tempFin) || !$tempFin)?$tempFin = date('Y-m-d'):null;
    if (!isset($tempDebut) || !$tempDebut)
        return null;
    while ((!CheckJourOuvrable($tempDebut) || date('H', $tempDebut) < HORAIRE_DEBUT || date('H', $tempDebut) >= HORAIRE_FIN)){
            $tempDebut = mktime(date('H', $tempDebut) + 1, 0, 0, date('m', $tempDebut), date('d', $tempDebut), date('Y', $tempDebut));
    }

    while ((!CheckJourOuvrable($tempFin) || date('H', $tempFin) < HORAIRE_DEBUT || date('H', $tempFin) > HORAIRE_FIN)){
            $tempFin = mktime(date('H', $tempFin) - 1, 0, 0, date('m', $tempFin), date('d', $tempFin), date('Y', $tempFin));
    }
    
    if (date('H', $tempFin) == HORAIRE_FIN)
         $tempFin = mktime(date('H', $tempFin), 0, 0, date('m', $tempFin), date('d', $tempFin), date('Y', $tempFin));   
    
    if ($tempDebut<$tempFin) {
        $nbJourOuvrable = calculJourOuvrable($tempDebut, $tempFin);

        $nbJourOuvre = CalculJourTotal($tempDebut, $tempFin) - $nbJourOuvrable;

        $TT = ($tempFin - $tempDebut) / 3600; //Je passe en heure pour les calculs
        $TT = $TT - (24 * $nbJourOuvre);

        if (date('d/m/Y', $tempDebut) != date('d/m/Y', $tempFin)){
            $TT = $TT - (CalculUneNuitTravail() * ($nbJourOuvrable));
        }

        if ($TT < 0)
            $TT = null ;
    
    }
    else {$TT=0;}
    return $TT;
}

function CalculUneNuitTravail() {
    $nbHeure = HORAIRE_FIN - HORAIRE_DEBUT;

    return (24 - $nbHeure);
}

function CalculJourTotal($Tdebut, $Tfin) {
    $nbJour = 0;
    
//    if (date('d', $Tdebut) != date('d', $Tfin))
        while ($Tdebut < $Tfin) {
            $nbJour++;
            $Tdebut = mktime(date('H', $Tfin), date('i', $Tfin), date('s', $Tfin), date('m', $Tdebut), date('d', $Tdebut) + 1, date('Y', $Tdebut));
//            $Tdebut = mktime(0, 0, 0, date('m', $Tdebut), date('d', $Tdebut) + 1, date('Y', $Tdebut));
//            $Tdebut = mktime(23, 59, 59, date('m', $Tdebut), date('d', $Tdebut) + 1, date('Y', $Tdebut));
        }
    return $nbJour;
}

/*
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++ Fin du module +++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 */
/*
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++ Debut des fonctions +++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 */

//Date incluse
//on lui passe deux date une debut une fin si ce n'est pas cohérent retourne faux
//Retourne le nombre de jour ouvrable (Sans les Week End et sans les jour ferier)
function calculJourOuvrable($timeDebut, $timeFin) {
    if (!isset($timeFin) || $timeFin == 0 || !$timeFin) 
        $timeFin = date("d-m-Y");
    if (!isset($timeDebut) || $timeDebut == 0 || !$timeDebut) 
        return false ;
    if ($timeDebut > $timeFin)
        return false;

    $nbJourTotalOuvrable = 0;

    while ($timeDebut < $timeFin) {
        //Si le jour checker est un jour ouvrable
        if (CheckJourOuvrable($timeDebut)){
            $nbJourTotalOuvrable++;
        }
        //on ajoute un jour si ce n'est ni un week end ni un jour fèrier


//        $timeDebut = mktime(0, 0, 0, date('m', $timeDebut), date('d', $timeDebut) + 1, date('Y', $timeDebut));
//        $timeDebut = mktime(23, 59, 59, date('m', $timeDebut), date('d', $timeDebut) + 1, date('Y', $timeDebut));
        $timeDebut = mktime(date('H', $timeFin), date('i', $timeFin), date('s', $timeFin), date('m', $timeDebut), date('d', $timeDebut) + 1, date('Y', $timeDebut));
    }
    return $nbJourTotalOuvrable;
}

function CheckJourOuvrable($time) {
    $JourFerierStatique = getJourFerier(date('Y', $time));

    //si la date passer est un samedi ou un dimanche
    if (in_array(date('N', $time), array('6', '7')))
        return false;

    //Si la date passer est un jour fèrier statique
    foreach ($JourFerierStatique as $unJourFerier)
        if (date('d-m-Y', $time) == date('d-m-Y', $unJourFerier))
            return false;

    return true;
}

function getJourFerier($year = null) {
    if ($year === null) {
        $year = intval(date('Y'));
    }

    $easterDate = easter_date($year);
    $easterDay = date('j', $easterDate);
    $easterMonth = date('n', $easterDate);
    $easterYear = date('Y', $easterDate);

    $holidays = array(
        // Dates fixes
        mktime(0, 0, 0, 1, 1, $year), // 1er janvier
        mktime(0, 0, 0, 5, 1, $year), // Fête du travail
        mktime(0, 0, 0, 5, 8, $year), // Victoire des alliés
        mktime(0, 0, 0, 7, 14, $year), // Fête nationale
        mktime(0, 0, 0, 8, 15, $year), // Assomption
        mktime(0, 0, 0, 11, 1, $year), // Toussaint
        mktime(0, 0, 0, 11, 11, $year), // Armistice
        mktime(0, 0, 0, 12, 25, $year), // Noel
        // Dates variables
        mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear),
        mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
        mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear),
    );

    sort($holidays);

    return $holidays;
}

/*
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++ Fin De la fonction ++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 */

/*
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++ Debut des fonctions +++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 */

function heure_to_str($uneHeureDecimale) {
    if ($uneHeureDecimale == null)
        return "";
    
    $jours = (int) ($uneHeureDecimale / 24);
    if ($jours != 0)
        $uneHeureDecimale = $uneHeureDecimale - $jours * 24;

    $heures = (int) ($uneHeureDecimale);
    $uneHeureDecimale = $uneHeureDecimale - $heures;

    $minutes = (int) ($uneHeureDecimale * 60);
    $uneHeureDecimale = $uneHeureDecimale - $minutes/60;
    
    $secondes = (int) ($uneHeureDecimale * 3600);
    $uneHeureDecimale = $uneHeureDecimale - $secondes/3600;

    $return_string = "";
    
    $heures = ($heures < 10)?"0".$heures:$heures;
    $minutes = ($minutes < 10)?"0".$minutes:$minutes;
    $secondes = ($secondes < 10)?"0".$secondes:$secondes;
    
    if ($jours != 0)
        $return_string = $jours . " j ";
    if ($heures != 0)
        $return_string = $return_string . $heures . " h ";
    if ($minutes != 0)
        $return_string = $return_string . $minutes . " min ";
    if ($secondes != 0 && $heures ==0 && $jours ==0)
        $return_string = $return_string . $secondes . " sec ";

    return $return_string;
}

function heure_to_xls($uneHeureDecimale) {
    
    if ($uneHeureDecimale < 0)
        return "";
    if ($uneHeureDecimale === 0)
        return "00:00:00";
    if ($uneHeureDecimale == false)
        return "";
    if ($uneHeureDecimale == null)
        return "";
    
    $heures = (int) ($uneHeureDecimale);
    $uneHeureDecimale = $uneHeureDecimale - $heures;

    $minutes = (int) ($uneHeureDecimale * 60);
    $uneHeureDecimale = $uneHeureDecimale - $minutes/60;
    
    $secondes = (int) ($uneHeureDecimale * 3600);
    $uneHeureDecimale = $uneHeureDecimale - $secondes/3600;

    $heures = str_pad($heures, 2, "0", STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
    $secondes = str_pad($secondes, 2, "0", STR_PAD_LEFT);

    return "$heures:$minutes:$secondes";
}

/*
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++ Fin De la fonction ++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ *
 */