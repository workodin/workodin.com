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

            // message feedback
            $feedback = "merci de votre inscription avec $email ($name)";
    
            // on envoie un mail    
            Site::Get("Email")->send("hello@workodin.com", 
                                        "newsletter/$email/$name", 
                                        "nouvel inscrit: $email / $name", $headers);
        }
        return $feedback;
    }
    
}