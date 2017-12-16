<?php

use SanTourWeb\Library\Utils\Redirect;

function error_404()
{
    return '404 ça marche pas';
}

function redirectIfNotConnected()
{
    if (!isset($_SESSION['connected']))
        Redirect::toAction('login');
}

function __($key, $return = false)
{
    // Langue par défaut
    $currentlang = 'en';
    // Si aucune langue n'est sélectionnée, on sélectionne la langue par défaut
    $currentlang = (isset($_SESSION['lang'])) ? strtolower($_SESSION['lang']) : $currentlang;

    // Chemin vers le fichier de langues
    $path = ASSETSPATH . DS . 'languages' . DS . $currentlang . '.json';

    // Récupération du contenu du fichier
    $a = file_get_contents($path);
    $lang = json_decode($a, true);

    // Si le fichier n'existe pas ou que le mot clé n'est pas encore traduit
    if (empty($lang) || !array_key_exists($key, $lang)) {

        // Si la langue actuelle est anglais
        if ($currentlang == 'en') {
            // Création du mot clé avec la traduction
            $lang[$key] = $key;
            // Ajout dans le fichier
            file_put_contents($path, json_encode($lang));
        } else {
            // Affichage du mot en anglais entouré de crochets
            return returnOrEcho('[' . $key . ']', $return);
        }
    }
    // Affichage de la traduction
    return returnOrEcho($lang[$key], $return);
}

function returnOrEcho($value, $isReturn)
{
    if ($isReturn) {
        return $value;
    } else {
        echo $value;
    }
    return '';
}