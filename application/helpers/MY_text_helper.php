<?php


function getAdresse($adresse)
{
    $array_adr = explode('-', $adresse);
         
    $adresse_1 = trim($array_adr[0]);
    $array_adr[1] = trim($array_adr[1]);
    $array_ville = explode(' ', $array_adr[1]);
    $code_postal = $array_ville[0];
    
    
    $count = count($array_ville);
    $ville = '';
    for ($i = 1; $i < $count; $i++) {
        if ($i !== 1) $ville .= ' ';
        $ville .= $array_ville[$i];
    }


    if (strlen($code_postal) < 5) {
        $zerosnecessaires = (5 - strlen($code_postal));
        for ($i=0; $i < $zerosnecessaires; $i++){
            $code_postal .= '0';
        }
    }
    return array(
        'adresse' => $adresse_1,
        'code_postal' => $code_postal,
        'ville' => $ville
    );
}