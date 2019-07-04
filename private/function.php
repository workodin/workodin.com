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
     * @param  l'étiquette du formulaire 
     * 
     */
    function processForm ($formFeedback="")
    {
        // on garde des valeurs dans une variable static
        // pour les réutiliser à travers plusieurs appels à la même focntion
        static $tabFeedback = [];

        if ($formFeedback == "")
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
                    // et on mémorise le feedback pour pouvoir l'afficher plus tard
                    $tabFeedback[$formTag] = $nomFonction();
                }    
            }    
        }
        else 
        {
            // on affiche le message feedback 
            // pour permettre l'affichage dans la partie view
            echo $tabFeedback[$formFeedback] ?? "";
        }
    }


/**
 * traiter le formulaire de newsletter
 * (note: cette fonction appelle une autre fonction getInfo)
 * @return le message de confirmation (feedback)
 * 
 */
function processFormNewsletter ()
{
    // attention
    // on peut utiliser des variables globales
    // mais il faut prévenir PHP
    global $modelDir, $today, $now;

    $feedback = "";
    // traitement du formulaire
    $nom        = getInfo("nom");
    $email      = getInfo("email");
    if (($nom != "") && (filter_var($email, FILTER_VALIDATE_EMAIL)))
    {
        // sauvegarder dans un fichier CSV
        file_put_contents("$modelDir/newsletter-$today.csv", "$nom,$email,$today $now\n", FILE_APPEND);

        // message feedback
        $feedback = "merci de votre inscription avec $email ($nom)";

        // on envoie un mail
        // https://www.php.net/manual/fr/function.mail.php
        $headers =  'From: hello@workodin.com' . "\r\n" .
                    'Reply-To: hello@workodin.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        @mail("hello@workodin.com", "newsletter/$email/$nom", "nouvel inscrit: $email / $nom", $headers);
    }
    return $feedback;
}

/**
 * traiter le formulaire de contact
 * (note: cette fonction appelle une autre fonction getInfo)
 * @return le message de confirmation (feedback)
 * 
 */
function processFormContact ()
{
    // attention
    // on peut utiliser des variables globales
    // mais il faut prévenir PHP
    global $modelDir, $today, $now;

    $feedback = "";
    // traitement du formulaire
    $nom        = getInfo("nom");
    $email      = getInfo("email");
    $message    = getInfo("message");
    if (($message != "") && ($nom != "") && (filter_var($email, FILTER_VALIDATE_EMAIL)))
    {
        // sauvegarder dans un fichier texte
        $messageContact =
<<<TEXTE
==============
date: $today $now
nom: $nom
email: $email
$message

TEXTE;

        file_put_contents("$modelDir/contact-$today.txt", $messageContact, FILE_APPEND);

        // message feedback
        $feedback = "merci de votre message, $nom($email)";

        // on envoie un mail
        // https://www.php.net/manual/fr/function.mail.php
        $headers =  'From: hello@workodin.com' . "\r\n" .
                    'Reply-To: hello@workodin.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        @mail("hello@workodin.com", "contact/$email/$nom", $messageContact, $headers);
    }

    return $feedback;
}

