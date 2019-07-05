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
    function __construct ($baseDir, $siteMode="DEV")
    {        
        // mode dev: debug plus facile
        $this->setSiteMode($siteMode);

        // variables globales avec $GLOBALS
        $GLOBALS["modelDir"]   = "$baseDir/private/model";
        $GLOBALS["today"]      = date("Y-m-d");
        $GLOBALS["now"]        = date("H:i:s");

        if ($siteMode == "TERMINAL")
        {
            $this->setupTerminal();
        }
        else
        {
            // garder un log du visiteur
            $this->trackVisit();

            // FRONT CONTROLLER ET ROUTEUR
            // on extrait de l'URI la page demandée
            global $pageUri;
            $pageUri                =  $this->getPageUri();
            $viewDir                = "$baseDir/private/template";
            $fichierSection         = "$viewDir/section-$pageUri.php";
            // https://www.php.net/manual/fr/function.is-file.php
            if (is_file($fichierSection)) 
            {
                // CONTROLLER
                // traitement des formulaires
                $form = new Form;
                $form->process();

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

    /**
     * garde un log de chaque visiteur
     */
    function trackVisit ()
    {
        // attention
        // on peut utiliser des variables globales
        // mais il faut prévenir PHP
        global $modelDir, $today, $now;

        $uri        = $_SERVER["REQUEST_URI"];
        $userAgent  = $_SERVER["HTTP_USER_AGENT"];
        $ip         = $_SERVER["REMOTE_ADDR"];
        
        // sauvegarder dans un fichier CSV
        file_put_contents("$modelDir/visit-$today.csv", "$today $now,$uri,$ip,'$userAgent'\n", FILE_APPEND);
        
    }

    /**
     * détermine quelle est la page à afficher
     */
    function getPageUri ()
    {
        $uri        = $_SERVER["REQUEST_URI"];
        // https://www.php.net/manual/fr/function.parse-url.php
        $path       = parse_url($uri, PHP_URL_PATH);
        // cas spécial auparavant géré par Apache
        if ($path == "/") 
        {
            // on considère que c'est index.php
            $path = "/index";   
        }

        // https://www.php.net/manual/fr/function.pathinfo.php
        $filename   = pathinfo($path, PATHINFO_FILENAME);

        return $filename;
    }

    /**
     * paramétrage pour le mode terminal
     */
    function setupTerminal ()
    {

    }

    /**
     * 
     */
    function install ()
    {
        global $tabConfigSQL, $modelDir, $installKey;

        $keyMD5 = md5($installKey);

        echo 
<<<TEXTE

* installation de SQL ($installKey)($keyMD5)

TEXTE;

        // création de la table Post
        $objModel = new Model($tabConfigSQL);
        $filePost = "$modelDir/Post.sql";
        if (is_file($filePost)) 
        {
            $sqlPost = file_get_contents($filePost);
            $objModel->executeSQL($sqlPost);
        }

    }
}