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

        $feedback = "";
        // traitement du formulaire
        $name       = $form->getInfo("name");
        $email      = $form->getInfo("email");
        $message    = $form->getInfo("message");
        if (($message != "") && ($name != "") && (filter_var($email, FILTER_VALIDATE_EMAIL)))
        {
            // compléter les infos manquantes 
            $creationDate = date("Y-m-d H:i:s");
            // ajouter une ligne dans la table SQL Contact
            Site::Get("Model")->insertLine("Contact", [
                                                "name"          => $name, 
                                                "email"         => $email, 
                                                "message"       => $message, 
                                                "creationDate"  => $creationDate,
                                            ]);

            // message feedback
            $feedback = "merci de votre message, $name ($email)";

            // on envoie un mail
            $messageContact =
<<<TEXTE
==============
date: $creationDate
nom: $name
email: $email
$message

TEXTE;
            
           Site::Get("Email")->send("contact/$email/$name", $messageContact);
        }

        return $feedback;
    }

}