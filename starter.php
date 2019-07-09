<?php

// variables globales
// on garde ce dossier comme base pour tous les chemins
$baseDir    = __DIR__;

// programmation fonctionnelle
// charger les déclarations des fonctions avant de pouvoir les utiliser
require_once("$baseDir/private/function.php");

// programmation orientée objet
// autoload de classe
// https://www.php.net/manual/fr/function.spl-autoload-register.php
spl_autoload_register(function($nomClasse){
    global $baseDir;
    $cheminFichierClasse = "$baseDir/private/class/$nomClasse.php";
    if (is_file($cheminFichierClasse))
    {
        // charger le code de la classe
        require_once($cheminFichierClasse);
    }
});

// variables globales
Site::Set("baseDir", $baseDir);

// chargement du fichier de config
$siteMode   = "DEV";
$configFile = "$baseDir/my-config.php";
if (is_file($configFile))
{
    require_once($configFile);
}

// On peut maintenant créer des objets
// => PHP va déclencher la méthode Site::__construct
$objetSite = new Site($baseDir, $siteMode);

