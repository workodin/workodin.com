<?php

class FormLogin 
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
        $email      = $form->getInfo("email");
        $password   = $form->getInfo("password");
        if (($email != "") && ($password != "") && (filter_var($email, FILTER_VALIDATE_EMAIL)))
        {
            // message feedback
            $feedback = "bienvenue ($email)";
        }

        return $feedback;
    }

}