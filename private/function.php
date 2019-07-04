<?php
// dans ce fichier, il n'y aura que des déclarations de fonctions
// aucun code ne devrait être activé

//===================================================================
// FONCTIONS MODEL


//===================================================================
// FONCTIONS VIEW


//===================================================================
// FONCTIONS CONTROLLER


/**
 * configure le mode de développement
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
 * récupère une info envoyée la navigateur à travers un formulaire
 * exemple:
 * <input name="nom">
 * $nom = getInfo("nom");
 */
function getInfo($name, $default="")
{
    $value = $default;
    if (isset($_REQUEST["$name"]))
    {
        $value = trim(strip_tags($_REQUEST["$name"]));
    }
    return $value;
}


/**
 * traiter le formulaire envoyé dans une requête
 * (note: cette fonction appelle une autre fonction getInfo)
 * 
 */
function processForm ()
{
    $formTag = getInfo("formTag");
    // filtrer pour ne garder que les lettres et les chiffres
    // https://www.php.net/manual/fr/function.preg-replace.php
    $formTag = preg_replace("/[^a-zA-Z0-9]/", "", $formTag);

    // framework dynamique
    // on prend comme convention que le traitement du formulaire est géré 
    // par une fonction dont le nom commence par processForm
    // et finit par l'étiquette du formulaire
    // exemple: 
    // <input type="hidden" name="formTag" value="Newsletter">
    // sera traité par la fonction processFormNewsletter
    if ($formTag != "")
    {
        $nomFonction = "processForm$formTag";
        if (function_exists($nomFonction)) {
            // assez étrange, mais ça fonctionne avec PHP ;-p
            $nomFonction();
        }    
    }
}

/**
 * traiter le formulaire de newsletter
 * (note: cette fonction appelle une autre fonction getInfo)
 * 
 */
function processFormNewsletter ()
{
    // attention
    // on peut utiliser des variables globales
    // mais il faut prévenir PHP
    global $modelDir, $today, $now;

    // traitement du formulaire
    $nom        = getInfo("nom");
    $email      = getInfo("email");
    if (($nom != "") && (filter_var($email, FILTER_VALIDATE_EMAIL)))
    {
        // sauvegarder dans un fichier CSV
        file_put_contents("$modelDir/newsletter-$today.csv", "$nom,$email,$today $now\n", FILE_APPEND);

        // message feedback
        echo "merci de votre inscription avec $email ($nom)";

        // on envoie un mail
        // https://www.php.net/manual/fr/function.mail.php
        $headers =  'From: hello@workodin.com' . "\r\n" .
                    'Reply-To: hello@workodin.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        @mail("hello@workodin.com", "newsletter/$email/$nom", "nouvel inscrit: $email / $nom", $headers);
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
