<?php

/**
 * 
 */
class Site
{
    // méthodes
    /**
     * constructeur
     * @param $baseDir est le dossier de base au code du site
     */
    function __construct ($baseDir)
    {
        // mode dev: debug plus facile
        $this->setSiteMode("DEV");

        // variables globales avec $GLOBALS
        $GLOBALS["modelDir"]   = "$baseDir/private/model";
        $GLOBALS["today"]      = date("Y-m-d");
        $GLOBALS["now"]        = date("H:i:s");

        // garder un log du visiteur
        trackVisit();

        // FRONT CONTROLLER ET ROUTEUR
        // on extrait de l'URI la page demandée
        global $pageUri;
        $pageUri                =  getPageUri();
        $viewDir                = "$baseDir/private/template";
        $fichierSection         = "$viewDir/section-$pageUri.php";
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

    }
    

    /**
     * configure le mode de développement
     * @param mode = "DEV"
     */
    function setSiteMode ($mode)
    {
        if ($mode == "DEV") 
        {
            error_reporting(E_ALL);
            ini_set("display_errors", "1"); 
            
            // heure de Paris
            // https://www.php.net/manual/fr/function.date-default-timezone-set.php
            date_default_timezone_set("Europe/Paris");

        }
    }

}