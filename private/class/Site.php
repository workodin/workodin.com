<?php

/**
 * 
 */
class Site
{
    // (static) propriétés collectives de Classe

    /**
     * 
     */
    public static $tabInfo  = [];

    // propriétés individuelles d'objet

    /**
     * 
     */
    public $modelDir = "";

    // méthodes de classe
    // design pattern Factory
    public static function Get ($className)
    {
        // vérification si un objet existe déjà
        $objet = self::$tabInfo[$className] ?? null;
        if ($objet == null)
        {
            if ($className == "Model")
            {
                global $tabConfigSQL;
                $objet = new Model($tabConfigSQL);
            }
            else
            {
                $objet = new $className;
            }
            // mémoriser l'objet pour les prochains appels
            self::$tabInfo[$className] = $objet;
        }
        return $objet;
    }

    // méthodes d'objets

    /**
     * constructeur
     * @param $baseDir est le dossier de base au code du site
     */
    function __construct ($baseDir, $siteMode="DEV")
    {        
        // mode dev: debug plus facile
        $this->setSiteMode($siteMode);

        $this->modelDir        = "$baseDir/private/model";

        // variables globales avec $GLOBALS
        $GLOBALS["modelDir"]   = $this->modelDir;
        $GLOBALS["today"]      = date("Y-m-d");
        $GLOBALS["now"]        = date("H:i:s");

        if ($siteMode == "TERMINAL")
        {
            $this->setupTerminal();
        }
        else
        {
            // FRONT CONTROLLER ET ROUTEUR
            // on extrait de l'URI la page demandée
            global $pageUri;
            $pageUri                =  $this->getPageUri();
            $viewDir                = "$baseDir/private/template";
            $fichierSection         = "$viewDir/section-$pageUri.php";
            $fichierPage            = "$viewDir/page-$pageUri.php";
            
            $form = Site::Get("Form");
            // https://www.php.net/manual/fr/function.is-file.php
            if (is_file($fichierPage)) 
            {
                // CONTROLLER
                // traitement des formulaires
                $form->process();

                // VIEW
                require_once($fichierPage);
            }
            elseif (is_file($fichierSection)) 
            {
                // CONTROLLER
                // traitement des formulaires
                $form->process();

                // VIEW
                // recomposer la page eavec les tranches de HTML
                require_once("$viewDir/header.php");
                require_once($fichierSection);
                require_once("$viewDir/footer.php");
            }
            else
            {
                $objPDOStatement = Site::Get("Model")->readLine("Post", "uri", $pageUri);
                foreach($objPDOStatement as $tabLine)
                {
                    // traitement des formulaires
                    $form->process();

                    extract($tabLine);

                    $templatePost = "$viewDir/template-post.php";
                    if ($template != "")
                    {
                        $templatePost = "$viewDir/$template.php";
                    }
                    if (is_file($templatePost))
                    {
                        // VIEW
                        require_once($templatePost);
                    }

                }
                if(empty($tabLine))
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

            // garder un log du visiteur
            $this->trackVisit();

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
            // heure de Paris
            // https://www.php.net/manual/fr/function.date-default-timezone-set.php
            date_default_timezone_set("Europe/Paris");
            $today = date("Y-m-d");

            // erreurs
            error_reporting(E_ALL);
            ini_set("display_errors",   "1"); 
            ini_set("log_errors",       true);
            ini_set("error_log",        $this->modelDir . "/error-$today.log");            

        }
    }

    /**
     * garder un log de chaque visiteur
     */
    function trackVisit ()
    {
        // attention
        // on peut utiliser des variables globales
        // mais il faut prévenir PHP
        // https://www.php.net/manual/fr/reserved.variables.server.php
        $uri        = $_SERVER["REQUEST_URI"];
        $userAgent  = $_SERVER["HTTP_USER_AGENT"];
        $ip         = $_SERVER["REMOTE_ADDR"];
        $referer    = $_SERVER["HTTP_REFERER"] ?? "";

        $today      = date("Y-m-d");
        $now        = date("Y-m-d H:i:s");

        // SECURITE: on ne stocke pas les mots de passe...
        $tabRequest = $_REQUEST;
        if (isset($tabRequest["password"]))
        {
            $tabRequest["password"] = mb_strlen($tabRequest["password"]);
        }
        $code       = json_encode($tabRequest);   // TODO: SECURITY

        // sauvegarder dans un fichier CSV
        Site::Get("Model")->insertLine("Visit", [
           "creationDate"   => $now,
           "uri"            => $uri,
           "code"           => $code,
           "userAgent"      => $userAgent, 
           "referer"        => $referer, 
           "ip"             => $ip, 
        ]);
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