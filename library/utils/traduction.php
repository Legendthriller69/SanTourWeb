<?php

/**
 * Page permettant la traduction des mots générés dans le javascript
 */

// Define constant
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath('..' . DS . '..' . DS));
define('APPPATH', realpath(ROOT . DS . 'app'));
define('LIBPATH', realpath(ROOT . DS . 'library'));
define('ASSETSPATH', realpath(ROOT . DS . 'assets'));

header('Content-Type: text/javascript');

session_start();

// Langue par défaut
$currentlang = 'en';
// Si aucune langue n'est sélectionnée, on sélectionne la langue par défaut
$currentlang = (isset($_SESSION['lang'])) ? strtolower($_SESSION['lang']) : $currentlang;

// Récupération du contenu du fichier
$path = ASSETSPATH . DS . 'languages' . DS . $currentlang . 'JS.json';
$a = file_get_contents($path);

?>

var trads = <?php echo $a; ?> ;

function __(key){
if(trads.hasOwnProperty(key)) {
        return trads[key];
    } else {
        return '[' + key + ']';
    }
}