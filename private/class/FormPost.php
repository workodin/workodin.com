<?php

/**
 * 
 */
class FormPost 
{
    /**
     * 
     */
    function processCreate ()
    {
        $feedback = "";
        $objController = Site::Get("Controller");

        // SECURITE
        $levelUser = Site::Get("Session")->get("levelUser");
        if ($levelUser == 100)
        {
            $feedback = $objController
                            ->check("title",    "text")
                            ->check("uri",      "text")
                            ->check("category", "text")
                            ->check("code",     "textarea")
                            ->check("urlMedia", "text")
                            // compléter les infos manquantes
                            ->addData("creationDate", date("Y-m-d H:i:s"))
                            // ajouter la ligne
                            ->insertLine("Post", "votre contenu est publié")
                            // récupérer le message de confirmation
                            ->getFeedback()
                            ;
        }
        return $feedback;
    }
}