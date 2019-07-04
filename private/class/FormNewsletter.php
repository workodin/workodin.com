<?php

/**
 * 
 */
class FormNewsletter
{

    /**
     * traiter le formulaire de newsletter
     * (note: cette fonction appelle une autre fonction getInfo)
     * @return le message de confirmation (feedback)
     * 
     */
    function process ($form)
    {
        // attention
        // on peut utiliser des variables globales
        // mais il faut prévenir PHP
        global $modelDir, $today, $now;
    
        $feedback = "";
        // traitement du formulaire
        $nom        = $form->getInfo("nom");
        $email      = $form->getInfo("email");
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
    
}