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

    /**
     * design pattern Factory
     */
    public static function Get ($className)
    {
        // vérification si un objet existe déjà
        $objet = self::$tabInfo[$className] ?? null;
        if ($objet === null)
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

    /**
     * affichage variable mémorisée
     */
    public static function Show ($key, $default="")
    {
        echo Site::Get($key) ?? $default;
    }

    /**
     * stockage général de variables pour le site
     */
    public static function Set ($key, $value)
    {
        self::$tabInfo[$key] = $value;

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

        // on ajoute un autre chargeur de classe
        spl_autoload_register(function($nameClass){
            $pathClass  = $this->loadFile("private/class/$nameClass.php");
            if (is_file($pathClass))
            {
                // charger le code de la classe
                require_once($pathClass);
            }
        });

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
            $fichierSection         = "$viewDir/page-section/$pageUri.php";
            $fichierPage            = "$viewDir/page/$pageUri.php";
            
            $fichierSection2         = "private/template/page-section/$pageUri.php";
            $fichierPage2            = "private/template/page/$pageUri.php";

            $form = Site::Get("Form");
            // https://www.php.net/manual/fr/function.is-file.php
            $filePage    = $this->loadFile($fichierPage2);
            $fileSection = $this->loadFile($fichierSection2);

            $tabRequire = [];
            if (is_file($filePage)) 
            {
                // CONTROLLER
                // traitement des formulaires
                $form->process();

                // VIEW
                $tabRequire[] = $filePage;
                // require_once($filePage);
            }
            elseif (is_file($fileSection)) 
            {
                // CONTROLLER
                // traitement des formulaires
                $form->process();

                // VIEW
                // recomposer la page eavec les tranches de HTML
                // require_once("$viewDir/part/header.php");
                // require_once($fileSection);
                // require_once("$viewDir/part/footer.php");

                $tabRequire[] = "$viewDir/part/header.php";
                $tabRequire[] = "$fileSection";
                $tabRequire[] = "$viewDir/part/footer.php";

            }
            else
            {
                $objPDOStatement = Site::Get("Model")->readLine("Post", "uri", $pageUri);
                foreach ($objPDOStatement as $tabLine)
                {
                    // traitement des formulaires
                    $form->process();

                    extract($tabLine);

                    $templatePost  = "$viewDir/template-post.php";
                    $templatePost2 = "private/template/template-post.php";
                    if ($template != "")
                    {
                        $templatePost = "$viewDir/template-$template.php";
                        $templatePost2 = "private/template/template-$template.php";
                    }

                    // on va chercher le fichier réel ou virtuel
                    $templateFile = $this->loadFile($templatePost2);
                    if (is_file($templateFile))
                    {
                        // VIEW
                        // require_once($templateFile);
                        $tabRequire[] = $templateFile;
                    }

                }
                if (empty($tabLine))
                {
                    // page non trouvée
                    // important: erreur 404 pour les moteurs de recherche
                    // https://www.php.net/manual/fr/function.header.php
                    header("HTTP/1.0 404 Not Found");
                    // require_once("$viewDir/template-404.php");
                    $tabRequire[] = "$viewDir/template-404.php";

                }
            }

            // on charge tous les fichiers nécessaires pour construire la réponse
            foreach($tabRequire as $fileRequire)
            {
                require_once($fileRequire);
            }

            // garder un log du visiteur
            $this->trackVisit();

        }

    }
    
    /**
     * 
     */
    function loadFile ($templatePost)
    {
        $result = "";
        $baseDir          = Site::Get("baseDir");
        // on peut paramétrer l'ordre de priorité
        $templatePriority = Site::Get("templatePriority");

        $templatePath   = "$baseDir/$templatePost"; 
        // on va chercher dans le cache des fichiers File
        $md5file = md5($templatePost);
        $cacheFile = "$baseDir/my-work/my-$md5file";

        $tabSearch = [];
        if ($templatePriority == "virtual")
        {
            $tabSearch[] = $cacheFile;
            $tabSearch[] = $templatePath;
        }
        else
        {
            $tabSearch[] = $templatePath;
            $tabSearch[] = $cacheFile;
        }

        $found = 0;
        foreach($tabSearch as $search)
        {
            if (is_file($search))
            {
                $result = $search;
                $found++;
                break;
            }
        }

        // mise à jour du cache à partir de SQL
        if ($found == 0)
        {
            $objPDOStatement = Site::get("Model")->readLine("File", "path", $templatePost);
            $md5path         = "";
            $feedbackVirtual = "";
            foreach($objPDOStatement as $tabLine)
            {
                extract($tabLine);
                // crée $code et $path
                $md5path = md5($path);

            }
            if ($md5path != "") {
                $baseDir = Site::get("baseDir");
                $virtualPath = "$baseDir/my-work/my-$md5path";
                // création du fichier cache
                file_put_contents($cacheFile, $code);
                
                // ré-actualisation du résultat
                $result = $cacheFile;
            }

        }
        return $result;
    }

    /**
     * 
     */
    function loadTabFile ($tabFile)
    {
        $result = [];
        foreach($tabFile as $file)
        {
            $file2 = $this->loadFile($file);
            if ($file2 != "")
            {
                $result[] = $file2;
            }
        }
        return $result;
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

        // https://www.php.net/manual/fr/function.hrtime.php
        // https://www.php.net/manual/fr/function.memory-get-peak-usage.php
        // en micro secondes
        $requestTime    = intval((microtime(true) - Site::Get("timeStart")));
        // en ko
        $requestMemory  = intval(memory_get_peak_usage() / 1024);

        // sauvegarder dans un fichier CSV
        Site::Get("Model")->insertLine("Visit", [
           "creationDate"   => $now,
           "uri"            => $uri,
           "code"           => $code,
           "userAgent"      => $userAgent, 
           "referer"        => $referer, 
           "ip"             => $ip,
           "requestTime"    => $requestTime,
           "requestMemory"  => $requestMemory, 
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

        // on mémorise le path
        Site::Set("pagePath", $path);
        // cas spécial auparavant géré par Apache
        if ($path == "/") 
        {
            // on considère que c'est index.php
            $path = "/index";   
        }

        // https://www.php.net/manual/fr/function.pathinfo.php
        $filename   = pathinfo($path, PATHINFO_FILENAME);
        $extension  = pathinfo($path, PATHINFO_EXTENSION);
        $extension  = strtolower($extension);
        Site::Set("pagePathExtension", $extension);

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