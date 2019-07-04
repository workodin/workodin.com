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
// On peut maintenant créer des objets
$objetSite = new Site;

// mode dev: debug plus facile
setSiteMode("DEV");

// variables globales
$modelDir   = "$baseDir/private/model";
$viewDir    = "$baseDir/private/template";
$today      = date("Y-m-d");
$now        = date("H:i:s");

// garder un log du visiteur
trackVisit();

// FRONT CONTROLLER ET ROUTEUR
// on extrait de l'URI la page demandée
$pageUri        =  getPageUri();
$fichierSection = "$viewDir/section-$pageUri.php";
// https://www.php.net/manual/fr/function.is-file.php
if (is_file($fichierSection)) 
{
    // CONTROLLER
    // traitement des formulaires
    processForm();

    // VIEW
    // recomposer la page eavec les tranches de HTML
    require_once("$viewDir/header.php");
    require_once($fichierSection);
    require_once("$viewDir/footer.php");
}
else
{
    // page non trouvée
    // important: erreur 404 pour les moteurs de recherche
    // https://www.php.net/manual/fr/function.header.php
    header("HTTP/1.0 404 Not Found");

    require_once("$viewDir/header.php");
    require_once("$viewDir/section-404.php");
    require_once("$viewDir/footer.php");
}
