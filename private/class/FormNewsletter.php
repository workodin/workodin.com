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
        $name       = $form->getInfo("name");
        $email      = $form->getInfo("email");
        if (($name != "") && (filter_var($email, FILTER_VALIDATE_EMAIL)))
        {
            // compléter les infos manquantes 
            $creationDate = date("Y-m-d H:i:s");

            // insertion dans la table SQL Newsletter
            $objModel = Site::Get("Model");
            $objModel->insertLine("Newsletter", [ 
                                        "name"          => $name, 
                                        "email"         => $email, 
                                        "creationDate"  => $creationDate,
                                    ]);

            // sauvegarder dans un fichier CSV
            file_put_contents("$modelDir/newsletter-$today.csv", "$name,$email,$today $now\n", FILE_APPEND);
            // message feedback
            $feedback = "merci de votre inscription avec $email ($name)";
    
            // on envoie un mail
            // https://www.php.net/manual/fr/function.mail.php
            $headers =  'From: hello@workodin.com' . "\r\n" .
                        'Reply-To: hello@workodin.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
    
            @mail("hello@workodin.com", "newsletter/$email/$name", "nouvel inscrit: $email / $name", $headers);
        }
        return $feedback;
    }
    
}