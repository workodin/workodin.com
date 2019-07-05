<?php

class FormContact 
{
    /**
     * traiter le formulaire de contact
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
        $name       = $form->getInfo("name");
        $email      = $form->getInfo("email");
        $message    = $form->getInfo("message");
        if (($message != "") && ($name != "") && (filter_var($email, FILTER_VALIDATE_EMAIL)))
        {
            // sauvegarder dans un fichier texte
            $messageContact =
<<<TEXTE
==============
date: $today $now
nom: $name
email: $email
$message

TEXTE;

            file_put_contents("$modelDir/contact-$today.txt", $messageContact, FILE_APPEND);

            // message feedback
            $feedback = "merci de votre message, $name($email)";

            // on envoie un mail
            // https://www.php.net/manual/fr/function.mail.php
            $headers =  'From: hello@workodin.com' . "\r\n" .
                        'Reply-To: hello@workodin.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

            @mail("hello@workodin.com", "contact/$email/$name", $messageContact, $headers);
        }

        return $feedback;
    }

}