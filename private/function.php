<?php

// dans ce fichier, il n'y aura que des déclarations de fonctions
// aucun code ne devrait être activé

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
    return trim(strip_tags($_REQUEST["$name"] ?? "$default"));
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
    global $baseDir, $today, $now;

    // traitement du formulaire
    $nom        = getInfo("nom");
    $email      = getInfo("email");
    if (($nom != "") && (filter_var($email, FILTER_VALIDATE_EMAIL)))
    {
        // sauvegarder dans un fichier CSV
        file_put_contents("$baseDir/private/newsletter-$today.csv", "$nom,$email,$today $now\n", FILE_APPEND);

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


function trackVisit ()
{
    // attention
    // on peut utiliser des variables globales
    // mais il faut prévenir PHP
    global $baseDir, $today, $now;

    $uri        = $_SERVER["REQUEST_URI"];
    $userAgent  = $_SERVER["HTTP_USER_AGENT"];
    $ip         = $_SERVER["REMOTE_ADDR"];
    
    // sauvegarder dans un fichier CSV
    file_put_contents("$baseDir/private/visit-$today.csv", "$today $now,$uri,$ip,'$userAgent'\n", FILE_APPEND);
    
}